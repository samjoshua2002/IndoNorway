<div class="container section-padding mb-3">
    <p class="title-dark text-center mb-4">Projects</p>

    <div class="activity-cards">
        <!-- Project Card 1 -->
        <div class="activity-card-01 card-item">
            <div class="card-image-container">
                <img src="assets/files/home/projectCard-erasmus.webp" alt="Erasmus Global Mobility Programme" class="card-01-img">
                <div class="image-gradient-overlay"></div>
            </div>
            <div class="card-01-text">
                <div class="project-status-02">
                    <span class="ongoing">ONGOING</span>
                </div>
                <h3 class="project-title">Erasmus+ Global Mobility Programme</h3>
                <p class="project-description">
                    The overall goal with the current project is to establish lasting academic and research collaborations among the partners. This is expected to be achieved by: a) educating students through mobility and exchange stays, b) educating...
                </p>
            </div>
        </div>

        <!-- Project Card 2 -->
        <div class="activity-card-2 card-item">
            <div class="card-image-container">
                <img src="assets/files/home/projectCard-batteries.webp" alt="Sustainable Chemical Engineering" class="card-01-img">
                <div class="image-gradient-overlay"></div>
            </div>
            <div class="card-01-text">
                <div class="project-status-02">
                    <span class="ongoing">ONGOING</span>
                </div>
                <h3 class="project-title">
                    Integrating Research & Education in Sustainable Chemical Engineering for Batteries & Water Treatment
                </h3>
                <p class="project-description">
                    In this project, NTNU, IIT Madras, and North Carolina State University (NCSU) will work together to achieve internationalization and benchmarking of NTNU's unique...
                </p>
            </div>
        </div>

        <!-- Project Card 3 -->
        <div class="activity-card-3 card-item">
            <div class="card-image-container">
                <img src="assets/files/home/projectCard-nanomaterials.webp" alt="Advanced Nanomaterials" class="card-01-img">
                <div class="image-gradient-overlay"></div>
            </div>
            <div class="card-01-text">
                <div class="project-status-02">
                    <span class="ongoing">ONGOING</span>
                </div>
                <h3 class="project-title">
                    Fostering Safety in Use of Advanced Nanomaterials in Health Sector
                </h3>
                <p class="project-description">
                    In this project, NTNU, IIT Madras, Indian Institute of Science (IISc), and a Norwegian biotech startup Lybe Scientific will work together to develop capacity-building programs for students and researchers with...
                </p>
            </div>
        </div>
    </div>

    <!-- All Projects Button -->
    <div class="d-flex justify-content-center mt-4">
        <button class="buttons-bt-24-pt-sans-dark">
            <span class="_24-pt-button">All Projects</span>
        </button>
    </div>
</div>

<style>
.section-padding {
    padding-top: 1.5rem !important; /* Mobile */
}

@media (min-width: 992px) {
    .section-padding {
        padding-top: 3rem !important; /* Desktop */
    }
}

/* Activity Cards Container - Full width */
.activity-cards {
    display: grid;
    grid-template-columns: 1fr; /* Single column by default */
    gap: 24px;
    width: 100%;
    max-width: 100%;
    margin-bottom: 32px;
}

/* Individual Card Styling - Full width */
.card-item {
    display: flex;
    flex-direction: column;
    width: 100%;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

/* Card Image Container */
.card-image-container {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
}

/* Card Image - Full width */
.card-01-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}

.card-item:hover .card-01-img {
    transform: scale(1.05);
}

/* Image Gradient Overlay - Fixed flickering */
.image-gradient-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 80px;
    background: linear-gradient(
        to bottom,
        transparent 0%,
        #004B62 100%
    );
    transition: background 0.3s ease;
    pointer-events: none;
    transform: translateZ(0); /* Fix flickering */
    backface-visibility: hidden; /* Fix flickering */
    will-change: background; /* Optimize animation */
}

/* Hover effect for gradient overlay */
.card-item:hover .image-gradient-overlay {
    background: linear-gradient(
        to bottom,
        transparent 0%,
        rgba(0, 47, 114, 1) 100%
    );
}

