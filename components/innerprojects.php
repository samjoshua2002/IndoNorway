<div class="container section-padding">
    <div class="people-list">
        <?php
        $conn = include __DIR__ . '/../database.php';
        $p_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $project = null;

        if ($p_id > 0) {
            $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
            $stmt->bind_param("i", $p_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $project = $result->fetch_assoc();
            }
            $stmt->close();
        }

        if ($project):
            $imagePath = $project['image'] ? 'assets/files/projects/' . htmlspecialchars($project['image']) : '';
            // Use fallback image if none provided to match design feeling
           
            $statusClass = 'status-' . strtolower($project['category'] ?? '');

            // For Overview, content might have line breaks
            $overview = $project['overview'] ?? ''; // New column
            ?>

            <div class="header">
                <!-- Back navigation -->
                <div class="link-small-nav">
                    <a href="Projects.php" style="text-decoration:none;">
                        <div class="back">&lt; All Projects</div>
                    </a>
                </div>

                <!-- Title -->
                <div class="project-detail-title">
                    <?php echo htmlspecialchars($project['title'] ?? ''); ?>
                </div>

                <!-- Date -->
                <?php if (!empty($project['date'])): ?>
                    <div class="project-detail-date">
                        <?php echo htmlspecialchars($project['date']); ?>
                    </div>
                <?php endif; ?>

                <!-- Tags / Category -->
                <div class="category">
                    <div class="project-detail-category">
                        <?php echo htmlspecialchars($project['tag'] ?? ''); ?>
                    </div>
                </div>

                <!-- Status -->
                <div class="project-status-02 <?php echo $statusClass; ?>">
                    <div class="project-detail-status">
                        <?php echo ucfirst($project['category'] ?? ''); ?>
                    </div>
                </div>
            </div>

            <!-- Banner Image -->
            <?php if (!empty($imagePath)): ?>
                <img class="project-detail-image" src="<?php echo $imagePath; ?>" alt="Project Image" />
            <?php endif; ?>

             <!-- Overview Section -->
            <?php if (!empty($project['Description'])): ?>
                <div class="frame-55">
                   
                    <div class="overview-text">
                        <?php echo nl2br($project['Description']); // Allow HTML/Breaks in overview ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Overview Section -->
            <?php if (!empty($overview)): ?>
                <div class="frame-55">
                    <div class="overview-heading">Overview</div>
                    <div class="overview-text">
                        <?php echo nl2br($overview); // Allow HTML/Breaks in overview ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Investigators Section -->
            <?php if (!empty($project['investigator'])): ?>
                <div class="frame-56">
                    <div class="section-heading">Investigators</div>
                    <div class="section-text">
                        <?php echo $project['investigator']; // Already HTML formatted in DB ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Funding Partners Section -->
            <?php if (!empty($project['funding_partner'])): ?>
                <div class="frame-57">
                    <div class="section-heading">Funding Partners</div>
                    <div class="section-text">
                        <?php echo $project['funding_partner']; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Mobilities Section -->
            <?php if (!empty($project['mobilites'])): ?>
                <div class="frame-57">
                    <div class="section-heading">Mobilities</div>
                    <div class="section-text">
                        <?php echo $project['mobilites']; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Budget Section -->
            <?php if (!empty($project['budget'])): ?>
                <div class="frame-57">
                    <div class="section-heading">Budget</div>
                    <div class="section-text">
                        <?php echo $project['budget']; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Publications Section -->
            <?php if (!empty($project['publication'])): ?>
                <div class="frame-57">
                    <div class="section-heading">Publications</div>
                    <div class="section-text publication-list">
                        <?php echo $project['publication']; ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="alert alert-warning text-center">Project not found.</div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* CSS Variables based on user pattern, with fallbacks */
    :root {
        --indo-header-font: 'Figtree-Bold', sans-serif;
        --indo-body-font: 'CrimsonPro-Regular', sans-serif;
        --indo-italic-font: 'CrimsonPro-Italic', sans-serif;
        --indo-caption-font: 'Figtree-Regular', sans-serif;

        --indonorway-v02-desktop-h1-font-family: var(--indo-header-font);
        --indonorway-v02-desktop-h1-font-size: 32px;

        --indonorway-v02-desktop-h21-font-family: var(--indo-header-font);
        --indonorway-v02-desktop-h21-font-size: 32px;

        --indonorway-v02-desktop-body-01-font-family: var(--indo-body-font);
        --indonorway-v02-desktop-body-01-font-size: 20px;
    }

    .people-list,
    .people-list * {
        box-sizing: border-box;
    }

    .people-list {
        display: flex;
        flex-direction: column;
        gap: 48px;
        align-items: center;
        justify-content: flex-start;
        position: relative;
        width: 100%;
        margin-top: 40px;
    }

    .header {
        display: flex;
        flex-direction: column;
        gap: 4px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        width: 100%;
        /* Changed from fixed 1196px to 100% of container */
        position: relative;
    }

    .link-small-nav {
        display: flex;
        flex-direction: row;
        gap: 10px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        margin-bottom: 20px;
    }

    .back {
        color: #000000;
        text-align: left;
        font-family: var(--indo-body-font);
        font-size: 20px;
        line-height: 108%;
        font-weight: 400;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        cursor: pointer;
    }

    /* Title */
    .project-detail-title {
        color: #000000;
        text-align: left;
        font-family: var(--indonorway-v02-desktop-h1-font-family);
        font-size: var(--indonorway-v02-desktop-h1-font-size);
        line-height: 112%;
        letter-spacing: -0.5px;
        font-weight: 700;
        position: relative;
        align-self: stretch;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-bottom: 8px;
    }

    /* Date */
    .project-detail-date {
        color: #000000;
        text-align: left;
        font-family: var(--indo-italic-font);
        font-size: var(--indonorway-v02-desktop-body-01-font-size);
        line-height: 108%;
        font-weight: 400;
        font-style: italic;
        position: relative;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-bottom: 8px;
    }

    .category {
        background: #daecf0;
        border-radius: 4px;
        padding: 8px;
        display: flex;
        flex-direction: row;
        gap: 10px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        align-self: flex-start;
        margin-bottom: 8px;
    }

    .project-detail-category {
        color: #000000;
        text-align: left;
        font-family: var(--indo-caption-font);
        font-size: 12px;
        line-height: 100%;
        letter-spacing: 2px;
        font-weight: 400;
        text-transform: uppercase;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    .project-status-02 {
        background: #7adef7;
        border-radius: 4px;
        padding: 8px;
        display: flex;
        flex-direction: row;
        gap: 10px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        align-self: flex-start;
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

    .project-detail-status {
        color: #000000;
        text-align: left;
        font-family: var(--indo-caption-font);
        font-size: 12px;
        line-height: 100%;
        letter-spacing: 2px;
        font-weight: 400;
        text-transform: uppercase;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    .project-detail-image {
        flex-shrink: 0;
        width: 100%;
        height: auto;
        max-height: 500px;
        position: relative;
        object-fit: cover;
    }

    .frame-55,
    .frame-56,
    .frame-57 {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .overview-heading,
    .section-heading {
        color: #000000;
        text-align: left;
        font-family: var(--indonorway-v02-desktop-h21-font-family);
        font-size: var(--indonorway-v02-desktop-h21-font-size);
        line-height: 112%;
        letter-spacing: -0.5px;
        font-weight: 700;
        position: relative;
        align-self: stretch;
    }

    .overview-text,
    .section-text {
        color: #000000;
        text-align: left;
        font-family: var(--indonorway-v02-desktop-body-01-font-family);
        font-size: var(--indonorway-v02-desktop-body-01-font-size);
        line-height: 108%;
        font-weight: 400;
        position: relative;
        align-self: stretch;
    }

    /* Publication Styling inside text */
    .publication-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .citation-doi {
        text-decoration: underline;
        color: #000;
        word-break: break-all;
    }

    @media (max-width: 992px) {
        .project-detail-title {
            font-size: 28px;
        }

        .overview-heading,
        .section-heading {
            font-size: 24px;
        }

        .overview-text,
        .section-text {
            font-size: 18px;
        }
    }
</style>