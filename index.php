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
    <link rel="stylesheet" href="css/style.css">
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
        <h1 class="catalogue-header" style="color: #4056A1;">Welcome UserName<?php //if (isset($_SESSION["activeUser"])) echo $_SESSION["activeUser"][1] 
                                                                                ?></h1>
        <h2 class="catalogue-h2">Major</h2>
        <h2 class="catalogue-h2">College</h2>
        <h2 class="catalogue-h2">Current Semester</h2>
        <br><br><br><br>
        <?php
        // if (isset($_GET["reserved"]) and $_GET["reserved"] == "true")
        //     echo '<h1 class="catalogue-header" style="color: green;"Your trip has been reserved!</h1>';


        // if (isset($_GET["reset-password"]) and $_GET["reset-password"] == "true")
        //     echo '<h1 class="catalogue-header" style="color: green;"Passward is reset successfully!</h1>';

        ?>

        <!-- The Search Bar -->
        <div class="wrap">
            <div class="search">
                <input type="text" class="searchTerm" placeholder="What are you looking for?">
                <button type="submit" class="searchButton">
                    <i class="fa fa-search search-icon"></i>
                </button>
            </div>
        </div>
        <!-- End of search bar html code -->

        <div class="catalogue-main">
            <h1 class="catalogue-header" style="color: #4056A1;font-size: 2em; margin-bottom: 0.5em;">Category A</h1>

            <div class="category-container">
                <a href="professor-view-section.php" class="butn primary-butn" style="text-align: center;margin-right: 1.5em;">
                    View Section
                </a>
                <a href="professor-grades.php" class="butn primary-butn" style="text-align: center;margin-right: 1.5em;">Manage Grades</a>
                <a href="attendance.php" class="butn primary-butn" style="text-align: center;margin-right: 1.5em;">View Attendance</a>

            </div>
        </div>
        <?php
        //}
        ?>
        </div>
    </main>


    <?php
    require("footer.php");
    ?>
</body>

</html>