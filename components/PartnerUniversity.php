<?php
// Include database connection
$conn = include(__DIR__ . '/../database.php');

// Fetch partners from database
$sql = "SELECT id, image, title FROM partners ORDER BY id ASC";
$result = $conn->query($sql);

$partners = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $partners[] = $row;
    }
}

// Group partners into slides (4 per slide for desktop, but we'll show 2 for now)
$partnersPerSlide = 4;
$slides = array_chunk($partners, $partnersPerSlide);
?>

<div class="container partner-padding">
  <p class="title-dark text-center mb-3">Partner Universities</p>

  <div id="partnerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <!-- Carousel Indicators -->
    <div class="carousel-indicators">
      <?php foreach ($slides as $index => $slide): ?>
        <button type="button" data-bs-target="#partnerCarousel" data-bs-slide-to="<?php echo $index; ?>" 
          <?php echo $index === 0 ? 'class="active" aria-current="true"' : ''; ?> 
          aria-label="Slide <?php echo $index + 1; ?>"></button>
      <?php endforeach; ?>
    </div>
    
    <div class="carousel-inner">
      <?php foreach ($slides as $slideIndex => $slidePartners): ?>
        <!-- Slide <?php echo $slideIndex + 1; ?> -->
        <div class="carousel-item <?php echo $slideIndex === 0 ? 'active' : ''; ?>">
          <div class="row justify-content-center align-items-start g-4">
            <?php foreach ($slidePartners as $partner): ?>
              <div class="col-6 col-md-3 text-center">
                <div class="d-flex flex-column align-items-center h-100">
                  <div class="logo-container d-flex align-items-center justify-content-center" style="height: 100px;">
                    <img src="assets/files/home/<?php echo htmlspecialchars($partner['image']); ?>" 
                         class="partner-logo img-fluid" 
                         alt="<?php echo htmlspecialchars($partner['title']); ?>">
                  </div>
                  <div class="partner-text-container mt-2" style="min-height: 60px; display: flex; align-items: center; justify-content: center;">
                    <p class="partner-logo-text"><?php echo htmlspecialchars($partner['title']); ?></p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Carousel Controls - Will be hidden when not needed -->
  
  </div>
</div>

<style>
    .partner-padding {
  padding-top: 3rem; /* Mobile */
}

@media (min-width: 992px) {
  .partner-padding {
    padding-top: 6rem; /* Desktop */
  }
}
/* Logo styling with better control */
#partnerCarousel .partner-logo {
  max-height: 80px;
  max-width: 180px;
  width: auto;
  height: auto;
  object-fit: contain;
  object-position: center;
  padding: 5px;
}

#partnerCarousel .logo-container {
  margin-bottom: 0;
  width: 100%;
  overflow: hidden;
}

#partnerCarousel .partner-text-container {
  width: 100%;
}

#partnerCarousel .partner-logo-text {
  font-family: 'Figtree', sans-serif;
  font-weight: 400;
  font-size: 16px;
  line-height: 1.3;
  letter-spacing: 2px;
  text-transform: uppercase;
  text-align: center;
  color: #000000;
  margin: 0;
  word-break: break-word;
  padding: 0 5px;
}

/* Carousel item height control */
#partnerCarousel .carousel-item {
  min-height: 220px;
  padding: 10px 0;
}

/* Carousel controls styling - Initially hidden */
#partnerCarousel .carousel-control-prev,
#partnerCarousel .carousel-control-next {
  display: none;
}

/* Hide indicators when only one slide */
#partnerCarousel .carousel-indicators {
  display: none;
}

/* Only show controls when there are multiple slides */
#partnerCarousel.multiple-slides .carousel-control-prev,
#partnerCarousel.multiple-slides .carousel-control-next {
  display: flex;
  width: 50px;
  opacity: 0.8;
  transition: opacity 0.3s;
}

#partnerCarousel.multiple-slides .carousel-control-prev:hover,
#partnerCarousel.multiple-slides .carousel-control-next:hover {
  opacity: 1;
}

#partnerCarousel.multiple-slides .carousel-control-prev {
  left: -25px;
}

