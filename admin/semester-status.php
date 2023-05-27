<?php

/**
 * Semester Status Page
 * Allows the admin user to 
 * Manage Semester Status from the system
 * 
 * @author Omar Eldansoury
 * @author Elyas Raed
 */
session_start();
if (!isset($_SESSION["activeUser"])) // if the user is not logged in he will be redirected to the sign up page
    header("location: /course-registration-system/login.php");

// only admin should access the page
if (!str_contains($_SESSION["userType"], "admin"))
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");

if (isset($_POST["manage-status"])) {
    require_once("../functions2.php");
    // first get data
    $semName = checkInput($_POST["sem-name"]);
    $semStatus = checkInput($_POST["sem-status"]);

    // then validate user input
    if ($semName == "" or $semStatus == "") { // if the admin user didn't choose a value for the semester name or status
        $feedbackMsg = "<span class='failed-feedback'>Please select a semester and status!</span>";
    } else if (getCurrentSemesterId() != null and intval($semStatus) == 1) {
        // if the user want to update a semester to be current semester while there is a current semester in the system
        /**
         * Here, we should prevent the user from updating the state
         * as the database should not have 2 semesters with the same
         * "in progress" state.
         * Hence, the user should first mark the current "in progress" semester
         * as finished, then update the chosen semester to be the current one.
         * 
         * @author Omar Eldanasoury
         */
        $feedbackMsg = "<span class='failed-feedback'>Cannot have 2 semester with In Progress state, Please mark the current semester as finished then try again!</span>";
    } else {
        // then update the status
        if (updateStatus($semStatus, $semName)) {
            $feedbackMsg = "<span class='success-feedback'>Semester Status is updated successfully!</span>";
        } else {
            $feedbackMsg = "<span class='failed-feedback'>Error updating status<br>Please try again later!</span>";
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
    <title>Manage Semester Status</title>

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
    // Required varialbes for updating the semester status
    $semesters = getSemesters(); // get the semesters list from the database
    ?>

    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Manage Semester Status</h1>
        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- Semester Names -->
                <div class="attendance-inner-flex">
                    <label for="sem-name">Semester Name:</label><br><br>
                    <select class="selecter" name="sem-name" id="sem-name">
                        <option value="">Select a Semester</option>
                        <?php
                        if ($semesters != array())
                            for ($i = 0; $i < count($semesters); $i++)
                                foreach ($semesters[$i] as $id => $name) {
                                    echo "<option value='" . strval($id) . "'>" . $name . "</option>";
                                }
                        ?>
                    </select>
                </div>

                <div class="attendance-inner-flex">
                    <label for="sem-status">Semester Status:</label><br><br>
                    <select class="selecter" name="sem-status" id="sem-status">
                        <option value="">Select a Status</option>
                        <option value="0">Has Not Started Yet</option>
                        <option value="1">In Progress (Current Semester)</option>
                        <option value="2">Semester is Finished</option>
                    </select>
                </div>

            </div>


            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" onclick="return confirm('Are you sure you want to update this semesters status?')" name="manage-status" id="manage-status" value="Update Status">
            <?php
            if (isset($feedbackMsg)) {
                echo $feedbackMsg;
                unset($feedbackMsg);
            }
            ?>

        </form>
        <table style="margin-bottom: 2.75em;">
            <thead>
                <tr>
                    <th class="th-color">Semester ID</th>
                    <th class="th-color">Semester Name</th>
                    <th class="th-color">Semester Status</th>
                </tr>
            </thead>
            <tbody>
                <?php try {
                    require('../connection.php');
                    $r = $db->query("SELECT * FROM `semester` ORDER BY SEM_ID");

                    while ($row = $r->fetch()) {
                        echo "<tr>";
                        echo "<td>" . $row['sem_id'] . "</td>";
                        echo "<td>" . $row['sem_name'] . "</td>";
                        echo "<td>" . ($row['sem_status'] == 2 ? "Semester is Finished" : ($row['sem_status'] == 1 ? "In Progress (Current Semester)" : "Has Not Started Yet!")) . "</td>";
                        // echo "<td></td>";
                        echo "</tr>";
                    }
                } catch (PDOException $i) {
                    echo "Error occurred";
                    die($i->getMessage());
                } ?>
            </tbody>
        </table>

    </main>

    <?php require("../footer.php") ?>
</body>

</html>