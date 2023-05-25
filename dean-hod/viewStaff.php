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

    <?php require("../header.php") ?>


    <main class="" style="background-color: white; background-image: none; text-align: left; ">
        <h1 class="catalogue-header" style="color: #4056A1;">View Staff</h1>

        <!-- Department selection -->
        <label for="department" class="catalogue-h2" style="font-size: 1.5em">Department</h2>
        <br>
        <select name="department" id="department" class="catalogue-h2" style="font-size: 1em">
          <option value="itcs489">Computer Engineering</option>
        </select>


        <br><br><br><br>

        <table>
	<thead>
		<tr>
			<td>Name</td>
            <td>ID</td>
            <td>College</td>
			<td>Department</td>
			<td>Courses</td>
		</tr>
	</thead>
	<tbody>
    <?php try{
    require('../connection.php');
    $r = $db->query("SELECT * FROM `users` as u INNER JOIN `college` as c ON u.college_id=c.college_id INNER JOIN `department` as d ON u.dep_id=d.dep_id WHERE type_id=1");

    while($row=$r->fetch()){
    echo"<tr>";
    echo "<td>".$row['username']."</td>";
    echo "<td>".$row['user_id']."</td>";
    echo "<td>".$row['college_name']."</td>";
    echo "<td>".$row['dep_name']."</td>";
    echo "<td>3</td>";
    echo"</tr>";

    }
    }
    catch(PDOException $i){
    echo "Error occurred";
    die($i->getMessage()); }?>

	</tbody>
</table>

    </main>


    <?php
    require("../footer.php");
    ?>
</body>

</html>
