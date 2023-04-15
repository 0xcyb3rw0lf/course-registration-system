<?php

/**
 * OMAR AHMED REFAAT ELDANASOURY, 202005808
 * ITCS333-SEC 03 , COURSE PROJECT, ALONE
 */
if (isset($_POST["signup"]) and !isset($_SESSION["activeUser"])) {
    require("functions.php");
    // get the data
    // the input is filtered


    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["cpassword"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];

    $msg = "";


    if (preg_match("/^[a-zA-z]\w+$/i", $username) == 0)
        $msg .= "Invalid Username!<br>";

    if (preg_match("/^[a-zA-Z0-9\._\-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/i", $email) == 0)
        $msg .= "Invalid Email!<br>";


    if (preg_match("/^[\w!@#$%^&*()]{8,}$/i", $password) == 0)
        $msg .= "Invlaid Password, it must be more than 8 characters!<br>";



    if ($password != $confirmPassword) {
        $msg .= "Passwords must be identical!<br>";
    }

    if (!isset($_POST["agree"]))
        $msg .= "You must agree to terms and conditions!<br>";


    if ($msg != "")
        header("location: signup.php?err=$msg");
    else {

        $username = checkInput($_POST["username"]);
        $password = checkInput($_POST["password"]);
        $confirmPassword = checkInput($_POST["cpassword"]);
        $email = checkInput($_POST["email"]);
        $gender = checkInput($_POST["gender"]);
        //     // convert password to sha:
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // then we add to the database
        try {
            require("connection.php");
            $sql = "INSERT INTO USERS VALUES (null, ?, ?, ?, ?, null)";
            $db->beginTransaction();
            $statement = $db->prepare($sql);
            $statement->execute(array($username, $email, $hashed_password, $gender));

            if ($statement->rowCount() != 1) {
                throw new PDOException();
            }

            $db->commit();
            $bd = null;
        } catch (PDOException $e) {
            $db->rollBack();
            echo "Error: " . $e->getMessage();
        }
        // and set the session for the user

        // then we get the id of the user as we need it:
        try {
            $rows = $db->query("SELECT USERID FROM USERS WHERE EMAIL = '$email'");
            $db = null;
            if ($row = $rows->fetch())
                $id = $row[0];
            else
                throw new PDOException();
        } catch (PDOException $ex) {
            echo "Error " . $ex->getMessage();
        }

        session_start();
        $_SESSION["activeUser"] = array($id, $username, $email);
        header("location: home.php");
    }
} else if (isset($_SESSION["activeUser"]))
    header("location: home.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <!-- Adding the css files -->
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css" />

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

    <?php require("header.php") ?>


    <main>
        <section class="sign-form">

            <h1 style="font-size: 2em; color: white;">Sign Up</h1>
            <br>
            <form action="" method="post" style="color: white;">
                <label for="username">Username:*</label>
                <br>
                <input type="text" placeholder="your_username" name="username" id="username">
                <br>

                <label for="email">Email:*</label><br>
                <input type="text" placeholder="email@example.com" name="email" id="email">
                <br>

                <label for="gender">Gender:*</label><br>
                <select class="selecter" name="gender" id="gender">
                    <option value="" selected>Choose Your Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <br><br>

                <label for="password">Password:*</label><br>
                <input type="password" placeholder="***********" name="password" id="password">
                <br>

                <label for="confirm-password">Confirm Password:*</label><br>
                <input type="password" placeholder="***********" name="cpassword" id="confirm-password">
                <br>

                <br>
                <input type="checkbox" name="agree" class="css-checkbox" id="agree">
                <label for="agree">I Agree to All Terms and Conditions</label>
                <br>
                <br>
                <input type="submit" class="butn primary-butn sign-butn" name="signup" id="signup" value="Sign Up!">
                <?php
                if (isset($_GET["err"])) {
                    $err = $_GET["err"];
                    echo "<p style='color: white; font-weight: 600;'>$err</p>";
                }
                ?>
            </form>
        </section>
    </main>



    <footer>
        <a href="catalogue.php">Browse Catalogue</a>
        <br>
        <a href="#" class="social">
            <i class="fa-brands fa-facebook"></i>
        </a>
        <a href="#" class="social">
            <i class="fa-brands fa-twitter"></i>
        </a>
        <a href="#" class="social">
            <i class="fa-brands fa-instagram"></i>
        </a>
        <p>Copyrights &copy; Omar Ahmed Eldanasoury, 202005808</p>
    </footer>

    <!-- Bootstrap via web -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>