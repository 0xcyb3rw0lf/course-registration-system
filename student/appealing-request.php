<?php

/**
 * Add Appealing Requests Page
 * Allow students to add appealing
 * requests to the system
 * TODO: add the validation for the date
 * 
 * @author Omar Eldanasoury 
 */

session_start();
if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

// only students are allowed to view this page, if non-student users tried to view the page, we prevent them using this code
if ($_SESSION["userType"] != "student")
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");


if (isset($_POST["add-appeal-request"])) {
    require_once("../functions.php");
    // first get data
    $cid = checkInput($_POST["course-code"]);
    // then validate user input
    if ($cid == "") { // if the user didn't choose a value for the course or the section
        $feedbackMsg = "<span class='failed-feedback'>Please select a course!</span>";
    } else if (isInAppealPeriod() and $cid != "out" and $cid != "full") {
        // then add the request
        if (addAppealRequest($_SESSION["activeUser"][0], $cid)) {
            $feedbackMsg = "<span class='success-feedback'>Appeal Request is Added Successfully!</span>";
        } else {
            $feedbackMsg = "<span class='failed-feedback'>Error Adding Appeal Request<br>Please try again later!</span>";
        }
    } else if ($cid == "full") { // is student has appeal for all his courses
        $feedbackMsg = "<span class='failed-feedback'>You Have Appealed For All Registered Courses!</span>";
    } else { // if the student is out of appeal period
        $feedbackMsg = "<span class='failed-feedback'>Out Of Appeal Period!</span>";
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Appealing Requests</title>

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
    // Required varialbes for adding the section
    if (isInAppealPeriod())
        $courses = getEligibleCourses($_SESSION["activeUser"][0]); // get the courses list from the database
    ?>


    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Add Appeal Request</h1>
        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- Course Code and Section Number -->
                <div class="attendance-inner-flex">
                    <label for="course-code">Course Code:</label><br><br>
                    <select class="selecter" name="course-code" id="course-code">
                        <option value="">Select a Course</option>
                        <?php
                        if ($courses != array() and isInAppealPeriod())
                            for ($i = 0; $i < count($courses); $i++)
                                foreach ($courses[$i] as $id => $code) {
                                    echo "<option value='" . strval($id) . "'>" . $code . "</option>";
                                }
                        else if (isInAppealPeriod()) { // but he has no courses to apply for, meaning that he had
                            // applied appealing requests for all his courses
                            // so he has no elligible courses left to add appealing request on
                            echo "<option value='full'>You Have Appealed For All Registered Courses!</option>";
                        } else {
                            echo "<option value='out'>Out Of Appeal Period!</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" onclick="return confirm('Are you sure you want to add appeal request for this course?')" name="add-appeal-request" id="add-appeal-request" value="Add Appeal Request">
            <?php
            if (isset($feedbackMsg)) { // shows the feedback message to the user
                echo $feedbackMsg;
                unset($feedbackMsg);
            }
            ?>
        </form>

    </main>

    <?php require("../footer.php") ?>
</body>

</html>