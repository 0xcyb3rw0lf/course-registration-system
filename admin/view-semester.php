<?php

/**
 * View Semester Page
 * Allows the admin to select
 * and view semester's information
 * inside the system
 *  
 * @author Omar Eldanasoury 
 */

session_start();

if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

// only admin are allowed to view this page, if non-admin users tried to view the page, we prevent them using this code
if ($_SESSION["userType"] != "admin")
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");

require_once("../functions2.php");
if (isset($_POST["view-semester"])) {
    // first get data
    $semId = checkInput($_POST["sem-name"]);
    $_SESSION["semester"] = $semId;

    if ($semId == "") { // if the user didn't choose a value for the course or the section
        $feedbackMsg = "<span class='failed-feedback'>Please select a semester!</span>";
    } else { // display the form to enter new section details
        // shows the form for the user to enter new information for the section
        $displayForm = true;
        $semesterData = getSemesterData($_SESSION["semester"]); // passing the id of the section user selected
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Section</title>

    <!-- Adding the css files -->
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css" />

    <!-- Adding the Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

        label {
            display: inline;
        }
    </style>

    <!-- Adding FontAwesome Kit -->
    <script src="https://kit.fontawesome.com/163915b421.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php require("../header.php");

    // Required varialbes for adding the section
    require_once("../functions2.php");
    // Required varialbes for updating the semester status
    $semesters = getSemesters(); // get the semesters list from the database

    ?>


    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">View Semester</h1>
        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- Course Code and Section Number -->
                <div class="attendance-inner-flex">
                    <label for="sem-name">Semester Name:</label><br><br>
                    <select class="selecter" name="sem-name" id="sem-name">
                        <option value="">Select a Semester</option>
                        <?php
                        if ($semesters != array())
                            for ($i = 0; $i < count($semesters); $i++)
                                foreach ($semesters[$i] as $id => $name) {
                                    echo "<option value='" . strval($id) . "'>" . $name . "</option>";
                                }
                        ?>
                    </select>
                </div>
            </div>

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="view-semester" id="view-semester" value="View Semester Details!">
            <br><br>
            <?php
            if (isset($feedbackMsg)) {
                echo $feedbackMsg;
                unset($feedbackMsg);
            }

            if (isset($displayForm)) {
            ?>
        </form>
        <!-- The Table of students list -->
        <div class="attendance-flex catalogue-main" style="margin-left: 3.25em; margin-top: 1.5em;">
            <!-- Adding Semester Name -->
            <div class="attendance-inner-flex">
                <label>Semester Name:</label><br><br>
                <p style="color: black;"><?php echo ($semesterData["sem_name"] == "" ? "Not Set Yet" : $semesterData["sem_name"]); ?></p>
                <br><br>

            </div>

            <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                <label>Semester Status:</label><br><br>
                <p style="color: black;"></p><?php echo ($semesterData["sem_status"] == "2" ? "Finished" : ($semesterData["sem_status"] == "1" ? "In Progress" : "Not Started Yet!")); ?></p>
            </div>

            <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                <label>Start of Appeal Requests Date:</label><br><br>
                <p style="color: black;"><?php echo ($semesterData["appeal_start"] == "" ? "Not Set Yet" : $semesterData["appeal_start"]); ?></p>
            </div>

            <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                <label>End of Appeal Requests Date:</label><br><br>
                <p style="color: black;"></p><?php echo ($semesterData["appeal_end"] == "" ? "Not Set Yet" : $semesterData["appeal_end"]); ?></p>
            </div>
        </div>
    <?php
            }
    ?>
    </form>
    </div>
    </main>

    <?php require("../footer.php") ?>
</body>

</html>