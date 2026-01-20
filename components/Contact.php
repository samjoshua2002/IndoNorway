<div class="container section-padding">
    <p class="header-dark text-center mb-4">Contact Us</p>

    <div class="activity-section">
        <div class="contact-grid">
            <!-- India -->
            <div class="gradient-border">
                <div class="bg-white h-100">
                    <div class="p-content pb-0">
                        <p class="title-dark mb-2">India</p>
                    </div>

                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2311.622979783668!2d80.22889704036533!3d12.992885286756891!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a52677f103957db%3A0x4a32b8c8b504a9b9!2sNew%20Academic%20Complex%201!5e0!3m2!1sen!2sin!4v1768632937707!5m2!1sen!2sin"
                        width="100%" height="250" style="border:0;" loading="lazy">
                    </iframe>

                    <div class="p-content pt-0">

                        <div class="content-section">
                            <img src="assets/icons/location.svg">
                            <p class="description-dark text-justify">
                                Room No. 452 <br>
                                New Academic Complex (NAC-1) <br>
                                Department of Chemical Engineering <br>
                                IIT Madras <br>
                                Chennai – 600036 <br>
                                India
                            </p>
                        </div>

                        <div class="content-section">
                            <img src="assets/icons/phone.svg">
                            <p class="description-dark">+91 44 2257 4157</p>
                        </div>

                        <div class="content-section">
                            <img src="assets/icons/mail.svg">
                            <p class="description-dark">innovision.enquiry@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Norway -->
            <div class="gradient-border">
                <div class="bg-white h-100">
                    <div class="p-content pb-0">
                        <p class="title-dark mb-2">Norway</p>
                    </div>

                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5049.524329754193!2d10.396669410461177!3d63.419286370376966!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x466d31bfd8c0937f%3A0xb4fde91ca281978b!2sNTNU!5e0!3m2!1sen!2sin!4v1768633077439!5m2!1sen!2sin"
                        width="100%" height="250" style="border:0;" loading="lazy">
                    </iframe>

                    <div class="p-content pt-0">

                        <div class="content-section">
                            <img src="assets/icons/location.svg">
                            <p class="description-dark text-justify">
                                Room No K4-305 <br>
                                Department of Chemical Engineering <br>
                                NTNU <br>
                                Trondheim <br>
                                Norway
                            </p>
                        </div>

                        <div class="content-section">
                            <img src="assets/icons/phone.svg">
                            <p class="description-dark">4773550339</p>
                        </div>

                        <div class="content-section">
                            <img src="assets/icons/mail.svg">
                            <p class="description-dark">innovision.enquiry@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    /* Desktop layout using GRID */
    .contact-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 72px;
    }

    /* Stack on mobile */
    @media (max-width: 991px) {
        .contact-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
    }

    /* Gradient border */
    .gradient-border {
        border: 1px solid;
        border-image: linear-gradient(90deg, #2DB9DD, #008CFF) 1;
        border-radius: 10px;
    }

    /* Padding except map */
    .p-content {
        padding: 2rem;
    }

    .content-section {
        margin-top: 1rem;
    }

    /* Typography */
    .header-dark {
        font-family: 'Crimson Pro';
        font-size: 36px; /* Mobile */
        font-weight: 400;
        text-align: center;
        line-height: 1.2;
    }

    @media (min-width: 768px) {
        .header-dark {
            font-size: 48px; /* Tablet */
        }
    }

    @media (min-width: 992px) {
        .header-dark {
            font-size: 64px; /* Desktop */
        }
    }

    .title-dark {
        font-size: 24px; /* Mobile */
        font-weight: 600;
        margin-bottom: 0;
    }

    @media (min-width: 768px) {
        .title-dark {
            font-size: 28px; /* Tablet */
        }
    }

    @media (min-width: 992px) {
        .title-dark {
            font-size: 32px; /* Desktop */
        }
    }

    .section-padding {
        padding-top: 1rem;
    }

    @media (min-width: 992px) {
        .section-padding {
            padding-top: 1rem;
        }
    }

    .text-justify {
        text-align: justify;
    }
</style>