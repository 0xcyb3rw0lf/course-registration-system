


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>

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
    <h1 class="catalogue-header" style="color: #4056A1;">Add New User</h1>

    <form method="post" class="form" style="margin-left: 2.75em;">
           
    <div class="attendance-inner-flex">
                <label for="user-type">Choose User Type:</label><br><br>
                    <select class="selecter" name="user-type" id="user-type">
                        <option value="user-type">Student</option>
                        <option value="user-type">Professor</option>
                        <option value="user-type">Head of Department</option>
                        <option value="user-type">Dean</option>
                        <option value="user-type">Admin</option>
                    </select>
                </div>
                <br><br>
            <div class="attendance-flex">
                <div class="attendance-inner-flex">
                    <label for="user-id">User ID:</label><br><br>
                    <input type="text">
                </div>

                <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                    <label for="user-name">Name:</label><br><br>
                    <input type="text">
                </div>

                <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                    <label for="email">Email:</label><br><br>
                    <input type="text">
                </div>

            </div>
            <br><br><br>
            <div class="attendance-flex">
                <div class="attendance-inner-flex">
                    <label for="password">Password:</label><br><br>
                    <input type="password">
                </div>

                <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                    <label for="college">College:</label><br><br>
                    <select class="selecter" name="college" id="college">
                        <?php
                        foreach ($colleges as $college)
                            echo "<option value='$college'>$college</option>";
                        ?>
                    </select>
                </div>

                <div class="attendance-inner-flex" style="margin-left: 2.5em;">
                    <label for="major">Major:</label><br><br>
                    <select class="selecter" name="major" id="major">
                        <?php
                        foreach ($major as $major)
                            echo "<option value='$major'>$major</option>";
                        ?>
                    </select>
                </div>


            </div>

            <input type="submit" class="butn primary-butn sign-butn no-margin-left margin-top small" name="add-user" id="add-user" value="Add user">
        </form>



            <div class="trip-container payment-trip">
                <?php
                // if ($row = $rows->fetch()) {
                //     $id = $row[0];
                //     $title = $row[1];
                //     $from = $row[2];
                //     $to = $row[3];
                //     $price = $row[4];
                //     $imagePath = $row[6];
                //     $location = $row[5]
                ?>
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
if(isset($_POST['add-user']))
{
    $userid = $_POST['userid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $college = $_POST['college'];
    $major = $_POST['major'];
    $usertype = $_POST['usertype'];

    $query = "INSERT INTO users (userid,name,email,password,college,major,usertype) VALUES ('$userid','$name','$email','$password','$college','$major','$usertype')";
    $query_run = mysqli_query($con, $query);
}
?>