#partnerCarousel.multiple-slides .carousel-control-next {
  right: -25px;
}

#partnerCarousel.multiple-slides .carousel-indicators {
  display: flex;
  bottom: -40px;
}

#partnerCarousel.multiple-slides .carousel-indicators button {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: #ccc;
  border: none;
  margin: 0 4px;
}

#partnerCarousel.multiple-slides .carousel-indicators button.active {
  background-color: #333;
}

/* Center the logos when only 2 items */
#partnerCarousel .row.justify-content-center .col-6.col-md-3 {
  flex: 0 0 auto;
  width: 50%; /* Show 2 logos per row on desktop */
  max-width: 300px; /* Limit maximum width */
}

/* Mobile tweak */
@media (max-width: 768px) {
  #partnerCarousel .logo-container {
    height: 100px !important;
  }
  
  #partnerCarousel .partner-text-container {
    min-height: 50px !important;
  }
  
  #partnerCarousel .partner-logo {
    max-height: 60px;
    max-width: 140px;
  }

  #partnerCarousel .partner-logo-text {
    font-size: 12px;
    letter-spacing: 1px;
    line-height: 1.2;
  }
  
  #partnerCarousel .carousel-item {
    min-height: 180px;
  }
  
  /* Mobile controls when multiple slides */
  #partnerCarousel.multiple-slides .carousel-control-prev,
  #partnerCarousel.multiple-slides .carousel-control-next {
    width: 35px;
  }
  
  #partnerCarousel.multiple-slides .carousel-control-prev {
    left: -15px;
  }
  
  #partnerCarousel.multiple-slides .carousel-control-next {
    right: -15px;
  }
  
  #partnerCarousel.multiple-slides .carousel-control-prev-icon,
  #partnerCarousel.multiple-slides .carousel-control-next-icon {
    width: 20px;
    height: 20px;
    background-size: 15px 15px;
  }
  
  /* On mobile, show 2 logos per row */
  #partnerCarousel .row.justify-content-center .col-6.col-md-3 {
    width: 50%;
  }
}

/* Ensure all text containers have same height */
@media (min-width: 768px) {
  #partnerCarousel .partner-text-container {
    min-height: 60px !important;
  }
  
  /* On desktop with 2 items, center them better */
  #partnerCarousel .row.justify-content-center .col-6.col-md-3 {
    width: 25%; /* 2 logos = 25% each, leaving space in between */
  }
}

/* Fix for large SVG files */
#partnerCarousel .logo-container img[src$=".svg"] {
  width: 100%;
  max-width: 250px;
  height: auto;
  max-height: 100px;
}

/* Add a fallback background for white logos on white background */
#partnerCarousel .logo-container {
  background-color: transparent;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var partnerCarousel = document.getElementById('partnerCarousel');
  
  if (partnerCarousel) {
    // Count how many carousel items we have
    var carouselItems = partnerCarousel.querySelectorAll('.carousel-item');
    var totalItems = carouselItems.length;
    
    if (totalItems > 1) {
      // Add class to show controls when there are multiple slides
      partnerCarousel.classList.add('multiple-slides');
      
      var carousel = new bootstrap.Carousel(partnerCarousel, {
        interval: 3000,
        wrap: true,
        touch: true,
        pause: 'hover'
      });
      
      // Add keyboard navigation only for multiple slides
      document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
          carousel.prev();
        } else if (e.key === 'ArrowRight') {
          carousel.next();
        }
      });
    } else {
      // Only one slide, remove carousel functionality
      partnerCarousel.setAttribute('data-bs-ride', 'false');
      partnerCarousel.removeAttribute('data-bs-interval');
    }
  }
  
  // Fix for SVG logos - ensure they're properly sized
  document.querySelectorAll('.partner-logo').forEach(function(img) {
    if (img.src.includes('.svg')) {
      // Add onload event to ensure SVG is properly loaded
      img.onload = function() {
        this.style.opacity = '1';
      };
      // If already loaded
      if (img.complete) {
        img.style.opacity = '1';
      }
    }
  });
});
</script>