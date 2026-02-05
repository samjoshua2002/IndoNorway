<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$homePages = ['banner.php', 'description.php', 'partners.php', 'edit-banner.php', 'edit-description.php', 'edit-partner.php'];
$isHomeActive = in_array($currentPage, $homePages);
?>
<aside class="sidebar">
    <nav class="sidebar-menu">
        <a href="index.php" class="menu-item <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        <!-- Home Dropdown -->
        <div class="nav-item">
            <a href="#homeSubmenu" class="menu-item <?php echo $isHomeActive ? 'active' : ''; ?>"
                data-bs-toggle="collapse" aria-expanded="<?php echo $isHomeActive ? 'true' : 'false'; ?>">
                <i class="fas fa-home"></i> Home <i class="fas fa-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
            </a>
            <div class="collapse <?php echo $isHomeActive ? 'show' : ''; ?>" id="homeSubmenu">
                <ul class="list-unstyled fw-normal pb-1 small mb-0 bg-white">
                    <li><a href="banner.php"
                            class="menu-item ps-5 <?php echo ($currentPage == 'banner.php' || $currentPage == 'edit-banner.php') ? 'active' : ''; ?>"><i
                                class="fas fa-image"></i> Banner</a></li>
                    <li><a href="description.php"
                            class="menu-item ps-5 <?php echo ($currentPage == 'description.php' || $currentPage == 'edit-description.php') ? 'active' : ''; ?>"><i
                                class="fas fa-file-alt"></i> Description</a></li>
                    <li><a href="partners.php"
                            class="menu-item ps-5 <?php echo ($currentPage == 'partners.php' || $currentPage == 'edit-partner.php') ? 'active' : ''; ?>"><i
                                class="fas fa-handshake"></i> Partners</a></li>
                </ul>
            </div>
        </div>

        <a href="projects.php"
            class="menu-item <?php echo in_array($currentPage, ['projects.php', 'edit-project.php']) ? 'active' : ''; ?>">
            <i class="fas fa-project-diagram"></i> Projects
        </a>
        <a href="news.php"
            class="menu-item <?php echo in_array($currentPage, ['news.php', 'edit-news.php']) ? 'active' : ''; ?>">
            <i class="fas fa-newspaper"></i> News & Events
        </a>
        <a href="people.php"
            class="menu-item <?php echo in_array($currentPage, ['people.php', 'edit-people.php']) ? 'active' : ''; ?>">
            <i class="fas fa-users"></i> People
        </a>
    </nav>
</aside>