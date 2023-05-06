<?php

/**
 * Manage Grades Page
 * Allows the professor user to 
 * add/delete/update students' grades to the system
 * 
 * @author Omar Eldanasoury 
 */

session_start();

if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

require_once("../functions.php");
echo getSectionStudents(4);
if (isset($_POST["manage-grades"])) {

    // TODO: after user confirms (using JS)
    // first get data
    $cid = checkInput($_POST["course-code"]);
    $secId = checkInput($_POST["section-number"]);

    $errMsg = "";
    unset($errMsg);
    if ($cid == "" or $secId == "") {

        $errMsg = "<span style='color: red;'>Please select a course and a section!</span>";
    }

    $students = getStudentsGrades($secId);
    $tableBody = "";

    // generating the table body based on the data
    $eachStudent = preg_split("/#/", $students);
    // echo print_r($eachStudent);
    foreach ($eachStudent as $studentData) {
        $piecesOfData = preg_split("/@/", $studentData);
        // echo print_r($piecesOfData);
        // add the complete table row for each student to the table body
        if ($piecesOfData[0] == "")
            continue; // solves the null issue, where it prints empty values
        $tableBody .= "\n<tr>\n<td>" . $piecesOfData[0] . "</td>\n<td>"
            . $piecesOfData[1] . "</td>\n<td>"
            . '<input style="font-size: medium; padding: 0.1em; width: min-content; border-radius: 0.1em" type="number" min="0" max="100" step=".01" name="grade" value="' . $piecesOfData[2] . '" />'
            . "</td>\n</tr>";
    } // after this, the table will shown as html
    // TODO: only validate for empty values from the <select>
    // when the user click delete button with no options selected

    // then delete the section + TODO: Feedback message of success of failed
    // if () {
    //     echo "Deleted Successfully!";
    //     // TODO: SHOW FEEDBACK MESSAGES!
    // } else {
    // }
}

// Now submitting the grade into the db
if (isset($_POST["update-grades"])) {
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Grades</title>

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
    // TODO: do these 2 functions and getProfessorSection() and display data, no validation required here,
    // also show if the section is empty

    // Required varialbes for adding the section
    $courses = getProfessorCourses($_SESSION["activeUser"][0]); // get the courses and sections that the professor
    // teaches at the current semester from the database
    // as an associative array course => section1, section2, ... etc

    // then once the professor selects from them, we will get data using ajax and present them in tables
    ?>


    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Manage Grades</h1>
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

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="manage-grades" id="manage-grades" value="View Student's Grades">
        </form>

        <?php
        // if (isset($feedback) and $feedback == true)
        //     createSuccessPopUp("Section Added Successfully!");
        // if (isset($secNumErr))
        //     echo "<p style='color: red; font-size: 1em;'></p>$secNumErr</p>";
        // if (isset($sameSecErr))
        //     echo "<p style='color: red; font-size: 1em;'></p>$sameSecErr</p>";
        // if ((isset($insertErr)))
        //     echo "<p style='color: red; font-size: 1em;'></p>$insertErr</p>";
        ?>

        <!-- The Table of students list -->
        <div class="catalogue-main" style="margin-bottom: 2em;">
            <form method="post" class="form" style="margin-left: 2.75em;  text-align: center;">
                <table id="displayTable" <?php if (isset($tableBody)) echo "style='visibility: visible; margin: 0;'";
                                            else echo "style='visibility: hidden;'" ?>>
                    <thead>
                        <tr>
                            <th class="th-color">Student ID</th>
                            <th class="th-color">Student Name</th>
                            <th class="th-color">Grade</th>

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
                <br><br><br>
                <input <?php if (isset($tableBody)) echo "style='visibility: visible; width: 35%;'";
                        else echo "style='visibility: hidden;'" ?> type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="update-grades" id="update-grades" value="Update Student's Grades">
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
            document.getElementById("section-number").innerHTML = "";
            document.getElementById("section-number").innerHTML += "<option value=''>Select a Course First</option>";

            return;
        }

        const request = new XMLHttpRequest();
        request.onload = showSections;
        request.open("GET", "getProfessorSections.php?cid=" + courseId, false);
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


<!-- <script>
    // *************************************** NEXT: AJAX code to get student's list
    /**@function getSection
     * gets the successive section number to be added
     * for a particular course id; using AJAX.
     * 
     * @author Omar Eldanasoury
     */
    function showStudents(sectionId) {
        if (sectionId == "") {
            return;
        }

        let request2 = new XMLHttpRequest();
        request2.onload = showStudentsTable;
        request2.open("GET", "getStudentsList.php?sectionId=" + sectionId);
        request2.send();
    }

    /**@function showSection
     * Shows the section number
     * retrieved from the database
     * to the user through html.
     */
    function showStudentsTable() {
        clearStudentsTable();
        console.log(this.responseText);
        console.log("code: " + this.status);
        console.log(this.status);
        console.log("ready state = " + this.readyState);
        if (this.responseText.length == 0) {
            document.getElementById("newRow").innerHTML += "\nSection is empty!";
            return;
        }
        results = this.responseText.split("#");
        showStudentsTable();
        for (let result of results) {
            studentData = result.split("@");
            if (studentData[0] == '')
                continue;
            document.getElementById("newRow").innerHTML += "\n<tr>\n<td>" + studentData[0] + "</td>\n<td>" + studentData[1] + "</td>\n<td>" + studentData[2] + "</td>\n<td>" + studentData[3] + "</td>\n<td>" + studentData[4] + "</td>\n</tr>";
        }

        // if (isStudentsTableHidden())
        //     showStudentsTable();
    }

    /**@function clearSectionNumber
     * clears the html that shows the students table
     */
    function clearStudentsTable() {
        document.getElementById("newRow").innerHTML = "";

    }

    function hideStudentsTable() {
        document.getElementById("displayTable").style.display = "hidden";
    }

    function showStudentsTable() {
        document.getElementById("displayTable").style.visibility = "visible";
    }

    function isStudentsTableHidden() {
        return document.getElementById("displayTable").style.visibility === "hidden";
    }
</script> -->
<!-- Script for popup -->
<script>
    document.getElementById('button').addEventListener('click', function() {
        document.querySelector('.bg-modal').style.display = 'flex';
    });

    document.querySelector('.close').addEventListener('click', function() {
        document.querySelector('.bg-modal').style.display = 'none';
    });
</script>

</html>