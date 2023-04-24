<?php

/**
 * The back-end code of the login page starts here
 * @author Omar Eldanasoury (202005808)
 */
session_start();
if (isset($_POST["login"])) { // if the user clicked on login button
    // we get the input and sanitize it
    require("functions.php");
    $email = checkInput($_POST["email"]);
    $password = checkInput($_POST["password"]);

    // setting the variables of error messages
    $emailErr = $passwordErr = $loginErr = "";

    // we then validate if the user typed a correct email
    if (empty($email)) {
        $emailErr = "Email is required!";
        header("login.php");
    } else {
        // if the email is not a student email (@stu.uob.edu.bh)
        // or not an employee email (@uob.edu.bh); then it is an invalid email
        if (!preg_match('/[a-z0-9]+@stu\.uob\.edu\.bh$/', $email) && !preg_match('/[a-z0-9]+@uob\.edu\.bh$/', $email))
            $emailErr = "Invalid email, please type a correct one!";
    } // end of email validation

    // password validation: if the password field is empty
    // then we print the error message
    if (empty($password)) {
        $passwordErr = "Password is required!";
        unset($emailErr);
        header("login.php");
    }

    // // then we establish connection for the login process
    // require("connection.php");
    // // first we check if the user exists in the database
    // $query = $db->prepare("SELECT * FROM USERS WHERE EMAIL = ?"); // preparing the query using PDO
    // $query->bindValue(1, $email); // adding email to the query
    // $query->execute();

    // if ($query->rowCount() == 0) { // if the user does not exist in the database

    // }



    // if ($row = $rows->fetch()) {
    //     // if we entered here, then the user exists in the database
    //     $id = $row[0];
    //     $username = $row[1];
    //     $hashedPassword = $row[3];
    //     // we check the password
    //     if (password_verify($enteredPassword, $hashedPassword)) { // here we update the session
    //         // user is signed in!
    //         $_SESSION["activeUser"] = array($id, $username, $email);
    //         header("location: home.php");
    //     }
    // }

    // $db = null;
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
                <br><span style="color: red; font-size: 1em;"> <?php if (isset($emailErr)) echo $emailErr;
                                                                elseif (isset($passwordErr)) echo $passwordErr;
                                                                elseif (isset($loginErr)) echo $loginErr; ?></span>
            </form>
        </section>
    </main>



    <?php
    require("footer.php");
    ?>
</body>

</html>