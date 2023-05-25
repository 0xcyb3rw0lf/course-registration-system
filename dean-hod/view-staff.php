<?php

/**
 * View Staff Page
 * allows dean to view staff
 * of his college.
 * 
 * @author Omar Eldanasoury
 * @author Mohammed Alammal
 */
session_start();
if (!isset($_SESSION["activeUser"]))
    header("location: /course-registration-system/index.php");

// only dean is allowed to view this page, if other users tried to view the page, we prevent them using this code
if ($_SESSION["userType"] != "dean")
    die("You are not allowed to view this page, <a href='/course-registration-system/index.php'>Click Here to Return to Home Page Here!</a>");

$invalidName = false;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Staff</title>

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

    <?php require("../header.php") ?>


    <main class="" style="background-color: white; background-image: none; text-align: left; ">
        <h1 class="catalogue-header" style="color: #4056A1;">View Staff</h1>

        <form class="" action="" method="post">

            <div class="div">
                <!-- Search Name-->
                <label for="name">Search</label>
                <input type="text" id="name" name="name" placeholder="Search Name" value="<?php $nameValidation = "/^[a-zA-Z ]*$/";
                                                                                            if (isset($_POST['name'])) {
                                                                                                if (trim($_POST['name']) != "" && preg_match($nameValidation, $_POST['name'])) {
                                                                                                    echo $_POST['name'];
                                                                                                }
                                                                                            } ?>">
            </div>


            <!-- program selection-->
            <div class="div">
                <label for="department">Department</label>

                <select class="selecter" name="department" id="department">
                    <option value="" <?php if (!isset($_POST['department'])) {
                                            echo "selected";
                                        }   ?>>Choose Department</option>
                    <?php try {
                        require('../connection.php');
                        require_once("../functions.php");
                        $collegeId = getCollegeId($_SESSION["activeUser"][0]);
                        // the system should only show the departments
                        // of the college that the dean is managing
                        $r = $db->query("SELECT * FROM `department` WHERE COLLEGE_ID = $collegeId");
                        $selected = "";
                        while ($row = $r->fetch()) {
                            if (isset($_POST['department'])) {
                                if ($row['dep_id'] == $_POST['department']) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                            }

                            echo "<option $selected value=" . $row['dep_id'] . ">" . $row['dep_name'] . "</option>";
                        }
                    } catch (PDOException $i) {
                        echo "Error occurred";
                        die($i->getMessage());
                    } ?>
                </select>
            </div>


            <div class="div">
                <input type="submit" class="butn primary-butn sign-butn small" style="margin-left:100px;" name="attendance" id="attendance" value="Search">
            </div>


        </form>


        <table>
            <thead>
                <tr>
                    <th class="th-color">Name</th>
                    <th class="th-color">ID</th>
                    <th class="th-color">User Type</th>
                    <th class="th-color">Department</th>
                    <th class="th-color">Courses</th>
                </tr>
            </thead>
            <tbody>
                <?php try {
                    require('../connection.php');

                    $condition = "";
                    if (isset($_POST['department'])) {
                        if (trim($_POST['department']) != "") {
                            $condition .= " AND u.dep_id=" . $_POST['department'] . "";
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


                    $r = $db->query("SELECT * FROM `users` as u INNER JOIN `college` as c ON u.college_id=c.college_id INNER JOIN `department` as d ON u.dep_id=d.dep_id INNER JOIN user_type as ut ON u.type_id=ut.type_id WHERE (u.type_id=1 OR u.type_id=5) $condition");

                    if ($r->rowCount() == 0) {
                        echo "<tr><td colspan='5'>No Results Found!</td></tr>";
                    } else {
                        while ($row = $r->fetch()) {
                            echo "<tr>";
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['user_id'] . "</td>";
                            echo "<td>" . $row['user_type'] . "</td>";
                            echo "<td>" . $row['dep_name'] . "</td>";
                            echo "<td>3</td>";
                            echo "</tr>";
                        }
                    }
                } catch (PDOException $i) {
                    echo "Error occurred";
                    die($i->getMessage());
                } ?>

            </tbody>
        </table>

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

</html>