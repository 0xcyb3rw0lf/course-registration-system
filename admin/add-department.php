<?php

/**
 * Add Department Page
 * Allows the admin user to 
 * add departments to the system
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


if (isset($_POST["add-department"])) {
    require_once("../functions2.php");

    // Adding the program
    $collegeId = $_POST["college-name"];
    $dname = $_POST["department-name"];

    // Validate/ check for empty values
    if (
        empty($collegeId)
        or empty($dname)
    ) {
        $feedbackMsg = "<span class='failed-feedback'>Please enter all fields as required!</span>";
    } else {
        try {
            if (addDepartment($dname, $collegeId)) {
                $feedbackMsg = "<span class='success-feedback'>Department is Added Successfully!</span>";
            } else {
                $feedbackMsg = "<span class='failed-feedback'>Error Adding Department!</span>";
            }
        } catch (Exception $exception) { // send error if department already exists
            $feedbackMsg = "<span class='failed-feedback'>Department Already Exists, Please Choose a New Department Name!</span>";
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
    <title>Add Department</title>

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
    // Required varialbes for adding the program
    $collegeName = getCollegeName(); // get the colleges list from the database
    ?>

    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Add Department</h1>

        <form method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex catalogue-main">
                <!-- College Name, Department Name, and HOD -->
                <div class="attendance-inner-flex">
                    <label for="college-id">College Name:</label><br><br>
                    <select class="selecter" name="college-name" id="college-name">
                        <option value="">Select a College</option>
                        <?php
                        if ($collegeName != array())
                            for ($i = 0; $i < count($collegeName); $i++)
                                foreach ($collegeName[$i] as $id => $name) {
                                    echo "<option value='" . strval($id) . "'>" . $name . "</option>";
                                }
                        ?>
                    </select>
                    <br><br>
                </div>

                <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                    <label for="department-name">Department Name:</label><br><br>
                    <input type="text" class="selecter" name="department-name" id="department-name">
                    </select>
                    <br><br>
                </div>


            </div>

            </div>

            <input onclick="return confirm('Are you sure you want to add a department?')" type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="add-department" id="add-department" value="Add a Department">
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

</html>