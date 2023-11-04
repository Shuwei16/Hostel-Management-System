<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    /* Footer CSS */
    footer {
        font-family: verdana, sans-serif;
        background-color: #293952;
        color: white;
        padding: 20px;
    }

    .footer-content {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* Create three equal-width columns */
        gap: 50px; /* Adjust the gap between columns */
    }

    .column {
        text-align: left; /* Align content within each column */
    }

    .footer-content h1 {
        font-size: 14px;
    }

    .footer-content p {
        font-size: 12px;
    }

    .footer-content a {
        color: white;
        text-decoration: none;
    }

    .footer-content iframe {
        width: 100%;
        height: 250px;
    }

    .social-media i {
        font-size: 20px;
        margin-top: 30px;
        margin-right: 10px;
    }

    @media only screen and (max-width: 600px) {
        .footer-content {
            grid-template-columns: repeat(1, 1fr);
        }
    }
</style>
<footer>
    <div class="footer-content">
        <div class="column">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7967.068511166933!2d101.72554052414016!3d3.216165690633493!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc384254b7d247%3A0xeef48f624b2fd920!2sTAR%20UMT%20Hostel!5e0!3m2!1sen!2smy!4v1687251636848!5m2!1sen!2smy" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="column">
            <h1>TAR UMT Hostel</h1>
            <p>
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                Lot 2890, Jalan Malinja, 53000 Setapak, Kuala Lumpur
            </p>
            <p>
                <i class="fa fa-phone" aria-hidden="true"></i>
                <a href="tel:+60341058952">03-4105 8952</a>
            </p>
            <p>
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <a href="mailto:admin@aktar.com.my">admin@aktar.com.my</a>
            </p>
            <p class="social-media">
                <a href="https://www.facebook.com/TarucHostelSociety"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                <a href="https://www.instagram.com/tarumthostelsociety"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                <a href="https://wa.me/+60173955363"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
            </p>
        </div>
        <div class="column">
            <h1>TAR UMT Official Website</h1>
            <p>
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <a href="https://www.tarc.edu.my">www.tarc.edu.my</a>
            </p>
        </div>
    </div>
</footer>
