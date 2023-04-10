<?php
// session_start();
// if (!isset($_SESSION["activeUser"]))
//     header("location: index.php");


// try {
//     require("connection.php");
//     $rows = $db->query("SELECT * FROM TRIPS");
//     $db = null;
// } catch (PDOException $ex) {
//     echo "Error: " . $ex->getMessage();
// }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Adding the css files -->
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

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

    <?php require("header.php") ?>


    <main class="" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Welcome <?php if (isset($_SESSION["activeUser"])) echo $_SESSION["activeUser"][1] ?></h1>
        <?php
        if (isset($_GET["reserved"]) and $_GET["reserved"] == "true")
            echo '<h1 class="catalogue-header" style="color: green;"Your trip has been reserved!</h1>';


        if (isset($_GET["reset-password"]) and $_GET["reset-password"] == "true")
            echo '<h1 class="catalogue-header" style="color: green;"Passward is reset successfully!</h1>';

        ?>
        <h1 class="catalogue-header" style="color: #F13C20; font-size: 2em; margin-bottom: 0;">Check these out!</h1>

        <div class="catalogue-main">
            <?php
            while ($row = $rows->fetch()) { // we need the title, from, to , and the price
                $id = $row[0];
                $title = $row[1];
                $from = $row[2];
                $to = $row[3];
                $price = $row[4];
                $imagePath = $row[6];
                // $count = $rows->rowCount();
            ?>

                <div class="trip-container">
                    <img class="trip-image" <?php echo "src=\"/333Project/" . $imagePath . "\"" ?> alt="">
                    <div class="trip-info">
                        <p class="info" style="color: #4056A1;"><?php echo $title ?></p>
                        <p class="info">From: <?php echo $from ?></p>
                        <p class="info">To: <?php echo $to ?></p>
                        <p class="info" style="color: #F13C20;"> <?php echo $price . " BHD" ?></p>
                        <a <?php echo "href='trip.php?tid=$id'" ?> class="butn primary-butn" style="text-align: center;margin-right: 1.5em;">Show More!</a>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </main>



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

    <!-- Bootstrap via web -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>