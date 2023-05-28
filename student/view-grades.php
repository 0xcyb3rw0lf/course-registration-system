<?php

/**
 * View Grades Page
 * Allows the student to view grades
 * of current semester
 * 
 * @author Abdulmohsen Abbas
 * @author Omar Eldanasoury 
 */
session_start();
if (!isset($_SESSION["activeUser"]))
    header("location: login.php");

// only admin should access the page
if (!str_contains($_SESSION["userType"], "student"))
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");


$userId = $_SESSION["activeUser"][0];
$userTypeId = $_SESSION["activeUser"][1];
$semId = $_SESSION["activeUser"][2]; // NOT WORKING output:'NULL'  so I used getCurrentSemesterId() instead
require_once("../functions.php");
require_once("../services.php");

$semId = getCurrentSemesterId();
$semName = getSemesterName($semId); // This function don't use the input it give the current semester name
$username = getUserName($userId); // done
$userTypeAsText = getUserTypeAsText($userTypeId);
$college = getCollegeName($userId, $userTypeAsText);
$major = getMajorName($userId, $userTypeAsText);
$delimiter = "-";
list($year, $sem) = explode($delimiter, $semName);
$semester = "Summer Semester";
if ($sem == 1)
    $semester = "First Semester";
elseif ($sem == 2)
    $semester = "Second Semester";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grades</title>

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
    <style>
        .selecter {
            margin-left: 50px;
            width: 70%;
            display: flex;
            flex-wrap: wrap;
        }

        .selecter h3 {
            font-weight: 500;
            margin-bottom: 10px;
        }

        .selecter span {
            font-weight: 400;
            color: black;
        }

        .tableinfo {
            display: flex;
            justify-content: space-around;
            min-height: 10px;
            width: 90%;
            margin: 15px auto;
            color: #4056A1;
            font-weight: 500;
        }

        .tableinfo span {
            font-weight: 400;
            color: black;
        }
    </style>
</head>

<body>

    <?php require("../header.php") ?>

    <main class="payment-main" style="margin-bottom:200px; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Student Grades</h1>
        <div class="selecter" style="display:flex; flex-direction:column;">
            <div class="stuinfo">
                <h3>Student ID: <span><?php echo $userId; ?></span> </h3>
                <h3>Student Name: <span><?php echo $username; ?></span> </h3>
            </div>
            <div class="stuinfo">
                <?php date_default_timezone_set('Asia/Bahrain');
                $currentTime = date('g:i:s a');
                $currentDate = date('d-M-Y'); ?>
                <h3>Date: <span><?php echo $currentDate; ?></span> </h3>
                <h3>Time: <span><?php echo $currentTime; ?></span> </h3>
            </div>
            <div class="stuinfo">
                <h3>College: <span><?php echo $college; ?></span> </h3>
                <h3>Major: <span><?php echo $major; ?></span> </h3>
            </div>
        </div>
        <!-- getCurrentSemesterId -->
        <div class="catalogue-main" style="padding:80px 0;">
            <?php require_once("../functions.php");
            $allSem = getSemesters();
            $totalCredits = array();
            $totalGrades = array();
            $allCreditSum = 0;
            foreach ($allSem as $seminfo) {
                $sem = $seminfo[0];
                $StuGrades = getStudentGrades($sem, $userId);
                $StuCredits = getStudentCredits($sem, $userId);
                for ($i = 0; $i < count($StuGrades); $i++) {
                    $allCreditSum += $StuCredits[$i];
                    array_push($totalCredits, $StuCredits[$i]);
                    array_push($totalGrades, $StuGrades[$i]);
                }
            }
            $stuInfo = getStudentGradesinfo($semId, $userId);
            if (empty(!$stuInfo)) {
                $semCredits = array();
                $semGrades = array();
                $semCreditSum = 0;
            ?>
                <div class="aboveTable tableinfo">
                    <div class="div1" style="width:45%;">
                        <h5>Year: <span><?php echo $year; ?></span> </h5>
                    </div>
                    <div class="div2" style="width:45%;">
                        <h5>Semester: <span><?php echo $semester; ?></span> </h5>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th class="th-color">Course Code</th>
                            <th class="th-color">Course Name</th>
                            <th class="th-color">CH</th>
                            <th class="th-color">Grade</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stuInfo as $Info) {
                            $courseCode = $Info[0];
                            $courseName = $Info[1];
                            $courseCredit = $Info[2];
                            $courseGrade = $Info[3];
                            array_push($semCredits, $courseCredit = $Info[2]);
                            array_push($semGrades, $courseGrade = $Info[3]);
                            array_push($totalCredits, $courseCredit = $Info[2]);
                            array_push($totalGrades, $courseGrade = $Info[3]);
                            $semCreditSum += $courseCredit;
                            $allCreditSum += $courseCredit;

                            echo "<tr>";
                            echo    "<td>" . $courseCode . "</td>";
                            echo    "<td>" . $courseName . "</td>";
                            echo    "<td>" . $courseCredit . "</td>";
                            echo    "<td>" . $courseGrade . "</td>";
                            echo "</tr>";
                        } ?>
                    </tbody>
                </table>

                <?php
                $sgpa = getGPA($semGrades, $semCredits);
                $cgpa = getGPA($totalGrades, $totalCredits);
                ?>
                <div class="beneathTable tableinfo">
                    <div class="div1" style="width:45%;">
                        <h5>Registered Credits: <span><?php echo $semCreditSum; ?></span> </h5>
                    </div>
                    <div class="div2" style="width:45%;">
                        <h5>SGPA: <span><?php echo $sgpa; ?></span> </h5>
                    </div>
                </div>
                <div class="beneathTable tableinfo">
                    <div class="div1" style="width:45%;">
                        <h5>Total Credits: <span><?php echo $allCreditSum; ?></span> </h5>
                    </div>
                    <div class="div2" style="width:45%;">
                        <h5>CGPA: <span><?php echo $cgpa; ?></span> </h5>
                    </div>
                </div>

            <?php
            } else {
            ?>
                <table>
                    <thead>
                        <tr>
                            <th class="th-color">Course Code</th>
                            <th class="th-color">Course Name</th>
                            <th class="th-color">CH</th>
                            <th class="th-color">Grade</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4">You have no registered courses!</td>
                        </tr>
                    </tbody>
                    <table>


                    <?php
                }
                    ?>

        </div>

    </main>

</body>

</html>