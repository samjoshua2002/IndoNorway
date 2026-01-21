<div class="container section-padding">
    <p class="page-header text-center mb-4">News & Events</p>

    <div class="news-list">
        <?php
        // Connect to database
        $conn = include __DIR__ . '/../database.php';

        // Fetch events
        $sql = "SELECT * FROM events ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $hasImage = !empty($row['image']);
                $hasTitle = !empty($row['title']);
                $isCitation = !$hasTitle && !empty($row['description']);

                // Determine category/tag
                $category = !empty($row['tag']) ? htmlspecialchars($row['tag']) : '';
                ?>

                <div class="news-item news-item--bordered">
                    <?php if ($hasImage): ?>
                        <img class="news-item__image" src="assets/files/news/<?php echo htmlspecialchars($row['image']); ?>"
                            alt="<?php echo htmlspecialchars($row['title']); ?>" />
                    <?php endif; ?>

                    <div class="news-item__content">
                        <?php if ($category): ?>
                            <div class="news-item__category">
                                <?php echo $category; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($isCitation): ?>
                            <div class="news-item__citation">
                                <?php echo $row['description']; // Allow HTML for citations ?>
                            </div>
                        <?php else: ?>
                            <?php if ($hasTitle): ?>
                                <div class="news-item__title">
                                    <a href="InnerNews.php?id=<?php echo htmlspecialchars($row['id']); ?>"
                                        style="text-decoration: none; color: inherit;">
                                        <?php echo htmlspecialchars($row['title']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($row['event_date']) && empty($row['event_time'])): ?>
                                <div class="news-item__date">
                                    <?php echo htmlspecialchars($row['event_date']); ?>
                                </div>
                            <?php endif; ?>

                            <?php
                            // Check for Meta Data
                            $hasTime = !empty($row['event_time']);
                            $hasVenue = !empty($row['venue']);
                            $hasSpeaker = !empty($row['speaker']);

                            if ($hasTime || $hasVenue || $hasSpeaker):
                                ?>
                                <div class="news-item__meta">
                                    <?php if ($hasTime): ?>
                                        <div class="meta-row">
                                            <span class="meta-label">Time:</span>
                                            <span class="meta-value">
                                                <?php
                                                echo htmlspecialchars($row['event_date']);
                                                if (!empty($row['event_time'])) {
                                                    echo ', ' . htmlspecialchars($row['event_time']);
                                                }
                                                ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($hasVenue): ?>
                                        <div class="meta-row">
                                            <span class="meta-label">Venue:</span>
                                            <span class="meta-value">
                                                <?php echo htmlspecialchars($row['venue']); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($hasSpeaker): ?>
                                        <div class="meta-row ">
                                            <span class="meta-label">Speaker:</span>
                                            <span class="meta-value ">
                                                <?php echo htmlspecialchars($row['speaker']); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($row['description'])): ?>
                                <div class="news-item__body">
                                    <?php echo nl2br(htmlspecialchars($row['description'])); ?>
                                </div>
                            <?php endif; ?>

                        <?php endif; // End isCitation check ?>
                    </div>
                </div>

                <?php
            }
        } else {
            echo '<p class="text-center">No news or events available at the moment.</p>';
        }
        ?>
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
        text-align: justify;
    }

    .news-item__title:hover {
        text-decoration: underline;
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
        margin-top: 4px;
        display: flex;
        flex-direction: column;
        gap: 10px;
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
        text-align: justify;
    }

    /* Body Text */
    .news-item__body {
        font-family: var(--font-body);
        font-size: 20px;
        line-height: 108%;
        font-weight: 400;
        color: var(--color-text);
        text-align: justify;
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

    .news-item__citation a {
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