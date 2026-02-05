<?php
session_start();
require_once '../database.php';

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// --- Pagination, Search, Sort Logic ---

// 1. Parameters
$limit = 5; // Max rows per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1)
    $page = 1;
$offset = ($page - 1) * $limit;

$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'created_at';
$order = $_GET['order'] ?? 'DESC';

// Validate Sort Column
$allowed_sort = ['name', 'department', 'specification', 'created_at'];
if (!in_array($sort, $allowed_sort))
    $sort = 'created_at';
$order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

// 2. Build Query
$whereSQL = "";
$params = [];
$types = "";

if (!empty($search)) {
    $whereSQL = "WHERE name LIKE ? OR department LIKE ? OR specification LIKE ?";
    $searchTerm = "%" . $search . "%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $types .= "sss";
}

// 3. Get Total Count
$countSql = "SELECT COUNT(*) as total FROM people $whereSQL";
$stmtCount = $conn->prepare($countSql);
if (!empty($params)) {
    $stmtCount->bind_param($types, ...$params);
}
$stmtCount->execute();
$totalRows = $stmtCount->get_result()->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

// 4. Fetch Data with Limit & Offset
$sql = "SELECT * FROM people $whereSQL ORDER BY $sort $order LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

$mainParams = $params;
$mainParams[] = $limit;
$mainParams[] = $offset;
$mainTypes = $types . "ii";

$stmt->bind_param($mainTypes, ...$mainParams);
$stmt->execute();
$result = $stmt->get_result();

// Helper for sort icon
function sortIcon($col, $currSort, $currOrder)
{
    if ($currSort !== $col)
        return '<i class="fas fa-sort text-muted ms-1" style="font-size:0.8em;"></i>';
    return $currOrder === 'ASC' ? '<i class="fas fa-sort-up ms-1"></i>' : '<i class="fas fa-sort-down ms-1"></i>';
}

