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
            <!-- Header Section -->
            <div class="inner-news__header">
                <div class="inner-news__breadcrumb">
                    <a href="News-Events.php" class="breadcrumb-link">&lt; All News</a>
                </div>
                <!-- Main Title from events table -->
                <h1 class="inner-news__title"><?php echo htmlspecialchars($event['title'] ?? ''); ?></h1>
            </div>

            <!-- Featured Image from events table -->
            <?php if (!empty($event['image'])): ?>
                <img class="inner-news__image" src="assets/files/news/<?php echo htmlspecialchars($event['image'] ?? ''); ?>"
                    alt="<?php echo htmlspecialchars($event['title'] ?? ''); ?>" />
            <?php endif; ?>

            <!-- Main Content Section from events table (Description) -->
            <div class="inner-news__content">
                <div class="content-block">
                    <div class="content-text">
                        <?php echo nl2br(htmlspecialchars($event['description'] ?? '')); ?>
                    </div>
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
        --font-header: 'Figtree-Bold', sans-serif;
        --font-body: 'CrimsonPro-Regular', sans-serif;
        --color-text: #000000;
        --color-bg: #ffffff;
    }

    * {
        box-sizing: border-box;
    }

    .section-padding {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    /* Main Container */
    .inner-news {
        display: flex;
        flex-direction: column;
        gap: 48px;
        align-items: center;
        justify-content: flex-start;
        position: relative;
        margin: 0 auto;
    }

    /* Header Section */
    .inner-news__header {
        display: flex;
        flex-direction: column;
        gap: 4px;
        align-items: flex-start;
        justify-content: flex-start;
        width: 100%;
        position: relative;
    }

    .inner-news__breadcrumb {
        display: flex;
        flex-direction: row;
        gap: 10px;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .breadcrumb-link {
        color: var(--color-text);
        text-align: left;
        font-family: var(--font-body);
        font-size: 20px;
        line-height: 108%;
        font-weight: 400;
        text-decoration: none;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        transition: text-decoration 0.2s ease;
    }

    .breadcrumb-link:hover {
        text-decoration: underline;
        color: var(--color-text);
    }

    .inner-news__title {
        color: var(--color-text);
        text-align: left;
        font-family: var(--font-header);
        font-size: 36px;
        line-height: 112%;
        letter-spacing: -0.5px;
        font-weight: 700;
        position: relative;
        width: 100%;
        margin: 0;
    }

    /* Featured Image */
    .inner-news__image {
        width: 100%;
        height: auto;
        max-height: 897px;
        position: relative;
        object-fit: cover;
        aspect-ratio: 4/3;
    }

    /* Content Sections */
    .inner-news__content,
    .inner-news__section {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        width: 100%;
        position: relative;
    }

    .content-block,
    .section-content {
        display: flex;
        flex-direction: column;
        gap: 16px;
        width: 100%;
    }

    .content-text {
        color: var(--color-text);
        text-align: justify;
        font-family: var(--font-body);
        font-size: 24px;
        line-height: 108%;
        font-weight: 400;
        margin: 0;
        width: 100%;
    }

    .section-title {
        color: var(--color-text);
        text-align: left;
        font-family: var(--font-header);
        font-size: 32px;
        line-height: 112%;
        letter-spacing: -0.5px;
        font-weight: 700;
        margin: 0;
        width: 100%;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .inner-news {
            gap: 32px;
        }

        .inner-news__title {
            font-size: 28px;
        }

        .section-title {
            font-size: 24px;
        }

        .content-text {
            font-size: 20px;
        }

        .breadcrumb-link {
            font-size: 18px;
        }
    }

    @media (max-width: 480px) {
        .inner-news {
            gap: 24px;
        }

        .inner-news__title {
            font-size: 24px;
        }

        .section-title {
            font-size: 20px;
        }

        .content-text {
            font-size: 18px;
        }
    }
</style>