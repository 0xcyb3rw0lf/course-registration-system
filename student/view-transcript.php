<?php

/**
 * View Transcript Page
 * Allows student to view his transcript
 * 
 * @author Abdulmohsen Abbas
 */
session_start();
if (!isset($_SESSION["activeUser"]))
    header("location: /course-registration-system/login.php");

// only admin should access the page
if (!str_contains($_SESSION["userType"], "student"))
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");


$userId = $_SESSION["activeUser"][0];
$userTypeId = $_SESSION["activeUser"][1];
$semId = $_SESSION["activeUser"][2];
require_once("../functions.php");
require_once("../services.php");
$username = getUserName($userId); // done
$userTypeAsText = getUserTypeAsText($userTypeId);
$semesterName = getSemesterName($semId); //done
$major = getMajorName($userId, $userTypeAsText); // DONE
$college = getCollegeName($userId, $userTypeAsText);
$department = getDepartmentName($userId, $userTypeAsText);


$del = "-";
list($currentYear, $currentSem) = explode($del, $semesterName);
$currentSemester = "Summer Semester";
if ($currentSem == 1)
    $currentSemester = "First Semester";
elseif ($currentSem == 2)
    $currentSemester = "Second Semester";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transcript</title>

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
            padding: 25px 0 0 0;
            width: 90%;
            margin: 15px auto;
            color: #4056A1;
            font-weight: 500;
        }

        .aboveTable {
            border-top: 2px dotted gray;
        }
    </style>
</head>

<body>

    <?php require("../header.php") ?>

    <main class="payment-main" style="margin-bottom:200px; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Academic Transcript</h1>
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
                <h3>Academic Year: <span><?php echo $currentYear . " " . $currentSemester; ?></span> </h3>
                <h3>College: <span><?php echo $college; ?></span> </h3>
            </div>
        </div>

        <div class="catalogue-main" style="padding:80px 0;">
            <?php require_once("../functions.php");
            $prevsem = getPreviousSemesters();
            $totalCredits = array();
            $totalGrades = array();
            $allCreditSum = 0;
            foreach ($prevsem as $seminfo) {
                $semId = $seminfo[0];
                $semName = $seminfo[1];
                $stuInfo = getStudentGradesinfo($semId, $userId);
                if (empty(!$stuInfo)) {

                    $delimiter = "-";
                    list($year, $sem) = explode($delimiter, $semName);
                    $semester = "Summer Semester";
                    if ($sem == 1)
                        $semester = "First Semester";
                    elseif ($sem == 2)
                        $semester = "Second Semester";

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
                                echo    "<td>" . $semName . "</td>";
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
                    // student have no registered courses
                ?>
                    <table>
                        <thead>
                            <tr>
                                <th class="th-color">Semester</th>
                                <th class="th-color">Course Code</th>
                                <th class="th-color">Course Name</th>
                                <th class="th-color">CH</th>
                                <th class="th-color">Grade</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="1"><?php echo $semName ?></td>
                                <td colspan="4">You have no registered courses!</td>
                            </tr>
                        </tbody>


                <?php
                }
            }
                ?>
        </div>


    </main>

</body>

</html>