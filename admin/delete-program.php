<?php

/**
 * Delete Program Page
 * Allows the admin user to 
 * Delete Programs from the system
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

if (isset($_POST["delete-program"])) {
    require_once("../functions2.php");
    // first get data
    $programName = checkInput($_POST["program-name"]);

    // then validate user input
    if ($programName == "") { // if the user didn't choose a value for the program name
        $feedbackMsg = "<span class='failed-feedback'>Please select a program!</span>";
    } else {
        // then delete the program
        if (deleteProgram($programName)) {
            $feedbackMsg = "<span class='success-feedback'>Program is deleted successfully!</span>";
        } else {
            $feedbackMsg = "<span class='failed-feedback'>Error deleting program<br>Please try again later!</span>";
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
    <title>Delete Program</title>

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
    // Required varialbes for deleting the program
    // $programName = getProgramName(); // get the programs list from the database
    $collegeName = getCollegeName(); // get the colleges list from the database
    ?>

    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Delete Program</h1>
        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <div class="attendance-inner-flex">
                    <label for="college-id">College Name:</label><br><br>
                    <select class="selecter" onchange="getPrograms(this.value)" name="college-name" id="college-name">
                        <option value="">Select a College</option>
                        <?php
                        if ($collegeName != array())
                            for ($i = 0; $i < count($collegeName); $i++)
                                foreach ($collegeName[$i] as $id => $name) {
                                    echo "<option value='" . strval($id) . "'>" . $name . "</option>";
                                }
                        ?>
                    </select>
                    <br><br>
                </div>
                <!-- Program Names -->
                <div class="attendance-inner-flex">
                    <label for="program-name">Program Name:</label><br><br>
                    <select class="selecter" name="program-name" id="program-name">
                        <option value="">Select a College</option>
                        <!-- Will Be filled by AJAX -->
                    </select>
                </div>

            </div>

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" onclick="return confirm('Are you sure you want to delete this program?')" name="delete-program" id="delete-program" value="Delete Program">
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
<!-- Script for getting the programs after the user selects the college :: Using AJAX
     Author: Omar Eldanasoury
 -->
<script>
    /**@@function getPrograms()
     * sends user choice to the script to get
     * programs of the college
     * 
     * @author Omar Eldanasoury
     */
    function getPrograms(collegeId) {
        if (collegeId.length == 0) {
            clearPrograms();
            return;
        }

        const request = new XMLHttpRequest();
        request.onload = showPrograms;
        request.open("GET", "getPrograms.php?id=" + collegeId);
        request.send();
    }

    /**@function showPrograms
     * populated the options inside <select>
     * after getting the programs
     * 
     * @author Omar Eldanasoury
     */
    function showPrograms() {
        clearPrograms();

        if (this.responseText == "") {
            document.getElementById("program-name").innerHTML = "<option value=''>College Has No Programs</option>";
            return;
        }
        results = this.responseText.split("#");
        for (let result of results) {
            idAndProgramName = result.split("@");
            if (idAndProgramName[0] == '')
                continue;
            document.getElementById("program-name").innerHTML += "\n<option value='" + idAndProgramName[0] + "'>" + idAndProgramName[1] + "</option>";
        }
    }

    /**@function clearPrograms
     * Clears the options to
     * populate new options when
     * user's choice changes.
     * 
     * @author Omar Eldanasoury
     */
    function clearPrograms() {
        document.getElementById("program-name").innerHTML = "<option value=''>Select a Program</option>"
    }
</script>

</html>