/* Card Text Container - Full width */
.card-01-text {
    background: linear-gradient(
        180deg,
        rgba(0, 75, 98, 1) 0%,
        rgba(0, 47, 114, 1) 100%
    );
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    flex: 1;
    width: 100%;
    transition: background 0.3s ease-in-out;
}

/* Card hover changes both image gradient AND card background */
.card-item:hover .card-01-text {
    background: linear-gradient(
        180deg,
        rgba(0, 47, 114, 1) 0%,
        rgba(0, 47, 114, 1) 100%
    );
}

/* Project Status Badge */
.project-status-02 {
    background: #7adef7;
    border-radius: 4px;
    padding: 8px 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    align-self: flex-start;
    flex-shrink: 0;
}

.ongoing {
    color: #000000;
    text-align: left;
    font-family: 'Figtree', sans-serif;
    font-size: 12px;
    line-height: 100%;
    letter-spacing: 2px;
    font-weight: 400;
    text-transform: uppercase;
    white-space: nowrap;
}

/* Project Titles with line clamping */
.project-title {
    color: #ffffff;
    text-align: left;
    font-family: 'Figtree', sans-serif;
    font-size: 24px;
    line-height: 120%;
    font-weight: 700;
    margin: 0;
    width: 100%;
    
    /* Line clamping for title - Maximum 5 lines */
    display: -webkit-box;
    -webkit-line-clamp: 5; /* Max 5 lines for title */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    
    /* Minimum height to ensure at least 1 line is visible */
    min-height: calc(1.2em * 1); /* 1 line minimum */
    max-height: calc(1.2em * 5); /* 5 lines maximum */
}

/* Project Description with line clamping */
.project-description {
    color: #ffffff;
    text-align: left;
    font-family: 'Crimson Pro', serif;
    font-size: 20px;
    line-height: 140%;
    font-weight: 400;
    margin: 0;
    width: 100%;
    flex: 1;
    
    /* Line clamping for description - Dynamic based on title lines */
    display: -webkit-box;
    -webkit-line-clamp: 6; /* Maximum total lines (title + description) */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    
    /* Flexible height - fills remaining space */
    min-height: calc(1.4em * 1); /* 1 line minimum */
}

/* JavaScript will dynamically adjust the line clamping */
.text-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex: 1;
    min-height: 0; /* Important for flex children to respect overflow */
}

/* All Projects Button */
.buttons-bt-24-pt-sans-dark {
    background: linear-gradient(90deg, #004B62 0%, #002F72 100%);
    border-radius: 8px;
    padding: 16px 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.25);
    border: none;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    min-width: 200px;
}

.buttons-bt-24-pt-sans-dark:hover {
    transform: translateY(-2px);
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
}

._24-pt-button {
    color: #ffffff;
    text-align: center;
    font-family: 'Figtree', sans-serif;
    font-size: 24px;
    line-height: 100%;
    font-weight: 700;
    white-space: nowrap;
}

