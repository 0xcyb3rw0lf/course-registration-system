<?php

/**
 * View Course Schedule Page
 * Allows student to view
 * his/her course schedule
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
$semId = $_SESSION["activeUser"][2];
require_once("../functions.php");
require_once("../services.php");
$username = getUserName($userId); // done
$userTypeAsText = getUserTypeAsText($userTypeId);
$semesterName = getSemesterName($semId); //done
$major = getMajorName($userId, $userTypeAsText); // DONE
$college = getCollegeName($userId, $userTypeAsText);
$department = getDepartmentName($userId, $userTypeAsText);
$pCourseSectionIDs = getCourseSSectionsPaymentStatusArray($userId); //Get course_id Section_id Payment_status
$regiseredCH = 0;
foreach ($pCourseSectionIDs as $val) {
    $curID = $val[0];
    $cInfo = getCourseInfo($curID);
    $regiseredCH += $cInfo[2];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Schedule</title>

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
    </style>
</head>

<body>
    <?php require("../header.php") ?>

    <main class="payment-main" style="margin-bottom:200px; background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Course Schedule</h1>
        <div class="selecter" style="display:flex; flex-direction:column;">
            <div class="stuinfo">
                <h3>Student ID: <span><?php echo $userId; ?></span> </h3>
                <h3>Student Name: <span><?php echo $username; ?></span> </h3>
            </div>
            <div class="stuinfo">
                <h3>Major: <span><?php echo $major; ?></span> </h3>
                <h3>Registered CH: <span><?php echo $regiseredCH ?></span> </h3>
            </div>
            <div class="stuinfo">
                <h3>Acadimiv Year: <span><?php echo $semesterName; ?></span> </h3>
                <h3>College: <span><?php echo $college; ?></span> </h3>
            </div>
        </div>

        <div class="catalogue-main">

            <form action="list.php">
                <table>
                    <thead>
                        <tr>
                            <th class="th-color">Course Code</th>
                            <th class="th-color">Days</th>
                            <th class="th-color">Time</th>
                            <th class="th-color">Building</th>
                            <th class="th-color">Room</th>
                            <th class="th-color">CH</th>
                            <th class="th-color">Paid</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if ($pCourseSectionIDs != array()) {

                            foreach ($pCourseSectionIDs as $Info) {
                                $courseID = $Info[0];
                                $SectionID = $Info[1];
                                $SectionData = getSectionData($SectionID);
                                $days = $SectionData['lec_days'];
                                $time = $SectionData['lec_time'];
                                $room_id = $SectionData['room_id'];
                                $roomName = getRoomName($room_id);
                                $courseData = getCourseInfo($courseID);
                                $courseCode = $courseData[0];
                                $courseName = $courseData[1]; //  Course Name Here in case we need it 
                                $courseCH = $courseData[2];
                                $building_id = getBuildingId($room_id);
                                $building_name = getBuildingName($building_id);

                                echo "<tr>";
                                echo    "<td>" . $courseCode . "</td>";
                                echo    "<td>" . $days . "</td>";
                                echo    "<td>" . $time . "</td>";
                                echo    "<td>" . $building_name . "</td>";
                                echo    "<td>" . $roomName . "</td>";
                                echo    "<td>" . $courseCH . "</td>";
                                $paid = "No";
                                if ($Info[2] == 1)
                                    $paid = "Yes";
                                echo    "<td>" . $paid . "</td>"; //CH
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>You have no courses registered yet!</td></tr>";
                        } ?>
                    </tbody>
                </table>
            </form>

        </div>
        </div>

    </main>

    <?php require("../footer.php") ?>
</body>

</html>