<div class="container section-padding">
    <p class="title-dark text-center mb-4">Our Activities</p>
    <div class="activity-section">
    <!-- First Row -->
    <div class="row g-3 align-items-stretch">
        <!-- Left Column - Text -->
        <div class="col-12 col-lg-6 d-flex flex-column">
            <div class="bg-white h-100  p-lg-5"> <!-- Added padding -->
                <p class="activity-title">Research Collaborations</p>
                <p class="description-dark text-justify ">
                    Our joint endeavours span researchers from various environments at both institutions, 
                    tackling global challenges in areas such as energy, environment, climate, health, 
                    and sustainable development. Our collaborations include bilateral research projects 
                    in areas of interest.
                </p>
            </div>
        </div>

        <!-- Right Column - Image -->
        <div class="col-12 col-lg-6 d-flex flex-column">
            <div class="description-image-bg bg-dark-blue h-100" 
                 style="background-image: url('assets/files/home/research-placeholder-img.webp'); min-height: 200px !important;">
                <!-- Optional: Add fallback text if image doesn't load -->
                <div class="visually-hidden">Research collaboration image</div>
            </div>
        </div>
    </div>
    </div>
  <div class="activity-section">
    <!-- Second Row -->
    <div class="row g-3 align-items-stretch">
        <!-- Left Column - Image -->
        <div class="col-12 col-lg-6 d-flex flex-column order-2 order-lg-1"> <!-- Changed order for mobile -->
            <div class="description-image-bg bg-dark-blue h-100" 
                 style="background-image: url('assets/files/home/mobility-placeholder-img(1).webp'); min-height: 150px !important;">
                <div class="visually-hidden">Mobility programmes image</div>
            </div>
        </div>

        <!-- Right Column - Text -->
        <div class="col-12 col-lg-6 d-flex flex-column order-1 order-lg-2"> <!-- Changed order for mobile -->
            <div class="bg-white h-100 p-4 p-lg-5"> <!-- Added padding -->
                <p class="activity-title">Mobility Programmes</p>
                <p class="description-dark text-justify m-0">
                    Open to students at all academic levels, we facilitate semester exchanges, 
                    research stays, and summer internships, supported by monthly allowances 
                    and travel funding.
                </p>
            </div>
        </div>
    </div>
</div>
</div>

<style>
    .activity-section {
  margin-bottom: 24px; /* mobile */
}

@media (min-width: 992px) {
  .activity-section {
    margin-bottom: 48px; /* desktop */
  }
}

.activity-title {
    font-family: 'Crimson Pro', serif;
    font-style: italic;
    font-weight: 300;
    font-size: 40px;
    line-height: 100%;
    color: var(--text-black);
    margin-bottom: 1rem !important;
}

.section-padding {
    padding-top: 1.5rem !important; /* Mobile */
}

@media (min-width: 992px) {
    .section-padding {
        padding-top: 3rem !important; /* Desktop */
    }
}

.text-justify {
    text-align: justify !important;
}

/* Ensure columns are equal height */
.align-items-stretch {
    align-items: stretch !important;
}

/* Image container styling - FIXED */
.description-image-bg {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    width: 100% !important;
    height: 100% !important;
    background-size: cover !important;
    background-position: center center !important;
    background-repeat: no-repeat !important;
    background-color: #0d2d5c; /* dark-blue fallback */
    position: relative !important;
    z-index: 1 !important;
}

/* Ensure image is visible and properly sized */
.description-image-bg::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(13, 45, 92, 0.1); /* Optional overlay */
    z-index: 2;
}

/* Text column styling */
.bg-white {
    background-color: white !important;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

/* Remove any default margins/padding from columns */
.row.g-0 > [class*="col-"] {
    padding-right: 0 !important;
    padding-left: 0 !important;
}

/* Ensure text content has proper padding */
.bg-white {
    padding: 2rem !important;
}

@media (min-width: 992px) {
    .bg-white {
        padding: 0rem !important;
        border-right: 1px solid #f0f0f0 !important;
        gap: 2 !important;
    }
    
    /* Ensure images are properly sized on desktop */
    .description-image-bg {
        min-height: 400px !important;
    }
}

/* Mobile specific adjustments */
@media (max-width: 991.98px) {
    .activity-title {
        font-size: 32px !important;
        margin-bottom: 0.75rem !important;
    }
    
    .description-image-bg {
        min-height: 250px !important;
    }
    
    /* Remove border on mobile */
    .bg-white {
        border: none !important;
        padding: 0rem !important;
    }
    
    /* Add space between sections on mobile */
    .row:first-of-type {
        margin-bottom: 0 !important;
    }
}

/* Fix for image loading */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.description-image-bg {
    animation: fadeIn 0.5s ease-in-out !important;
}
</style>

<script>
// Optional: Add image loading fallback
document.addEventListener('DOMContentLoaded', function() {
    const imageContainers = document.querySelectorAll('.description-image-bg');
    
    imageContainers.forEach(container => {
        const bgImage = container.style.backgroundImage;
        const url = bgImage.replace('url("', '').replace('")', '');
        
        // Test if image loads
        const img = new Image();
        img.onload = function() {
            console.log('Image loaded successfully:', url);
        };
        img.onerror = function() {
            console.warn('Image failed to load:', url);
            // Add fallback color or placeholder
            container.style.backgroundColor = '#0d2d5c';
            container.innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 100%; color: white; padding: 2rem; text-align: center;">Image placeholder</div>';
        };
        img.src = url;
    });
});
</script>