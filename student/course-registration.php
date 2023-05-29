<?php

/**
 * View Section Page
 * Allows the professor user to 
 * view students and their information
 * in sections he/she is teaching
 * 
 * @author Omar Eldanasoury
 * @author Abdulmohsen Abbas
 */
session_start();

if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

// only professor are allowed to view this page, if non-professor users tried to view the page, we prevent them using this code
if ($_SESSION["userType"] != "student")
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");

$errMsg = "";
if (isset($_POST["view-course"])) {
    require_once("../functions.php");

    // first get data
    $cid = checkInput($_POST["course-code"]);
    $secId = checkInput($_POST["section-number"]);

    if ($cid == "" or $secId == "") { // if the user didn't choose a value for the course or the section
        $feedbackMsg = "<span class='failed-feedback'>Please select a course and a section!</span>";
    } else {
        $_SESSION["section"] = $secId;
        $_SESSION["course"] = $cid;
        // then we get the data and display it
        $displayInfo = true;

        $sectionData = getSectionInfo($secId); //sec_id, sem_id, course_id, (sec_num), (professor_id), room_id, (lecture_days), (lecture_time), (capacity)
        $courseId = $sectionData[2];
        $courseinfo = getCourse($courseId); // (code), (name) , (ch)
        $roomId = $sectionData[5];
        $roomName = getRoomName($roomId);
        $courseCode = $courseinfo[1];
        $courseName = $courseinfo[2];
        $courseCredits = $courseinfo[2];
        $sectionNumber = $sectionData[3];
        $professor_id = $sectionData[4];
        $professorName = getProfessorName($professor_id);
        $days = $sectionData[6];
        $time = $sectionData[7];
        $capacity = $sectionData[8];
        $buildingName = getBuildingNameByRoomId($roomId);
        $showWaitReqAddButton = intval($capacity) == 0 ? true : false;

        $_SESSION["capacity_int"] = intval($capacity);
        $_SESSION["days"] = $days;
        $_SESSION["roomId"] = $roomId;
        $_SESSION["time"] = $time;
    }
}

if (isset($_POST["add-course"])) {
    require_once("../functions.php");
    $semesterId = getCurrentSemesterId();
    $sectionId = $_SESSION["section"];
    $studentId = $_SESSION["activeUser"][0];
    $courseId = $_SESSION["course"];
    $capacityInt = $_SESSION["capacity_int"];
    $days = $_SESSION["days"];
    $roomId = $_SESSION["roomId"];
    $time = $_SESSION["time"];

    /**
     * Algorithm:
     * 1- check for the if the capacity is full, to show the wait list
     * 2- check if the student will exceed the 19 credits limit
     * 3- check for prerequisites; if they are fulfilled or not
     * 4- check for time conflicts
     * 5- if 1,2,3,4 are fulfilled, then the course is added + section capacity is decreased by 1
     * 
     * @author Omar Eldanasoury
     */
    if (!isInRegistrationPeriod()) {
        $feedbackMsg = "<span class='failed-feedback'>Out of registration period!</span>";
    } else if (exceededMaximumCredits($studentId, $courseId)) {
        $feedbackMsg = "<span class='failed-feedback'>Cannot register the course, you will exceed 19 credits!</span>";
    } else if (!hasFulfilledPrerequisites($studentId, $courseId)) {
        $feedbackMsg = "<span class='failed-feedback'>You have not fulfilled all prerequisites for this course!</span>";
    } else if (!hasTimeConflictStudentRegistration($studentId, $days, $roomId, $time)) {
        $feedbackMsg = "<span class='failed-feedback'>You have time conflict, please choose another section!</span>";
    } else {
        if (registerCourse($semesterId, $courseId, $sectionId, $studentId)) {
            if (reduceCapacity($sectionId, $capacityInt))
                $feedbackMsg = "<span class='success-feedback'>Course is Registered Successfully!</span>";
            else { // if reducing the capacity was not successful
                dropCourse($sectionId, $studentId); // then we drop the course and increase the capacity again
                increaseCapacity($sectionId, $capacity - 1);
                $feedbackMsg = "<span class='failed-feedback'>Something went wrong, please try again later!</span>";
            }
        } else { // if there is a time conflict, an exception will be thrown by updateSection()
            $feedbackMsg = "<span class='failed-feedback'>Something Went Wrong, Please Choose Try Again Later!</span>";
        }
    }
}


