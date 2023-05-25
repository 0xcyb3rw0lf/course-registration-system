<?php
// session_start();
// if (!isset($_SESSION["activeUser"]))
//     header("location: index.php");

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
        <h1 class="catalogue-header" style="color: #4056A1;">View Students</h1>

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
			<td>Name</td>
            <td>ID</td>
            <td>Gender</td>
			<td>Program</td>
			<td>Year</td>
            <td>Credit</td>
            <td>GPA</td>
		</tr>
	</thead>
	<tbody>
    <?php try{
    require('../connection.php');
    $r = $db->query("SELECT * FROM `student_info` as s INNER JOIN `program_college` as p on s.prog_id=p.program_id INNER JOIN college as c ON p.college_id=c.college_id WHERE 1");

    while($row=$r->fetch()){
    echo"<tr>";
    echo "<td>".$row['firstName']."</td>";
    echo "<td>".$row['student_id']."</td>";
    echo "<td>".$row['gender']."</td>";
    echo "<td>".$row['program_name']."</td>";
    echo "<td>".$row['year']."</td>";
    echo "<td>40</td>";
    echo "<td>".$row['gpa']."</td>";
    echo"</tr>";

    }
    }
    catch(PDOException $i){
    echo "Error occurred";
    die($i->getMessage()); }?>
		<tr>
			<td>David</td>
            <td>232323</td>
			<td>Male</td>
            <td>Computer Science</td>
            <td>2018</td>
			<td>23</td>
            <td>3.2</td>
		</tr>
		<tr>
			<td>Jessica</td>
            <td>241123</td>
			<td>Female</td>
            <td>Computer Science</td>
            <td>2020</td>
			<td>47</td>
            <td>3.4</td>
		</tr>
		<tr>
			<td>Warren</td>
            <td>412353</td>
			<td>Male</td>
            <td>Computer Science</td>
            <td>2021</td>
			<td>12</td>
            <td>2.7</td>
		</tr>
	</tbody>
</table>

    </main>


    <?php
    require("../footer.php");
    ?>
</body>

</html>