/* Desktop Layout - 3 columns */
@media (min-width: 992px) {
    .activity-cards {
        grid-template-columns: repeat(3, 1fr);
        gap: 32px;
    }
    
    .card-item {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .card-image-container {
        height: 180px;
    }
    
    .card-01-text {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0; /* Important for flex children */
    }
    
    .project-title {
        font-size: 24px;
        line-height: 120%;
    }
    
    .project-description {
        font-size: 24px;
        line-height: 140%;
    }
}

/* Tablet Layout - 2 columns */
@media (min-width: 768px) and (max-width: 991px) {
    .activity-cards {
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }
    
    .card-item {
        height: 100%;
    }
    
    .card-image-container {
        height: 160px;
    }
    
    .card-01-text {
        padding: 20px;
    }
    
    .project-title {
        font-size: 22px;
        line-height: 120%;
    }
    
    .project-description {
        font-size: 18px;
        line-height: 140%;
    }
}

/* Mobile Responsive */
@media (max-width: 767px) {
    .activity-cards {
        gap: 20px;
    }
    
    .card-image-container {
        height: 140px;
    }
    
    .card-01-text {
        padding: 20px;
    }
    
    .project-title {
        font-size: 20px;
        line-height: 120%;
    }
    
    .project-description {
        font-size: 24px;
        line-height: 140%;
    }
    
    .buttons-bt-24-pt-sans-dark {
        padding: 14px 28px;
        min-width: 180px;
    }
    
    ._24-pt-button {
        font-size: 20px;
    }
}

/* Small Mobile */
@media (max-width: 375px) {
    .card-01-text {
        padding: 16px;
    }
    
    .project-title {
        font-size: 18px;
        line-height: 120%;
    }
    
    .project-description {
        font-size: 15px;
        line-height: 140%;
    }
}

/* Adjust gradient overlay for different screen sizes */
@media (min-width: 992px) {
    .image-gradient-overlay {
        height: 70px;
    }
}

@media (max-width: 767px) {
    .image-gradient-overlay {
        height: 60px;
    }
}

@media (max-width: 375px) {
    .image-gradient-overlay {
        height: 50px;
    }
}

/* Fix for Safari line-clamp */
.project-title, .project-description {
    display: -webkit-box;
    display: -moz-box;
    display: box;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fix flickering by pre-loading hover states
    const cards = document.querySelectorAll('.card-item');
    
    cards.forEach(card => {
        // Add hardware acceleration for smoother animations
        card.style.transform = 'translateZ(0)';
        
        // Dynamic line clamping calculation
        const title = card.querySelector('.project-title');
        const description = card.querySelector('.project-description');
        
        if (title && description) {
            // Calculate available space and adjust line clamping
            adjustLineClamping(title, description);
        }
    });
    
    // Adjust on window resize
    window.addEventListener('resize', function() {
        document.querySelectorAll('.card-item').forEach(card => {
            const title = card.querySelector('.project-title');
            const description = card.querySelector('.project-description');
            
            if (title && description) {
                adjustLineClamping(title, description);
            }
        });
    });
    
    function adjustLineClamping(title, description) {
        // Reset to defaults
        title.style.WebkitLineClamp = '5'; // Max 5 lines for title
        description.style.WebkitLineClamp = '6'; // Max 6 lines total
        
        // Get actual line heights
        const titleLineHeight = parseInt(window.getComputedStyle(title).lineHeight);
        const descLineHeight = parseInt(window.getComputedStyle(description).lineHeight);
        
        // Calculate available height (approximate)
        const cardTextHeight = title.parentElement.offsetHeight;
        const statusHeight = title.parentElement.querySelector('.project-status-02').offsetHeight;
        const gapHeight = 16; // gap value from CSS
        const paddingBottom = 24; // padding bottom
        
        const availableHeight = cardTextHeight - statusHeight - gapHeight - paddingBottom;
        
        // Calculate how many lines fit
        let titleLines = Math.floor((title.offsetHeight) / titleLineHeight);
        let remainingHeight = availableHeight - (titleLines * titleLineHeight);
        let descLines = Math.max(1, Math.floor(remainingHeight / descLineHeight));
        
        // Ensure total lines don't exceed 6
        const totalLines = titleLines + descLines;
        
        if (totalLines > 6) {
            // Reduce title lines first if possible
            if (titleLines > 1) {
                titleLines = Math.min(5, 6 - 1); // Leave at least 1 line for description
                descLines = 1;
            } else {
                // If title already 1 line, limit description
                descLines = 5; // Max 5 lines for description if title is 1 line
            }
        }
        
        // Apply calculated line clamping
        title.style.WebkitLineClamp = titleLines.toString();
        description.style.WebkitLineClamp = descLines.toString();
    }
    
    // Initialize line clamping
    setTimeout(() => {
        document.querySelectorAll('.card-item').forEach(card => {
            const title = card.querySelector('.project-title');
            const description = card.querySelector('.project-description');
            
            if (title && description) {
                adjustLineClamping(title, description);
            }
        });
    }, 100); // Small delay to ensure CSS is applied
});
</script>