// --- AJAX Handler ---
if (isset($_GET['ajax'])) {
    ob_start();
    if ($result && $result->num_rows > 0) {
        $i = $offset + 1;
        while ($row = $result->fetch_assoc()) {

            // Placeholder logic
            $imgPath = $row['image'] && file_exists("../assets/files/people/" . $row['image'])
                ? "../assets/files/people/" . htmlspecialchars($row['image'])
                : "../assets/files/people/placeholder.png";

            // Build Location String
            $loc = [];
            if ($row['college1'])
                $loc[] = $row['college1'];
            if ($row['college2'])
                $loc[] = $row['college2'];
            $locStr = implode(', ', $loc);

            echo '<tr>';
            echo '<td>' . $i++ . '</td>';
            echo '<td><img src="' . $imgPath . '" alt="Person" style="height: 50px; width: 50px; object-fit: cover; border-radius: 50%;"></td>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['specification'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['department'] ?? '') . '</td>';
            echo '<td class="text-end">
                    <a href="edit-people.php?id=' . $row['id'] . '" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></a>
                    <a href="delete-people.php?id=' . $row['id'] . '" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Are you sure you want to delete this person?\');"><i class="fas fa-trash"></i></a>
                  </td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="6" class="text-center py-4 text-muted">No people found.</td></tr>';
    }
    $tableHtml = ob_get_clean();

    ob_start();
    if ($totalPages > 1) {
        echo '<ul class="pagination justify-content-end">';
        $prevDisabled = ($page <= 1) ? 'disabled' : '';
        $prevPage = $page - 1;
        echo '<li class="page-item ' . $prevDisabled . '"><a class="page-link" href="#" data-page="' . $prevPage . '">Previous</a></li>';

        for ($p = 1; $p <= $totalPages; $p++) {
            $active = ($p == $page) ? 'active' : '';
            echo '<li class="page-item ' . $active . '"><a class="page-link" href="#" data-page="' . $p . '">' . $p . '</a></li>';
        }

        $nextDisabled = ($page >= $totalPages) ? 'disabled' : '';
        $nextPage = $page + 1;
        echo '<li class="page-item ' . $nextDisabled . '"><a class="page-link" href="#" data-page="' . $nextPage . '">Next</a></li>';
        echo '</ul>';
    }
    $paginationHtml = ob_get_clean();

    header('Content-Type: application/json');
    echo json_encode(['table' => $tableHtml, 'pagination' => $paginationHtml]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage People - IndoNorway Connect</title>
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,300;0,400;1,300&family=Figtree:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main Styles -->
    <link rel="stylesheet" href="../styles/style.css">

    <style>
        /* Dashboard Specific Styles */
        body {
            background-color: #f4f6f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        .top-navbar {
            background: var(--bg-dark-blue);
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
        }

        .brand-logo img {
            height: 40px;
            width: auto;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: white;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .content-wrapper {
            display: flex;
            flex: 1;
            margin-top: 70px;
        }

        .sidebar {
            width: 260px;
            background: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #eee;
            position: fixed;
            top: 70px;
            bottom: 0;
            z-index: 1020;
            height: calc(100vh - 70px);
        }

        .sidebar-menu {
            padding: 1.5rem 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: var(--text-black);
            text-decoration: none;
            font-family: 'Figtree', sans-serif;
            transition: all 0.2s;
            border-left: 4px solid transparent;
            font-weight: 500;
        }

        .menu-item:hover,
        .menu-item.active {
            background: #f8f9fa;
            color: var(--btn-light);
            border-left-color: var(--btn-light);
            text-decoration: none;
        }

        .menu-item i {
            width: 24px;
            margin-right: 10px;
            color: #6c757d;
        }

        .menu-item:hover i,
        .menu-item.active i {
            color: var(--btn-light);
        }

        .collapse .menu-item {
            font-size: 0.95rem;
            border-left: none;
        }

        .collapse .menu-item:hover {
            background: #f1f3f5;
            border-left: 4px solid var(--btn-light);
        }

        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
            background: #f4f6f9;
        }

        .table-custom th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
            font-weight: 600;
        }

        .table-custom th a {
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
        }

        .table-custom td {
            vertical-align: middle;
        }

        /* Custom Pagination */
        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-item .page-link {
            color: #002F72;
            border: 1px solid #dee2e6;
            margin: 0 3px;
            border-radius: 6px;
            font-weight: 500;
            padding: 0.5rem 0.85rem;
            transition: all 0.2s ease-in-out;
        }

        .pagination .page-item.active .page-link {
            background: var(--bg-dark-blue);
            border-color: #002F72;
            color: #ffffff !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .pagination .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: #fff;
            border-color: #dee2e6;
        }

        .pagination .page-link:hover {
            background-color: #e9ecef;
            color: #002F72;
            transform: translateY(-1px);
        }

        .pagination .page-item.active .page-link:hover {
            background: var(--bg-dark-blue);
            color: #ffffff !important;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="content-wrapper">
        <?php include 'sidebar.php'; ?>

        <main class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h2 style="font-family: 'Figtree', sans-serif;">Manage People</h2>
                <a href="edit-people.php" class="btn btn-primary"
                    style="background: var(--bg-dark-blue); border: none;">
                    <i class="fas fa-plus me-2"></i> Add Person
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <!-- Search -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i
                                        class="fas fa-search text-muted"></i></span>
                                <input type="text" id="live-search" class="form-control border-start-0 ps-0"
                                    placeholder="Search by Name, Dept, or Designation..."
                                    value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-custom mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">S.No</th>
                                    <th style="width: 80px;">Image</th>
                                    <th><a href="#" class="sort-link" data-sort="name">Name <span id="sort-icon-name">
                                                <?php echo sortIcon('name', $sort, $order); ?>
                                            </span></a></th>
                                    <th><a href="#" class="sort-link" data-sort="specification">Designation <span
                                                id="sort-icon-specification">
                                                <?php echo sortIcon('specification', $sort, $order); ?>
                                            </span></a></th>
                                    <th><a href="#" class="sort-link" data-sort="department">Department <span
                                                id="sort-icon-department">
                                                <?php echo sortIcon('department', $sort, $order); ?>
                                            </span></a></th>
                                    <th style="width: 150px;" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php $i = $offset + 1; ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <?php echo $i++; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $imgPath = $row['image'] && file_exists("../assets/files/people/" . $row['image'])
                                                    ? "../assets/files/people/" . htmlspecialchars($row['image'])
                                                    : "../assets/files/people/placeholder.png";
                                                ?>
                                                <img src="<?php echo $imgPath; ?>" alt="Person"
                                                    style="height: 50px; width: 50px; object-fit: cover; border-radius: 50%;">
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($row['name']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($row['specification'] ?? ''); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($row['department'] ?? ''); ?>
                                            </td>
                                            <td class="text-end">
                                                <a href="edit-people.php?id=<?php echo $row['id']; ?>"
                                                    class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></a>
                                                <a href="delete-people.php?id=<?php echo $row['id']; ?>"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this person?');"><i
                                                        class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">No people found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-4" id="pagination-container">
                        <?php if ($totalPages > 1): ?>
                            <ul class="pagination justify-content-end">
                                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="#" data-page="<?php echo $page - 1; ?>">Previous</a>
                                </li>
                                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                                    <li class="page-item <?php echo ($p == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="#" data-page="<?php echo $p; ?>">
                                            <?php echo $p; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="#" data-page="<?php echo $page + 1; ?>">Next</a>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </nav>

                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('live-search');
            const tableBody = document.getElementById('table-body');
            const paginationContainer = document.getElementById('pagination-container');
            let currentSort = '<?php echo $sort; ?>';
            let currentOrder = '<?php echo $order; ?>';
            let currentPage = <?php echo $page; ?>;

            // Debounce
            function debounce(func, timeout = 300) {
                let timer;
                return (...args) => {
                    clearTimeout(timer);
                    timer = setTimeout(() => { func.apply(this, args); }, timeout);
                };
            }

            function fetchData(page = 1) {
                const searchTerm = searchInput.value;
                const params = new URLSearchParams({
                    ajax: 1,
                    page: page,
                    search: searchTerm,
                    sort: currentSort,
                    order: currentOrder
                });

                fetch('people.php?' + params.toString())
                    .then(response => response.json())
                    .then(data => {
                        tableBody.innerHTML = data.table;
                        paginationContainer.innerHTML = data.pagination;
                        currentPage = page;

                        const newUrlParams = new URLSearchParams({
                            page: page,
                            search: searchTerm,
                            sort: currentSort,
                            order: currentOrder
                        });
                        window.history.replaceState({}, '', '?' + newUrlParams.toString());

                        bindPaginationLinks();
                    })
                    .catch(error => console.error('Error:', error));
            }

            const handleSearch = debounce(() => fetchData(1));

            searchInput.addEventListener('input', handleSearch);

            // Sort
            document.querySelectorAll('.sort-link').forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const col = this.getAttribute('data-sort');
                    if (currentSort === col) {
                        currentOrder = currentOrder === 'ASC' ? 'DESC' : 'ASC';
                    } else {
                        currentSort = col;
                        currentOrder = 'DESC';
                    }

                    document.querySelectorAll('.sort-link span').forEach(span => span.innerHTML = '<i class="fas fa-sort text-muted ms-1" style="font-size:0.8em;"></i>');
                    const icon = currentOrder === 'ASC' ? '<i class="fas fa-sort-up ms-1"></i>' : '<i class="fas fa-sort-down ms-1"></i>';
                    this.querySelector('span').innerHTML = icon;

                    fetchData(1);
                });
            });

            // Pagination
            function bindPaginationLinks() {
                document.querySelectorAll('.page-link').forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        if (this.parentElement.classList.contains('disabled')) return;
                        const page = this.getAttribute('data-page');
                        fetchData(page);
                    });
                });
            }

            bindPaginationLinks();
        });
    </script>
</body>

</html>