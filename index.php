<?php

/**
 * OMAR AHMED REFAAT ELDANASOURY, 202005808
 * ITCS333-SEC 03 , COURSE PROJECT, ALONE
 */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>

    <!-- Adding the css files -->
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css" />

    <!-- Adding the Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>

    <!-- Adding FontAwesome Kit -->
    <script src="https://kit.fontawesome.com/163915b421.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php require("header.php"); ?>

    <main>
        <h1>Welcome to Our Website</h1>
        <p class="light-font300">Get the chance to have <span class="italic light-font300">amazing times with friends
                and family</span> during
            our trips!
        </p>
        <a href="#" class="butn primary-butn">Explore Catalogue</a>
        <!-- <img src="images/bab-bahrain.jpg" alt="Bab-Bahrain"> -->
    </main>

    <section class="section">
        <div class="icons-sec1">
            <i class="fa-solid fa-face-smile"></i>
            <h2>Enjoy Your Time</h2>
            <p class="light-font300">Whether you are alone or with family and friends</p>
        </div>
        <div class="icons-sec2">
            <i class="fa-regular fa-map"></i>
            <h2>Expand Your Horizons</h2>
            <p class="light-font300">Explore Wonderful Places in the Kingdom of Bahrain</p>
        </div>
        <div class="icons-sec3">
            <i class="fa-solid fa-user-group"></i>
            <h2>Expand your network</h2>
            <p class="light-font300">Group trips to meet new people and have a nice time together</p>
        </div>
    </section>

    <section class="section feedback">
        <div class="icons-sec1">
            <img class="reviewer" src="/333Project/images/Mohamed2.jpg" alt="Mohamed">
            <h2 class="name">Mohamed</h2>
            <p class="light-font300 italic">"I have enjoyed the most wonderful trips in my life with BBay trips!"</p>
        </div>
        <div class="icons-sec3">
            <img class="reviewer" src="/333Project/images/Sarah.jpg" alt="Mohamed">
            <h2 class="name">Sarah</h2>
            <p class="light-font300 italic">"These trips were the best trips ever with my family!"</p>
        </div>
        <div class="icons-sec2">
            <img class="reviewer" src="/333Project/images/James2.jpg" alt="Mohamed">
            <h2 class="name">James</h2>
            <p class="light-font300 italic">"Always remember the amazing moments with my friends and family, thanks to
                BBay!"
            </p>
        </div>
    </section>
    <footer>
        <a href="catalogue.php">Browse Catalogue</a>
        <br>
        <a href="#" class="social">
            <i class="fa-brands fa-facebook"></i>
        </a>
        <a href="#" class="social">
            <i class="fa-brands fa-twitter"></i>
        </a>
        <a href="#" class="social">
            <i class="fa-brands fa-instagram"></i>
        </a>
        <p>Copyrights &copy; Omar Ahmed Eldanasoury, 202005808</p>
    </footer>
</body>

</html>