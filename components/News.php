<div class="container section-padding">
    <p class="page-header text-center mb-4">News & Events</p>

    <div class="news-list">
        <!-- Item 1 -->
        <div class="news-item">
            <img class="news-item__image" src="assets/files/news/pexels-edward-jenner-4031418-r02.webp"
                alt="News Image" />
            <div class="news-item__content">
                <div class="news-item__title">
                    List of students accepted for the Global Mobility Programme 2025
                </div>
                <div class="news-item__date">12 September 2025</div>
            </div>
        </div>

        <!-- Item 2 -->
        <div class="news-item news-item--bordered">
            <img class="news-item__image" src="assets/files/news/pexels-olly-3778603-r01.webp" alt="Seminar Image" />
            <div class="news-item__content">
                <div class="news-item__category">Seminar</div>
                <div class="news-item__title">
                    Sample news item contained on this page. Aliquam arcu velit, suscipit sed auctor a, facilisis eget
                    augue.
                </div>

                <div class="news-item__meta">
                    <div class="meta-row">
                        <span class="meta-label">Time:</span>
                        <span class="meta-value">18 August 2025, 3:00 pm</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Venue:</span>
                        <span class="meta-value">NAC 101</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Speaker:</span>
                        <span class="meta-value">
                            Maecenas scelerisque dapibus dolor non tincidunt. Vestibulum ante ipsum primis in faucibus
                            orci luctus et ultrices posuere cubilia curae; Etiam risus mi, tincidunt non lobortis nec,
                            gravida vel erat. Nam quis turpis eu risus vulputate commodo. Orci varius natoque penatibus
                            et magnis dis parturient montes, nascetur ridiculus mus.
                        </span>
                    </div>
                </div>

                <div class="news-item__body">
                    Sed in est sed tellus facilisis tincidunt. Phasellus semper justo et mauris egestas ornare. Maecenas
                    eu ex dolor. Aenean facilisis ut turpis sed semper. Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Integer ornare ut orci ac lobortis. Donec rutrum metus ut risus mattis laoreet.
                    Fusce commodo diam eget egestas dictum. Vestibulum sed porta urna. Donec tincidunt vitae leo id
                    bibendum. Morbi purus felis, molestie quis semper at, consequat vitae diam. Maecenas finibus tellus
                    vitae lacus vehicula, sed molestie metus pellentesque. Maecenas mollis dui non arcu dapibus,
                    bibendum iaculis quam interdum. Aliquam arcu velit, suscipit sed auctor a, facilisis eget augue.
                    Curabitur et libero tincidunt, accumsan nisi non, semper lacus. Vivamus rhoncus dignissim consequat.
                    Donec euismod, tortor id varius luctus, nisl enim tincidunt nibh, sed laoreet enim mi vitae purus.
                    Ut leo nibh, commodo a augue ut, porta mollis velit. Mauris sollicitudin augue at faucibus pharetra.
                    Maecenas scelerisque dapibus dolor non tincidunt. Vestibulum ante ipsum primis in faucibus orci
                    luctus et ultrices posuere cubilia curae; Etiam risus mi, tincidunt non lobortis nec, gravida vel
                    erat.
                </div>
            </div>
        </div>

        <!-- Item 3 -->
        <div class="news-item news-item--bordered">
            <div class="news-item__content">
                <div class="news-item__category">Recent Publication</div>
                <div class="news-item__citation">
                    <span class="cita-author">Krishnamurthy, S., Sudhakar, S., &amp; Mani, E. (2022). Kinetics of
                        aggregation of amyloid β under different shearing conditions: Experimental and modelling
                        analyses.</span>
                    <span class="cita-journal">Colloids and surfaces. B, Biointerfaces, 209</span>
                    <span class="cita-pages">(Pt 1), 112156.</span>
                    <a href="https://doi.org/10.1016/j.colsurfb.2021.112156"
                        class="cita-doi">doi.org/10.1016/j.colsurfb.2021.112156</a>
                </div>
            </div>
        </div>

        <!-- Item 4 -->
        <div class="news-item">
            <div class="news-item__content">
                <div class="news-item__title">
                    Applications open for Project Title (Last date: 13 July 2025)
                </div>
                <div class="news-item__date">30 June 2025</div>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS Variables & Reset */
    :root {
        --font-header: 'Crimson Pro', "CrimsonPro-Regular", sans-serif;
        --font-body: "CrimsonPro-Regular", sans-serif;
        --font-meta-label: "CrimsonPro-Italic", sans-serif;
        --font-caption: "Figtree-Regular", sans-serif;
        --color-text: #000000;
        --color-bg: #ffffff;
    }

    * {
        box-sizing: border-box;
    }

    /* Page Header */
    .page-header {
        font-family: var(--font-header);
        font-size: 36px;
        font-weight: 400;
        text-align: center;
        line-height: 1.2;
        color: var(--color-text);
    }

    @media (min-width: 768px) {
        .page-header {
            font-size: 48px;
        }
    }

    @media (min-width: 992px) {
        .page-header {
            font-size: 64px;
        }
    }

    .section-padding {
        padding-top: 1rem;
    }

    /* News List Container */
    .news-list {
        display: flex;
        flex-direction: column;
        gap: 32px;
        width: 100%;
        position: relative;
    }

    /* News Item Card with semantic class names */
    .news-item {
        background: var(--color-bg);
        padding: 12px;
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        width: 100%;
        position: relative;
    }

    .news-item--bordered {
        border-width: 1px;
        border-style: solid;
        border-image: linear-gradient(90deg, #2DB9DD 0%, #008CFF 100%) 1;
        /* Note: border-image currently overrides border-radius */
    }

    /* Image Styles */
    .news-item__image {
        flex-shrink: 0;
        width: 388px;
        max-width: 40%;
        height: auto;
        aspect-ratio: 4/3;
        object-fit: cover;
    }

    /* Content Area */
    .news-item__content {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }

    /* Typography Classes */
    .news-item__title {
        font-family: var(--font-header);
        font-size: 32px;
        line-height: 108%;
        font-weight: 400;
        color: var(--color-text);
    }

    .news-item__date,
    .news-item__category {
        font-family: var(--font-caption);
        font-size: 16px;
        line-height: 100%;
        letter-spacing: 2px;
        font-weight: 400;
        text-transform: uppercase;
        color: var(--color-text);
    }

    /* Meta text (Time, Venue, Speaker) */
    .news-item__meta {
        margin-top: 8px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        font-size: 20px;
        line-height: 108%;
        color: var(--color-text);
    }

    .meta-row {
        font-family: var(--font-body);
    }

    .meta-label {
        font-family: var(--font-meta-label);
        font-style: italic;
    }

    .meta-value {
        font-family: var(--font-body);
    }

    /* Body Text */
    .news-item__body {
        font-family: var(--font-body);
        font-size: 20px;
        line-height: 108%;
        font-weight: 400;
        color: var(--color-text);
        text-align: left;
        margin-top: 8px;
        max-width: 100%;
    }

    /* Citation Styles */
    .news-item__citation {
        font-family: var(--font-body);
        font-size: 20px;
        line-height: 108%;
        color: var(--color-text);
    }

    .cita-author {
        font-family: var(--font-body);
    }

    .cita-journal {
        font-family: var(--font-meta-label);
        font-style: italic;
    }

    .cita-pages {
        font-family: var(--font-body);
    }

    .cita-doi {
        font-family: var(--font-body);
        text-decoration: underline;
        color: var(--color-text);
    }

    /* Mobile Responsiveness for Item Layout */
    @media (max-width: 768px) {
        .news-item {
            flex-direction: column;
        }

        .news-item__image {
            width: 100%;
            max-width: 100%;
        }
    }
</style>