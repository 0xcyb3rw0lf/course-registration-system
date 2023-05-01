<?php

/**
 * Server-side script that calls
 * getBuildingRooms() from functions.php
 * which returns the rooms and their ids
 * as a string.
 * 
 * @author Omar Eldanasoury
 */
session_start();
require_once("../functions.php"); // already has included funcitons.php inside it
if (isset($_GET["id"]))
    $id = checkInput($_GET["id"]); // called checkInput() to sanitize the input from user

echo getBuildingRooms($id);
