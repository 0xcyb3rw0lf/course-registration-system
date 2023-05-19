<?php

/**
 * View Course Prerequisites Page
 * Allows the professor user to 
 * add/delete/update students' grades to the system
 * 
 * @author Omar Eldanasoury 
 */

session_start();

if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

require_once("../functions.php");
if (isset($_POST["get-prereqs"])) {

    // TODO: after user confirms (using JS)
    // first get data
    $cid = checkInput($_POST["course-code"]);

    if ($cid == "") { // if the user didn't choose a value for the course or the section
        $feedbackMsg = "<span class='failed-feedback'>Please select a course!</span>";
    } else {
        $prerequisites = getPrerequisites($cid);
        $tableBody = "";

        // generating the table body based on the data
        if (empty($prerequisites)) {
            $tableBody = "<tr><td colspan='3'>The Selected Course Has No Prerequisites!</td></tr>";
        } else {
            foreach ($prerequisites as $course) {
                $tableBody .= "\n<tr>\n<td>" . $course[0] . "</td>\n<td>" . $course[1] . "</td>\n<td>" . $course[2] . "</td>\n</tr>";
            }
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
    <title>View Course Prerequisites</title>

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
    // retrieves the courses that are in the program of the student
    $courses = getProgramCourses(getStudentProgramId($_SESSION["activeUser"][0]));
    ?>


    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">View Course Prerequisites</h1>
        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- Course Code and Section Number -->
                <div class="attendance-inner-flex">
                    <label for="course-code">Course Code:</label><br><br>
                    <select class="selecter" onchange="getSections(this.value)" name="course-code" id="course-code">
                        <option value="">Select a Course</option>
                        <?php
                        if ($courses != array())
                            for ($i = 0; $i < count($courses); $i++)
                                foreach ($courses[$i] as $id => $code) {
                                    echo "<option value='" . strval($id) . "'>" . $code . "</option>";
                                }
                        ?>
                    </select>
                </div>

            </div>

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="get-prereqs" id="get-prereqs" value="View Course Prerequisites">
            <br><br>
            <?php
            if (isset($feedbackMsg)) {
                echo $feedbackMsg;
                unset($feedbackMsg);
            }
            ?>
        </form>
        <!-- The Table of students list -->
        <div class="catalogue-main" style="margin-bottom: 2em;">
            <form method="post" class="form" style="margin-left: 2.75em;  text-align: center;">
                <table id="displayTable" <?php if (isset($tableBody)) echo "style='visibility: visible; margin: 0;'";
                                            else echo "style='visibility: hidden;'" ?>>
                    <thead>
                        <tr>
                            <th class="th-color">Course Code</th>
                            <th class="th-color">Course Name</th>
                            <th class="th-color">Credits</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--  Here we add the dynamic content from the database -->
                        <?php
                        if (isset($tableBody))
                            echo $tableBody;
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </main>

    <?php require("../footer.php") ?>
</body>

</html>