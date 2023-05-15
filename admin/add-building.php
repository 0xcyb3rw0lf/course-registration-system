<?php

/**
 * Add Building Page
 * Allows the admin user to 
 * add buildings to the system
 */
session_start();
if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

if (isset($_POST["add-building"])) {
    require_once("../functions.php");

    // Adding the building
    $buildingId = $_POST["building-id"];
    $buildingName = $_POST["building-name"];

    // Validate/ check for empty values
    if (
        empty($buildingId)
        or empty($buildingName)
    ) {
        $feedbackMsg = "<span class='failed-feedback'>Please enter all fields as required!</span>";
    
    } else {
        
            if (addBuilding($buildingId, $buildingName)) {
                $feedbackMsg = "<span class='success-feedback'>Building is Added Successfully!</span>";
            } else {
                $feedbackMsg = "<span class='failed-feedback'>Error Adding Building!</span>";
    }
    }}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Building</title>

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
    require_once("../functions.php");
    // Required varialbes for adding the building
    $buildings = getBuildings();
    ?>

    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Add Building</h1>

        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- Building ID and Building Name -->
                <div class="attendance-inner-flex">
                    <label for="building-id">Building ID:</label><br><br>
                    <input type="number" min="1" class="selecter" name="building-id" id="building-id">
                    </select>
                    <br><br>
                </div>
                
                <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                    <label for="building-name">Building Name:</label><br><br>
                    <input type="text" class="selecter" name="building-name" id="building-name">
                    </select>
                    <br><br>
                </div>
                
            </div>

            <input onclick="return confirm('Are you sure you want to add a building?')" type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="add-building" id="add-building" value="Add a Building">
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