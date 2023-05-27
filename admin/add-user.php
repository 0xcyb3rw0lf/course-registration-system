<?php

/**
 * Add User Page
 * Allows the admin user to 
 * add users to the system
 * 
 * @author Omar Eldanasoury
 * @author Elyas Raed
 */
session_start();
if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

// only admin should access the page
if (!str_contains($_SESSION["userType"], "admin"))
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");

if (isset($_POST["add-user"])) {
    require_once("../functions2.php");

    // Adding the user details
    $userType = checkInput($_POST["user-type"]);
    $userName = checkInput($_POST["user-name"]);
    $email = checkInput($_POST["user-email"]);
    $password = checkInput($_POST["user-password"]);
    $gender = checkInput($_POST["user-gender"]);

    $college = checkInput($_POST["colleg"]);
    $department = checkInput($_POST["dept"]);

    // Validate/ check for empty values
    if ( // checking the required fields first
        $userType == "" // do not use empty($userType); it will count admin id 0 as empty
        or empty($userName)
        or empty($email)
        or empty($password)
        or empty($gender)

    ) {
        $feedbackMsg = "<span class='failed-feedback'>Please enter all fields as required!</span>";
    } else if (intval($userType) == 3 && !preg_match("/[a-z0-9]+@stu\.uob\.edu\.bh$/", $email)) { // if the user entered wrong value for student email
        $feedbackMsg = "<span class='failed-feedback'>Invalid student email address!</span>";
    } else if (intval($userType) != 3 and !preg_match("/[a-z0-9]+@uob\.edu\.bh$/", $email)) { // if the user entered wrong value for non-student email
        $feedbackMsg = "<span class='failed-feedback'>Invalid email address!</span>";
        echo $email;
    } else if (!preg_match("/^.{6,}$/", $password)) { // if the user entered wrong value for password
        $feedbackMsg = "<span class='failed-feedback'>Password should not be less than 8 characters!</span>";
    } else if (intval($userType) == 0 and (!empty($college) or !empty($department))) { // the user is admin, he should not have a college or department
        $feedbackMsg = "<span class='failed-feedback'>Admin shall not has a college or department!</span>";
    } else if (intval($userType) == 4 and (!empty($department))) { // the user is dean, he should not have a department
        $feedbackMsg = "<span class='failed-feedback'>Dean shall not has a department!</span>";
    } else {
        try {
            if (addUser($userType, $userName, $email, $password, $college, $department, $gender)) {
                $feedbackMsg = "<span class='success-feedback'>User is Added Successfully!</span>";
            } else {
                $feedbackMsg = "<span class='failed-feedback'>Error Adding User!</span>";
            }
        } catch (Exception $exception) { // if there is a conflict in name/email entry/ already exists
            $feedbackMsg = "<span class='failed-feedback'>Name/Email Already Exists!</span>";
        }
    }

    unset($userName, $userType, $email, $password, $gender, $college, $department);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>

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
    $type = getUserTypeAsText(); //get the user types list from the database
    $collegeName = getCollegeName(); //get the colleges list from the database
    $departmentName = getDepartmentName(); //get the departments list from the database
    ?>

    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Add New User</h1>

        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">

                <div class="attendance-inner-flex">
                    <label for="user-type">Choose User Type:</label><br><br>
                    <select required class="selecter" name="user-type" id="user-type">
                        <option value="">Select a User Type</option>
                        <?php
                        if ($type != array())
                            for ($i = 0; $i < count($type); $i++)
                                foreach ($type[$i] as $id => $name) {
                                    echo "<option value='" . strval($id) . "'>" . $name . "</option>";
                                }
                        ?>
                    </select>
                    <br><br><br>
                    <label for="dept">Department:</label><br><br>
                    <select class="selecter" name="dept" id="dept">
                        <option value="">Select a College First</option>
                        <!-- Will be filled by AJAX -->
                    </select>
                </div>

                <div class="attendance-inner-flex" style="margin-left: 2.75em;">
                    <label for="colleg">College:</label><br><br>
                    <select class="selecter" onchange="getDepartments(this.value)" name="colleg" id="colleg">
                        <option value="">Select a College</option>
                        <?php
                        if ($collegeName != array())
                            for ($i = 0; $i < count($collegeName); $i++)
                                foreach ($collegeName[$i] as $id => $name) {
                                    echo "<option value='" . strval($id) . "'>" . $name . "</option>";
                                }
                        ?>
                    </select>
                    <br><br><br>
                    <label for="user-name">Name:</label><br><br>
                    <input type="text" required class="selecter" name="user-name" id="user-name">
                </div>

                <div class="attendance-inner-flex" style="margin-left: 2.75em;">
                    <label for="email">Email:</label><br><br>
                    <input type="text" required class="selecter" name="user-email" id="user-email">
                    <br><br><br>
                    <label for="password">Password:</label><br><br>
                    <input type="text" required class="selecter" name="user-password" id="user-password">
                </div>

                <div class="attendance-inner-flex" style="margin-left: 2.75em;">
                    <label for="gender">Gender:</label><br><br>
                    <select required class="selecter" name="user-gender" id="user-gender">
                        <option value="">Select a Gender</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
            </div>
            <br><br><br>
            <input onclick="return confirm('Are you sure you want to add a user?')" type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="add-user" id="add-user" value="Add User!">
            <br><br>
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
            document.getElementById("dept").innerHTML += "\n<option value=''>No Departments Available</option>";
            return
        }
        results = this.responseText.split("#");
        for (let result of results) {
            idAndNum = result.split("@");
            if (idAndNum[0] == '')
                continue;
            document.getElementById("dept").innerHTML += "\n<option value='" + idAndNum[0] + "'>" + idAndNum[1] + "</option>";
        }
    }

    function clearDepartment() {
        document.getElementById("dept").innerHTML = "<option value=''>Select a Department</option>";

    }
</script>

</html>