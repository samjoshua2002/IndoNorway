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
$event = null;
$sections = [];

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $event = $stmt->get_result()->fetch_assoc();
    if (!$event) {
        header("Location: news.php");
        exit();
    }
    $stmt->close();

    $stmtSec = $conn->prepare("SELECT * FROM event_sections WHERE event_id = ? ORDER BY section_order ASC");
    $stmtSec->bind_param("i", $id);
    $stmtSec->execute();
    $resultSec = $stmtSec->get_result();
    while ($row = $resultSec->fetch_assoc()) {
        $sections[] = $row;
    }
    $stmtSec->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for Image Deletion
    if (isset($_POST['delete_image']) && $id) {
        $stmt = $conn->prepare("UPDATE events SET image = NULL WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: edit-news.php?id=" . $id);
            exit();
        } else {
            $error = "Failed to remove image.";
        }
    } else {
        $title = $_POST['title'] ?? '';
        $tag = $_POST['tag'] ?? '';
        $event_date = $_POST['event_date'] ?? '';
        $event_time = $_POST['event_time'] ?? '';
        $venue = $_POST['venue'] ?? '';
        $speaker = $_POST['speaker'] ?? '';
        $description = $_POST['description'] ?? '';

        // Handle Image Upload
        $imageName = $event['image'] ?? null;

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp'];
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfo, $_FILES['image']['tmp_name']);
            finfo_close($fileInfo);

            if (in_array($mimeType, $allowedTypes)) {
                $uploadDir = '../assets/files/news/';
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
                $stmt = $conn->prepare("UPDATE events SET title=?, tag=?, event_date=?, event_time=?, venue=?, speaker=?, description=?, image=? WHERE id=?");
                $stmt->bind_param("ssssssssi", $title, $tag, $event_date, $event_time, $venue, $speaker, $description, $imageName, $id);
                $stmt->execute();
                $stmt->close();
            } else {
                $stmt = $conn->prepare("INSERT INTO events (title, tag, event_date, event_time, venue, speaker, description, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssss", $title, $tag, $event_date, $event_time, $venue, $speaker, $description, $imageName);
                if ($stmt->execute()) {
                    $id = $conn->insert_id;
                }
                $stmt->close();
            }

            // Save Sections
            if (!$error && $id) {
                $submitted_section_ids = $_POST['section_id'] ?? [];
                $subtitles = $_POST['subtitle'] ?? [];
                $sub_descriptions = $_POST['sub_description'] ?? [];

                $existing_ids = [];
                $stmtGet = $conn->prepare("SELECT id FROM event_sections WHERE event_id = ?");
                $stmtGet->bind_param("i", $id);
                $stmtGet->execute();
                $resultGet = $stmtGet->get_result();
                while ($row = $resultGet->fetch_assoc()) {
                    $existing_ids[] = $row['id'];
                }
                $stmtGet->close();

                $processed_ids = [];
                $stmtUpdateSec = $conn->prepare("UPDATE event_sections SET subtitle=?, sub_description=?, section_order=? WHERE id=?");
                $stmtInsertSec = $conn->prepare("INSERT INTO event_sections (event_id, subtitle, sub_description, section_order) VALUES (?, ?, ?, ?)");

                for ($i = 0; $i < count($subtitles); $i++) {
                    $sec_id = $submitted_section_ids[$i] ?? null;
                    $sub_title = $subtitles[$i];
                    $sub_desc = $sub_descriptions[$i];
                    $order = $i + 1;

                    if (!empty($sec_id) && in_array($sec_id, $existing_ids)) {
                        $stmtUpdateSec->bind_param("ssii", $sub_title, $sub_desc, $order, $sec_id);
                        $stmtUpdateSec->execute();
                        $processed_ids[] = $sec_id;
                    } else {
                        $stmtInsertSec->bind_param("issi", $id, $sub_title, $sub_desc, $order);
                        $stmtInsertSec->execute();
                    }
                }
                $stmtUpdateSec->close();
                $stmtInsertSec->close();

                $ids_to_delete = array_diff($existing_ids, $processed_ids);
                if (!empty($ids_to_delete)) {
                    $ids_str = implode(',', array_map('intval', $ids_to_delete));
                    $conn->query("DELETE FROM event_sections WHERE id IN ($ids_str)");
                }

                header("Location: news.php");
                exit();
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
    <title><?php echo $id ? 'Edit' : 'Add'; ?> Event - IndoNorway Connect</title>
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
                <h2 style="font-family: 'Figtree', sans-serif;"><?php echo $id ? 'Edit' : 'Add'; ?> News / Event</h2>
                <a href="news.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to List
                </a>
            </div>

            <div class="card shadow-sm border-0" style="max-width: 900px;">
                <div class="card-body p-4">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">

                        <!-- Main Event Details -->
                        <div class="mb-4">
                            <h5 class="mb-3 text-secondary">Basic Information</h5>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label fw-bold">Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="<?php echo $id ? htmlspecialchars($event['title']) : ''; ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="tag" class="form-label fw-bold">Tag (e.g. SEMINAR)</label>
                                        <input type="text" class="form-control" id="tag" name="tag"
                                            value="<?php echo $id ? htmlspecialchars($event['tag']) : ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="event_date" class="form-label fw-bold">Event Date</label>
                                        <input type="text" class="form-control" id="event_date" name="event_date"
                                            placeholder="e.g. 12 SEPTEMBER 2025"
                                            value="<?php echo $id ? htmlspecialchars($event['event_date']) : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="event_time" class="form-label fw-bold">Event Time</label>
                                        <input type="text" class="form-control" id="event_time" name="event_time"
                                            placeholder="e.g. 4:00 PM"
                                            value="<?php echo $id ? htmlspecialchars($event['event_time']) : ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="venue" class="form-label fw-bold">Venue</label>
                                        <input type="text" class="form-control" id="venue" name="venue"
                                            value="<?php echo $id ? htmlspecialchars($event['venue']) : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="speaker" class="form-label fw-bold">Speaker Profile</label>
                                        <textarea class="form-control" id="speaker" name="speaker"
                                            rows="3"><?php echo $id ? htmlspecialchars($event['speaker']) : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Description / content</label>
                                <textarea class="form-control" id="description" name="description"
                                    rows="10"><?php echo $id ? htmlspecialchars($event['description']) : ''; ?></textarea>
                                <div class="form-text">You can use basic HTML tags if needed.</div>
                            </div>

                            <div class="mb-4">
                                <label for="image" class="form-label fw-bold">Event Image</label>
                                <?php if ($id && !empty($event['image'])): ?>
                                    <div class="mb-3 p-3 border rounded bg-light d-flex flex-column">
                                        <p class="small text-muted mb-2">Current Image:</p>

                                        <img src="../assets/files/news/<?php echo htmlspecialchars($event['image']); ?>"
                                            alt="Current Image" class="img-fluid mb-2"
                                            style="max-height: 190px; max-width: 300px;">

                                        <button type="submit" name="delete_image" value="1"
                                            class="btn btn-sm btn-outline-danger mt-auto align-self-start"
                                            onclick="return confirm('Delete this image?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                <?php endif; ?>

                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="form-text">Allowed formats: JPG, PNG, SVG, WEBP</div>
                            </div>
                        </div>

                        <!-- Dynamic Sections -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0 text-secondary">Additional Sections</h5>
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="addSection()">
                                    <i class="fas fa-plus me-1"></i> Add Section
                                </button>
                            </div>

                            <div id="sections-container">
                                <?php if (!empty($sections)): ?>
                                    <?php foreach ($sections as $index => $section): ?>
                                        <div class="card mb-3 section-item">
                                            <div class="card-body bg-light position-relative">
                                                <button type="button" class="btn-close position-absolute top-0 end-0 m-2"
                                                    onclick="removeSection(this)" aria-label="Close"></button>
                                                <input type="hidden" name="section_id[]" value="<?php echo $section['id']; ?>">

                                                <div class="mb-2">
                                                    <label class="form-label small fw-bold text-muted">Section Subtitle</label>
                                                    <input type="text" class="form-control form-control-sm" name="subtitle[]"
                                                        value="<?php echo htmlspecialchars($section['subtitle']); ?>">
                                                </div>

                                                <div class="mb-0">
                                                    <label class="form-label small fw-bold text-muted">Section Content</label>
                                                    <textarea class="form-control form-control-sm" name="sub_description[]"
                                                        rows="3"><?php echo htmlspecialchars($section['sub_description']); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="form-text">Add extra sections with subtitles and descriptions if needed.</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <button type="button" class="btn btn-light"
                                onclick="window.location.href='news.php'">Cancel</button>
                            <button type="submit" class="btn btn-primary"
                                style="background: var(--bg-dark-blue); border: none;">
                                <?php echo $id ? 'Update Event & Sections' : 'Save Event'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addSection() {
            const container = document.getElementById('sections-container');
            const newSection = document.createElement('div');
            newSection.className = 'card mb-3 section-item';
            newSection.innerHTML = `
                <div class="card-body bg-light position-relative">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="removeSection(this)" aria-label="Close"></button>
                    <input type="hidden" name="section_id[]" value="">
                    
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-muted">Section Subtitle</label>
                        <input type="text" class="form-control form-control-sm" name="subtitle[]">
                    </div>
                    
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted">Section Content</label>
                        <textarea class="form-control form-control-sm" name="sub_description[]" rows="3"></textarea>
                    </div>
                </div>
            `;
            container.appendChild(newSection);
        }

        function removeSection(btn) {
            // Find the parent card and remove it
            const card = btn.closest('.section-item');
            if (card) {
                card.remove();
            }
        }
    </script>
</body>

</html>