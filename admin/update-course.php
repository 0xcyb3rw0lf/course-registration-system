<?php

/**
 * Update Course Page
 * allows admin to update
 * course information from the system.
 * 
 * @author Mohammed Alammal
 */
session_start();

if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

require_once("../functions.php");
if (isset($_POST["view-course"])) {

    $cid = checkInput($_POST["course-code"]);


    if ($cid == "") {
        $feedbackMsg = "<span class='failed-feedback'>Please select a course!</span>";
    } else {
        $displayForm = true;
    }
}

function updateCourse($course_code, $courseName, $credits)
{

    try {
        require("../connection.php");
        $sql = "UPDATE course SET COURSE_CODE = ?, COURSE_NAME=?,CREDITS = ? WHERE COURSE_CODE = ?;";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($course_code, $courseName, $credits, $course_code));
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        echo $e->getMessage() . "<br>";

        $db = null;
        return false;
    }

    return ($statement->rowCount() == 1);
}


if (isset($_POST["update-course"])) {
    $courseCode = $_POST["course-code"];
    $courseName = $_POST["courseName"];
    $credits = $_POST["credits"];
    $courseCodeValidation = "/^[A-Za-z]+.*[0-9]+$/";
    $creditsValidation = "/\d+/";
    $courseNameValidation = "/^[a-zA-Z ]*$/";

    if (
        empty($courseCode)
        or empty($courseName)
        or empty($credits)

    ) {
        $feedbackMsg = "<span class='failed-feedback'>Please enter all fields as required!</span>";
    } else if (!preg_match($courseCodeValidation, $courseCode) or !preg_match("/\d+/", $credits) or !preg_match($courseNameValidation, $courseName)) { // if the user entered wrong value for credits number\
        $feedbackMsg = "<span class='failed-feedback'>Please enter valid data!</span>";
    } else {
        try {
            if (updateCourse($courseCode, $courseName, $credits)) {
                $feedbackMsg = "<span class='success-feedback'>Course is Updated Successfully!</span>";
            } else {
                $feedbackMsg = "<span class='failed-feedback'>Error Updating Course!</span>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

if (isset($_POST["view-course"])) {
    try {
        require('../connection.php');
        $code = $_POST["course-code"];
        $r = $db->query("SELECT * FROM course WHERE course_code = '$code'");

        while ($row = $r->fetch()) {
            $cName = $row['course_name'];
            $cred = $row['credits'];
        }
    } catch (PDOException $i) {
        echo "Error occurred";
        die($i->getMessage());
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course</title>

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

    $courses = getCourses();

    ?>


    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Update Course</h1>
        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- Course Code -->
                <div class="attendance-inner-flex">
                    <label for="course-code">Course Code:</label><br><br>
                    <select class="selecter" name="course-code" id="course-code">
                        <option value="">Select a Course</option>
                        <?php
                        if ($courses != array())
                            for ($i = 0; $i < count($courses); $i++)
                                foreach ($courses[$i] as $id => $code) {
                                    echo "<option value='" . $code . "'>" . $code . "</option>";
                                }
                        ?>
                    </select>
                </div>


            </div>

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="view-course" id="view-course" value="View Course To Update">
            <br><br>
            <?php
            if (isset($feedbackMsg)) {
                echo $feedbackMsg;
                unset($feedbackMsg);
            }
            ?>
        </form>


        <div class="catalogue-main" style="margin-bottom: 2em; text-align: left;">
            <form method="post" class="form" style="margin-left: 2.75em;  text-align: center;">
                <?php
                if (isset($displayForm) and $displayForm) {

                    $courses = getCourses(); // get the courses list from the database
                    $professorNames = getProfessorNames();
                    $buildings = getBuildings();
                    $rooms = getRooms();
                ?>

                    <div class="attendance-flex catalogue-main">
                        <!-- Course Code-->
                        <div class="attendance-inner-flex">
                            <label for="course-code">Course Code:</label><br><br>
                            <input type="text" class="selecter" name="course-code" id="course-code" placeholder="Course Code" value="<?php if (isset($_POST["course-code"])) {
                                                                                                                                            echo $_POST["course-code"];
                                                                                                                                        } ?>">

                        </div>


                        <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                            <!-- Course Name -->
                            <label for="courseName">Course Name:</label><br><br>
                            <input type="text" name="courseName" placeholder="Course Name" value="<?php echo $cName ?>">

                        </div>

                        <!-- Credits -->
                        <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                            <label for="capacity">Credits:</label><br><br>
                            <input type="number" min="1" max="5" class="selecter" name="credits" id="credits" placeholder="1-5" value="<?php echo $cred ?>">
                        </div>
                    </div>

                    <input onclick="return confirm('Do you want to update the information for this course?')" type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="update-course" id="update-course" value="Update Course">
                <?php
                }
                ?>
            </form>
        </div>
    </main>

    <?php require("../footer.php") ?>
</body>


</html>