<?php

/**
 * Add College Page
 * Allows the admin user to 
 * add colleges to the system
 * 
 * @author Elyas Raed
 * @author Omar Eldansoury
 */
session_start();
if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

// only admin should access the page
if (!str_contains($_SESSION["userType"], "admin"))
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");


if (isset($_POST["add-college"])) {
    require_once("../functions2.php");

    // Adding the room
    $collegeName = $_POST["college-name"];

    // Validate/ check for empty values
    if (
        empty($collegeName)
    ) {
        $feedbackMsg = "<span class='failed-feedback'>Please enter all fields as required!</span>";
    } else {
        try {
            if (addCollege($collegeName)) {
                $feedbackMsg = "<span class='success-feedback'>College is Added Successfully!</span>";
            } else {
                $feedbackMsg = "<span class='failed-feedback'>Error Adding College!</span>";
            }
        } catch (Exception $exception) { // send error if college already exists
            $feedbackMsg = "<span class='failed-feedback'>College Already Exists, Please Choose a New College Name!</span>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add College</title>

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

    <?php require("../header.php");
    require_once("../functions2.php");
    // Required varialbes for adding the college
    $buildings = getBuildings();
    ?>

    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Add College</h1>

        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- Add College Name -->
                <div class="attendance-inner-flex">
                    <label for="college-name">College Name:</label><br><br>
                    <input type="text" class="selecter" name="college-name" id="college-name">
                    </select>
                    <br><br>
                </div>

            </div>

            <input onclick="return confirm('Are you sure you want to add a college?')" type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="add-college" id="add-college" value="Add a College">
            <br><br>
            <?php
            if (isset($feedbackMsg)) {
                echo $feedbackMsg;
                unset($feedbackMsg);
            }
            ?>

        </form>
    </main>

    <?php require("../footer.php") ?>
</body>

</html>