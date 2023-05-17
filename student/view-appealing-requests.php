<?php

/**
 * View Appealing Requests Page
 * Allows the student user to 
 * view his appealing requests
 * and their status 
 * @author Omar Eldanasoury 
 */

session_start();

if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

require_once("../functions.php");


$requests = getStudentAppealingRequests($_SESSION["activeUser"][0]);
$tableBody = "";
if ($requests == array()) {
    $tableBody = "<tr><td colspan='4'>You Have No Appealing Requests!</td></tr>";
}


foreach ($requests as $request) {
    $code = $request[0];
    $name = $request[1];
    $state = $request[2];
    $grade = $request[3];

    $tableBody .= "<tr>\n<td>$code</td>\n<td>$name</td>\n<td>$state</td>\n<td>$grade</td>\n</tr>\n";
} // after this, the table will shown as html
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appealing Requests</title>

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
    ?>


    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">View Appealing Requests</h1>
        <!-- The Table of students list -->
        <div class="catalogue-main" style="margin-bottom: 2em;">
            <form method="post" class="form" style="margin-left: 2.75em;  text-align: center;">
                <table id="displayTable" style="margin: 0;">
                    <thead>
                        <tr>
                            <th class="th-color">Course Code</th>
                            <th class="th-color">Course Name</th>
                            <th class="th-color">Status</th>
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

</html>