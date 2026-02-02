<div class="container section-padding">
    <div class="projects-main">
        <!-- Header Section -->
        <div class="projects-header-section mb-2">
            <div class="page-header text-center">Projects</div>
            <div class="filter-tabs">
                <div class="filter-tab active" onclick="filterProjects('all', this)">All</div>
                <div class="filter-tab" onclick="filterProjects('upcoming', this)">Upcoming</div>
                <div class="filter-tab" onclick="filterProjects('ongoing', this)">Ongoing</div>
                <div class="filter-tab" onclick="filterProjects('completed', this)">Completed</div>
            </div>
        </div>

        <?php
        $conn = include __DIR__ . '/../database.php';
        $projects_sql = "SELECT * FROM projects ORDER BY id ASC";
        $projects_result = $conn->query($projects_sql);

        if ($projects_result && $projects_result->num_rows > 0) {
            while ($row = $projects_result->fetch_assoc()) {
                // Data extraction
                $category = htmlspecialchars($row['category'] ?? ''); // ongoing, completed, upcoming
                $tag = htmlspecialchars($row['tag'] ?? '');
                $title = htmlspecialchars($row['title'] ?? '');
                $dateText = htmlspecialchars($row['date'] ?? '');
                $imagePath = $row['image'] ? 'assets/files/projects/' . htmlspecialchars($row['image']) : '';

                // For HTML content fields, allow basic tags or just output raw if trusted
                // Since manual SQL insertion was done, we output directly but be careful if user input is possible later.
                // Using plain echo for HTML content fields as requested structure implies HTML in DB.
                $investigator = $row['investigator'];
                $funding = $row['funding_partner'];
                $budget = $row['budget'];
                $mobilites = $row['mobilites'];
                $publications = $row['publication'];

                // Status Badge Class
                $statusBadgeClass = 'status-' . strtolower($category);
                // e.g. status-ongoing, status-upcoming
                ?>

                <!-- Project Card Link -->
                <!-- Changed to div to avoid nested <a> tags issue with DOI links -->
                <div onclick="if(!event.target.closest('a')) window.location.href='InnerProjects.php?id=<?php echo htmlspecialchars($row['id']); ?>'"
                    class="project-card-link" style="cursor: pointer;" data-category="<?php echo strtolower($category); ?>">
                    <div class="project-card">

                        <?php if (!empty($imagePath)): ?>
                            <img class="project-image" src="<?php echo $imagePath; ?>" alt="<?php echo $title; ?>" />
                        <?php endif; ?>

                        <div class="project-card-content <?php echo empty($imagePath) ? 'title-block' : 'border-common'; ?>">
                            <div class="category-wrapper">
                                <div class="category-tag"><?php echo $tag; ?></div>
                            </div>
                            <h3 class="project-heading">
                                <?php echo $title; ?>
                            </h3>
                            <div class="meta-row">
                                <div class="status-badge <?php echo $statusBadgeClass; ?>">
                                    <div class="status-text"><?php echo ucfirst($category); ?></div>
                                </div>
                                <?php if ($dateText): ?>
                                    <div class="date-text"><?php echo $dateText; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Detailed sections restored for list view as requested -->
                        <?php if (!empty($investigator)): ?>
                            <div class="project-section border-common">
                                <div class="section-label">Investigators</div>
                                <div class="section-text">
                                    <?php echo $investigator; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($funding)): ?>
                            <div class="project-section border-common">
                                <div class="section-label">Funding Partners</div>
                                <div class="section-text"><?php echo $funding; ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($mobilites)): ?>
                            <div class="project-section border-common">
                                <div class="section-label">Mobilities</div>
                                <div class="section-text">
                                    <?php echo $mobilites; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($budget)): ?>
                            <div class="project-section border-common">
                                <div class="section-label">Budget</div>
                                <div class="section-text"><?php echo $budget; ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($publications)): ?>
                            <div class="project-section border-common">
                                <div class="section-label">Publications</div>
                                <div class="section-text publication-list">
                                    <?php echo $publications; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- End Project Card -->

                <?php
            }
        } else {
            echo '<p class="text-center">No projects found.</p>';
        }
        ?>
    </div>
</div>

