<?php

/**
 * View Students Page
 * allow dean to view students
 * in his/her college
 * @author Omar Eldanasoury
 * @author Mohammed Alammal
 */
session_start();

if (!isset($_SESSION["activeUser"]))
    header("location: /course-registration-system/index.php");

// only dean and heads departments are allowed to view this page, if other users tried to view the page, we prevent them using this code
$isDean = str_contains($_SESSION["userType"], "dean");
$isHod = str_contains($_SESSION["userType"], "head of department");
if (!($isDean xor $isHod)) // if neither the user is dean nor head of department, he should not view this page
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");


$invalidName = false;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>

    <!-- Adding the css files -->
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <!-- Adding the Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

        div {
            margin-bottom: 10px;
        }

        label {
            display: inline-block;
            width: 150px;
            text-align: right;
        }
    </style>



    <!-- Adding FontAwesome Kit -->
    <script src="https://kit.fontawesome.com/163915b421.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php require('../header.php'); ?>

    <main class="" style="background-color: white; background-image: none; text-align: left; ">
        <h1 class="catalogue-header" style="color: #4056A1;">View Students</h1>
        <div id=test>

        </div>
        <form action="" method="post">


            <div class="div">
                <!-- Search Name-->
                <label for="name">Search</label>
                <input type="text" id="name" name="name" placeholder="Search Name" value="<?php $nameValidation = "/^[a-zA-Z]*$/";
                                                                                            if (isset($_POST['name'])) {
                                                                                                if (trim($_POST['name']) != "" && preg_match($nameValidation, $_POST['name'])) {
                                                                                                    echo $_POST['name'];
                                                                                                }
                                                                                            } ?>">
            </div>


            <!-- program selection-->
            <div class="div">
                <label for="program">Program</label>

                <select class="selecter" name="program" id="program">
                    <option value="" <?php if (!isset($_POST['program'])) {
                                            echo "selected";
                                        }   ?>>Choose Program</option>
                    <?php try {
                        require('../connection.php');
                        require_once("../functions.php");
                        $collegeId = getCollegeId($_SESSION["activeUser"][0]);
                        $r = $db->query("SELECT * FROM `program_college` WHERE COLLEGE_ID = $collegeId");
                        $selected = "";
                        while ($row = $r->fetch()) {
                            if (isset($_POST['program'])) {
                                if ($row['program_id'] == $_POST['program']) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                            }

                            echo "<option $selected value=" . $row['program_id'] . ">" . $row['program_name'] . "</option>";
                        }
                    } catch (PDOException $i) {
                        echo "Error occurred";
                        die($i->getMessage());
                    } ?>
                </select>
            </div>

            <!-- Year selection -->

            <div class="div">
                <label for="year">Year</label>

                <select class="selecter" name="year">
                    <option value="" <?php if (!isset($_POST['year'])) {
                                            echo "selected";
                                        }   ?>>Choose Year</option>
                    <?php try {
                        require('../connection.php');
                        $r = $db->query("SELECT DISTINCT year FROM `student_info` WHERE 1");
                        $selected = "";
                        while ($row = $r->fetch()) {
                            if (isset($_POST['year'])) {
                                if ($row['year'] == $_POST['year']) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                            }

                            echo "<option $selected value=" . $row['year'] . ">" . $row['year'] . "</option>";
                        }
                    } catch (PDOException $i) {
                        echo "Error occurred";
                        die($i->getMessage());
                    } ?>
                </select>

            </div>
            <div class="div">
                <input type="submit" class="butn primary-butn sign-butn small" style="margin-left:100px;" name="get-students" id="get-students" value="Search">
            </div>

        </form>


        <div id="studentTable">

            <table>
                <thead>
                    <tr>
                        <th class="th-color">Name</th>
                        <th class="th-color">ID</th>
                        <th class="th-color">Program</th>
                        <th class="th-color">Year</th>
                        <th class="th-color">Credit</th>
                        <th class="th-color">GPA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php try {
                        require('../connection.php');

                        $condition = "1";
                        if (isset($_POST['program'])) {
                            if (trim($_POST['program']) != "") {
                                $condition .= " AND program_id=" . $_POST['program'] . "";
                            }
                        }
                        if (isset($_POST['year'])) {
                            if (trim($_POST['year']) != "") {
                                $condition .= " AND year=" . $_POST['year'] . "";
                            }
                        }
                        $nameValidation = "/^[a-zA-Z ]*$/";
                        if (isset($_POST['name'])) {
                            if (preg_match($nameValidation, $_POST['name'])) {
                                $search = $_POST['name'];
                                $condition .= " AND username LIKE '$search%'";
                            } else {
                                $invalidName = true;
                            }
                        }

                        $r = $db->query("SELECT * FROM `student_info` as s INNER JOIN `program_college` as p on s.prog_id=p.program_id INNER JOIN college as c ON p.college_id=c.college_id INNER JOIN users as u ON s.student_id=u.user_id WHERE $condition");
                        if ($r->rowCount() == 0) {
                            echo "<tr><td colspan='6'>No Results Found!</td></tr>";
                        } else {

                            while ($row = $r->fetch()) {
                                echo "<tr>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['student_id'] . "</td>";
                                echo "<td>" . $row['program_name'] . "</td>";
                                echo "<td>" . $row['year'] . "</td>";
                                echo "<td>" . $row['credits_done'] . "</td>";
                                echo "<td>" . $row['gpa'] . "</td>";
                                echo "</tr>";
                            }
                        }
                    } catch (PDOException $i) {
                        echo "Error occurred";
                        die($i->getMessage());
                    } ?>

                </tbody>
            </table>

        </div>

    </main>


    <?php
    require("../footer.php");

    if ($invalidName) {
    ?>
        <script>
            window.onload = function() {
                alert("Invalid Name Format");
            }
        </script>
    <?php
    }
    ?>


</body>

</html