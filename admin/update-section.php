<?php

/**
 * Manage Appealing Requests Page
 * Allows the professor user to 
 * view students' appealing requests 
 * and update students' grades to the system 
 * @author Omar Eldanasoury 
 */

session_start();

if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

require_once("../functions.php");
if (isset($_POST["view-section"])) {
    // TODO: after user confirms (using JS)
    // first get data
    $cid = checkInput($_POST["course-code"]);
    $secId = checkInput($_POST["section-number"]);
    $_SESSION["section"] = $secId;

    if ($cid == "" or $secId == "") { // if the user didn't choose a value for the course or the section
        $feedbackMsg = "<span class='failed-feedback'>Please select a course and a section!</span>";
    } else { // display the form to enter new section details
        // shows the form for the user to enter new information for the section
        $displayForm = true;
        $sectionData = getSectionData($_SESSION["section"]); // passing the id of the section user selected
    }
}

// Now submitting the grade into the db
if (isset($_POST["update-section"])) {
    $sectionId = $_SESSION["section"];
    $courseId = $_POST["course-code"];
    $professorId = $_POST["prof-name"];
    $sectionNum = checkInput($_POST["section-num"]);
    $buildingId = $_POST["bldng"];
    $roomId = $_POST["room"];
    $dateTime = $_POST["datetime"];
    $days = $_POST["days"];
    $capacity = $_POST["capacity"];
    $semId = getCurrentSemesterId();

    // check for empty section number, or any empty value
    if (
        empty($sectionId)
        or empty($courseId)
        or empty($professorId)
        or (empty($sectionNum))
        or empty($buildingId)
        or empty($roomId)
        or empty($dateTime)
        or empty($days)
        or empty($capacity)
    ) {
        $feedbackMsg = "<span class='failed-feedback'>Please enter all fields as required!</span>";
    } else if (!preg_match("/\d+/", $sectionNum)) { // if the user entered wrong value for section number\
        $feedbackMsg = "<span class='failed-feedback'>Enter only numbers for section number!</span>";
    } else {
        try {
            if (updateSection($_SESSION["section"], $courseId, $professorId, $dateTime, $sectionNum, $roomId, $days, $capacity)) {
                $feedbackMsg = "<span class='success-feedback'>Section is Updated Successfully!</span>";
            } else { // if updateSection() returned false
                $feedbackMsg = "<span class='failed-feedback'>Error Updating Section!</span>";
            }
        } catch (LogicException $samePreviousTimeRoomDays) { // if there is a time conflict, an exception will be thrown by updateSection()
            $feedbackMsg = "<span class='failed-feedback'>You Chose The Same Time, Room, And Days!<br>Please Choose Different Time/Room/Day Other Than Existing One(s)!</span>";
        } catch (Exception $exception) { // if there is a time conflict, an exception will be thrown by updateSection()
            $feedbackMsg = "<span class='failed-feedback'>Time Conflict Exists, Please Choose Another Time/Days!</span>";
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
    <title>Update Section</title>

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

    // Required varialbes for adding the section
    $courses = getCourses(); // get the courses and sections that the professor
    // teaches at the current semester from the database
    // as an associative array course => section1, section2, ... etc

    // then once the professor selects from them, we will get data using ajax and present them in tables
    ?>


    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Update Section</h1>
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

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="view-section" id="view-section" value="View Section To Update">
            <br><br>
            <?php
            if (isset($feedbackMsg)) {
                echo $feedbackMsg;
                unset($feedbackMsg);
            }
            ?>
        </form>
        <!-- The Table of students list -->
        <div class="catalogue-main" style="margin-bottom: 2em; text-align: left;">
            <form method="post" class="form" style="margin-left: 2.75em;  text-align: center;">
                <?php
                if (isset($displayForm) and $displayForm) {
                    // $sectionInfo = getSectionInformation(); // an array
                    // Required varialbes for adding the section
                    $courses = getCourses(); // get the courses list from the database
                    $professorNames = getProfessorNames();
                    $buildings = getBuildings();
                    $rooms = getRooms();
                ?>

                    <div class="attendance-flex catalogue-main">
                        <!-- Course Code and Section Number -->
                        <div class="attendance-inner-flex">
                            <label for="course-code">Course Code:</label><br><br>
                            <select class="selecter" name="course-code" id="course-code">
                                <?php
                                if ($courses != array())
                                    for ($i = 0; $i < count($courses); $i++)
                                        foreach ($courses[$i] as $id => $code) {
                                            echo "<option value='" . strval($id) . "'>" . $code . "</option>";
                                        }

                                ?>
                            </select>
                            <br><br>
                            <!-- Section Number -->
                            <label for="section-num">Section Number:</label><br><br>
                            <input type="number" min="1" class="selecter" name="section-num" id="section-num">
                        </div>

                        <!-- Building and Room -->
                        <div class="attendance-inner-flex" style="margin-left: 2.5em;">
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
                            <br><br><br>
                            <label for="room">Room:</label><br><br>
                            <select class="selecter" name="room" id="room">
                                <option value="">Select a Room</option>
                                <!-- The options will be optained from the database using AJAX and PHP -->
                                <!-- Refer to the script at the end of the page, after <body> -->
                            </select>
                        </div>

                        <!-- Professor and Date+Time -->
                        <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                            <label for="prof-name">Professor:</label><br><br>
                            <select class="selecter" name="prof-name" id="prof-name">
                                <?php
                                if ($professorNames != array())
                                    for ($i = 0; $i < count($professorNames); $i++)
                                        foreach ($professorNames[$i] as $id => $name) {
                                            echo "<option value='" . strval($id) . "'>" . $name . "</option>";
                                        }

                                ?>
                            </select>
                            <br><br><br>
                            <label for="datetime">Days:</label><br><br>
                            <select class="selecter" name="days" id="days">
                                <option value="UTH">UTH</option>
                                <option value="MW">MW</option>
                            </select>
                        </div>

                        <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                            <label for="datetime">Time:</label><br><br>
                            <input type="time" name="datetime" id="datetime">
                            <br><br><br>
                            <label for="capacity">Capacity:</label><br><br>
                            <input type="number" min="15" max="9999" class="selecter" name="capacity" id="capacity">
                        </div>
                    </div>
                    <input onclick="return confirm('Do you want to update the information for this section?')" type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="update-section" id="update-section" value="Update Section">
                <?php
                }
                ?>
            </form>
        </div>
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
            return;
        }

        const request = new XMLHttpRequest();
        request.onload = showSections;
        request.open("GET", "getSections.php?cid=" + courseId);
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

        const request2 = new XMLHttpRequest();
        request2.onload = showRooms;
        request2.open("GET", "getRooms.php?id=" + buildingId);
        request2.send();
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