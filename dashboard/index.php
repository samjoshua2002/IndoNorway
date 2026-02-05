<?php
session_start();
require_once '../database.php';

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

$error = '';

// Handle Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Simple query to check user
    // WARNING: In production use prepared statements and password_hash
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Check password (assuming plain text based on user provided data)
        // If hashed, use password_verify($password, $row['password'])
        if ($password === $row['password']) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['Name'] = $row['Name'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}

// Check if logged in
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - IndoNorway Connect</title>
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

        /* --- Login Page Styles --- */
        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .login-card {
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo img {
            max-width: 150px;
        }

        /* --- Dashboard Layout Styles --- */
        .dashboard-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Top Navbar - Dark Theme to match header.php scrolled state */
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
            /* offset for fixed navbar */
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
            /* overflow-y: auto; */
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
            /* No border for subitems */
        }

        .collapse .menu-item:hover {
            background: #f1f3f5;
            border-left: 4px solid var(--btn-light);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            /* offset for fixed sidebar */
            padding: 2rem;
            background: #f4f6f9;
        }

        /* Card */
        .card-custom {
            background: white;
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.03);
            margin-bottom: 1.5rem;
        }

        .card-header-custom {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            background: transparent;
        }

        .card-body-custom {
            padding: 1.5rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .brand-logo img {
                height: 32px;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <?php if (!$isLoggedIn): ?>
        <!-- LOGIN PAGE -->
        <div class="login-container">
            <div class="login-card">
                <div class="login-logo">
                    <img src="../assets/files/header-footer/header-indonorway-logo-stacked-black.svg" alt="IndoNorway Logo">
                </div>

                <h4 class="text-center mb-4" style="font-family: 'Figtree', sans-serif;">Admin Login</h4>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" name="login" class="btn btn-primary"
                            style="background: var(--bg-dark-blue); border: none;">Login</button>
                    </div>
                </form>
            </div>
        </div>

    <?php else: ?>
        <!-- DASHBOARD PAGE -->
        <?php include 'header.php'; ?>

        <?php
        // Fetch Counts for Analytics
        $projectCount = $conn->query("SELECT COUNT(*) as total FROM projects")->fetch_assoc()['total'];
        $peopleCount = $conn->query("SELECT COUNT(*) as total FROM people")->fetch_assoc()['total'];
        $eventCount = $conn->query("SELECT COUNT(*) as total FROM events")->fetch_assoc()['total'];
        $partnerCount = $conn->query("SELECT COUNT(*) as total FROM partners")->fetch_assoc()['total'];

        // Fetch Latest Projects
        $latestProjects = $conn->query("SELECT * FROM projects ORDER BY created_at DESC LIMIT 3");

        // Fetch Latest Events
        $latestEvents = $conn->query("SELECT * FROM events ORDER BY event_date DESC LIMIT 3");
        ?>

        <style>
            :root {
                --primary-gradient: linear-gradient(135deg, #002F72 0%, #0056b3 100%);
                --accent-gradient: linear-gradient(135deg, #FF6B6B 0%, #EE5253 100%);
                --success-gradient: linear-gradient(135deg, #1dd1a1 0%, #10ac84 100%);
                --info-gradient: linear-gradient(135deg, #48dbfb 0%, #0abde3 100%);
                --glass-bg: rgba(255, 255, 255, 0.95);
                --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                --hover-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
            }

            .main-content {
                background: #f0f2f5;
                padding: 2.5rem;
            }

            .welcome-banner {
                background: var(--primary-gradient);
                border-radius: 20px;
                padding: 2.5rem;
                color: white;
                margin-bottom: 2.5rem;
                position: relative;
                overflow: hidden;
                box-shadow: var(--card-shadow);
                animation: fadeInDown 0.8s ease-out;
            }

            .welcome-banner::after {
                content: '';
                position: absolute;
                top: -50px;
                right: -50px;
                width: 200px;
                height: 200px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
            }

            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .stat-card {
                border: none;
                border-radius: 18px;
                padding: 1.5rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                background: white;
                box-shadow: var(--card-shadow);
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: center;
                animation: fadeInUp 0.8s ease-out both;
            }

            .stat-card:hover {
                transform: translateY(-8px);
                box-shadow: var(--hover-shadow);
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                margin-bottom: 1rem;
                color: white;
            }

            .stat-val {
                font-size: 2rem;
                font-weight: 700;
                color: #2d3436;
                margin-bottom: 0.2rem;
            }

            .stat-label {
                color: #636e72;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                font-size: 0.75rem;
            }

            .nav-card {
                border: none;
                border-radius: 18px;
                background: white;
                padding: 1.2rem;
                text-decoration: none;
                color: inherit;
                display: flex;
                align-items: center;
                gap: 1rem;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
                animation: fadeInUp 0.8s ease-out both;
            }

            .nav-card:hover {
                background: var(--bg-dark-blue);
                color: white !important;
                transform: scale(1.03);
            }

            .nav-card i {
                font-size: 1.2rem;
                padding: 10px;
                background: #f8f9fa;
                border-radius: 10px;
                color: var(--bg-dark-blue);
                transition: all 0.3s ease;
            }

            .nav-card:hover i {
                background: rgba(255, 255, 255, 0.2);
                color: white;
            }

            .content-section {
                background: white;
                border-radius: 20px;
                padding: 2rem;
                box-shadow: var(--card-shadow);
                height: 100%;
                animation: fadeInUp 0.8s ease-out both;
            }

            .section-title {
                font-family: 'Figtree', sans-serif;
                font-weight: 700;
                color: #2d3436;
                margin-bottom: 1.5rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .highlight-item {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1rem;
                border-radius: 12px;
                transition: all 0.2s ease;
                border-left: 4px solid transparent;
            }

            .highlight-item:hover {
                background: #f8f9fa;
                border-left-color: var(--bg-dark-blue);
            }

            .highlight-img {
                width: 60px;
                height: 60px;
                border-radius: 10px;
                object-fit: cover;
                flex-shrink: 0;
            }

            .highlight-info {
                flex: 1;
                min-width: 0;
            }

            .highlight-title {
                font-weight: 600;
                color: #2d3436;
                margin-bottom: 0.2rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .highlight-meta {
                font-size: 0.8rem;
                color: #636e72;
            }

            .badge-category {
                font-size: 0.7rem;
                padding: 4px 10px;
                border-radius: 50px;
                background: #edf2f7;
                color: #4a5568;
                font-weight: 600;
            }
        </style>

        <div class="content-wrapper">
            <?php include 'sidebar.php'; ?>

            <!-- Main Content -->
            <main class="main-content">
                <!-- Welcome Banner -->
                <div class="welcome-banner">
                    <h1 class="display-5 fw-bold mb-2">Welcome back,
                        <?php echo htmlspecialchars($_SESSION['Name'] ?? $_SESSION['username']); ?>!
                    </h1>
                    <p class="lead mb-0 opacity-75">Here's what's happening with IndoNorway Connect today.</p>
                </div>

                <!-- Analytics Row -->
                <div class="row g-4 mb-5">
                    <div class="col-xl-3 col-md-6" style="animation-delay: 0.1s;">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: var(--primary-gradient)">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div class="stat-val"><?php echo $projectCount; ?></div>
                            <div class="stat-label">Total Projects</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6" style="animation-delay: 0.2s;">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: var(--accent-gradient)">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stat-val"><?php echo $eventCount; ?></div>
                            <div class="stat-label">News & Events</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6" style="animation-delay: 0.3s;">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: var(--success-gradient)">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-val"><?php echo $peopleCount; ?></div>
                            <div class="stat-label">Members & People</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6" style="animation-delay: 0.4s;">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: var(--info-gradient)">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div class="stat-val"><?php echo $partnerCount; ?></div>
                            <div class="stat-label">Global Partners</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Navigation Cards -->
                <h4 class="mb-4 fw-bold" style="font-family: 'Figtree', sans-serif;">Quick Access</h4>
                <div class="row g-3 mb-5">
                    <div class="col-lg-2 col-md-4 col-6" style="animation-delay: 0.5s;">
                        <a href="projects.php" class="nav-card">
                            <i class="fas fa-rocket"></i>
                            <span class="fw-semibold">Projects</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6" style="animation-delay: 0.55s;">
                        <a href="news.php" class="nav-card">
                            <i class="fas fa-bullhorn"></i>
                            <span class="fw-semibold">Events</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6" style="animation-delay: 0.6s;">
                        <a href="people.php" class="nav-card">
                            <i class="fas fa-user-friends"></i>
                            <span class="fw-semibold">People</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6" style="animation-delay: 0.65s;">
                        <a href="banner.php" class="nav-card">
                            <i class="fas fa-images"></i>
                            <span class="fw-semibold">Hero</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6" style="animation-delay: 0.7s;">
                        <a href="partners.php" class="nav-card">
                            <i class="fas fa-link"></i>
                            <span class="fw-semibold">Partners</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6" style="animation-delay: 0.75s;">
                        <a href="description.php" class="nav-card">
                            <i class="fas fa-file-alt"></i>
                            <span class="fw-semibold">About</span>
                        </a>
                    </div>
                </div>

                <!-- Detailed View Row -->
                <div class="row g-4">
                    <!-- Upcoming Projects -->
                    <div class="col-lg-6" style="animation-delay: 0.8s;">
                        <div class="content-section">
                            <div class="section-title">
                                <span><i class="fas fa-paper-plane me-2 text-primary"></i> Latest Projects</span>
                                <a href="projects.php" class="btn btn-sm btn-light rounded-pill px-3">View All</a>
                            </div>
                            <?php if ($latestProjects->num_rows > 0): ?>
                                <?php while ($row = $latestProjects->fetch_assoc()): ?>
                                    <div class="highlight-item">
                                        <?php
                                        $projImg = $row['image'] ? '../assets/files/projects/' . htmlspecialchars($row['image']) : '../assets/files/people/placeholder.png';
                                        ?>
                                        <img src="<?php echo $projImg; ?>" class="highlight-img" alt="Project">
                                        <div class="highlight-info">
                                            <div class="highlight-title"><?php echo htmlspecialchars($row['title']); ?></div>
                                            <div class="highlight-meta">
                                                <span
                                                    class="badge-category"><?php echo htmlspecialchars($row['category']); ?></span>
                                                <span class="ms-2"><i class="far fa-calendar-alt me-1"></i>
                                                    <?php echo date('M d, Y', strtotime($row['created_at'])); ?></span>
                                            </div>
                                        </div>
                                        <a href="edit-project.php?id=<?php echo $row['id']; ?>"
                                            class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p class="text-muted text-center py-4">No projects found.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Recent Events -->
                    <div class="col-lg-6" style="animation-delay: 0.9s;">
                        <div class="content-section">
                            <div class="section-title">
                                <span><i class="fas fa-bolt me-2 text-warning"></i> Recent Events</span>
                                <a href="news.php" class="btn btn-sm btn-light rounded-pill px-3">View All</a>
                            </div>
                            <?php if ($latestEvents->num_rows > 0): ?>
                                <?php while ($row = $latestEvents->fetch_assoc()): ?>
                                    <div class="highlight-item">
                                        <?php
                                        $eventImg = $row['image'] ? '../assets/files/news/' . htmlspecialchars($row['image']) : '../assets/files/people/placeholder.png';
                                        ?>
                                        <img src="<?php echo $eventImg; ?>" class="highlight-img" alt="Event">
                                        <div class="highlight-info">
                                            <div class="highlight-title"><?php echo htmlspecialchars($row['title']); ?></div>
                                            <div class="highlight-meta">
                                                <span
                                                    class="text-primary font-weight-bold"><?php echo htmlspecialchars($row['tag']); ?></span>
                                                <span class="ms-2"><i class="far fa-clock me-1"></i>
                                                    <?php echo date('M d, Y', strtotime($row['event_date'])); ?></span>
                                            </div>
                                        </div>
                                        <a href="edit-news.php?id=<?php echo $row['id']; ?>"
                                            class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p class="text-muted text-center py-4">No events found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>