


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User</title>

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
</head>

<body>

    <?php require("../header.php") ?>


    <main class="payment-main" style="background-color: white; background-image: none; text-align: left;">
        <h1 class="catalogue-header" style="color: #4056A1;">Manage Users</h1>

        <form <?php 
                ?> method="post" class="form" style="margin-left: 2.75em;">
            <div class="attendance-flex">
                <div class="attendance-inner-flex">
                    <label for="course-code">Choose User Type:</label><br><br>
                    <select class="selecter" name="user-type" id="user-type">
                        <option value="user-type">Student</option>
                        <option value="user-type">Professor</option>
                        <option value="user-type">Head of Department</option>
                        <option value="user-type">Dean</option>
                        <option value="user-type">Admin</option>

                    </select>
                </div>

            </div>

            <div class="attendance-inner-flex">
            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="list" id="list" value="Get List">
            <div id="nav"><a href="add-user.php" style="background-color:white"><input type="button" class="butn primary-butn sign-butn no-margin-left margin-top small" name="add" id="add" value="Add New User"></a></div>
        </div>
        

        </form>


        <div class="catalogue-main">

            <form action="list.php">
                <table>
                    <thead>
                        <tr>
                            <th class="th-color">ID</th>
                            <th class="th-color">Name</th>
                            <th class="th-color">Email</th>
                            <th class="th-color">Confirm</th>
                            

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>20200000</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>
                            <input  type="submit" value="Delete User" name="delete-user" class="butn primary-butn">
                            </td>
                        </tr>
                        <tr>
                            <td>20200000</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>
                            <input  type="submit" value="Delete User" name="delete-user" id="delete-user" class="butn primary-butn">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>


                <img class="trip-image" <?php //echo "src=\"/333Project/" . $imagePath . "\"" 
                                        ?> alt="">
                <div class="trip-info">
                    <p class="info" style="color: #4056A1;"><?php //echo $title 
                                                            ?></p>
                    <p class="info">From: <?php //echo $from 
                                            ?></p>
                    <p class="info">To: <?php //echo $to 
                                        ?></p>
                    <p class="info" style="color: #F13C20;"> <?php //echo $price . " BHD" 
                                                                ?></p>
                </div>
                <?php
                // }
                ?>
            </div>
        </div>

    </main>

    <?php require("../footer.php") ?>
</body>

</html>

<?php
if(isset($_POST['delete-user']))
{
    $user_id = $_POST['delete-user'];

    if($_SESSION[''] != $user_id)
    {
        $query = "DELETE FROM users WHERE id='$user_id' ";
        $query_run = mysqli_query($con, $query);

        if($query_run){

        }
            
    }
}
?>