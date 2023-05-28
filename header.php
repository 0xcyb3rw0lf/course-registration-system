<?php
if (isset($_SESSION["activeUser"])) { // if the user is signed in
?>
    <link rel="stylesheet" href="css/style.css">
    <div id="container">
        <header>
            <a href="/course-registration-system/index.php" id="logo">
                <img class="uob-logo" src="/course-registration-system/images/uob-logo.png" alt="University of Bahrian Logo">
                <p style="margin-left: 1.5em;">UOB Course Registration System</p>
            </a>
            <div id="nav">
                <a href="/course-registration-system/index.php">Home Page</a>
                <a href="/course-registration-system/index.php">
                    Services
                </a>
                <a href="/course-registration-system/help.php">Get Help!</a>
                <a href="/course-registration-system/logout.php" class="butn">Log out</a>
            </div>
        </header>
    </div>


<?php
} else { // if the user is not logged in
?>
    <link rel="stylesheet" href="css/style.css">
    <div id="container">
        <header>
            <a href="index.php" id="logo">
                <img class="uob-logo" src="/course-registration-system/images/uob-logo.png" alt="University of Bahrian Logo">
                <p style="margin-left: 1.5em;">UOB Course Registration System</p>
            </a>
            <div id="nav">
                <a href="/course-registration-system/help.php">Help</a>
                <a href="/course-registration-system/logout.php" class="butn">Log in</a>
            </div>
        </header>
    </div>
<?php
}
?>