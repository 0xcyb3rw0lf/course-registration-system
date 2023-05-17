<?php

/**
 * Help page
 * Assising Users and showing
 * information for their common
 * inquiries
 * 
 * @author Omar Eldanasoury 
 */
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Help!</title>

    <!-- Adding the css files -->
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css" />

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

    <?php require("header.php");
    ?>


    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Get Help!</h1>
        <div class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main" style="font-style: normal;">
                <h2>Forgot Your Passowrd?</h2>

                <p style="color: black;">You can contact the administrator to ask for password reset.</p>
            </div>

            <br>

            <div class="attendance-flex catalogue-main" style="font-style: normal;">
                <h2>Contact Us</h2>

                <p style="color: black;">You can contact the administrator at <a href="mailto: admin1@uob.edu.bh" style="color: black;">admin1@uob.edu.bh</a></p>
            </div>
        </div>

    </main>

    <?php require("footer.php") ?>
</body>

</html>