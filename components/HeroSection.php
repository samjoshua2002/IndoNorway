<?php
// Include database connection
$conn = include(__DIR__ . '/../database.php');

// Fetch hero banners from database
$sql = "SELECT id, image, title, description FROM herobanner ORDER BY id ASC";
$result = $conn->query($sql);

$banners = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $banners[] = $row;
    }
}
?>

<div class="container pt-5 pb-0 pb-md-5">
    <div class="row g-4 align-items-stretch">
        <!-- Left Column: Carousel -->
        <div class="col-12 col-lg-8 d-flex flex-column">
            <div id="heroCarousel" class="carousel slide h-100" data-bs-ride="carousel">

                <!-- Indicators -->
                <div class="carousel-indicators">
                    <?php foreach ($banners as $index => $banner): ?>
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?php echo $index; ?>"
                            <?php echo $index === 0 ? 'class="active" aria-current="true"' : ''; ?> 
                            aria-label="Slide <?php echo $index + 1; ?>"></button>
                    <?php endforeach; ?>
                </div>

                <!-- Slides -->
                <div class="carousel-inner h-100">
                    <?php foreach ($banners as $index => $banner): ?>
                        <!-- Slide <?php echo $index + 1; ?> -->
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?> h-100">
                            <div class="hero-slide">
                                <img
                                    src="assets/files/home/<?php echo htmlspecialchars($banner['image']); ?>"
                                    class="hero-img"
                                    alt="<?php echo htmlspecialchars($banner['title']); ?>"
                                >

                                <!-- Gradient Overlay -->
                                <div class="hero-gradient"></div>

                                <div class="carousel-caption text-start">
                                    <h1 class="hero-title mb-2"><?php echo nl2br(htmlspecialchars($banner['title'])); ?></h1>
                                    <p class="hero-description">
                                        <?php echo nl2br(htmlspecialchars($banner['description'])); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
<style>
    /* Hero slide wrapper */
.hero-slide {
  position: relative;
  width: 100%;
  height: 100%;
  min-height: 500px;
}

/* Image cover */
.hero-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

/* Grey → transparent gradient (bottom → top) */
.hero-gradient {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to top,
    rgba(3, 0, 0, 0.87),
    rgba(0, 0, 0, 0)
  );
  z-index: 1;
}

/* Caption above gradient */
.carousel-caption {
  z-index: 2;
  bottom: 40px;
  left: 40px;
  right: auto;
}

/* Mobile adjustment */
@media (max-width: 768px) {
  .carousel-caption {
    bottom: 20px;
    left: 20px;
  }
}

</style>

        <!-- Right Column: News & Events -->
        <div class="col-lg-4 d-flex flex-column">
            <div class="bg-dark-blue p-4 p-lg-5 h-100 d-flex flex-column justify-content-between">
                <div>
                    <h2 class="main-title-light mb-4">News & Events</h2>

                    <!-- News Item 1 -->
                    <div class="mb-4 news-item">
                        <h3 class="title-light mb-2">List of students accepted for the Global Mobility Programme 2025</h3>
                        <div class="d-flex align-items-center w-100">
                            <span class="title-light news-date" style="font-size: 14px; letter-spacing: 1px;">12 SEP 2025</span>
                            <span class="news-spacer"></span>
                            <span class="ms-2 text-white news-arrow">→</span>
                        </div>
                    </div>

                    <!-- News Item 2 -->
                    <div class="mb-4 news-item">
                        <h3 class="title-light mb-2" >Seminar: Title & Speaker</h3>
                        <div class="d-flex align-items-center w-100">
                            <span class="title-light news-date" style="font-size: 14px; letter-spacing: 1px;">18 AUG 2025</span>
                            <span class="news-spacer"></span>
                            <span class="ms-2 text-white news-arrow">→</span>
                        </div>
                    </div>

                    <!-- News Item 3 -->
                    <div class="mb-4 news-item">
                        <h3 class="title-light mb-2">Publication: Title & Author</h3>
                        <div class="d-flex align-items-center w-100">
                            <span class="title-light news-date" style="font-size: 14px; letter-spacing: 1px;">2 AUG 2025</span>
                            <span class="news-spacer"></span>
                            <span class="ms-2 text-white news-arrow">→</span>
                        </div>
                    </div>
                    
                     <!-- News Item 4 -->
                    <div class="mb-4 news-item">
                        <h3 class="title-light mb-2">Applications open for Project Title (Last date: 13 July 2025)</h3>
                        <div class="d-flex align-items-center w-100">
                            <span class="title-light news-date" style="font-size: 14px; letter-spacing: 1px;">30 JUN 2025</span>
                            <span class="news-spacer"></span>
                            <span class="ms-2 text-white news-arrow">→</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center w-100" >
                    <button class="btn-white">All News & Events</button>
                </div>
            </div>
        </div>
    </div>
</div>
