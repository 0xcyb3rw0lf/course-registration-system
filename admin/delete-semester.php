<?php

/**
 * Delete Semester Page
 * Allows the admin user to 
 * Delete Semesters from the system
 * 
 * @author Elyas Raed
 * @author Omar Eldanasoury
 */
session_start();
if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

// only admin should access the page
if (!str_contains($_SESSION["userType"], "admin"))
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");

if (isset($_POST["delete-semester"])) {
    require_once("../functions2.php");
    // first get data
    $semesters = checkInput($_POST["sem-name"]);

    // then validate user input
    if ($semesters == "") { // if the user didn't choose a value for the semester name
        $feedbackMsg = "<span class='failed-feedback'>Please select a semester!</span>";
    } else {
        // then delete the semester
        if (deleteSemester($semesters)) {
            $feedbackMsg = "<span class='success-feedback'>Semester is deleted successfully!</span>";
        } else {
            $feedbackMsg = "<span class='failed-feedback'>Error deleting semester<br>Please try again later!</span>";
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
    <title>Delete Semester</title>

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
    // Required varialbes for deleting the semester
    $semesters = getSemesters();
    ?>

    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Delete Semester</h1>
        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- Room Numbers -->
                <div class="attendance-inner-flex">
                    <label for="sem-name">Semester Name:</label><br><br>
                    <select class="selecter" name="sem-name" id="sem-name">
                        <option value="">Select a Semester</option>
                        <?php
                        if ($semesters != array())
                            for ($i = 0; $i < count($semesters); $i++)
                                foreach ($semesters[$i] as $id => $code) {
                                    echo "<option value='" . strval($id) . "'>" . $code . "</option>";
                                }
                        ?>
                    </select>
                </div>

            </div>

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" onclick="return confirm('Are you sure you want to delete this semester?')" name="delete-semester" id="delete-semester" value="Delete Semester">
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