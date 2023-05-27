<?php

/**
 * View User Page
 * Allows the admin user to 
 * view users and their information
 * 
 * @author Elyas Raed
 * @author Omar Eldanasoury
 */
session_start();
if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

$errMsg = "";
if (isset($_POST["view-user"])) {
    require_once("../functions2.php");
    // first get data
    $utp = checkInput($_POST["user-type"]);

    if ($utp == "") { // if the user didn't choose a value for the user type
        $feedbackMsg = "<span class='failed-feedback'>Please select a user type!</span>";
    } else {
        $users = getTypeusers($utp);
        $tableBody = "";

        // generating the table body based on the data
        $eachUser = preg_split("/#/", $users);
        foreach ($eachUser as $userData) {
            $piecesOfData = preg_split("/!/", $userData);
            // echo print_r($piecesOfData);
            // add the complete table row for each data to the table body
            if ($piecesOfData[0] == "")
                continue; // solves the null issue, where it prints empty values
            $tableBody .= "\n<tr>\n<td>" . $piecesOfData[0] . "</td>\n<td>"
                . $piecesOfData[1] . "</td>\n<td>"
                . $piecesOfData[2] . "</td>\n<td>"
                . $piecesOfData[5] . "</td>\n<td>"
                . $piecesOfData[3] . "</td>\n<td>"
                . $piecesOfData[4] . "</td>\n</tr>";
        } // after this, the table will shown as html
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>

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
    $type = getUserTypeAsText(); // get the user types list from the database
    ?>

    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">View Users</h1>
        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- User Type -->
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
            </div>

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="view-user" id="view-user" value="View Users">
            <?php
            if (isset($feedbackMsg)) {
                echo $feedbackMsg;
                unset($feedbackMsg);
            }
            ?>
        </form>

        <!-- The Table of users -->
        <div class="catalogue-main" style="margin-bottom: 2em;">
            <table id="displayTable" <?php if (isset($tableBody)) echo "style='visibility: visible;'";
                                        else echo "style='visibility: hidden;'" ?>>
                <thead>
                    <tr>
                        <th class="th-color">ID</th>
                        <th class="th-color">Name</th>
                        <th class="th-color">Email</th>
                        <th class="th-color">College</th>
                        <th class="th-color">Department</th>
                        <th class="th-color">Gender</th>
                    </tr>
                </thead>
                <tbody id="newRow">
                    <?php
                    if (isset($tableBody)) {
                        echo $tableBody;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php require("../footer.php") ?>
</body>

</html>