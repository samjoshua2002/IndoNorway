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

        <div class="content-wrapper">
            <!-- Side Navbar -->
            <?php include 'sidebar.php'; ?>

            <!-- Main Content -->
            <main class="main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 style="font-family: 'Figtree', sans-serif;">Dashboard</h2>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-custom">
                            <div class="card-body-custom">
                                <h5 class="card-title text-muted">Total Users</h5>
                                <h2 class="mt-2 text-dark">1</h2>
                                <p class="text-success mb-0"><i class="fas fa-arrow-up"></i> 100%</p>
                            </div>
                        </div>
                    </div>
                    <!-- Add more dummy widgets if needed -->
                </div>

                <div class="card card-custom">
                    <div class="card-header-custom">
                        <h5 class="mb-0" style="font-family: 'Figtree', sans-serif;">Recent Activity</h5>
                    </div>
                    <div class="card-body-custom">
                        <p class="text-muted">Welcome to your new dashboard.</p>
                    </div>
                </div>
            </main>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>