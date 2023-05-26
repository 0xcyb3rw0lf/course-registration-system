<?php

/**
 * Delete Room Page
 * Allows the admin user to 
 * Delete Rooms from the system
 * 
 * @author Omar Eldanasoury
 * @author Elyas Raed
 */
session_start();
if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");


// only admin should access the page
if (!str_contains($_SESSION["userType"], "admin"))
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");


if (isset($_POST["delete-room"])) {
    require_once("../functions2.php");
    // first get data
    $rooms = checkInput($_POST["room-number"]);

    // then validate user input
    if ($rooms == "") { // if the user didn't choose a value for the room number
        $feedbackMsg = "<span class='failed-feedback'>Please select a room!</span>";
    } else {
        // then delete the room
        if (deleteRoom($rooms)) {
            $feedbackMsg = "<span class='success-feedback'>Room is deleted successfully!</span>";
        } else {
            $feedbackMsg = "<span class='failed-feedback'>Error deleting room<br>Please try again later!</span>";
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
    <title>Delete Room</title>

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
    // Required varialbes for deleting the room
    $buildings = getBuildings(); // get the rooms list from the database

    ?>

    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Delete Room</h1>
        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <div class="attendance-inner-flex">
                    <label for="bldng">Building:</label><br><br>
                    <select onchange="getRooms(this.value)" class="selecter" name="bldng" id="bldng">
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
                <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                    <label for="room">Room:</label><br><br>
                    <select class="selecter" name="room-number" id="room">
                        <option value="">Select a Room</option>
                        <!-- The options will be optained from the database using AJAX and PHP -->
                        <!-- Refer to the script at the end of the page, after <body> -->
                    </select>
                </div>

            </div>

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" onclick="return confirm('Are you sure you want to delete this room?')" name="delete-room" id="delete-room" value="Delete Room">
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
<!-- Script for getting the rooms after the user selects the buildings :: Using AJAX
     Author: Omar Eldanasoury
 -->
<script>
    /**@@function getRooms()
     * sends user choice to the script to get
     * rooms of the building
     * 
     * @author Omar Eldanasoury
     */
    function getRooms(buildingId) {
        if (buildingId.length == 0) {
            clearRooms();
            return;
        }

        const request = new XMLHttpRequest();
        request.onload = showRooms;
        request.open("GET", "getRooms.php?id=" + buildingId);
        request.send();
    }

    /**@function showRooms
     * populated the options inside <select>
     * after getting the rooms
     * 
     * @author Omar Eldanasoury
     */
    function showRooms() {
        clearRooms();
        results = this.responseText.split("#");
        for (let result of results) {
            idAndRoom = result.split("@");
            if (idAndRoom[0] == '')
                continue;
            document.getElementById("room").innerHTML += "\n<option value='" + idAndRoom[0] + "'>" + idAndRoom[1] + "</option>";
        }
    }

    /**@function clearRooms
     * Clears the options to
     * populate new options when
     * user's choice changes.
     * 
     * @author Omar Eldanasoury
     */
    function clearRooms() {
        document.getElementById("room").innerHTML = "<option value=''>Select a Room</option>"
    }
</script>

</html>