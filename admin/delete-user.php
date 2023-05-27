<?php

/**
 * Delete User Page
 * Allows the admin user to 
 * delete users from the system
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


if (isset($_POST["delete-user"])) {
    require_once("../functions2.php");
    // first get data
    $uid = checkInput($_POST["user-type"]);
    $uname = checkInput($_POST["user-name"]);

    // then validate user input
    if ($uid == "" or $uname == "") { // if the user didn't choose a value for the type or the name
        $feedbackMsg = "<span class='failed-feedback'>Please select a user type and a name!</span>";
    } else {
        // then delete the user
        if (deleteUser($uname)) {
            $feedbackMsg = "<span class='success-feedback'>User is deleted successfully!</span>";
        } else {
            $feedbackMsg = "<span class='failed-feedback'>Error deleting user<br>Please try again later!</span>";
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
    <title>Delete User</title>

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
        <h1 class="catalogue-header" style="color: #4056A1;">Delete User</h1>
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

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" onclick="return confirm('Are you sure you want to delete this user?')" name="delete-user" id="delete-user" value="Delete User">
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
            document.getElementById("user-name").innerHTML += "\n<option value=''>No Users Available</option>";
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

</html>