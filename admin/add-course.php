<?php

/**
 * Add Course Page
 * allows the admin to add a course
 * to the system
 * 
 * @author Mohamed Alammal
 * @author Omar Eldanasoury
 */

session_start();
if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

// only admin should access the page
if (!str_contains($_SESSION["userType"], "admin"))
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");


if (isset($_POST["add-course"])) {
    require_once("../functions.php");


    $courseName = $_POST["courseName"];
    $courseCode = $_POST["courseCode"];
    $program_id = $_POST["program"];
    $prereq_id = $_POST["prereq_id"];
    $credits = $_POST["credits"];
    $courseCodeValidation = "/^[A-Za-z]+.*[0-9]+$/";
    $creditsValidation = "/\d+/";
    $courseNameValidation = "/^[a-zA-Z ]*$/";


    if (
        empty($courseName)
        or empty($courseCode)
        or (empty($credits))
        or (trim($_POST["college"]) == "")
        or (trim($_POST["program"]) == "")

    ) {
        $feedbackMsg = "<span class='failed-feedback'>Please enter all fields as required!</span>";
    } elseif (!preg_match($courseCodeValidation, $courseCode) or !preg_match("/\d+/", $credits) or !preg_match($courseNameValidation, $courseName)) {
        $feedbackMsg = "<span class='failed-feedback'>Please enter data in the correct format!</span>";
    } else {
        $added = false;

        if (!doesCourseExist($courseCode)) {
            try {
                $SQL = "INSERT INTO course VALUES(NULL, '$courseCode', '$courseName', '$credits')";
                require('../connection.php');
                $db->beginTransaction();
                $r = $db->exec($SQL);
                if ($r > 0) {
                    $course_id = $db->lastInsertId();
                    $added = true;
                }

                $SQL2 = "INSERT INTO program_course VALUES('$program_id','$course_id')";
                $r2 = $db->exec($SQL2);
                if (trim($_POST["prereq_id"]) != "") {
                    $SQL3 = "INSERT INTO course_prereq VALUES('$course_id','$prereq_id')";
                    $r3 = $db->exec($SQL3);
                }


                $db->commit();
                if ($added) {
                    $feedbackMsg = "<span class='success-feedback'>Course is Added Successfully!</span>";
                } else {
                    $feedbackMsg = "<span class='failed-feedback'>Error Adding Course!</span>";
                }
            } catch (PDOException $i) {
                $db->rollback();
                die($i->getMessage());
                $feedbackMsg = "<span class='failed-feedback'>Duplicate course code!</span>";
            }
        } else {
            $feedbackMsg = "<span class='failed-feedback'>Course Already Exists!</span>";
        }
    }
}

/**
 * Returns an array of colleges and
 * their ids
 * 
 * @author Omar Eldanasoury
 * @author Mohamed Alammal
 * @return array of arrays, inner arrays are assocciative arrays of id => collegeName
 */
function getColleges()
{
    $colleges = array();
    try {
        // establishing connection
        require("../connection.php");
        // setting and running the query
        $query = $db->query("SELECT * FROM college");
        while ($allColleges = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $collegs = array($allColleges[0] => $allColleges[1]);
            array_push($colleges, $collegs);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $colleges;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>

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
    $professorNames = getProfessorNames();
    $college = getColleges();
    $rooms = getRooms();

    ?>


    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Add Course</h1>

        <!--
            Needed Information to add a course:
                -
         -->
        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- Course Code-->
                <div class="attendance-inner-flex">
                    <label for="courseCode">Course Code:</label><br><br>
                    <input type="text" name="courseCode" placeholder="Course Code" value="">
                    <br><br>
                    <!-- College -->
                    <label for="bldng">College:</label><br><br>
                    <select onchange="getPrograms(this.value)" class="selecter" name="college" id="college">
                        <option value="">Select a College</option>
                        <?php
                        if ($college != array())
                            for ($i = 0; $i < count($college); $i++)
                                foreach ($college[$i] as $id => $name) {
                                    echo "<option value='" . strval($id) . "'>" . $name . "</option>";
                                }

                        ?>
                    </select>
                </div>


                <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                    <!-- Course Name -->
                    <label for="courseName">Course Name:</label><br><br>
                    <input type="text" name="courseName" placeholder="Course Name" value="">
                    <br><br>
                    <!-- Program -->
                    <label for="room">Program:</label><br><br>
                    <select class="selecter" name="program" id="program">
                        <option value="">Select a Program</option>
                        <!-- The options will be optained from the database using AJAX and PHP -->
                        <!-- Refer to the script at the end of the page, after <body> -->
                    </select>
                </div>

                <!-- Credits -->
                <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                    <label for="capacity">Credits:</label><br><br>
                    <input type="number" min="1" max="5" class="selecter" name="credits" id="credits" placeholder="1-5">
                    <br><br>
                    <!-- Course Code -->
                    <label for="course-code">Pre-Requisite:</label><br><br>
                    <select class="selecter" name="prereq_id" id="prereq_id">
                        <option value="">Select a Course</option>
                        <?php
                        if ($courses != array())
                            for ($i = 0; $i < count($courses); $i++)
                                foreach ($courses[$i] as $id => $code) {
                                    echo "<option value='" . $id . "'>" . $code . "</option>";
                                }
                        ?>
                    </select>

                </div>
            </div>
            <input onclick="return confirm('Are you sure you want to add a course?')" type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="add-course" id="add-course" value="Add a Course!">
            <br><br>
            <?php
            if (isset($feedbackMsg)) {
                echo $feedbackMsg;
                unset($feedbackMsg);
            }
            ?>

        </form>
        <br><br><br>
    </main>

    <?php require("../footer.php") ?>
</body>

<script>
    function getPrograms(program_id) {
        if (program_id.length == 0) {
            return;
        }

        const request = new XMLHttpRequest();
        request.onload = showPrograms;
        request.open("GET", "getPrograms.php?id=" + program_id);
        request.send();
    }

    function showPrograms() {
        clearPrograms();
        results = this.responseText.split("#");
        for (let result of results) {
            idAndProgram = result.split("@");
            if (idAndProgram[0] == '')
                continue;
            document.getElementById("program").innerHTML += "\n<option value='" + idAndProgram[0] + "'>" + idAndProgram[1] + "</option>";
        }
    }


    function clearPrograms() {
        document.getElementById("program").innerHTML = "<option value=''>Select a Program</option>"
    }
</script>

</html>