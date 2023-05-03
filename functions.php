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

/**
 * Retrieves the type of the user
 * as a text string.  
 * 
 * @author Omar Eldanasoury
 * @param int $userTypeId the id that represents the type of the user inside the database.
 * @return string the actual desctribtion of the user type and title inside the system.
 */
function getUserTypeAsText($userTypeId)
{
    $type = null;
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT USER_TYPE FROM USER_TYPE WHERE TYPE_ID = $userTypeId");
        if ($result = $query->fetch(PDO::FETCH_NUM)) {
            $type = $result[0]; // getting the name if the query was successful
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
        echo $result[0];
    }
    // closing connection with the database
    $db = null;
    return $type;
}

/**
 * Retrieves the college name from
 * the database.
 * 
 * @author Omar Eldanasoury
 * @param int $userId
 * @param string $userType
 * @return string the actual user name from the system database, otherwise null if the use is admin.
 */
function getCollegeName($userId, $userType)
{
    $collegeName = null;
    if ($userType != 'admin') {
        try {
            // establishing connection
            require("connection.php");
            // setting and running the query
            $query = $db->query("SELECT COLLEGE_NAME FROM COLLEGE AS C, USERS AS U WHERE C.COLLEGE_ID = U.COLLEGE_ID AND USER_ID = $userId");
            if ($result = $query->fetch(PDO::FETCH_NUM)) {
                $collegeName = $result[0]; // getting the name if the query was successful
            }
        } catch (PDOException $ex) {
            // printing the error message if error happens
            echo $ex->getMessage();
        }
        // closing connection with the database
        $db = null;
    }
    return $collegeName;
}

/**
 * Retrieves the department name
 * of the user from the database.
 * 
 * @author Omar Eldanasoury
 * @param int $userId
 * @param string $userType
 * @return string the actual user name from the system database, otherwise null if the use is admin.
 */
function getDepartmentName($userId, $userType)
{
    $depName = null;
    if ($userType != 'admin') {
        try {
            // establishing connection
            require("connection.php");
            // setting and running the query
            $query = $db->query("SELECT DEP_NAME FROM DEPARTMENT AS D, USERS AS U WHERE D.DEP_ID = U.DEP_ID AND USER_ID = $userId");
            if ($result = $query->fetch(PDO::FETCH_NUM)) {
                $depName = $result[0]; // getting the name if the query was successful
            }
        } catch (PDOException $ex) {
            // printing the error message if error happens
            echo $ex->getMessage();
        }
        // closing connection with the database
        $db = null;
    }
    return $depName;
}

/**
 * Returns a list of all the courses
 * available in the database
 * 
 * @author Omar Eldanasoury
 * @return array course id, and course code = as an associative array
 */
function getCourses()
{
    $courses = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT COURSE_ID, COURSE_CODE FROM COURSE ORDER BY COURSE_ID");
        while ($allCourses = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $course = array($allCourses[0] => $allCourses[1]);
            array_push($courses, $course);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $courses;
}

/**
 * Retrieves all the names
 * of professors from the system
 * 
 * @author Omar Eldanasoury
 * @return array of names
 */
function getProfessorNames()
{
    $names = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT USER_ID, USERNAME FROM USERS WHERE TYPE_ID = 1");
        while ($allNames = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $name = array($allNames[0] => $allNames[1]);
            array_push($names, $name);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $names;
}

/**
 * Retrieves all the buildings
 * from the system
 * 
 * @author Omar Eldanasoury
 * @return array of names
 */
function getBuildings()
{
    $buildings = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT * FROM BUILDING");
        while ($allBldngs = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $bldng = array($allBldngs[0] => $allBldngs[1]);
            array_push($buildings, $bldng);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $buildings;
}

/**
 * Retrieves all the buildings
 * from the system
 * 
 * @author Omar Eldanasoury
 * @return array of names
 */
function getRooms()
{
    $rooms = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT ROOM_ID, ROOM_NAME FROM ROOM");
        while ($allRooms = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $room = array($allRooms[0] => $allRooms[1]);
            array_push($rooms, $room);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $rooms;
}

/**
 * Returns the rooms inside a building
 * by retreiving them from the database
 * 
 * @author Omar Eldanasoury
 * @return string to be handeled by javascript code
 */
function getBuildingRooms($buildingId)
{
    $rooms = "";
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT ROOM_ID, ROOM_NAME FROM ROOM WHERE BUILDING_ID = $buildingId");
        while ($allRooms = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $rooms .= $allRooms[0] . "@" . $allRooms[1] . "#";
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $rooms;
}

/**
 * Inserts a section into the system
 * 
 * @author Omar Eldanasoury
 * @return bool true if the operation was true, otherwise false
 */
function addSection($sid, $cid, $secNum, $pid, $roomId, $datetime)
{
    try {
        require("connection.php");
        $sql = "INSERT INTO COURSE_SECTION VALUES(null, ?, ?, ?, ?, ?, ?);";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($sid, $cid, $secNum, $pid, $roomId, $datetime));
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        echo $e->getMessage() . "<br>";
        // print_r(array($sid, $cid, $secNum, $pid, $roomId, $datetime)) . "<br>";
        // echo "sem id: " . $sid;

        $db = null;
        return false;
    }

    if ($statement->rowCount() != 1)
        return false;
    echo "row count: " . $statement->rowCount();
    return true;
}

/**
 * Gets the id of the current semester
 * from the database
 * 
 * @author Omar Eldanasoury
 * @return mixed the id of the semester, or null if there is an error
 */
function getCurrentSemesterId()
{
    $currentSemesterId = null;
    require("connection.php");
    try {
        $query = $db->query("SELECT SEM_ID FROM SEMESTER WHERE SEM_STATUS = 'IN_PROGRESS';");
        if ($sem = $query->fetch(PDO::FETCH_NUM)) {
            $currentSemesterId =  $sem[0];
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    return $currentSemesterId;
}

/**
 * Returns if there is a time conflict
 * when adding a section by the admin
 * 
 * @author Omar Eldanasoury
 * @param mixed sectionDays
 * @param mixed sectionRoom
 * @param mixed sectionTime
 * @return bool true if there is a time conflict, false otherwise
 */
function hasTimeConflict($sectionDays, $sectionRoom, $sectionTime)
{
}
