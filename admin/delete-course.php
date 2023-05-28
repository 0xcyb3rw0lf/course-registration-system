<?php

/**
 * Delete Course Page
 * allows the admin to delete a course
 * to the system
 * 
 * @author Mohamed Alammal
 */
session_start();
if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

// only admin should access the page
if (!str_contains($_SESSION["userType"], "admin"))
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");

function deleteCourse($cid)
{
    require("../connection.php");
    try {
        // establishing connection
        require("../connection.php");
        // setting and running the query
        $db->beginTransaction();
        $sql = "DELETE FROM COURSE WHERE COURSE_ID = ?";
        $statement = $db->prepare($sql);
        $statement->execute(array($cid));
        $db->commit();
    } catch (PDOException $ex) {
        $db->rollBack();
        // printing the error message if error happens
        echo $ex->getMessage();
        return false;
    }
    // closing connection with the database
    $db = null;
    return true;
}



if (isset($_POST["delete-course"])) {
    require_once("../functions.php");
    // first get data
    $cid = checkInput($_POST["course-code"]);

    // then validate user input
    if ($cid == "") { // if the user didn't choose a value for the course
        $feedbackMsg = "<span class='failed-feedback'>Please select a course!</span>";
    } else {
        // then delete the course
        if (deleteCourse($cid)) {
            $feedbackMsg = "<span class='success-feedback'>Course is deleted successfully!</span>";
        } else {
            $feedbackMsg = "<span class='failed-feedback'>Error deleting seciton<br>Please try again later!</span>";
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
    <title>Delete Course</title>

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

    $courses = getCourses(); // get the courses list from the database
    ?>


    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Delete Course</h1>
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
                                    echo "<option value='" . strval($id) . "'>" . $code . "</option>";
                                }
                        ?>
                    </select>
                </div>


            </div>

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" onclick="return confirm('Are you sure you want to delete this course?')" name="delete-course" id="delete-course" value="Delete course">
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