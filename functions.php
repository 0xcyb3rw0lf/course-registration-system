<?php

/**
 * Functions that retrieve data from
 * the database about the user, and
 * does input sanitization on user 
 * input.
 * 
 * @author Omar Eldanasoury
 */

 
/**
 * @name checkInput
 * Performs input sanitization on user input
 * to prevent injection attacks. It encodes
 * special characters, removes slaches,
 * and removes extra spaces. 
 * 
 * @author Omar Eldanasoury
 * @param $input user Input as text
 * @return string sanitized secure text to process.
 */
function checkInput($input)
{
    return htmlspecialchars(stripslashes(trim($input)));
}