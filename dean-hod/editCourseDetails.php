<?php
// session_start();
// if (!isset($_SESSION["activeUser"]))
//     header("location: index.php");

//UPDATE course SET course_code = 'ITCS214',course_name='DATA STRUCTURES',credits=3 WHERE course_id = 13

if(isset($_POST['submit'])){

  $courseCode = $_POST["courseCode"];
  $courseName = $_POST["courseName"];
  $credits = $_POST["credits"];
  $validation = "/^([a-zA-Z 0-9]+)(?![_.])(?!.*[_.]{2})$/";

if (trim($courseCode)=="" || trim($courseName)=="" || trim($credits)=="" || empty($_POST['Course']))
      echo  "There is missing information";
  else{
    if(!preg_match($validation , $courseName) || !preg_match($validation , $courseCode)){
      echo"error";

    }
    else{
      $SQL = "UPDATE course SET course_code = '$courseCode',course_name='$courseName',credits=$credits WHERE course_code = '".$_POST["Course"]."'";

      try {
        //upload data
          require('../connection.php');
          $db->beginTransaction();
          $r = $db->exec($SQL);
          if($r>0){
            $pid = $db->lastInsertId();
          }
          $db->commit();


        }
        catch(PDOException $i){
          $db->rollback();
        echo "Error occurred";
        die($i->getMessage()); }
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
    <title>Home</title>

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

    <?php require('../header.php') ?>


    <main class="" style="background-color: white; background-image: none; text-align: left; ">
        <h1 class="catalogue-header" style="color: #4056A1;">Edit Course Details</h1>
        <form class="" action="editCourseDetails.php" method="post">
        <label for="Course">Course:</label>
        <select class="selecter" name="Course">
          <option value="" disabled selected>Choose Course</option>
          <?php try{
          require('../connection.php');
          $r = $db->query("SELECT * FROM `course` WHERE 1");

          while($row=$r->fetch()){
          echo "<option value=".$row['course_code'].">".$row['course_code']."</option>";
          }
          }
          catch(PDOException $i){
          echo "Error occurred";
          die($i->getMessage()); }?>
        </select>

        <br>
        <br><br>


        <h2 class="catalogue-header" style="color: #4056A1">New Course Details</h2>

          <div class="div">
            <label for="courseCode">Course Code:</label>
            <input type="text" name="courseCode"  placeholder="Pick Course" value="">
            <br>
          </div>

          <div class="div">
            <label for="courseName">Course Name:</label>
            <input type="text" name="courseName" placeholder="Pick Course" value="">
            <br>
          </div>

          <div class="div">
            <label for="credits">Credits:</label>
            <input type="text" name="credits" placeholder="Pick Course" value="">
            <br>
          </div>

          <div class="div">
            <label for="preReq">Pre-Requisite:</label>
            <select class="selecter" name="preReq">
              <option value="itcs489">ITCS321</option>
            </select>
          </div>


          <button style="margin-left:50px" class="butn primary-butn sign-butn no-margin-left margin-top small" type="submit" name="submit" value="submit">Submit</button>

        </form>

        </div>



    </main>


    <?php
    require("../footer.php");
    ?>
</body>

</html>
