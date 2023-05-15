<?php

/**
 * The back-end code of the login page starts here
 * @author Omar Eldanasoury (202005808)
 */
session_start();
if (isset($_SESSION["activeUser"]))
    header("location: /course-registration-system/index.php");


if (isset($_POST["login"])) { // if the user clicked on login button
    // we get the input and sanitize it
    require("functions.php");
    $email = checkInput($_POST["email"]);
    $password = checkInput($_POST["password"]);

    // setting the variables of error messages
    $emailErr = $passwordErr = $loginErr = "";
    unset($emailErr, $passwordErr, $loginErr); // fixed the problem of printing empty strings

    // we then validate if the user typed a correct email
    if (empty($email)) {
        $emailErr = "<span class='failed-feedback'>Email is required!</span>";
        header("login.php");
    } else {
        // if the email is not a student email (@stu.uob.edu.bh)
        // or not an employee email (@uob.edu.bh); then it is an invalid email
        if (!preg_match('/[a-z0-9]+@stu\.uob\.edu\.bh$/', $email) && !preg_match('/[a-z0-9]+@uob\.edu\.bh$/', $email)) {
            $emailErr = "<span class='failed-feedback'>Invalid email, please type a correct one!</span>";
            header("login.php");
        }
    } // end of email validation

    // password validation: if the password field is empty
    // then we print the error message
    if (empty($password)) {
        $passwordErr = "<span class='failed-feedback'>Password is required!</span>";
        header("login.php");
    }

    // then we establish connection for the login process
    try {
        require("connection.php");
        // first we check if the user exists in the database
        $query = $db->prepare("SELECT * FROM USERS WHERE EMAIL = ?"); // preparing the query using PDO
        $query->bindValue(1, $email); // adding email to the query
        $query->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        // Showing Error Message to the user
        $loginErr = "<span class='failed-feedback'>Unexpected error, please try again later!</span>";
        header("login.php");
    }


    if ($query->rowCount() == 0) { // if the user does not exist in the database
        unset($passwordErr);
        /**
         * we only show that the email is not registered in the system
         * if the email is valid, meaning if does not belong to the domains:
         * @stu.uob.edu.bh or @uob.edu.bh, then we do not tell the user that
         * the email is not registered.
         * WHY? this improves the security of the system, so we do not tell much
         * information than needed.
         */
        if (!isset($emailErr))
            $loginErr = "<span class='failed-feedback'>Invalid Email!</span>";
        header("login.php");
    } else { // if the user email is in the database
        // then we proceed by checking the password
        // but first, we extract needed data from the query
        if ($user = $query->fetch(PDO::FETCH_ASSOC)) {
            // first verify the password
            $hashedPassword = $user["password"];
            $userId = $user["user_id"];
            $userTypeId = $user["type_id"];
            // TODO: add password_verify to the following if
            // TODO: remove email is not in system message: security reasons
            if ($password == $hashedPassword) { // here we update the session
                // user is signed in!
                /**
                 * We need to store the following in the session data:
                 * - User ID
                 * - User Type ID
                 * - Current Semester ID
                 * 
                 * 
                 * we need to query the database to get sem_id
                 * NOTE + TODO: there are two functions that help us get
                 * the name of the current semester + a function
                 * for getting the describtion of the type of the user
                 * e.x.: "admin" or "student" .. etc. These functoins
                 * will be included in functions.php
                 */
                try {
                    $query = $db->query("SELECT SEM_ID, SEM_NAME FROM SEMESTER WHERE SEM_STATUS = 'IN_PROGRESS';");
                    if ($sem = $query->fetch(PDO::FETCH_ASSOC)) {
                        $currentSemesterId = $sem["sem_id"];
                        // $semName = $sem["sem_name"];
                        // header("location: index.php?sem='$semName'");
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    // Showing Error Message to the user
                    $loginErr = "<span class='failed-feedback'>Unexpected error, please try again later!</span>";
                    header("login.php");
                }

                // Setting the session(s)
                $_SESSION["userType"] = getUserTypeAsText($userTypeId); // this makes it easier
                // to manage authorization based on the user type, so instead of querying
                // the database each time to check the user type, we store the text in this
                // session variable accross the whole web application.

                $_SESSION["activeUser"] = array($userId, $userTypeId, $currentSemesterId);
                header("location: /course-registration-system/index.php");
            } else { // if the password is wrong!
                $loginErr = "<span class='failed-feedback'>Please enter the correct password!</span>";
                header("login.php");
            }
        }
    }
    $db = null;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>

    <!-- Adding the css files -->
    <link rel="stylesheet" href="css/reset.css">
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
        <section class="login-form" style="color: black">

            <h1 style="font-size: 2em; margin-bottom: 1.5em; color: #4056A1;">Sign in</h1>

            <form method="post">
                <label for="email">Email:*</label><br>
                <input class="margin-bottom-login-form" type="text" placeholder="email@example.com" name="email" id="email">
                <label for="email"></label>
                <br>

                <label for="password">Password:*</label><br>
                <input class="margin-bottom-login-form" type="password" placeholder="***********" name="password" id="password">
                <label for="password"></label>
                <br>

                <input type="submit" class="butn primary-butn sign-butn" name="login" id="login" value="Log in!">
                <br><br>
                <?php
                /**
                 * The error messages are shown 1 by 1 if anyone of them happend
                 */
                if (isset($emailErr)) {
                    echo $emailErr . "<br>";
                    unset($emailErr);
                } else if (isset($passwordErr)) {
                    echo $passwordErr . "<br>";
                    unset($passwordErr);
                } else if (isset($loginErr)) {
                    echo $loginErr . "<br>";;
                    unset($loginErr);
                } ?>
            </form>
        </section>
    </main>



    <?php
    require("footer.php");
    ?>
</body>

</html>