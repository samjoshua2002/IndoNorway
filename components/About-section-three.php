<div class="container section-padding headpos">
  <div class="about-section-two__wrapper">

    <!-- ===== SECTION 1 : IMAGE LEFT ===== -->
    <div class="about-float-layout">
      <img
        src="assets/files/about/iitm-entrance-04-r01.webp"
        alt="IIT Madras entrance"
        class="about-float-image float-left"
      >

      <p class="about-section-two__title">IIT Madras</p>

      <p class="description-dark text-justify">
        The Indian Institute of Technology Madras (IIT Madras), established in 1959, is one of India’s most prestigious
        institutions for higher education, research, and innovation. Located in Chennai, Tamil Nadu, the institute is
        internationally recognized for its excellence in engineering, science, and technology, as well as for its
        interdisciplinary approach to solving complex real-world problems. IIT Madras offers a broad range of
        undergraduate, postgraduate, and doctoral programs across diverse fields, including engineering, sciences,
        humanities, management, and entrepreneurship. The institute is known for its world-class faculty, cutting-edge
        research infrastructure, and vibrant campus life. It actively promotes innovation and entrepreneurship through
        initiatives such as the IIT Madras Research Park, incubation centers, and strategic partnerships with industries
        and global academic institutions. With a strong emphasis on global collaboration, IIT Madras has established
        partnerships with leading universities and research organizations around the world. These engagements support
        academic exchange, joint research, and the co-creation of knowledge that addresses societal and technological
        challenges. Through its role in IndoNorway Connect, IIT Madras reinforces its commitment to global education and
        research partnerships, providing students and researchers with opportunities to engage in impactful
        international experiences.
      </p>
    </div>

    <!-- ===== SECTION 2 : IMAGE RIGHT ===== -->
    <div class="about-float-layout">
      <img
        src="assets/files/about/Gløshaugen campus 800x400.webp"
        alt="NTNU campus"
        class="about-float-image float-right"
      >

      <p class="about-section-two__title">NTNU</p>

      <p class="description-dark text-justify">
        The Norwegian University of Science and Technology (NTNU) is Norway’s largest and most diverse university, known
        for its leadership in science, technology, and innovation. Headquartered in Trondheim, with additional campuses
        in Gjøvik and Ålesund, NTNU offers a comprehensive academic portfolio spanning engineering, natural sciences,
        medicine, architecture, social sciences, arts, and humanities. NTNU is deeply rooted in a mission to contribute
        to sustainable development and to create knowledge for a better world. With a strong focus on interdisciplinary
        research and real-world impact, the university is involved in numerous international research projects and
        collaborates closely with industry and public institutions across the globe. The university has a long-standing
        tradition of international cooperation, and its strategic focus on global engagement is reflected in various
        mobility programs, research partnerships, and academic exchanges. NTNU provides a stimulating environment for
        students and researchers, offering access to advanced facilities, high-quality education, and a supportive
        international community. As part of IndoNorway Connect, NTNU contributes its academic excellence and
        collaborative spirit to strengthen ties with IIT Madras and enhance educational and research opportunities
        between Norway and India.
      </p>
    </div>

  </div>
</div>

<style>
  .headpos{
    padding-top: 1.5rem; /* Mobile */
  }
  .about-float-layout {
  overflow: hidden; /* clears floats */
  margin-bottom: 6px;
}
  @media (min-width: 992px) {
    .headpos{
      padding-top: 9rem; /* Desktop */
    }
    .about-float-layout {
  overflow: hidden; /* clears floats */
  margin-bottom: 48px;
}
  }
/* ===============================
   FLOAT LAYOUT CORE
   =============================== */



/* Base image */
.about-float-image {
  width: 50%;
  height: auto;
  display: block;
  margin-bottom: 16px;
}

/* Left image */
.float-left {
  float: left;
  margin-right: 23px;
}

/* Right image */
.float-right {
  float: right;
  margin-left: 23px;
}

/* ===============================
   TYPOGRAPHY
   =============================== */

.about-section-two__title {
  font-family: 'Crimson Pro', serif;
  font-style: italic;
  font-weight: 300;
  font-size: 40px;
  line-height: 1.1;
  margin-bottom: 1rem;
}

/* ===============================
   MOBILE
   =============================== */

@media (max-width: 991.98px) {
  .about-float-image {
    float: none;
    width: 100%;
    margin: 0 0 16px 0;
  }

  .about-section-two__title {
    font-size: 32px;
  }
}
</style>
