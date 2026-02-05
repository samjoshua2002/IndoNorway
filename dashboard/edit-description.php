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
$success = '';
$desc = null;

// If ID provided, fetch existing data
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM description WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $desc = $stmt->get_result()->fetch_assoc();

    if (!$desc) {
        header("Location: description.php");
        exit();
    }
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $about = $_POST['about'] ?? '';

    // Handle Image Upload
    $imageName = $desc['image'] ?? null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp'];
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $_FILES['image']['tmp_name']);
        finfo_close($fileInfo);

        if (in_array($mimeType, $allowedTypes)) {
            $uploadDir = '../assets/files/home/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Clean filename
            $filename = basename($_FILES['image']['name']);
            $filename = time() . '_' . $filename; // Add timestamp

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
            // Update
            $stmt = $conn->prepare("UPDATE description SET about = ?, image = ? WHERE id = ?");
            $stmt->bind_param("ssi", $about, $imageName, $id);
            if ($stmt->execute()) {
                header("Location: description.php");
                exit();
            } else {
                $error = "Database update failed: " . $conn->error;
            }
        } else {
            // Insert
            $stmt = $conn->prepare("INSERT INTO description (about, image) VALUES (?, ?)");
            $stmt->bind_param("ss", $about, $imageName);
            if ($stmt->execute()) {
                header("Location: description.php");
                exit();
            } else {
                $error = "Database insert failed: " . $conn->error;
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
    <title>
        <?php echo $id ? 'Edit' : 'Add'; ?> Description - IndoNorway Connect
    </title>
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,300;0,400;1,300&family=Figtree:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main Styles -->
    <link rel="stylesheet" href="../styles/style.css">

    <style>
        /* Shared Dashboard Styles */
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
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="content-wrapper">
        <?php include 'sidebar.php'; ?>

        <main class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 style="font-family: 'Figtree', sans-serif;">
                    <?php echo $id ? 'Edit' : 'Add'; ?> Description
                </h2>
                <a href="description.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to List
                </a>
            </div>

            <div class="card shadow-sm border-0" style="max-width: 800px;">
                <div class="card-body p-4">
                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">

                        <div class="mb-4">
                            <label for="about" class="form-label fw-bold">About Content</label>
                            <textarea class="form-control" id="about" name="about" rows="10"
                                required><?php echo $id ? htmlspecialchars($desc['about']) : ''; ?></textarea>
                            <div class="form-text">This text will be displayed in the description section.</div>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold">Side Image</label>
                            <?php if ($id && !empty($desc['image'])): ?>
                                <div class="mb-2 p-3 border rounded bg-light mb-3">
                                    <p class="small text-muted mb-2">Current Image:</p>
                                    <img src="../assets/files/home/<?php echo htmlspecialchars($desc['image']); ?>"
                                        alt="Current Image" class="img-fluid" style="max-height: 200px;">
                                </div>
                            <?php endif; ?>

                            <input type="file" class="form-control" id="image" name="image" accept="image/*" <?php echo $id ? '' : 'required'; ?>>
                            <div class="form-text">Allowed formats: JPG, PNG, SVG, WEBP</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light"
                                onclick="window.location.href='description.php'">Cancel</button>
                            <button type="submit" class="btn btn-primary"
                                style="background: var(--bg-dark-blue); border: none;">
                                <?php echo $id ? 'Update Content' : 'Add Content'; ?>
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