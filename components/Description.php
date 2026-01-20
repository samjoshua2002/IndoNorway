<?php
// Include database connection
$conn = include(__DIR__ . '/../database.php');

// Fetch description from database
$sql = "SELECT id, about, image FROM description LIMIT 1";
$result = $conn->query($sql);

$description = null;
if ($result && $result->num_rows > 0) {
  $description = $result->fetch_assoc();
}
?>

<div class="container section-padding">
  <div class="row g-4 align-items-stretch">

    <!-- Left Column -->
    <div class="col-12 col-lg-8 d-flex flex-column">
      <div class="bg-white p-4 p-lg-5 h-100"> <!-- Inner Wrapper -->
        <p class="description-dark text-justify m-0">
          <?php echo $description ? nl2br(htmlspecialchars($description['about'])) : 'No description available.'; ?>
        </p>
      </div>
    </div>

    <!-- Right Column -->
    <div class="col-12 col-lg-4 d-flex flex-column">
      <div class="description-image-bg bg-dark-blue h-100"
        style="background-image: url('assets/files/home/<?php echo $description ? htmlspecialchars($description['image']) : 'about-placeholder-img.webp'; ?>');">
      </div>
    </div>

  </div>
</div>

<style>
  .section-padding {
    padding-top: 1.5rem;
    /* Mobile */
  }

  @media (min-width: 992px) {
    .section-padding {
      padding-top: 3rem;
      /* Desktop */
    }
  }

  .text-justify {
    text-align: justify;
  }

  /* Ensure columns are equal height */
  .align-items-stretch {
    align-items: stretch !important;
  }

  /* Image container - now fills entire column */
  .image-cover {
    display: flex;
    overflow: hidden;
  }

  .image-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  /* Added for text column */
  .bg-white {
    background-color: white;
  }

  /* Remove any default margins/padding from columns */
  .row.g-0>[class*="col-"] {
    padding-right: 0;
    padding-left: 0;
  }

  /* Optional: Add a subtle border between columns on desktop */
  @media (min-width: 992px) {
    .bg-white {
      border-right: 1px solid #f0f0f0;
    }
  }
</style>