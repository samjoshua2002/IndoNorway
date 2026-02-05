<?php
session_start();
require_once '../database.php';

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch partners
$sql = "SELECT * FROM partners ORDER BY id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Partners - IndoNorway Connect</title>
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,300;0,400;1,300&family=Figtree:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main Styles -->
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="dashboard.css">

    <style>
        /* Dashboard Specific Styles */
        body {
            background-color: #f4f6f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Top Navbar */
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

        /* Sidebar and Main Layout */
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

        /* Submenu styles */
        .collapse .menu-item {
            font-size: 0.95rem;
            border-left: none;
        }

        .collapse .menu-item:hover {
            background: #f1f3f5;
            border-left: 4px solid var(--btn-light);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
            background: #f4f6f9;
        }

        /* Custom Table */
        .table-custom th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
            font-weight: 600;
        }

        .table-custom td {
            vertical-align: middle;
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
            <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in-down">
                <h2 style="font-family: 'Figtree', sans-serif;">Manage Partners</h2>
                <a href="edit-partner.php" class="btn btn-primary"
                    style="background: var(--bg-dark-blue); border: none;">
                    <i class="fas fa-plus me-2"></i> Add New Partner
                </a>
            </div>

            <div class="card shadow-sm border-0 animate-fade-in-up delay-1">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-custom mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">S.No</th>
                                    <th style="width: 150px;">Image</th>
                                    <th>Title</th>
                                    <th style="width: 150px;" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php $i = 1; ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td>
                                                <?php if ($row['image']): ?>
                                                    <img src="../assets/files/home/<?php echo htmlspecialchars($row['image']); ?>"
                                                        alt="Partner"
                                                        style="height: 40px; width: auto; max-width: 100px; object-fit: contain;">
                                                <?php else: ?>
                                                    <span class="text-muted small">No Image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                                            <td class="text-end">
                                                <a href="edit-partner.php?id=<?php echo $row['id']; ?>"
                                                    class="btn btn-sm btn-outline-primary me-1">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="delete-partner.php?id=<?php echo $row['id']; ?>"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this partner?');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No partners found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>