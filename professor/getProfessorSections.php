<?php

/**
 * Server-side script that calls
 * getProfessorSections() from functions.php
 * which returns the section numbers and their ids
 * to be displayed to the professor, so he/she can select
 * from them.
 * 
 * @author Omar Eldanasoury
 */
session_start();
require_once("../functions.php"); // already has included funcitons.php inside it
if (isset($_GET["cid"]))
    $id = checkInput($_GET["cid"]); // called checkInput() to sanitize the input from user

echo getProfessorSections($_SESSION["activeUser"][0], $id);
