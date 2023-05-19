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


        // extracting data from the id
        $courseCode = getCourseCode($sectionData["course_id"]);
        $professorName = getProfessorName($sectionData["professor_id"]);
        $sectionNumber = $sectionData["Sec_num"];
        $buildingName = getBuildingName($sectionData["room_id"]);
        $roomName = getRoomName($sectionData["room_id"]);
        $days = $sectionData["lec_days"];
        $time = $sectionData["lec_time"];
        $capacity = $sectionData["capacity"];
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

        label,
        p {
            display: inline;
        }
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
        <h1 class="catalogue-header" style="color: #4056A1;">View Section</h1>
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

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="view-section" id="view-section" value="View Section Details!">
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

                    // TODO: edit the form, to display only data + write the functions to get data from the database
                ?>

                    <div class="attendance-flex catalogue-main">
                        <!-- Course Code and Section Number -->
                        <div class="attendance-inner-flex" style="flex: 4;">
                            <label for="course-code">Course Code:</label>
                            <p style="color: black;"><?php echo $courseCode ?></p>
                            <br><br><br>
                            <!-- Section Number -->
                            <label for="section-num">Section Number:</label>
                            <p style="color: black;"></p><?php echo $sectionNumber ?></p>
                        </div>

                        <!-- Building and Room -->
                        <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                            <label for="bldng">Building:</label>
                            <p style="color: black;"><?php echo $buildingName ?></p>
                            <br><br><br><br>
                            <label for="room">Room:</label>
                            <p style="color: black;"><?php echo $roomName ?></p>
                        </div>

                        <!-- Professor and Date+Time -->
                        <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                            <label for="prof-name">Professor:</label><br><br>
                            <p style="color: black;"><?php echo $professorName ?></p>
                            <br><br><br>
                            <label for="datetime">Days:</label><br><br>
                            <p style="color: black;"><?php echo $days ?></p>
                        </div>

                        <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                            <label for="datetime">Time:</label><br><br>
                            <p style="color: black;"><?php echo $time ?></p>
                            <br><br><br>
                            <label for="capacity">Capacity:</label><br><br>
                            <p style="color: black;"><?php echo $capacity ?></p>
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