<style>
    /* 
   We reuse key fonts:
   Heads: 'Crimson Pro'
   Body: 'Crimson Pro' / 'Figtree'
*/

    .projects-main {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: center;
    }

    /* HEADER */
    .projects-header-section {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 20px;
        align-items: center;
    }

    .page-header {
        font-family: 'Crimson Pro', serif;
        font-size: 36px;
        font-weight: 400;
        text-align: center;
        line-height: 1.2;
        color: #000;
        margin-top: 20px;
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

    .filter-tabs {
        display: flex;
        gap: 32px;
    }

    .filter-tab {
        font-family: 'Crimson Pro', serif;
        font-size: 20px;
        line-height: 108%;
        color: #000;
        cursor: pointer;
        font-weight: 400;
    }

    .filter-tab.active {
        font-weight: 700;
        text-decoration: underline;
    }

    .filter-tab:hover {
        text-decoration: underline;
    }

    /* PROJECT CARD LINK WRAPPER */
    .project-card-link {
        width: 100%;
        text-decoration: none;
        /* Remove default link underline */
        color: inherit;
        display: flex;
        /* Ensure it takes space */
        flex-direction: column;
    }

    .project-card-link:hover .project-card {
        box-shadow: 0 0 5px 1px #2DB9DD;
        /* Outer glow 2px */
        /* You might want a transition */
        transition: box-shadow 0.2s ease;
    }

    .project-card-link:hover .project-heading {
        text-decoration: underline;
    }

    /* PROJECT CARD */
    .project-card {
        width: 100%;
        background: #fff;
        display: flex;
        flex-direction: column;
        cursor: pointer;
    }

    /* Image */
    .project-image {
        width: 100%;
        height: 250px;
        min-height: 100px;
        max-height: 400px;
        object-fit: cover;
        border: 1px solid;
        border-image-source: linear-gradient(90deg, #2DB9DD 0%, #008CFF 100%);
        border-image-slice: 1;
    }

    /* BORDERS */
    /* 
   The design uses a border gradient for almost every section.
   We can create a utility class.
*/
    .border-common,
    .title-block,
    .investigators,
    .budget,
    .publications,
    .funding-partners,
    .mobilities {
        border: 1px solid;
        border-image-source: linear-gradient(90deg, #2DB9DD 0%, #008CFF 100%);
        border-image-slice: 1;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
        width: 100%;
    }

    .title-block {
        /* Special class if needed, usually same as border-common */
    }

    /* CONTENT INSIDE CARDS */
    .category-wrapper {
        background: #DAECF0;
        border-radius: 4px;
        padding: 8px;
        display: inline-flex;
        align-self: flex-start;
    }

    .category-tag {
        font-family: 'Figtree', sans-serif;
        font-size: 12px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #000;
    }

    .project-heading {
        font-family: 'Crimson Pro', serif;
        font-size: 32px;
        line-height: 108%;
        font-weight: 400;
        margin: 0;
        color: #000;
    }

    .meta-row {
        display: flex;
        gap: 16px;
        align-items: center;
        flex-wrap: wrap;
    }

    .status-badge {
        border-radius: 4px;
        padding: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .status-ongoing {
        background: #7ADEF7;
    }

    .status-completed {
        background: #A8E2B3;
    }

    .status-upcoming {
        background: #F7DA7A;
    }

    .status-text {
        font-family: 'Figtree', sans-serif;
        font-size: 12px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #000;
    }

    .date-text {
        font-family: 'Crimson Pro', serif;
        font-style: italic;
        font-size: 24px;
        color: #000;
    }

    /* SECTIONS (Investigator, Budget, etc) */
    .section-label {
        color: #004B62;
        /* --indonorway-v02-blue-m */
        font-family: 'Figtree', sans-serif;
        font-size: 12px;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .section-text {
        font-family: 'Crimson Pro', serif;
        font-size: 20px;
        line-height: 108%;
        color: #000;
    }

    /* PUBLICATIONS SPECIFIC */
    .publication-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .pub-item {
        font-family: 'Crimson Pro', serif;
        font-size: 20px;
        line-height: 1.1;
    }

    .citation-doi {
        text-decoration: underline;
        color: #000;
        word-break: break-all;
    }

    @media (max-width: 768px) {
        .filter-tabs {
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px;
        }

        .project-heading {
            font-size: 28px;
        }

        .date-text {
            font-size: 20px;
        }

        /* Hide images on mobile */
        /* .project-image {
            display: none !important;
        } */
    }
</style>

<script>
    function filterProjects(category, tabElement) {
        // Update Tabs
        const tabs = document.querySelectorAll('.filter-tab');
        tabs.forEach(t => t.classList.remove('active'));
        tabElement.classList.add('active');

        // Filter Cards
        const cards = document.querySelectorAll('.project-card-link'); // TARGET THE LINK WRAPPER
        cards.forEach(card => {
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });

    }
</script>