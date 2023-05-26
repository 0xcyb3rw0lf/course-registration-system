<?php
/**
 * @author Elyas Raed
 */
session_start();
require_once("../functions2.php"); // already has included funcitons.php inside it
if (isset($_GET["uid"]))
    $id = checkInput($_GET["uid"]); // called checkInput() to sanitize the input from user

echo getUserNames($id);
