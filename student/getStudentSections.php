<?php
session_start();
require_once("../functions.php"); 
if (isset($_GET["cid"]))
    $id = $_GET["cid"]; 

echo getCourseSections($id);
?>