<div class="footer-container">
    <div class="footer-logo-section">
        <img class="footer-logo" src="assets/files/home/partner-iitm.svg" alt="IIT Madras Logo" />
        <div class="footer-institution-name">
            Indian Institute of
            <br />
            Technology Madras
        </div>
    </div>
    <nav class="footer-nav-links">
        <a href="#" class="footer-link footer-link-home">
            <span class="footer-link-text">Home</span>
        </a>
        <a href="#" class="footer-link">
            <span class="footer-link-text">People</span>
        </a>
        <a href="#" class="footer-link">
            <span class="footer-link-text">News</span>
        </a>
        <a href="#" class="footer-link">
            <span class="footer-link-text">Projects</span>
        </a>
        <a href="#" class="footer-link">
            <span class="footer-link-text">About</span>
        </a>
        <a href="#" class="footer-link">
            <span class="footer-link-text">Contact</span>
        </a>
    </nav>
</div>

<style>
    /* Footer Container */
    .footer-container {
        background: linear-gradient(90deg, rgba(0, 75, 98, 1) 0%, rgba(0, 47, 114, 1) 100%);
        padding: 3rem 122px 40px 122px; /* Consistent padding-top: 3rem for desktop */
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        position: relative;
        width: 100%;
        box-sizing: border-box;
    }

    /* Footer Logo Section */
    .footer-logo-section {
        display: flex;
        flex-direction: row;
        gap: 11px;
        align-items: center;
        justify-content: flex-start;
        flex-shrink: 0;
        height: 116px;
        position: relative;
    }

    .footer-logo {
        align-self: stretch;
        flex-shrink: 0;
        width: 116px;
        height: auto;
        position: relative;
        overflow: visible;
        aspect-ratio: 1;
        object-fit: contain;
    }

    .footer-institution-name {
        color: #ffffff;
        text-align: left;
        font-family: 'Crimson Pro', serif;
        font-size: 24px;
        line-height: 108%;
        font-weight: 400;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    /* Footer Navigation Links */
    .footer-nav-links {
        flex-shrink: 0;
        display: grid;
        gap: 32px;
        row-gap: 12px;
        position: relative;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        grid-template-rows: repeat(3, minmax(0, 1fr));
    }

    .footer-link {
        display: flex;
        flex-direction: row;
        gap: 10px;
        align-items: center;
        justify-content: center;
        width: 190px;
        position: relative;
        text-decoration: none;
        transition: opacity 0.2s ease;
    }

    .footer-link:hover {
        opacity: 0.8;
    }

    /* Grid positioning for links */
    .footer-link:nth-child(1) { /* Home */
        grid-column: 1 / span 1;
        grid-row: 1 / span 1;
    }

    .footer-link:nth-child(2) { /* People */
        grid-column: 1 / span 1;
        grid-row: 2 / span 1;
    }

    .footer-link:nth-child(3) { /* News */
        grid-column: 2 / span 1;
        grid-row: 1 / span 1;
    }

    .footer-link:nth-child(4) { /* Projects */
        grid-column: 1 / span 1;
        grid-row: 3 / span 1;
    }

    .footer-link:nth-child(5) { /* About */
        grid-column: 2 / span 1;
        grid-row: 2 / span 1;
    }

    .footer-link:nth-child(6) { /* Contact */
        grid-column: 2 / span 1;
        grid-row: 3 / span 1;
    }

    .footer-link-text {
        color: #ffffff;
        text-align: left;
        font-family: 'Figtree', sans-serif;
        font-size: 20px;
        line-height: 100%;
        font-weight: 400;
        position: relative;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    /* Home link is bold */
    .footer-link-home .footer-link-text {
        font-weight: 700;
    }

    /* Tablet Responsive */
    @media (max-width: 991px) {
        .footer-container {
            padding: 2rem 60px 32px 60px; /* Consistent padding-top: 2rem for tablet */
        }

        .footer-logo-section {
            height: 90px;
        }

        .footer-logo {
            width: 90px;
        }

        .footer-institution-name {
            font-size: 20px;
        }

        .footer-nav-links {
            gap: 24px;
            row-gap: 10px;
        }

        .footer-link {
            width: 150px;
        }

        .footer-link-text {
            font-size: 18px;
        }
    }

@media (max-width: 767px) {
  .footer-container {
    padding: 20px;
    justify-content: center;
  }

  .footer-logo-section {
    height: 90px;
    gap: 12px;
  }

  .footer-logo {
    width: 90px;
  }

  .footer-institution-name {
    font-size: 18px;
    line-height: 130%;
  }

  /* Hide navigation links on mobile */
  .footer-nav-links {
    display: none;
  }
}
@media (max-width: 375px) {
  .footer-container {
    padding: 1.5rem 16px 20px 16px;
  }

  .footer-logo-section {
    height: 80px;
    gap: 10px;
  }

  .footer-logo {
    width: 80px;
  }

  .footer-institution-name {
    font-size: 16px;
  }
}

</style>