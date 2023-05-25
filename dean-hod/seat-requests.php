<?php
//TODO: Show requests of this semester only
//TODO: Fix buttons to make rounded only on edges and not center

session_start();
if (!isset($_SESSION["activeUser"]))
  header("location: ../index.php");

require_once("../functions.php");
$courses = getCourses();

//UPDATE wait_reqs SET request_state = 'Accepted' WHERE request_id = 1;
//Note: Add course to registered courses

if (isset($_POST['submit'])) {
  $request_id = $_POST['submit'];

  $SQL = "UPDATE wait_reqs SET request_state = 1 WHERE request_id = $request_id";

  try {
    //upload data
    require('../connection.php');
    $db->beginTransaction();
    $r = $db->exec($SQL);
    if ($r > 0) {
      $pid = $db->lastInsertId();
    }
    $db->commit();
  } catch (PDOException $i) {
    $db->rollback();
    echo "Error occurred";
    die($i->getMessage());
  }
}

if (isset($_POST['reject'])) {
  $request_id = $_POST['reject'];

  $SQL = "UPDATE wait_reqs SET request_state = 0 WHERE request_id = $request_id";

  try {
    //upload data
    require('../connection.php');
    $db->beginTransaction();
    $r = $db->exec($SQL);
    if ($r > 0) {
      $pid = $db->lastInsertId();
    }
    $db->commit();
  } catch (PDOException $i) {
    $db->rollback();
    echo "Error occurred";
    die($i->getMessage());
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Seat Requests</title>

  <!-- Adding the css files -->
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/style.css">
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

  <?php require('../header.php') ?>


  <main class="" style="background-color: white; background-image: none; text-align: left; ">
    <h1 class="catalogue-header" style="color: #4056A1;">Seat Requests</h1>

    <form method="post" class="form" style="margin-left: 2.75em;">
      <div class="attendance-flex catalogue-main">
        <!-- Course Code and Section Number -->
        <div class="attendance-inner-flex">
          <label for="course-code">Course Code:</label><br><br>
          <select class="selecter" onchange="getSections(this.value)" name="course-code" id="course-code">
            <option value="">Select a Course</option>
            <?php
            if ($courses != array())
              for ($i = 0; $i < count($courses); $i++)
                foreach ($courses[$i] as $id => $code) {
                  echo "<option value='" . strval($id) . "'>" . $code . "</option>";
                }
            ?>
          </select>
        </div>

        <div class="attendance-inner-flex">
          <!-- Section Number -->
          <!-- onchange="showStudents(this.value)" -->
          <label for="section-number">Section Number:</label><br><br>
          <!-- Will be populated automatically by the system after selecting the course code, again by AJAX -->
          <select class="selecter" name="section-number" id="section-number" style="margin-left: 0">
            <option value="">Select a Course First</option>
            <!-- Will be filled by AJAX -->
          </select>
        </div>
      </div>

      <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="search" id="search" value="Search">
      <br><br>
      <?php
      if (isset($feedbackMsg)) {
        echo $feedbackMsg;
        unset($feedbackMsg);
      }
      ?>
    </form>

    <form class="" method="post">


      <table>
        <thead>
          <tr>
            <th class="th-color">Course</th>
            <th class="th-color">Section</th>
            <th class="th-color">ID</th>
            <th class="th-color">Year</th>
            <th class="th-color">Credit</th>
            <th class="th-color">Add Seat</th>
          </tr>
        </thead>
        <tbody>
          <?php try {

            $condition = "";
            if (isset($_POST['course-code'])) {
              if (trim($_POST['course-code']) != "") {
                $condition .= " AND w.course_id=" . $_POST['course-code'] . "";
              }
            }
            if (isset($_POST['section-number'])) {
              if (trim($_POST['section-number']) != "") {
                $condition .= " AND w.section_id=" . $_POST['section-number'] . "";
              }
            }



            require('../connection.php');
            $r = $db->query("SELECT * FROM `wait_reqs` as w INNER JOIN `student_info` as s ON w.student_id=s.student_id INNER JOIN `course` as c ON w.course_id=c.course_id INNER JOIN `course_section` as cs ON w.section_id=cs.section_id WHERE request_state IS NULL $condition");

            while ($row = $r->fetch()) {
              echo "<tr>";
              echo "<td>" . $row['course_code'] . "</td>";
              echo "<td>" . $row['Sec_num'] . "</td>";
              echo "<td>" . $row['student_id'] . "</td>";
              echo "<td>" . $row['year'] . "</td>";
              echo "<td>" . $row['credits_done'] . "</td>";
              echo "<td><button style='padding:10px;background-color: #28a745' type='submit' class='butn primary-butn sign-butn no-margin-left margin-top small' name='submit' value='" . $row['request_id'] . "'>Add<button style='padding:10px;background-color: #dc3545' type='submit' class='butn primary-butn sign-butn no-margin-left margin-top small' name='reject' value='" . $row['request_id'] . "'>Reject</td>";
              echo "</tr>";
            }
          } catch (PDOException $i) {
            echo "Error occurred";
            die($i->getMessage());
          } ?>

        </tbody>
      </table>
    </form>

  </main>


  <?php
  require("../footer.php");
  ?>

  <script type="text/javascript">
    function getSections(courseId) {
      if (courseId == "") {
        return;
      }

      const request = new XMLHttpRequest();
      request.onload = showSections;
      request.open("GET", "../admin/getSections.php?cid=" + courseId);
      request.send();
    }

    function showSections() {
      clearSectionNumber();
      if (this.responseText.length == 0) {
        document.getElementById("section-number").innerHTML += "\n<option value=''>No Sections Available</option>";
        return
      }
      results = this.responseText.split("#");
      for (let result of results) {
        idAndNum = result.split("@");
        if (idAndNum[0] == '')
          continue;
        document.getElementById("section-number").innerHTML += "\n<option value='" + idAndNum[0] + "'>" + idAndNum[1] + "</option>";
      }
    }

    /**@function clearSectionNumber
     * clears the html that shows the section number
     */
    function clearSectionNumber() {
      document.getElementById("section-number").innerHTML = "<option value=''>Select a Section</option>";

    }
  </script>
</body>

</html>