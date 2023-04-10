<?php
if (isset($_SESSION["activeUser"])) { // if the user is signed in
?>
    <div id="container">
        <header>
            <a href="home.php" id="logo">
                <p>UOB Course Registration System</p>
            </a>
            <div id="nav">
                <!-- TODO: add necessary icons for navigating the system -->
                <a href="home.php">Home Page</a>
                <a href="catalogue.php">Catalogue</a>
                <a href="history.php">My History</a>
                <a href="myprofile.php">My Profile</a>
                <a href="signout.php" class="butn">Sign out</a>
            </div>
        </header>
    </div>
<?php
} else {
    // if the user is not logged in
?>
    <div id="container">
        <header>
            <a href="home.php" id="logo">
                <p>BBay</p>
            </a>
            <div id="nav">
                <!-- TODO: add necessary icons for navigating the system -->
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