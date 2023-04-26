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

/**
 * Retrieves the user name from
 * the database.
 * 
 * @author Omar Eldanasoury
 * @param int $userId
 * @return string the actual user name from the system database.
 */
function getUserName($userId)
{
    $username = null;
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT USERNAME FROM USERS WHERE USER_ID = $userId");
        if ($query->rowCount() != 0 and $name = $query->fetch(PDO::FETCH_NUM)) {
            $username = $name[0]; // getting the name if the query was successful
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $username;
}

/**
 * Retrieves the major name from
 * the database. if the user is not admin.
 * 
 * @author Omar Eldanasoury
 * @param int $userId
 * @param string $userType
 * @return string the actual user name from the system database, otherwise null if the use is admin.
 */
function getMajorName($userId, $userType)
{
    $major = null;
    $query = "";
    if ($userType == "student") { // only student users has major, other users do not
        try {
            // establishing connection
            require("connection.php");
            // setting and running the query
            $query = $db->query("SELECT PC.PROGRAM_NAME FROM STUDENT_INFO AS SI, PROGRAM_COLLEGE AS PC WHERE SI.STUDENT_ID = $userId AND SI.PROG_ID = PC.PROGRAM_ID");
            if ($program = $query->fetch(PDO::FETCH_NUM)) {
                $major = "hey";
                $major = $program[0]; // getting the major if the query was successful
            }
        } catch (PDOException $ex) {
            // printing the error message if error happens
            echo $ex->getMessage();
        }
        // closing connection with the database
        $db = null;
    }
    return $major;
}

/**
 * Retrieves the semester name from
 * the database.  
 * 
 * @author Omar Eldanasoury
 * @param $semId semester id in the database (from the session).
 * @return string the actual semester name from the system database.
 */

function getSemesterName($semId)
{
    $semName = "";
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = "SELECT SEM_NAME FROM SEMESTER WHERE SEM_STATUS = 'IN_PROGRESS'";
        $rows = $db->prepare($query);
        $rows->execute();
        $semName = "testoo";
        if ($sem = $rows->fetch(PDO::FETCH_NUM)) {
            $semName = $sem[0]; // getting the name if the query was successful
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
        $semName = "TestTest";
    }
    // closing connection with the database
    $db = null;
    return $semName;
}