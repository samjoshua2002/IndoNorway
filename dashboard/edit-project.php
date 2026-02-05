<?php
session_start();
require_once '../database.php';

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'] ?? null;
$error = '';
$project = null;

// If ID provided, fetch existing data
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $project = $stmt->get_result()->fetch_assoc();

    if (!$project) {
        header("Location: projects.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if it's an image deletion request
    if (isset($_POST['delete_image']) && $id) {
        $stmt = $conn->prepare("UPDATE projects SET image = NULL WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: edit-project.php?id=" . $id);
            exit();
        } else {
            $error = "Failed to remove image.";
        }
    } else {
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? '';
        $tag = $_POST['tag'] ?? '';
        $date = $_POST['date'] ?? '';
        $description = $_POST['description'] ?? '';
        $overview = $_POST['overview'] ?? '';

        // Process Investigators
        $investigators = array_filter($_POST['investigator'] ?? []);
        $investigatorStr = !empty($investigators) ? implode('<br />', array_map('htmlspecialchars', $investigators)) : null;

        // Process Funding Partners
        $funding = array_filter($_POST['funding_partner'] ?? []);
        $fundingStr = !empty($funding) ? implode('<br />', array_map('htmlspecialchars', $funding)) : null;

        // Process Budget
        $budget = array_filter($_POST['budget'] ?? []);
        $budgetStr = !empty($budget) ? implode('<br />', array_map('htmlspecialchars', $budget)) : null;

        // Process Mobilities
        $mobilities = array_filter($_POST['mobilities'] ?? []);
        // FIX: Ensure correct variable name usage
        $mobilitiesStr = !empty($mobilities) ? implode('<br />', array_map('htmlspecialchars', $mobilities)) : null;

        // Process Publications (Structured)
        $pubCitations = $_POST['pub_citation'] ?? [];
        $pubLinks = $_POST['pub_link'] ?? [];
        $pubLinkTexts = $_POST['pub_link_text'] ?? [];

        $formattedPubs = [];
        if (is_array($pubCitations)) {
            for ($i = 0; $i < count($pubCitations); $i++) {
                $citation = trim($pubCitations[$i]);
                if (empty($citation))
                    continue;

                $link = trim($pubLinks[$i] ?? '');
                $linkText = trim($pubLinkTexts[$i] ?? '');

                // Construct HTML: <div class="pub-item">Citation... <a href="...">LinkText</a></div>
                $html = '<div class="pub-item">' . htmlspecialchars($citation);

                if (!empty($link)) {
                    if (empty($linkText)) {
                        $linkText = preg_replace('#^https?://#', '', $link);
                    }
                    $html .= ' <a href="' . htmlspecialchars($link) . '" target="_blank" class="citation-doi">' . htmlspecialchars($linkText) . '</a>';
                }

                $html .= '</div>';
                $formattedPubs[] = $html;
            }
        }
        $publicationStr = !empty($formattedPubs) ? implode('', $formattedPubs) : null;


        // Handle Image Upload
        $imageName = $project['image'] ?? null;

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp'];
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfo, $_FILES['image']['tmp_name']);
            finfo_close($fileInfo);

            if (in_array($mimeType, $allowedTypes)) {
                $uploadDir = '../assets/files/projects/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $filename = basename($_FILES['image']['name']);
                $filename = time() . '_' . $filename;
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $imageName = $filename;
                } else {
                    $error = "Failed to upload image.";
                }
            } else {
                $error = "Invalid file type. Only JPG, PNG, SVG, and WEBP allowed.";
            }
        }

        if (!$error) {
            if ($id) {
                // IMPORTANT: Ensure 'mobilites' matches exact column name in DB (schema has 'mobilites' misspelled potentially?)
                // Based on previous valid queries, it seems the column is likely 'mobilites' (checked schema: projects table has 'mobilites' text default null)
                $stmt = $conn->prepare("UPDATE projects SET category=?, tag=?, image=?, title=?, Description=?, date=?, investigator=?, funding_partner=?, budget=?, mobilites=?, publication=?, overview=? WHERE id=?");
                $stmt->bind_param("ssssssssssssi", $category, $tag, $imageName, $title, $description, $date, $investigatorStr, $fundingStr, $budgetStr, $mobilitiesStr, $publicationStr, $overview, $id);
            } else {
                $stmt = $conn->prepare("INSERT INTO projects (category, tag, image, title, Description, date, investigator, funding_partner, budget, mobilites, publication, overview) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssssssss", $category, $tag, $imageName, $title, $description, $date, $investigatorStr, $fundingStr, $budgetStr, $mobilitiesStr, $publicationStr, $overview);
            }

            if ($stmt->execute()) {
                header("Location: projects.php");
                exit();
            } else {
                $error = "Database error: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $id ? 'Edit' : 'Add'; ?> Project - IndoNorway Connect</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,300;0,400;1,300&family=Figtree:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">

    <style>
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

        .toggle-field-btn {
            font-size: 0.85rem;
            padding: 2px 8px;
            margin-left: 10px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
            background: #fff;
            cursor: pointer;
        }

        .toggle-field-btn.active {
            background: var(--bg-dark-blue);
            color: white;
            border-color: var(--bg-dark-blue);
        }

        .dynamic-list-item {
            display: flex;
            gap: 10px;
            margin-bottom: 8px;
            align-items: flex-start;
        }

        .btn-plus {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            padding: 0;
            flex-shrink: 0;
        }

        /* Publication Specific */
        .pub-form-item {
            background: #fff;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-bottom: 15px;
            position: relative;
        }

        .pub-form-item .remove-pub-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        function toggleSection(id, btn) {
            const section = document.getElementById(id);
            if (section.style.display === 'none') {
                section.style.display = 'block';
                btn.classList.add('active');
                btn.innerHTML = 'Hide';
            } else {
                section.style.display = 'none';
                btn.classList.remove('active');
                btn.innerHTML = 'Show';
            }
        }

        function addListItem(containerId, inputName, placeholder) {
            const container = document.getElementById(containerId);
            const div = document.createElement('div');
            div.className = 'dynamic-list-item';
            div.innerHTML = `
                <input type="text" class="form-control" name="${inputName}[]" placeholder="${placeholder}">
                <button type="button" class="btn btn-outline-danger btn-plus" onclick="this.parentElement.remove()">
                    <i class="fas fa-minus"></i>
                </button>
            `;
            container.appendChild(div);
        }

        function addPublicationItem() {
            const container = document.getElementById('publication-list');
            const div = document.createElement('div');
            div.className = 'pub-form-item';
            div.innerHTML = `
                <button type="button" class="btn btn-sm btn-outline-danger remove-pub-btn" onclick="this.parentElement.remove()">
                    <i class="fas fa-trash"></i>
                </button>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Citation (Authors, Year, Title, Journal)</label>
                    <textarea class="form-control form-control-sm" name="pub_citation[]" rows="2" placeholder="e.g. Krishnamurthy, S. (2022). Kinetics of aggregation..."></textarea>
                </div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">DOI / Link URL</label>
                        <input type="url" class="form-control form-control-sm" name="pub_link[]" placeholder="https://doi.org/10.1016/...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Link Display Text</label>
                        <input type="text" class="form-control form-control-sm" name="pub_link_text[]" placeholder="e.g. doi.org/10.1016/...">
                    </div>
                </div>
            `;
            container.appendChild(div);
        }
    </script>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="content-wrapper">
        <?php include 'sidebar.php'; ?>

        <main class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 style="font-family: 'Figtree', sans-serif;"><?php echo $id ? 'Edit' : 'Add'; ?> Project</h2>
                <a href="projects.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to List
                </a>
            </div>

            <div class="card shadow-sm border-0" style="max-width: 900px;">
                <div class="card-body p-4">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">

                        <!-- Basic Info -->
                        <div class="mb-4">
                            <h5 class="mb-3 text-secondary">Basic Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Title</label>
                                    <input type="text" class="form-control" name="title"
                                        value="<?php echo $id ? htmlspecialchars($project['title']) : ''; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Detail Tag</label>
                                    <input type="text" class="form-control" name="tag"
                                        value="<?php echo $id ? htmlspecialchars($project['tag']) : ''; ?>"
                                        placeholder="e.g. Erasmus+ Global Mobility">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Category</label>
                                    <select class="form-select" name="category">
                                        <option value="ongoing" <?php if ($id && $project['category'] == 'ongoing')
                                            echo 'selected'; ?>>Ongoing</option>
                                        <option value="completed" <?php if ($id && $project['category'] == 'completed')
                                            echo 'selected'; ?>>Completed</option>
                                        <option value="upcoming" <?php if ($id && $project['category'] == 'upcoming')
                                            echo 'selected'; ?>>Upcoming</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Date / Duration</label>
                                    <input type="text" class="form-control" name="date"
                                        value="<?php echo $id ? htmlspecialchars($project['date']) : ''; ?>"
                                        placeholder="e.g. 2020–2026">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Image</label>
                                    <?php if ($id && !empty($project['image'])): ?>
                                        <div class="mb-2">
                                            <img src="../assets/files/projects/<?php echo htmlspecialchars($project['image']); ?>"
                                                alt="Current" style="height: 60px; object-fit: cover;">
                                            <button type="submit" name="delete_image" value="1"
                                                class="btn btn-sm btn-outline-danger ms-2" title="Remove Image"
                                                onclick="return confirm('Remove this image?')"><i
                                                    class="fas fa-trash"></i></button>
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Description (Card)</label>
                                <textarea class="form-control" name="description"
                                    rows="3"><?php echo $id ? htmlspecialchars($project['Description']) : ''; ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Overview (Detail Page)</label>
                                <textarea class="form-control" name="overview"
                                    rows="4"><?php echo $id ? htmlspecialchars($project['overview']) : ''; ?></textarea>
                            </div>
                        </div>

                        <!-- Optional Fields with Toggle -->
                        <div class="mb-4">
                            <h5 class="mb-3 text-secondary">Create Project Details</h5>

                            <!-- Investigators -->
                            <div class="mb-3 p-3 border rounded bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="fw-bold m-0">Investigators</label>
                                    <button type="button"
                                        class="toggle-field-btn <?php echo ($id && !empty($project['investigator'])) ? 'active' : ''; ?>"
                                        onclick="toggleSection('investigator-sec', this)">
                                        <?php echo ($id && !empty($project['investigator'])) ? 'Hide' : 'Show'; ?>
                                    </button>
                                </div>
                                <div id="investigator-sec"
                                    style="display: <?php echo ($id && !empty($project['investigator'])) ? 'block' : 'none'; ?>;">
                                    <div id="investigator-list">
                                        <?php
                                        if ($id && !empty($project['investigator'])) {
                                            $items = explode('<br />', $project['investigator']);
                                            foreach ($items as $item) {
                                                echo '<div class="dynamic-list-item">
                                                        <input type="text" class="form-control" name="investigator[]" value="' . htmlspecialchars(strip_tags($item)) . '">
                                                        <button type="button" class="btn btn-outline-danger btn-plus" onclick="this.parentElement.remove()"><i class="fas fa-minus"></i></button>
                                                       </div>';
                                            }
                                        } else {
                                            echo '<div class="dynamic-list-item">
                                                    <input type="text" class="form-control" name="investigator[]" placeholder="e.g. Dr. Ethayaraja Mani (PI – India)">
                                                    <button type="button" class="btn btn-outline-danger btn-plus" onclick="this.parentElement.remove()"><i class="fas fa-minus"></i></button>
                                                  </div>';
                                        }
                                        ?>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-1"
                                        onclick="addListItem('investigator-list', 'investigator', 'Investigator Name')">
                                        <i class="fas fa-plus"></i> Add Investigator
                                    </button>
                                </div>
                            </div>

                            <!-- Funding Partners -->
                            <div class="mb-3 p-3 border rounded bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="fw-bold m-0">Funding Partners</label>
                                    <button type="button"
                                        class="toggle-field-btn <?php echo ($id && !empty($project['funding_partner'])) ? 'active' : ''; ?>"
                                        onclick="toggleSection('funding-sec', this)">
                                        <?php echo ($id && !empty($project['funding_partner'])) ? 'Hide' : 'Show'; ?>
                                    </button>
                                </div>
                                <div id="funding-sec"
                                    style="display: <?php echo ($id && !empty($project['funding_partner'])) ? 'block' : 'none'; ?>;">
                                    <div id="funding-list">
                                        <?php
                                        if ($id && !empty($project['funding_partner'])) {
                                            $items = explode('<br />', $project['funding_partner']);
                                            foreach ($items as $item) {
                                                echo '<div class="dynamic-list-item">
                                                        <input type="text" class="form-control" name="funding_partner[]" value="' . htmlspecialchars(strip_tags($item)) . '">
                                                        <button type="button" class="btn btn-outline-danger btn-plus" onclick="this.parentElement.remove()"><i class="fas fa-minus"></i></button>
                                                       </div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-1"
                                        onclick="addListItem('funding-list', 'funding_partner', 'Funding Partner')">
                                        <i class="fas fa-plus"></i> Add Partner
                                    </button>
                                </div>
                            </div>

                            <!-- Budget -->
                            <div class="mb-3 p-3 border rounded bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="fw-bold m-0">Budget</label>
                                    <button type="button"
                                        class="toggle-field-btn <?php echo ($id && !empty($project['budget'])) ? 'active' : ''; ?>"
                                        onclick="toggleSection('budget-sec', this)">
                                        <?php echo ($id && !empty($project['budget'])) ? 'Hide' : 'Show'; ?>
                                    </button>
                                </div>
                                <div id="budget-sec"
                                    style="display: <?php echo ($id && !empty($project['budget'])) ? 'block' : 'none'; ?>;">
                                    <div id="budget-list">
                                        <?php
                                        if ($id && !empty($project['budget'])) {
                                            $items = explode('<br />', $project['budget']);
                                            foreach ($items as $item) {
                                                echo '<div class="dynamic-list-item">
                                                        <input type="text" class="form-control" name="budget[]" value="' . htmlspecialchars(strip_tags($item)) . '">
                                                        <button type="button" class="btn btn-outline-danger btn-plus" onclick="this.parentElement.remove()"><i class="fas fa-minus"></i></button>
                                                       </div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-1"
                                        onclick="addListItem('budget-list', 'budget', 'Budget Amount')">
                                        <i class="fas fa-plus"></i> Add Budget Line
                                    </button>
                                </div>
                            </div>

                            <!-- Mobilities -->
                            <div class="mb-3 p-3 border rounded bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="fw-bold m-0">Mobilities</label>
                                    <button type="button"
                                        class="toggle-field-btn <?php echo ($id && !empty($project['mobilites'])) ? 'active' : ''; ?>"
                                        onclick="toggleSection('mobilites-sec', this)">
                                        <?php echo ($id && !empty($project['mobilites'])) ? 'Hide' : 'Show'; ?>
                                    </button>
                                </div>
                                <div id="mobilites-sec"
                                    style="display: <?php echo ($id && !empty($project['mobilites'])) ? 'block' : 'none'; ?>;">
                                    <div id="mobilites-list">
                                        <?php
                                        if ($id && !empty($project['mobilites'])) {

                                            $items = explode('<br />', $project['mobilites']);
                                            foreach ($items as $item) {
                                                echo '<div class="dynamic-list-item">
                                                        <input type="text" class="form-control" name="mobilities[]" value="' . htmlspecialchars(strip_tags($item)) . '">
                                                        <button type="button" class="btn btn-outline-danger btn-plus" onclick="this.parentElement.remove()"><i class="fas fa-minus"></i></button>
                                                       </div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-1"
                                        onclick="addListItem('mobilites-list', 'mobilities', 'Person/Mobility Info')">
                                        <i class="fas fa-plus"></i> Add Mobility
                                    </button>
                                </div>
                            </div>

                            <!-- Publications (Structured) -->
                            <div class="mb-3 p-3 border rounded bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="fw-bold m-0">Publications</label>
                                    <button type="button"
                                        class="toggle-field-btn <?php echo ($id && !empty($project['publication'])) ? 'active' : ''; ?>"
                                        onclick="toggleSection('publication-sec', this)">
                                        <?php echo ($id && !empty($project['publication'])) ? 'Hide' : 'Show'; ?>
                                    </button>
                                </div>
                                <div id="publication-sec"
                                    style="display: <?php echo ($id && !empty($project['publication'])) ? 'block' : 'none'; ?>;">
                                    <div id="publication-list">
                                        <?php
                                        if ($id && !empty($project['publication'])) {
                                            preg_match_all('/<div class="pub-item">(.*?)<\/div>/s', $project['publication'], $matches);

                                            if (!empty($matches[1])) {
                                                foreach ($matches[1] as $innerHtml) {
                                                    $citationVal = '';
                                                    $linkVal = '';
                                                    $linkTextVal = '';

                                                    if (preg_match('/(.*?)<a href="([^"]+)"[^>]*>(.*?)<\/a>/s', $innerHtml, $linkMatches)) {
                                                        $citationVal = trim(strip_tags($linkMatches[1]));
                                                        $linkVal = htmlspecialchars_decode($linkMatches[2]);
                                                        $linkTextVal = strip_tags($linkMatches[3]);
                                                    } else {
                                                        $citationVal = trim(strip_tags($innerHtml));
                                                    }

                                                    echo '
                                                     <div class="pub-form-item">
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-pub-btn" onclick="this.parentElement.remove()">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <div class="mb-2">
                                                            <label class="form-label small fw-bold">Citation (Authors, Year, Title, Journal)</label>
                                                            <textarea class="form-control form-control-sm" name="pub_citation[]" rows="2">' . htmlspecialchars($citationVal) . '</textarea>
                                                        </div>
                                                        <div class="row g-2">
                                                            <div class="col-md-6">
                                                                <label class="form-label small fw-bold">DOI / Link URL</label>
                                                                <input type="url" class="form-control form-control-sm" name="pub_link[]" value="' . htmlspecialchars($linkVal) . '">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label small fw-bold">Link Display Text</label>
                                                                <input type="text" class="form-control form-control-sm" name="pub_link_text[]" value="' . htmlspecialchars($linkTextVal) . '">
                                                            </div>
                                                        </div>
                                                    </div>';
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-1"
                                        onclick="addPublicationItem()">
                                        <i class="fas fa-plus"></i> Add Publication
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light"
                                onclick="window.location.href='projects.php'">Cancel</button>
                            <button type="submit" class="btn btn-primary"
                                style="background: var(--bg-dark-blue); border: none;">
                                <?php echo $id ? 'Update Project' : 'Save Project'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>