if (isset($_POST["add-wait"])) {
    require_once("../functions.php");
    $sectionId = $_SESSION["section"];
    $studentId = $_SESSION["activeUser"][0];
    $courseId = $_SESSION["course"];
    if (doesWaitReqExist($studentId, $courseId)) {
        $feedbackMsg = "<span class='failed-feedback'>You already did a wait request for this course!</span>";
    } else if (exceededMaximumCredits($studentId, $courseId)) {
        $feedbackMsg = "<span class='failed-feedback'>Cannot register the course, you will exceed 19 credits!</span>";
    } else if (!hasFulfilledPrerequisites($studentId, $courseId)) {
        $feedbackMsg = "<span class='failed-feedback'>You have not fulfilled all prerequisites for this course!</span>";
    } else if (!hasTimeConflictStudentRegistration($studentId, $days, $roomId, $time)) {
        $feedbackMsg = "<span class='failed-feedback'>You have time conflict, please choose another section!</span>";
    } else {
        if (exceededMaximumCredits($studentId, $courseId)) {
            $feedbackMsg = "<span class='failed-feedback'>Cannot register the course, you will exceed 19 credits!</span>";
        } else {
            if (addWaitRequest($courseId, $sectionId, $studentId)) {
                $feedbackMsg = "<span class='success-feedback'>Wait Request is Added Successfully!</span>";
            } else {
                $feedbackMsg = "<span class='failed-feedback'>Error while adding wait request, Please Choose Try Again Later!</span>";
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
    <title>Course Registration</title>

    <!-- Adding the css files -->
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css" />

    <!-- Adding the Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');


        .selectTitle {
            font-weight: 400;
        }

        .catalogue-main {
            margin-bottom: 50px;
        }

        .selecter {
            width: 170%;
            display: flex;
            flex-wrap: wrap;
        }

        .selecter h3 {
            font-weight: 500;
            margin-bottom: 10px;
        }

        .selecter span {
            font-weight: 400;
            color: black;
        }

        .tableinfo {
            display: flex;
            justify-content: space-around;
            min-height: 10px;
            width: 90%;
            margin: 15px auto;
            color: #4056A1;
            font-weight: 500;
        }

        .tableinfo span {
            font-weight: 400;
            color: black;
        }

        .innerDiv {
            width: 45%;
        }

        .formSelector {
            width: 80px;
            height: 40px;
            padding: 0px;
            margin: 0 auto;
            cursor: pointer;
        }

        .buttonsDiv {
            width: 90%;
            display: flex;
            justify-content: space-around;
            margin: 7px 0 7px 70px;
        }

        .butn {
            padding: 15px 50px;
            margin: 12px;
            cursor: pointer;
            min-width: 220px;
        }

        .secInfo {
            width: 82%;
        }

        @media (max-width:700px) {
            .tableinfo {
                width: 95%;
                flex-direction: column;
            }

            .innerDiv {
                width: 95%;
            }

            .buttonsDiv {
                width: 90%;
                display: flex;
                flex-direction: column;
                margin: 7px 0 7px 7px;

            }
        }
    </style>

    <!-- Adding FontAwesome Kit -->
    <script src="https://kit.fontawesome.com/163915b421.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php require("../header.php");
    require_once("../functions.php");
    $courses = getStudentAvailableCourses($_SESSION["activeUser"][0]); // get the courses and sections that the professor
    // teaches at the current semester from the database
    // as an associative array course => section1, section2, ... etc
    // then once the professor selects from them, we will get data using ajax and present them in tables
    ?>


    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Course Registration</h1>
        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- Course Code and Section Number -->
                <div class="attendance-inner-flex">
                    <label for="course-code">Course Code:</label><br><br>
                    <select class="selecter" onchange="getSections(this.value)" name="course-code" id="course-code">
                        <option value="">Select a Course</option>
                        <?php
                        if ($courses != array())
                            for ($i = 0; $i < count($courses); $i++) {
                                $courseCode = getCourseInfo($courses[$i]);
                                echo "<option value='" . $courses[$i] . "'>" . $courseCode[0] . "</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="attendance-inner-flex">
                    <!-- Section Number -->
                    <!-- onchange="showStudents(this.value)" -->
                    <label for="section-number">Section Number:</label><br><br>
                    <!-- Will be populated automatically by the system after selecting the course code, again by AJAX -->
                    <select class="selecter" name="section-number" id="section-number" style="margin-left: 0">
                        <option value="">Select a Course First</option>
                        <!-- Will be filled by AJAX -->
                    </select>
                </div>
            </div>

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="view-course" id="view-course" value="View Section">
            <?php
            if (isset($feedbackMsg)) {
                echo $feedbackMsg;
                unset($feedbackMsg);
            }
            ?>

            <!-- The Table of students list -->
            <div class="catalogue-main" style="margin-bottom: 2em;">
                <?php
                if (isset($displayInfo)) {
                ?>
                    <div class="selecter secInfo" id="sectionInfo">
                        <div class="aboveTable tableinfo">
                            <div class="innerDiv">
                                <h5>Course Name: <span><?php echo $courseName ?></span> </h5>
                            </div>
                            <div class="innerDiv">
                                <h5>Course Code: <span><?php echo $courseCode[0] ?></span> </h5>
                            </div>
                        </div>
                        <div class="aboveTable tableinfo">
                            <div class="innerDiv">
                                <h5>Professor: <span><?php echo $professorName ?></span> </h5>
                            </div>
                            <div class="innerDiv">
                                <h5>Credit: <span><?php echo $courseCredits ?></span> </h5>
                            </div>
                        </div>
                        <div class="aboveTable tableinfo">
                            <div class="innerDiv">
                                <h5>Available Seats: <span><?php echo $capacity ?></span> </h5>
                            </div>
                            <div class="innerDiv">
                                <h5>Section No.: <span><?php echo $sectionNumber ?></span> </h5>
                            </div>
                        </div>
                        <div class="aboveTable tableinfo">
                            <div class="innerDiv">
                                <h5>Lecture Time: <span><?php echo $time ?></span> </h5>
                            </div>
                            <div class="innerDiv">
                                <h5>Lecture Days: <span><?php echo $days ?></span> </h5>
                            </div>
                        </div>

                        <div class="aboveTable tableinfo">
                            <div class="innerDiv">
                                <h5>Room: <span><?php echo $roomName ?></span> </h5>
                            </div>
                            <div class="innerDiv">
                                <h5>Building: <span><?php echo $buildingName ?></span> </h5>
                            </div>
                        </div>
                        <?php
                        if (isset($showWaitReqAddButton) and ($showWaitReqAddButton == true)) {
                        ?>
                            <input type="submit" onclick="return confirm('Are you sure you want to add wait request?')" style="margin-left:100px;" class="butn primary-butn sign-butn no-margin-left margin-top small" name="add-wait" id="add-wait-req" value="Add Wait Request">
                        <?php
                        } else {
                        ?>
                            <input type="submit" onclick="return confirm('Are you sure you want to register this course?')" style="margin-left:100px;" class="butn primary-butn sign-butn no-margin-left margin-top small" name="add-course" id="add-course" value="Register Course">

                        <?php
                        }
                        ?>
                        <br><br>
                    </div>

                <?php
                }
                ?>
            </div>
        </form>
    </main>

    <?php require("../footer.php") ?>
</body>
<!-- Script for getting the sections after the user selects the course code :: Using AJAX
     Author: Omar Eldanasoury
 -->
<script>
    /**@function getSection
     * gets the successive section number to be added
     * for a particular course id; using AJAX.
     * 
     * @author Omar Eldanasoury
     */
    function getSections(courseId) {
        if (courseId == "") {
            document.getElementById("section-number").innerHTML = "";
            document.getElementById("section-number").innerHTML += "<option value=''>Select a Course First</option>";

            return;
        }

        const request = new XMLHttpRequest();
        request.onload = showSections;
        request.open("GET", "getStudentSections.php?cid=" + courseId, false);
        request.send();
    }

    /**@function showSection
     * Shows the section number
     * retrieved from the database
     * to the user through html.
     */
    function showSections() {
        clearSectionNumber();
        if (this.responseText.length == 0) {
            document.getElementById("section-number").innerHTML += "\n<option value=''>No Sections Available</option>";
            return
        }
        results = this.responseText.split("#");
        console.log(results);
        for (let result of results) {
            idAndNum = result.split("@");
            if (idAndNum[0] == '')
                continue;
            document.getElementById("section-number").innerHTML += "\n<option value='" + idAndNum[0] + "'>" + idAndNum[1] + "</option>";
        }
    }

    /**@function clearSectionNumber
     * clears the html that shows the section number
     */
    function clearSectionNumber() {
        document.getElementById("section-number").innerHTML = "<option value=''>Select a Section</option>";

    }
</script>

</html>