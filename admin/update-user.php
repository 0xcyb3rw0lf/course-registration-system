<?php

/**
 * Update User Page
 * Allows the admin user to 
 * update user details from the system
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

if (isset($_POST["view-user"])) {
    require_once("../functions2.php");
    // first get data
    $uid = checkInput($_POST["user-type"]);
    $uname = checkInput($_POST["user-name"]);
    $_SESSION["name"] = $uname;

    // then validate user input
    if ($uid == "" or $uname == "") { // if the user didn't choose a value for the type or the name
        $feedbackMsg = "<span class='failed-feedback'>Please select a user type and a name!</span>";
    } else {
        // shows the form for the admin to enter updated user data
        $displayForm = true;
        $nameData = getnameData($_SESSION["name"]);
    }
}

if (isset($_POST["update-user"])) {
    require_once("../functions2.php");

    // Adding the user details
    $userType = $_POST["user-type"];
    $username = $_POST["user-name"];
    $email = $_POST["user-email"];
    $password = $_POST["user-password"];
    $college = $_POST["colleg"];
    $department = $_POST["dept"];
    $gender = $_POST["user-gender"];

    // Validate/ check for empty values
    if (
        $userType == ""
        or empty($username)
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
            if (updateUser($_SESSION["name"], $userType, $username, $email, $password, $college, $department, $gender)) {
                $feedbackMsg = "<span class='success-feedback'>User is Updated Successfully!</span>";
            } else {
                $feedbackMsg = "<span class='failed-feedback'>Error Updating User!</span>";
            }
        } catch (Exception $exception) { // if there is a conflict in name/email entry
            $feedbackMsg = "<span class='failed-feedback'>User Name and/or Email Already Exists!</span>";
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
    <title>Update User</title>

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
    // Required varialbes for adding the section
    $type = getUserTypeAsText(); // get the types list from the database
    ?>

    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Update User</h1>
        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- User Type and User Name -->
                <div class="attendance-inner-flex">
                    <label for="user-type">Choose User Type:</label><br><br>
                    <select class="selecter" onchange="getUsers(this.value)" name="user-type" id="user-type">
                        <option value="">Select a User Type</option>
                        <?php
                        if ($type != array())
                            for ($i = 0; $i < count($type); $i++)
                                foreach ($type[$i] as $id => $code) {
                                    echo "<option value='" . strval($id) . "'>" . $code . "</option>";
                                }
                        ?>
                    </select>
                </div>

                <div class="attendance-inner-flex">
                    <!-- User Name -->
                    <label for="user-name">Choose User Name:</label><br><br>
                    <!-- Will be populated automatically by the system after selecting the user type, again by AJAX -->
                    <select class="selecter" name="user-name" id="user-name" style="margin-left: 0">
                        <option value="">Select a Type First</option>
                        <!-- Will be filled by AJAX -->
                    </select>
                </div>
            </div>

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="view-user" id="view-user" value="View User To Update">
            <?php
            if (isset($feedbackMsg)) {
                echo $feedbackMsg;
                unset($feedbackMsg);
            }
            ?>
        </form>

        <!-- The update user data fields -->
        <!-- <div class="catalogue-main" style="margin-bottom: 2em; text-align: left;"> -->
        <form method="post" class="form" style="margin-left: 2.75em; text-align: center;">
            <?php
            if (isset($displayForm) and $displayForm) {
                $type = getUserTypeAsText();
                $collegeName = getCollegeName();
                $departmentName = getDepartmentName();
            ?>

                <div class="catalogue-main" style="margin-bottom: 2em; text-align: left;">
                    <!-- <h3>Update Data For User: <?php echo "$uname" ?></h3><br><br> -->
                    <div class="attendance-flex">
                        <div class="attendance-inner-flex">
                            <label for="user-type">Choose User Type:</label><br><br>
                            <select class="selecter" name="user-type" id="user-type">
                                <option value="">Select a User Type</option>
                                <?php
                                if ($type != array())
                                    for ($i = 0; $i < count($type); $i++)
                                        foreach ($type[$i] as $id => $name) {
                                            echo "<option value='" . strval($id) . "'>" . $name . "</option>";
                                        }
                                ?>
                            </select>
                        </div>

                        <div class="attendance-inner-flex" style="margin-left: 5em;">
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
                        </div>

                        <div class="attendance-inner-flex" style="margin-left: 5em;">
                            <label for="dept">Department:</label><br><br>
                            <select class="selecter" name="dept" id="dept">
                                <option value="">Select a Department</option>
                                <!-- Will be filled by AJAX -->
                            </select>
                        </div>

                    </div>
                    <br><br><br>
                    <div class="attendance-flex">

                        <div class="attendance-inner-flex">
                            <label for="user-name">Name:</label><br><br>
                            <input type="text" class="selecter" name="user-name" id="user-name">
                        </div>

                        <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                            <label for="email">Email:</label><br><br>
                            <input type="text" class="selecter" name="user-email" id="user-email">
                        </div>

                        <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                            <label for="password">Password:</label><br><br>
                            <input type="text" class="selecter" name="user-password" id="user-password">
                        </div>

                    </div>
                    <br><br><br>
                    <div class="attendance-flex">

                        <div class="attendance-inner-flex">
                            <label for="gender">Gender:</label><br><br>
                            <select class="selecter" name="user-gender" id="user-gender">
                                <option value="">Select a Gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                        </div>

                    </div>
                    <input onclick="return confirm('Do you want to update the information for this user?')" type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="update-user" id="update-user" value="Update User">
                <?php
            }
                ?>
        </form>
        </div>
        </div>
    </main>

    <?php require("../footer.php") ?>
</body>

<!-- Script for getting the user names after the user selects the user type-->
<script>
    function getUsers($userIds) {
        if ($userIds == "") {
            return;
        }

        const request = new XMLHttpRequest();
        request.onload = showUsers;
        request.open("GET", "getNames.php?uid=" + $userIds);
        request.send();
    }

    function showUsers() {
        clearUserNames();
        if (this.responseText.length == 0) {
            document.getElementById("user-name").UpdateML += "\n<option value=''>No Users Available</option>";
            return
        }
        results = this.responseText.split("#");
        for (let result of results) {
            idAndNum = result.split("@");
            if (idAndNum[0] == '')
                continue;
            document.getElementById("user-name").innerHTML += "\n<option value='" + idAndNum[0] + "'>" + idAndNum[1] + "</option>";
        }
    }

    function clearUserNames() {
        document.getElementById("user-name").innerHTML = "<option value=''>Select a User</option>";

    }
</script>

<!-- Script for getting the departments after the user selects the college -->
<script>
    function getDepartments(deptIds) {
        if (deptIds == "") {
            return;
        }

        const request3 = new XMLHttpRequest();
        request3.onload = showDepartments;
        request3.open("GET", "getDepartments.php?cid=" + deptIds);
        request3.send();
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