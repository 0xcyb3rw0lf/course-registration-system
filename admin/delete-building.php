<?php

/**
 * Delete Building Page
 * Allows the admin user to 
 * Delete Buildings from the system
 */

session_start();
if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

if (isset($_POST["delete-building"])) {
    require_once("../functions.php");
    // first get data
    $buildings = checkInput($_POST["building-name"]);

    // then validate user input
    if ($buildings == "") { // if the user didn't choose a value for the building name
        $feedbackMsg = "<span class='failed-feedback'>Please select a building!</span>";
    } else {
        // then delete the building
        if (deleteBuilding($buildings)) {
            $feedbackMsg = "<span class='success-feedback'>Building is deleted successfully!</span>";
        } else {
            $feedbackMsg = "<span class='failed-feedback'>Error deleting building<br>Please try again later!</span>";
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
    <title>Delete Building</title>

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
    // Required varialbes for deleting the building
    $buildings = getBuildings(); // get the buildings list from the database
    ?>

    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Delete Building</h1>
        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- Building Name -->
                <div class="attendance-inner-flex">
                    <label for="building-name">Building Name:</label><br><br>
                    <select class="selecter" name="building-name" id="building-name">
                        <option value="">Select a Building</option>
                        <?php
                        if ($buildings != array())
                            for ($i = 0; $i < count($buildings); $i++)
                                foreach ($buildings[$i] as $id => $name) {
                                    echo "<option value='" . strval($id) . "'>" . $name . "</option>";
                                }
                        ?>
                    </select>
                </div>

            </div>

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" onclick="return confirm('Are you sure you want to delete this building?')" name="delete-building" id="delete-building" value="Delete Building">
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