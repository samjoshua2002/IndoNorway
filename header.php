<header class="site-header" id="siteHeader">
    <div class="header-inner">

        <!-- LEFT : LOGO -->
        <div class="header-logo">
            <img
                id="headerLogo"
                src="assets\files\header-footer\header-indonorway-logo-stacked-black.svg"
                alt="IndoNorway Connect"
            >
        </div>

        <!-- RIGHT : NAVIGATION -->
        <!-- Mobile nav toggle -->
        <button id="navToggle" class="nav-toggle" aria-label="Open navigation" aria-expanded="false">
            <span class="hamburger" aria-hidden="true"></span>
        </button>

        <nav class="nav-menu" id="mainNav">
            <a href="index.php">Home</a>
            <a href="people.php">People</a>
            <a href="#">Projects</a>
            <a href="#">News</a>
            <a href="About.php">About</a>
            <a href="contact.php">Contact</a>
        </nav>

        <div id="navBackdrop" class="nav-backdrop" hidden></div>

    </div>
</header>

<script>
    const header = document.getElementById('siteHeader');
    const logo = document.getElementById('headerLogo');

    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('mainNav');
    const navBackdrop = document.getElementById('navBackdrop');

    function setHeaderScrolled(scrolled) {
        if (scrolled) {
            header.classList.add('scrolled');
            logo.src = 'assets/files/header-footer/header-indonorway-logo-stacked-white.svg';
        } else {
            header.classList.remove('scrolled');
            logo.src = 'assets/files/header-footer/header-indonorway-logo-stacked-black.svg';
        }
    }

    window.addEventListener('scroll', () => {
        setHeaderScrolled(window.scrollY > 80);
    });

    // Mobile nav toggle
    function setNavOpen(open) {
        header.classList.toggle('nav-open', open);
        navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        if (open) {
            navBackdrop.removeAttribute('hidden');
        } else {
            navBackdrop.setAttribute('hidden', '');
        }
    }

    navToggle.addEventListener('click', () => {
        const isOpen = header.classList.contains('nav-open');
        setNavOpen(!isOpen);
        navToggle.classList.toggle('open');
    });

    navBackdrop.addEventListener('click', () => {
        setNavOpen(false);
        navToggle.classList.remove('open');
    });

    // Close nav when a link is clicked
    navMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            setNavOpen(false);
            navToggle.classList.remove('open');
        });
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            setNavOpen(false);
            navToggle.classList.remove('open');
        }
    });
</script>
