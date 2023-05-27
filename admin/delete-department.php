<?php

/**
 * Delete Program Page
 * Allows the admin user to 
 * Delete Programs from the system
 * 
 * @author Elyas Raed
 * @author Omar Eldanasoury
 */

session_start();
if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

    // only admin should access the page
if (!str_contains($_SESSION["userType"], "admin"))
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");

if (isset($_POST["delete-department"])) {
    require_once("../functions2.php");
    // first get data
    $cid = checkInput($_POST["college-name"]);
    $departmentName = checkInput($_POST["department-name"]);

    // then validate user input
    if ($cid == "" || $departmentName == "") { // if the user didn't choose a value for the college or department
        $feedbackMsg = "<span class='failed-feedback'>Please select a department!</span>";
    } else {
        // then delete the department
        if (deleteDepartment($departmentName)) {
            $feedbackMsg = "<span class='success-feedback'>Department is deleted successfully!</span>";
        } else {
            $feedbackMsg = "<span class='failed-feedback'>Error deleting department<br>Please try again later!</span>";
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
    <title>Delete Department</title>

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
    require_once("../functions2.php");
    // Required varialbes for deleting the department
    $collegeName = getCollegeName(); // get the colleges list from the database
    $departmentName = getDepartmentName(); // get the departments list from the database
    ?>

    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Delete Department</h1>
        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <div class="attendance-inner-flex">
                    <label for="college-name">College Name:</label><br><br>
                    <select class="selecter" onchange="getDepartments(this.value)" name="college-name" id="college-name">
                        <option value="">Select a College</option>
                        <?php
                        if ($collegeName != array())
                            for ($i = 0; $i < count($collegeName); $i++)
                                foreach ($collegeName[$i] as $id => $name) {
                                    echo "<option value='" . strval($id) . "'>" . $name . "</option>";
                                }
                        ?>
                    </select>
                </div>
                <!-- Department Names -->
                <div class="attendance-inner-flex">
                    <label for="department-name">Department Name:</label><br><br>
                    <select class="selecter" name="department-name" id="department-name">
                        <option value="">Select a College First</option>

                    </select>
                </div>

            </div>

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" onclick="return confirm('Are you sure you want to delete this department?')" name="delete-department" id="delete-department" value="Delete Department">
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
<!-- Script for getting the departments after the user selects the college -->
<script>
    function getDepartments(deptIds) {
        if (deptIds == "") {
            return;
        }

        const request = new XMLHttpRequest();
        request.onload = showDepartments;
        request.open("GET", "getDepartments.php?cid=" + deptIds);
        request.send();
    }

    function showDepartments() {
        clearDepartment();
        if (this.responseText.length == 0) {
            document.getElementById("department-name").innerHTML += "\n<option value=''>No Departments Available</option>";
            return
        }
        results = this.responseText.split("#");
        for (let result of results) {
            idAndNum = result.split("@");
            if (idAndNum[0] == '')
                continue;
            document.getElementById("department-name").innerHTML += "\n<option value='" + idAndNum[0] + "'>" + idAndNum[1] + "</option>";
        }
    }

    function clearDepartment() {
        document.getElementById("department-name").innerHTML = "<option value=''>Select a Department</option>";

    }
</script>

</html>