<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
</head>
<body>
    <section id="footer" class="d-flex space">
        <div class="footer-nav">
            <ul class="footer-list">
                <li class="footer-item">
                    <a href="/" class="footer-link">
                        <img src="assets/home.png" class="icons" alt="icons">Home
                    </a>
                </li>
                <!-- <li class="footer-item">
                    <a href="/auth" class="footer-link">Details</a>
                </li> -->
                <li class="footer-item">
                    <a href="index.php?page=events" class="footer-link">
                        <img src="assets/calendar.png" class="icons" alt="icons">Events
                    </a>
                </li>
                <li class="footer-item">
                    <a href="index.php?page=map" class="footer-link">
                        <img src="assets/location.png" class="icons" alt="icons">Map
                    </a>
                </li>
                <li class="footer-item">
                    <a href="index.php?page=rsvp" class="footer-link">
                        <img src="assets/rsvp.png" class="icons" alt="icons">RSVP
                    </a>
                </li>
                <li class="footer-item">
                <?php
                if (isset($_SESSION['login']) === true && $_SESSION['login']) {
                    if ($_SESSION['type'] = 1) {
                    ?>
                <?php
                } 
                }else {
                    ?>
                    <a href="index.php?page=login" class="footer-link">
                        <img src="assets/user.png" class="icons" alt="icons">Admin
                    </a>
                    <?php
                    }
                ?>
                </li>
            </ul>
        </div>
        <div class="footer-container">
            <a href="https://zenjakucreations.vercel.app/" target="_blank">
                <div class="footer-logo">
                    <h3>Zenjaku Creations</h3>
                </div>
            </a>
            <p>All rights reserved.</p>
        </div>
    </section>
    <section id="email-footer" class="p-1">
        <p>zenjakucreations@gmail.com</p>
    </section>
    
</body>
</html>