<?php
session_start();
require_once("../functions2.php"); // already has included funcitons.php inside it
if (isset($_GET["cid"]))
    $id = checkInput($_GET["cid"]); // called checkInput() to sanitize the input from user

echo getDepartmentsName($id);
