<?php

/**
 * Server-side script that calls
 * getCollegeHODs($collegeId) from functions.php
 * which returns the heads of departments of a college
 * and their ids to be displayed to the admin,
 * so he/she can select from them.
 * 
 * @author Omar Eldanasoury
 */
session_start();
require_once("../functions2.php"); // already has included funcitons.php inside it
if (isset($_GET["id"]))
    $id = checkInput($_GET["id"]); // called checkInput() to sanitize the input from user
echo getCollegeProgramsToString($id);
