<div class="container section-padding">
    <div class="inner-news">
        <?php
        // Connect to database
        $conn = include __DIR__ . '/../database.php';

        // Get Event ID from URL, default to latest or specific ID if needed
        $event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Fetch Main Event Details
        $event = null;
        if ($event_id > 0) {
            $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
            $stmt->bind_param("i", $event_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $event = $result->fetch_assoc();
            }
            $stmt->close();
        } else {
            // Fallback: Get the most recent event if no ID provided (optional behavior)
            $result = $conn->query("SELECT * FROM events ORDER BY created_at DESC LIMIT 1");
            if ($result->num_rows > 0) {
                $event = $result->fetch_assoc();
                $event_id = $event['id'];
            }
        }

        if ($event):
            ?>
            <!-- Main Event Layout -->
            <div class="event-details-container">
                <!-- Header / Nav -->
                <div class="event-header-nav">
                    <div class="link-small-nav">
                        <a href="News-Events.php" class="back-link">&lt; All News</a>
                    </div>
                </div>

                <!-- Top Section (Hero) -->
                <div class="event-hero">
                    <?php if (!empty($event['image'])): ?>
                        <img class="event-hero-image"
                            src="assets/files/news/<?php echo htmlspecialchars($event['image'] ?? ''); ?>"
                            alt="<?php echo htmlspecialchars($event['title'] ?? ''); ?>" />
                    <?php endif; ?>

                    <div class="event-hero-details">
                        <div class="event-meta-group">
                            <div class="event-tag"><?php echo htmlspecialchars($event['tag'] ?? ''); ?></div>
                            <div class="event-title"><?php echo htmlspecialchars($event['title'] ?? ''); ?></div>
                        </div>

                        <div class="event-info-group">
                            <?php if (!empty($event['event_date']) || !empty($event['event_time'])): ?>
                                <div class="event-info-row">
                                    <span>
                                        <?php if (!empty($event['event_time'])): ?>
                                            <span class="info-label">Time:</span>
                                        <?php endif; ?>
                                        <span class="info-value">
                                            <?php echo htmlspecialchars($event['event_date'] ?? ''); ?>
                                            <?php echo htmlspecialchars($event['event_time'] ?? ''); ?>
                                        </span>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($event['venue'])): ?>
                                <div class="event-info-row">
                                    <span>
                                        <span class="info-label">Venue:</span>
                                        <span class="info-value">
                                            <?php echo htmlspecialchars($event['venue'] ?? ''); ?>
                                        </span>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Content Body -->
                <div class="event-content-body">
                    <!-- Speaker -->
                    <?php if (!empty($event['speaker'])): ?>
                        <div class="event-speaker-block">
                            <span>
                                <span class="info-label">Speaker:</span>
                                <span class="info-value">
                                    <?php echo nl2br(htmlspecialchars($event['speaker'] ?? '')); ?>
                                </span>
                            </span>
                        </div>
                    <?php endif; ?>

                    <!-- Description -->
                    <?php if (!empty($event['description'])): ?>
                        <div class="event-speaker-block">
                            <span>
                                <span class="info-value">
                                    <?php echo nl2br(htmlspecialchars($event['description'] ?? '')); ?>
                                </span>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Additional Sections from event_sections table -->
            <?php
            // Fetch associated sections
            $sections_sql = "SELECT * FROM event_sections WHERE event_id = ? ORDER BY section_order ASC";
            $stmt_sec = $conn->prepare($sections_sql);
            if ($stmt_sec) {
                $stmt_sec->bind_param("i", $event_id);
                $stmt_sec->execute();
                $sections_result = $stmt_sec->get_result();

                while ($section = $sections_result->fetch_assoc()):
                    ?>
                    <div class="inner-news__section">

                        <?php if (!empty($section['subtitle'])): ?>
                            <h2 class="section-title"><?php echo htmlspecialchars($section['subtitle'] ?? ''); ?></h2>
                        <?php endif; ?>

                        <?php if (!empty($section['sub_description'])): ?>
                            <div class="section-content">
                                <div class="content-text">
                                    <?php echo nl2br(htmlspecialchars($section['sub_description'] ?? '')); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                endwhile;
                $stmt_sec->close();
            }
            ?>

        <?php else: ?>
            <div class="alert alert-warning">Event not found.</div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* CSS Variables */
    :root {
        --indo-header-font: 'Figtree-Bold', sans-serif;
        --indo-body-font: 'CrimsonPro-Regular', sans-serif;
        --indo-italic-font: 'CrimsonPro-Italic', sans-serif;
        --indo-caption-font: 'Figtree-Regular', sans-serif;
    }

    .event-details-container,
    .event-details-container * {
        box-sizing: border-box;
    }

    .event-details-container {
        display: flex;
        flex-direction: column;
        gap: 48px;
        align-items: center;
        justify-content: flex-start;
        position: relative;
        width: 100%;
        margin-top: 40px;
    }

    @media (min-width: 992px) {
        .event-details-container {
            margin-top: 40px;
        }
    }

    /* Header */
    .event-header-nav {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        width: 100%;
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
    }

    .back-link {
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
        text-decoration: none;
    }

    /* Hero Section */
    .event-hero {
        display: flex;
        flex-direction: row;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .event-hero-image {
        flex-shrink: 0;
        width: 388px;
        height: 291px;
        position: relative;
        object-fit: cover;
        aspect-ratio: 4/3;
    }

    .event-hero-details {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
    }

    /* Meta Group */
    .event-meta-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .event-tag {
        color: #000000;
        text-align: left;
        font-family: var(--indo-caption-font);
        font-size: 16px;
        line-height: 100%;
        letter-spacing: 2px;
        font-weight: 400;
        text-transform: uppercase;
        position: relative;
        align-self: stretch;
    }

    .event-title {
        color: #000000;
        text-align: left;
        font-family: var(--indo-header-font);
        font-size: 32px;
        line-height: 112%;
        letter-spacing: -0.5px;
        font-weight: 700;
        position: relative;
        align-self: stretch;
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    /* Info Group */
    .event-info-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .event-info-row {
        color: #000000;
        text-align: left;
        font-family: var(--indo-body-font);
        font-size: 20px;
        line-height: 108%;
        font-weight: 400;
        position: relative;
        align-self: stretch;
    }

    .info-label {
        font-family: var(--indo-italic-font);
        font-style: italic;
    }

    .info-value {
        font-family: var(--indo-body-font);
        
    }

    /* Content Body */
    .event-content-body {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .event-speaker-block {
        color: #000000;
        text-align: left;
        font-family: var(--indo-body-font);
        font-size: 20px;
        line-height: 108%;
        font-weight: 400;
        position: relative;
        align-self: stretch;
    }

    /* Preserved Section Styles */
    .inner-news__section {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        width: 100%;
        position: relative;
        padding-top: 10px;
    }

    .section-title {
        color: #000000;
        text-align: left;
        font-family: var(--indo-header-font);
        font-size: 32px;
        line-height: 112%;
        letter-spacing: -0.5px;
        font-weight: 700;
        margin: 0;
        width: 100%;
    }

    .content-text {
        color: #000000;
        text-align: justify;
        font-family: var(--indo-body-font);
        font-size: 20px;
        line-height: 108%;
        font-weight: 400;
        margin: 0;
        width: 100%;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .event-hero {
            flex-direction: column;
        }

        .event-hero-image {
            width: 100%;
            height: auto;
        }
    }
</style>