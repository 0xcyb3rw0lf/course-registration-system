<?php

/**
 * OMAR AHMED REFAAT ELDANASOURY, 202005808
 * ITCS333-SEC 03 , COURSE PROJECT, ALONE
 */
if (isset($_SESSION["activeUser"])) { // if the user signed in
?>
    <div id="container">
        <header>
            <a href="home.php" id="logo">
                <p>BBay</p>
                <!-- <img src="images/logo.svg" alt="Logo"> -->
            </a>
            <div id="nav">
                <a href="home.php">Home</a>
                <a href="catalogue.php">Catalogue</a>
                <a href="history.php">My History</a>
                <a href="myprofile.php">My Profile</a>
                <a href="signout.php" class="butn">Sign out</a>
            </div>
        </header>
    </div>
<?php
} else {
?>
    <div id="container">
        <header>
            <a href="home.php" id="logo">
                <p>BBay</p>
                <!-- <img src="images/logo.svg" alt="Logo"> -->
            </a>
            <div id="nav">
                <a href="home.php">Home</a>
                <a href="catalogue.php">Catalogue</a>
                <a href="signin.php" class="butn">Sign in</a>
                <a href="signup.php" class="butn primary-butn">Create Account</a>
            </div>
        </header>
    </div>
<?php
}
?>