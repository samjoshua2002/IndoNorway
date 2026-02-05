<header class="top-navbar">
    <div class="d-flex align-items-center">
        <button class="btn btn-link text-white d-md-none me-2"
            onclick="document.querySelector('.sidebar').classList.toggle('show')">
            <i class="fas fa-bars"></i>
        </button>
        <a href="index.php" class="brand-logo">
            <img src="../assets/files/header-footer/header-indonorway-logo-horiz-white.svg" alt="IndoNorway">
        </a>
    </div>

    <div class="user-profile">
        <span class="d-none d-md-inline">Welcome,
            <?php echo htmlspecialchars($_SESSION['Name'] ?? $_SESSION['username']); ?>
        </span>
        <div class="user-avatar">
            <?php echo strtoupper(substr($_SESSION['Name'] ?? $_SESSION['username'], 0, 1)); ?>
        </div>
        <a href="index.php?logout=true" class="text-white ms-3" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
    </div>
</header>