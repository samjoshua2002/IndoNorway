<div class="container section-padding">
    <p class="header-dark text-center mb-3">About</p>
  <div class="row g-4 align-items-stretch">

    <!-- Left Column -->
    <div class="col-12 col-lg-8 d-flex flex-column">
      <div class="bg-white  h-100"> <!-- Inner Wrapper -->
        <p class="description-dark text-justify m-0">
      We are a community of students, researchers, faculty, and staff from the Indian Institute of Technology Madras (IIT Madras) and the Norwegian University of Science and Technology (NTNU), working together to promote international collaboration in higher education and research. IndoNorway Connect is a platform born out of mutual respect, shared academic interests, and a vision to create meaningful cross-cultural and interdisciplinary learning experiences. At the core of this initiative is a commitment to fostering student mobility, joint research, and institutional cooperation that transcends geographical boundaries. Our collaboration is shaped by people—individuals who believe that impactful education and research thrive on openness, dialogue, and diversity. From facilitating semester exchanges and research internships to supporting collaborative projects, we work together to build a strong and inclusive academic bridge between India and Norway. By connecting two world-class institutions, IndoNorway Connect creates a space where students and researchers are empowered to explore global perspectives, challenge conventional thinking, and contribute to solving shared challenges through innovation and collaboration. 
      </div>
    </div>

    <!-- Right Column -->
    <div class="col-12 col-lg-4 d-flex flex-column">
      <div class="description-image-bg bg-dark-blue h-100 mb-2" style="background-image: url('./assets/files/about/pexels-artempodrez-8533097-r01.webp');">
      </div>
       <div class="description-image-bg bg-dark-blue h-100" style="background-image: url('./assets/files/about/pexels-madvortex-12807377-r01.webp');">
      </div>
    </div>

  </div>
</div>

<style>
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
  .section-padding {
    padding-top: 1.5rem;
    /* Mobile */
  }

  @media (min-width: 992px) {
    .section-padding {
      padding-top: 1rem;
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
  .description-image-bg {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 200px;
  }

  @media (min-width: 992px) {
    .description-image-bg {
      min-height: auto;
    }
  }

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