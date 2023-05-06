<?php

/**
 * Server-side script that calls
 * getSectionStudents() from functions.php
 * which returns the students in a section
 * to be displayed to the professor, so he/she can select
 * from them.
 * 
 * @author Omar Eldanasoury
 */
session_start();
require_once("../functions.php"); // already has included funcitons.php inside it
if (isset($_GET["sectionId"]))
    $id = checkInput($_GET["sectionId"]); // called checkInput() to sanitize the input from user

echo getSectionStudents($id);
