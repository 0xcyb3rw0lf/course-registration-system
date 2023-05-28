<?php

/**
 * Simulate GPA Page
 * Allows students to calculate
 * the next Commulative GPA using
 * the values they insert inside the system.
 * 
 * @author Abdulmohsen Abbas
 * @author Omar Eldanasoury
 */
session_start();
if (!isset($_SESSION["activeUser"]))
    header("location: /course-registration-system/login.php");

// only admin should access the page
if (!str_contains($_SESSION["userType"], "student"))
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");

$userId = $_SESSION["activeUser"][0];
$userTypeId = $_SESSION["activeUser"][1];
require_once("../functions.php");
require_once("../services.php");

$semId = getCurrentSemesterId();
$semName = getSemesterName($semId); // This function don't use the input it give the current semester name
$username = getUserName($userId); // done
$userTypeAsText = getUserTypeAsText($userTypeId);
$college = getCollegeName($userId, $userTypeAsText);
$major = getMajorName($userId, $userTypeAsText);
$studentGPA = getStudentGPA($userId);

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
    <title>GPA Simulator</title>

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

        .innerDiv {
            width: 45%;
        }

        .formSelector {
            width: 80px;
            height: 40px;
            padding: 0px;
            margin: 0 auto;
            cursor: pointer;
        }

        .buttonsDiv {
            width: 90%;
            display: flex;
            justify-content: space-around;
            margin: 7px 0 7px 70px;
        }

        .butn {
            padding: 15px 50px;
            margin: 12px;
            cursor: pointer;
        }

        @media (max-width:700px) {
            .tableinfo {
                width: 95%;
                flex-direction: column;
            }

            .innerDiv {
                width: 95%;
            }

            .buttonsDiv {
                width: 90%;
                display: flex;
                flex-direction: column;
                margin: 7px 0 7px 7px;

            }

            h5 {
                margin: 0.5em 0;
            }
        }
    </style>
</head>

<body>

    <?php require("../header.php") ?>

    <main class="payment-main" style="margin-bottom:200px; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">GPA Simulator</h1>
        <div class="selecter" style="display:flex; flex-direction:column;">
            <div class="aboveTable tableinfo">
                <div class="innerDiv">
                    <h5>Student Name: <span><?php echo $username; ?></span> </h5>
                </div>
                <div class="innerDiv">
                    <h5>Student ID: <span><?php echo $userId; ?></span> </h5>
                </div>
            </div>
            <div class="aboveTable tableinfo">
                <div class="innerDiv">
                    <h5>College: <span><?php echo $college; ?></span> </h5>
                </div>
                <div class="innerDiv">
                    <h5>Major: <span><?php echo $major; ?></span> </h5>
                </div>
            </div>
            <div class="aboveTable tableinfo">
                <div class="innerDiv">
                    <h5>Year: <span><?php echo $year; ?></span> </h5>
                </div>
                <div class="innerDiv">
                    <h5>Semester: <span><?php echo $semester; ?></span> </h5>
                </div>
                <div class="innerDiv">
                    <h5>Current GPA: <span><?php echo $studentGPA; ?></span> </h5>
                </div>
            </div>
        </div>
        </div>

        <div class="catalogue-main" style="padding:80px 0;">
            <?php require_once("../functions.php");
            $prevSem = getPreviousSemesters();
            $totalCredits = array();
            $totalGrades = array();
            $allCreditSum = 0;
            foreach ($prevSem as $seminfo) {
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
                $c = 0;
            ?>

                <table style="margin:0 auto;">
                    <thead>
                        <tr>
                            <th class="th-color">Course Code</th>
                            <th class="th-color">Course Name</th>
                            <th class="th-color">CH</th>
                            <th class="th-color">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="post" class="form" style="margin-left: 2.75em;">
                            <?php foreach ($stuInfo as $Info) {
                                $courseCode = $Info[0];
                                $courseName = $Info[1];
                                $courseCredit = $Info[2];
                                array_push($semCredits, $courseCredit);
                                array_push($totalCredits, $courseCredit); // we need this because getGPA function take two arrays as inputs
                                $semCreditSum += $courseCredit; // we need these to show the registered credits
                                $allCreditSum += $courseCredit; // we need these to show the total credits

                                echo "<tr>";
                                echo    "<td>" . $courseCode . "</td>";
                                echo    "<td>" . $courseName . "</td>";
                                echo    "<td>" . $courseCredit . "</td>";
                            ?>
                                <td>
                                    <select class="selecter formSelector" name="studentGrades[]">
                                        <option value="A">A</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B">B</option>
                                        <option value="B-">B-</option>
                                        <option value="C+">C+</option>
                                        <option value="C">C</option>
                                        <option value="C-">C-</option>
                                        <option value="D+">D+</option>
                                        <option value="D">D</option>
                                        <option value="F">F</option>
                                    </select>
                                </td>
                                </tr>

                            <?php }  // End of foreach($stuInfo as $Info) 
                            ?>
                    </tbody>
                </table>

                <div class="buttonsDiv">
                    <input type="submit" class="butn primary-butn sign-butn" name="calculate" value="Calculate SGPA & CGPA">
                    <input type="reset" class="butn primary-butn sign-butn" value="Reset">

                </div>


                </form>
            <?php
            } // End of if(empty(!$stuInfo))
            ?>

        </div>


        <?php

        if (isset($_POST['calculate'])) {
            $expectedGrades = $_POST['studentGrades'];
            for ($i = 0; $i < count($expectedGrades); $i++) {
                array_push($totalGrades, $expectedGrades[$i]);
            }
            $sgpa = getGPA($expectedGrades, $semCredits);
            $cgpa = getGPA($totalGrades, $totalCredits);


        ?>
            <div class="beneathTable tableinfo">
                <div class="innerDiv">
                    <h5>Registered Credits: <span><?php echo $semCreditSum; ?></span> </h5>
                </div>
                <div class="innerDiv">
                    <h5>SGPA: <span><?php echo $sgpa; ?></span> </h5>
                </div>
            </div>
            <div class="beneathTable tableinfo">
                <div class="innerDiv">
                    <h5>Total Credits: <span><?php echo $allCreditSum; ?></span> </h5>
                </div>
                <div class="innerDiv">
                    <h5>CGPA: <span><?php echo $cgpa; ?></span> </h5>
                </div>
            </div>

        <?php } ?>
    </main>

    <?php require("../footer.php") ?>
</body>

</html>