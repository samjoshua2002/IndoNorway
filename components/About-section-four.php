<style>
    /* Section spacing */
.section-padding {
  padding-top: 1.5rem;
}

@media (min-width: 992px) {
  .section-padding {
    padding-top: 1rem;
  }
}

/* Buttons wrapper */
.get-involved-buttons {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 24px;
  flex-wrap: wrap; /* allows wrap if needed */
}

/* Button styling */
.buttons-bt-24-pt-sans-dark {
  background: linear-gradient(90deg, #004B62 0%, #002F72 100%);
  border-radius: 8px;
  padding: 10px 32px;
  border: none;
  cursor: pointer;
  display: inline-block;
  text-decoration: none;

  color: #ffffff;
  font-family: 'Figtree', sans-serif;
  font-size: 24px;
  font-weight: 700;
  white-space: nowrap;

  box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.25);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.buttons-bt-24-pt-sans-dark:hover {
  transform: translateY(-2px);
  box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
  color: #ffffff;
}

/* Mobile */
@media (max-width: 767px) {
  .get-involved-buttons {
    flex-direction: column;
    gap: 16px;
  }

  .buttons-bt-24-pt-sans-dark {
    width: 100%;
    max-width: 280px;
    font-size: 20px;
    padding: 14px 24px;
    text-align: center;
  }
}

</style>
<div class="container section-padding mb-3">
  <p class="title-dark text-center mb-4">Get Involved</p>

  <div class="get-involved-buttons">
    <a href="Projects.php" class="buttons-bt-24-pt-sans-dark">Projects</a>
    <a href="People.php" class="buttons-bt-24-pt-sans-dark">People</a>
    <a href="Contact.php" class="buttons-bt-24-pt-sans-dark">Contact</a>
  </div>
</div>
