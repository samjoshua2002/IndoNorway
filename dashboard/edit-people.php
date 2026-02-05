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
$person = null;

if ($id) {
    // Check if table column is 'department' or 'deparartment' based on earlier typo
    // The create query used 'department'.
    $stmt = $conn->prepare("SELECT * FROM people WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $person = $stmt->get_result()->fetch_assoc();
    if (!$person) {
        header("Location: people.php");
        exit();
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete Image Logic
    if (isset($_POST['delete_image']) && $id) {
        $stmt = $conn->prepare("UPDATE people SET image = 'placeholder.png' WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            // Update local variable
            $person['image'] = 'placeholder.png';
            // header("Location: edit-people.php?id=" . $id);
            // exit();
        } else {
            $error = "Failed to remove image.";
        }
    } else {
        $name = $_POST['name'] ?? '';
        $specification = $_POST['specification'] ?? '';
        $department = $_POST['department'] ?? '';
        $college1 = $_POST['college1'] ?? '';
        $college2 = $_POST['college2'] ?? '';
        $college3 = $_POST['college3'] ?? '';
        $college4 = $_POST['college4'] ?? '';
        $about = $_POST['about'] ?? '';
        $researchintest = $_POST['researchintest'] ?? '';
        $contact = $_POST['contact'] ?? '';

        // Handle Image Upload
        $imageName = $person['image'] ?? 'placeholder.png';

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp'];
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfo, $_FILES['image']['tmp_name']);
            finfo_close($fileInfo);

            if (in_array($mimeType, $allowedTypes)) {
                $uploadDir = '../assets/files/people/';
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
                // Update
                $stmt = $conn->prepare("UPDATE people SET name=?, specification=?, department=?, college1=?, college2=?, college3=?, college4=?, about=?, researchintest=?, contact=?, image=? WHERE id=?");
                $stmt->bind_param("sssssssssssi", $name, $specification, $department, $college1, $college2, $college3, $college4, $about, $researchintest, $contact, $imageName, $id);
            } else {
                // Insert
                $stmt = $conn->prepare("INSERT INTO people (name, specification, department, college1, college2, college3, college4, about, researchintest, contact, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssssssss", $name, $specification, $department, $college1, $college2, $college3, $college4, $about, $researchintest, $contact, $imageName);
            }

            if ($stmt->execute()) {
                header("Location: people.php");
                exit();
            } else {
                $error = "Database Error: " . $stmt->error;
            }
            $stmt->close();
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
        <?php echo $id ? 'Edit' : 'Add'; ?> Person - IndoNorway Connect
    </title>
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
                    <?php echo $id ? 'Edit' : 'Add'; ?> Person
                </h2>
                <a href="people.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to List
                </a>
            </div>

            <div class="card shadow-sm border-0" style="max-width: 900px;">
                <div class="card-body p-4">
                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="<?php echo $id ? htmlspecialchars($person['name']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="specification" class="form-label fw-bold">Designation</label>
                                    <input type="text" class="form-control" id="specification" name="specification"
                                        placeholder="e.g. Professor"
                                        value="<?php echo $id ? htmlspecialchars($person['specification']) : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="department" class="form-label fw-bold">Department</label>
                                    <input type="text" class="form-control" id="department" name="department"
                                        placeholder="e.g. Department of Chemical Engineering"
                                        value="<?php echo $id ? htmlspecialchars($person['department']) : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="college1" class="form-label fw-bold">Location Line 1</label>
                                    <input type="text" class="form-control" id="college1" name="college1"
                                        placeholder="e.g. IIT Madras"
                                        value="<?php echo $id ? htmlspecialchars($person['college1']) : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="college2" class="form-label fw-bold">Location Line 2</label>
                                    <input type="text" class="form-control" id="college2" name="college2"
                                        value="<?php echo $id ? htmlspecialchars($person['college2']) : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="college3" class="form-label fw-bold">Location Line 3</label>
                                    <input type="text" class="form-control" id="college3" name="college3"
                                        value="<?php echo $id ? htmlspecialchars($person['college3']) : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="college4" class="form-label fw-bold">Location Line 4</label>
                                    <input type="text" class="form-control" id="college4" name="college4"
                                        value="<?php echo $id ? htmlspecialchars($person['college4']) : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="about" class="form-label fw-bold">Bio (About)</label>
                            <textarea class="form-control" id="about" name="about"
                                rows="4"><?php echo $id ? htmlspecialchars($person['about']) : ''; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="researchintest" class="form-label fw-bold">Research Interests</label>
                            <textarea class="form-control" id="researchintest" name="researchintest"
                                rows="3"><?php echo $id ? htmlspecialchars($person['researchintest']) : ''; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="contact" class="form-label fw-bold">Contact Email</label>
                            <input type="text" class="form-control" id="contact" name="contact"
                                value="<?php echo $id ? htmlspecialchars($person['contact']) : ''; ?>">
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold">Profile Image</label>
                            <?php if ($id && !empty($person['image']) && $person['image'] !== 'placeholder.png'): ?>
                                <div class="mb-3 p-3 border rounded bg-light d-flex flex-column">
                                    <p class="small text-muted mb-2">Current Image:</p>
                                    <img src="../assets/files/people/<?php echo htmlspecialchars($person['image']); ?>"
                                        alt="Current Image" class="img-fluid mb-2"
                                        style="max-height: 150px; max-width: 150px; object-fit: cover;">

                                    <button type="submit" name="delete_image" value="1"
                                        class="btn btn-sm btn-outline-danger mt-auto align-self-start"
                                        onclick="return confirm('Reset to placeholder?')">
                                        <i class="fas fa-trash"></i> Reset Image
                                    </button>
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">If no image is uploaded, a default placeholder will be used.</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <button type="button" class="btn btn-light"
                                onclick="window.location.href='people.php'">Cancel</button>
                            <button type="submit" class="btn btn-primary"
                                style="background: var(--bg-dark-blue); border: none;">
                                <?php echo $id ? 'Update Person' : 'Save Person'; ?>
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