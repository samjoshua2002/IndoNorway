<div class="container section-padding">
    <p class="header-dark text-center mb-3">People</p>

    <div class="people-grid">
        <?php
        // Connect to database if not already connected
        require_once __DIR__ . '/../database.php';

        $sql = "SELECT * FROM people ORDER BY id ASC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Prepare Image
                $imgSrc = 'assets/files/people/' . htmlspecialchars($row['image']);
                
                // Prepare Designation Info (Specification, Department, Colleges)
                $designationParts = [];
                if (!empty($row['specification'])) $designationParts[] = htmlspecialchars($row['specification']);
                if (!empty($row['department']))    $designationParts[] = htmlspecialchars($row['department']);
                if (!empty($row['college1']))      $designationParts[] = htmlspecialchars($row['college1']);
                if (!empty($row['college2']))      $designationParts[] = htmlspecialchars($row['college2']);
                if (!empty($row['college3']))      $designationParts[] = htmlspecialchars($row['college3']);
                if (!empty($row['college4']))      $designationParts[] = htmlspecialchars($row['college4']);
                
                $designationHtml = implode('<br>', $designationParts);
        ?>
        <div class="person-card">
            <div class="person-header">
                <img src="<?php echo $imgSrc; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="person-image">
                <div class="person-info">
                    <h2 class="person-name"><?php echo htmlspecialchars($row['name']); ?></h2>
                    <p class="person-designation"><?php echo $designationHtml; ?></p>
                </div>
            </div>
            <div class="person-content">
                <?php if (!empty($row['about'])): ?>
                <p class="person-bio">
                    <?php echo nl2br(htmlspecialchars($row['about'])); ?>
                </p>
                <?php endif; ?>
                
                <?php if (!empty($row['researchintest'])): ?>
                <div class="person-section">
                    <h3 class="section-title">Research Interests</h3>
                    <p class="section-text"><?php echo nl2br(htmlspecialchars($row['researchintest'])); ?></p>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($row['contact'])): ?>
                <div class="person-section">
                    <h3 class="section-title">Contact</h3>
                    <p class="section-text"><?php echo htmlspecialchars($row['contact']); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php 
            }
        } else {
            echo '<p class="text-center col-span-2">No people found.</p>';
        }
        ?>
    </div>
</div>

<style>
    /* People Grid Layout */
    .people-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 48px;
        margin-bottom: 48px;
    }

    @media (max-width: 991px) {
        .people-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
    }

    /* Person Card */
    .person-card {
        background: #ffffff;
        border: 1px solid;
        border-image: linear-gradient(90deg, #2DB9DD, #008CFF) 1;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Person Header (Image + Info) */
    .person-header {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }
    @media (min-width: 768px) {
    .person-header {
        align-items: flex-end;
    }
}

    .person-image {
        width: 186px;
        height: 186px;
        object-fit: cover;
        flex-shrink: 0;
    }

    @media (max-width: 576px) {
        .person-header {
            flex-direction: column;
        }
        
        .person-image {
            width: 100%;
            height: auto;
            max-width: 186px;
        }
    }

    .person-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    /* Person Name */
    .person-name {
        font-family: 'Figtree', sans-serif;
        font-size: 32px;
        font-weight: 700;
        line-height: 112%;
        letter-spacing: -0.5px;
        color: #000000;
        margin: 0;
    }

    @media (max-width: 768px) {
        .person-name {
            font-size: 24px;
        }
    }

    /* Person Designation */
    .person-designation {
        font-family: 'Crimson Pro', serif;
        font-size: 20px;
        font-weight: 400;
        font-style: italic;
        line-height: 108%;
        color: #000000;
        margin: 0;
    }

    @media (max-width: 768px) {
        .person-designation {
            font-size: 18px;
        }
    }

    /* Person Content */
    .person-content {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* Person Bio */
    .person-bio {
        font-family: 'Crimson Pro', serif;
        font-size: 22px;
        font-weight: 400;
        line-height: 108%;
        color: #000000;
        margin: 0;
        text-align: justify;
    }

    @media (max-width: 768px) {
        .person-bio {
            font-size: 18px;
        }
    }

    /* Section */
    .person-section {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    /* Section Title (Research Interests, Contact) */
    .section-title {
        font-family: 'Crimson Pro', serif;
        font-size: 22px;
        font-weight: 700;
        line-height: 108%;
        color: #000000;
        margin: 0;
    }

    @media (max-width: 768px) {
        .section-title {
            font-size: 18px;
        }
    }

    /* Section Text */
    .section-text {
        font-family: 'Crimson Pro', serif;
        font-size: 22px;
        font-weight: 400;
        line-height: 108%;
        color: #000000;
        margin: 0;
        text-align: justify;
    }

    @media (max-width: 768px) {
        .section-text {
            font-size: 18px;
        }
    }

    /* Header Typography */
    .header-dark {
        font-family: 'Crimson Pro', serif;
        font-size: 36px;
        font-weight: 400;
        text-align: center;
        line-height: 1.2;
        letter-spacing: -1px;
        color: #000000;
    }

    @media (min-width: 768px) {
        .header-dark {
            font-size: 48px;
        }
    }

    @media (min-width: 992px) {
        .header-dark {
            font-size: 64px;
        }
    }

    /* Section Padding */
    .section-padding {
        padding-top: 1rem;
       
    }

    @media (min-width: 992px) {
        .section-padding {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
    }
</style>