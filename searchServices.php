<?php

/**
 * searchServices.php
 * 
 * gets what the user wrote in
 * the search box and searchs
 * the list of services for similar
 * titles.
 * 
 * @return string of found services.
 * @author Omar Eldanasoury
 */

require_once("services.php"); // already has included funcitons.php inside it
if (isset($_GET["text"]))
    $userText = checkInput($_GET["text"]); // called checkInput() to sanitize the input from user

$output = '';
$services = getUserServicesList(getUserTypeAsText($_SESSION["activeUser"][1]));
foreach ($services as $service => $path)
    if (str_contains($service, $userText))
        $output += "#$service@$path";

echo $output;
