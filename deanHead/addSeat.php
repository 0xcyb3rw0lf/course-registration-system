<?php
// session_start();
// if (!isset($_SESSION["activeUser"]))
//     header("location: index.php");

//UPDATE wait_reqs SET request_state = 'Accepted' WHERE request_id = 1;

if(isset($_POST['submit'])){
      $request_id = $_POST['submit'];

      $SQL = "UPDATE wait_reqs SET request_state = 'Accepted' WHERE request_id = $request_id";

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

        table {
        	border-collapse: collapse;
            font-family: Tahoma, Geneva, sans-serif;
            margin: 0 auto;
        }
        table td {
        	padding: 15px;
        }
        table thead td {
        	background-color: #54585d;
        	color: #ffffff;
        	font-weight: bold;
        	font-size: 1em;
        	border: 1px solid #54585d;
        }
        table tbody td {
        	color: #636363;
        	border: 1px solid #54585d;
        }
        table tbody tr {
        	background-color: #f9fafb;
        }
        table tbody tr:nth-child(odd) {
        	background-color: #ffffff;
        }
        table tbody td:first-child {
        	color: brown;
        }


    </style>



    <!-- Adding FontAwesome Kit -->
    <script src="https://kit.fontawesome.com/163915b421.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php require('../header.php') ?>


    <main class="" style="background-color: white; background-image: none; text-align: left; ">
        <h1 class="catalogue-header" style="color: #4056A1;">Seat Requests</h1>
        <form class="" action="addSeat.php" method="post">


        <!-- Course selection -->
        <label for="course" class="catalogue-h2" style="font-size: 1.5em">Course</h2>
        <br>
        <select name="course" id="course" class="catalogue-h2" style="font-size: 1em">
          <option value="itcs489">ITCS489</option>
        </select>
        <br><br>

        <!-- Section will only be shown after a course has been chosen, or it will be empty with no choices until course selection -->
        <label for="section" class="catalogue-h2" style="font-size: 1em">Section</h2>
        <br>
        <select name="section" id="section" class="catalogue-h2" style="font-size: 1em">
          <option value="section3">Section 3</option>
        </select>
        <br><br><br><br>

        <table>
	<thead>
		<tr>
			<td>Course</td>
      <td>Section</td>
            <td>ID</td>
			<td>Year</td>
			<td>Credit</td>
            <td>Add Seat</td>
		</tr>
	</thead>
	<tbody>
    <?php try{
    require('../connection.php');
    $r = $db->query("SELECT * FROM `wait_reqs` as w INNER JOIN `student_info` as s ON w.student_id=s.student_id INNER JOIN `course` as c ON w.course_id=c.course_id INNER JOIN `course_section` as cs ON w.section_id=cs.section_id WHERE request_state IS NULL");

    while($row=$r->fetch()){
    echo"<tr>";
    echo "<td>".$row['course_code']."</td>";
    echo "<td>".$row['Sec_num']."</td>";
    echo "<td>".$row['student_id']."</td>";
    echo "<td>".$row['year']."</td>";
    echo "<td>40</td>";
    echo "<td><button style='padding:10px' type='submit' class='butn primary-butn sign-butn no-margin-left margin-top small' name='submit' value='".$row['request_id']."'>Add</td>";
    echo"</tr>";

    }
    }
    catch(PDOException $i){
    echo "Error occurred";
    die($i->getMessage()); }?>

	</tbody>
</table>
</form>

    </main>


    <?php
    require("../footer.php");
    ?>
</body>

</html>
