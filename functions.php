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
function addSection($sid, $cid, $secNum, $pid, $roomId, $days, $datetime)
{
    if (hasTimeConflict($days, $roomId, $datetime))
        throw new Exception();

    try {
        require("connection.php");
        $sql = "INSERT INTO COURSE_SECTION VALUES(null, ?, ?, ?, ?, ?, ?, ?);";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($sid, $cid, $secNum, $pid, $roomId, $days, $datetime));
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

/** // TODO: complete the funciton
 * // TODO: do the pop up menus using ajax, and js
 * Returns if there is a time conflict
 * when adding a section by the admin
 * 
 * @author Omar Eldanasoury
 * @param mixed sectionDays
 * @param mixed sectionRoomId
 * @param mixed sectionTime
 * @return bool true if there is a time conflict, false otherwise
 */
function hasTimeConflict($sectionDays, $sectionRoomId, $sectionTime)
{
    $count = 0;
    require("connection.php");
    try {
        $query = $db->query("SELECT COUNT(*) FROM COURSE_SECTION WHERE LEC_DAYS = $sectionDays AND ROOM_ID = $sectionRoomId AND LEC_TIME = $sectionTime");
        if ($result = $query->fetch(PDO::FETCH_NUM)) {
            $count =  $result[0];
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    if ($count != 0) // if there are sections with the same time
        return true; // there is a conflict
    return false; // otherwise, there is no conflict
}

function createSuccessPopUp($msg)
{
    return "<div class='bg-modal'>
<div class='modal-contents'>

    <div class='close'>+</div>
    <p>$msg</p>    
    <a href='#' class='button'>Ok</a>

</div>
</div>
";
}

/**
 * Retrieves the sections of a course
 * of the running semester so the admin
 * can operate over them (delete, edit, view)
 * 
 * @author Omar Eldanasoury
 * @param mixed courseId Course Id
 * @return mixed string of the section id and section num separated by @, and # is used to separate each section
 */
function getCourseSections($courseId)
{
    // first we get the id of current semester from the db
    $sections = "";
    $currentSemId = getCurrentSemesterId();
    require("connection.php");
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT SECTION_ID, SEC_NUM FROM COURSE_SECTION WHERE SEM_ID = $currentSemId AND COURSE_ID = $courseId");
        while ($allSections = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $sections .= $allSections[0] . "@" . $allSections[1] . "#";
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $sections;
}

/**
 * Deletes a section from the database
 * 
 * @author Omar Eldanasoury
 * @param mixed courseId
 * @param mixed sectionId
 * @return bool true if delete operation was successfull, otherwise false
 */
function deleteSection($sectionId)
{
    require("connection.php");
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $db->beginTransaction();
        $sql = "DELETE FROM COURSE_SECTION WHERE SECTION_ID = ?";
        $statement = $db->prepare($sql);
        $statement->execute(array($sectionId));
        $db->commit();
    } catch (PDOException $ex) {
        $db->rollBack();
        // printing the error message if error happens
        echo $ex->getMessage();
        return false;
    }
    // closing connection with the database
    $db = null;
    return true;
}

/**
 * Returns the courses that current professor
 * is teaching in the current semester
 * 
 * @author Omar Eldanasoury
 * @param mixed $professorId the user(professor) id in the system
 * @return mixed an associative array of course id pointing to course code if the professor has courses, otherwise it returns empty array
 */
function getProfessorCourses($professorId)
{
    $currentSemesterId = getCurrentSemesterId();
    $courses = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT CS.COURSE_ID, C.COURSE_CODE FROM COURSE_SECTION AS CS, COURSE AS C WHERE C.COURSE_ID = CS.COURSE_ID AND CS.PROFESSOR_ID = $professorId AND CS.SEM_ID = $currentSemesterId");
        while ($idAndCode = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $course = array($idAndCode[0] => $idAndCode[1]);
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
 * Returns the sections that current professor
 * is teaching in the current semester
 * 
 * @author Omar Eldanasoury
 * @param mixed $professorId the user(professor) id in the system
 * @param mixed $courseId the id of the course that the professor want to retrieve its sections
 * @return mixed a string that has the section id + "@" + section num + "#", the # separates each section data
 */
function getProfessorSections($professorId, $courseId)
{
    $currentSemesterId = getCurrentSemesterId();
    $sections = "";
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT SECTION_ID, SEC_NUM FROM COURSE_SECTION WHERE PROFESSOR_ID = $professorId AND SEM_ID = $currentSemesterId AND COURSE_ID = $courseId");
        while ($idAndNum = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $sections .= $idAndNum[0] . "@" . $idAndNum[1] . "#";
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $sections;
}

/**
 * Gets the list of students in the section
 * 
 * @author Omar Eldanasoury
 * @param mixed $sectionId the id of the section
 * @return string string of students, each student is separated by #, and data is separated by @
 */
function getSectionStudents($sectionId)
{
    $currentSemesterId = getCurrentSemesterId();
    $students = "";
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT RC.STUDENT_ID, U.USERNAME, RC.ABSENCE, RC.GRADE, RC.APPEAL_STATE FROM REGISTRATION_COURSES AS RC, USERS AS U WHERE U.USER_ID = RC.STUDENT_ID AND RC.SECTION_ID = $sectionId AND RC.SEM_ID = $currentSemesterId");
        while ($studentData = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $grade = $studentData[3] == "" ? "Not Inserted Yet" : $studentData[3];
            $appealRequest = $studentData[4] == "" ? "No" : $studentData[4];
            $students .= $studentData[0] . "@" . $studentData[1] . "@" . $studentData[2] . "@" . $grade . "@" . $appealRequest .  "#";
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $students;
}

/**
 * Returns the student informaiton
 * as well as the grade of each student,
 * as a number
 * 
 * @author Omar Eldanasoury
 * @param mixed $sectionId id of the section of students
 * @return string string of students, each student is separated by #, and data is separated by @
 */
function getStudentsGrades($sectionId)
{
    $currentSemesterId = getCurrentSemesterId();
    $students = "";
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT RC.STUDENT_ID, U.USERNAME, RC.GRADE FROM REGISTRATION_COURSES AS RC, USERS AS U WHERE U.USER_ID = RC.STUDENT_ID AND RC.SECTION_ID = $sectionId AND RC.SEM_ID = $currentSemesterId");
        while ($studentData = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful

            // if the grde is not enterned yet, it is shown to professor as -1
            // if he/she tried to insert this as the grade as -1, input validation will prevent this
            $grade = $studentData[2] == "" ? "-1" : $studentData[2];
            $students .= $studentData[0] . "@" . $studentData[1] . "@" . $grade . "#";
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $students;
}

/**
 * Updates the grade of student
 * in the database
 * 
 * @author Omar Eldanasoury
 * @param mixed $studentId id of the student
 */
function updateGrade($sectionId, $studentIds, $studentGrades)
{
    $currentSemesterId = intval(getCurrentSemesterId());
    require("connection.php");
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $sql = "UPDATE REGISTRATION_COURSES SET GRADE = ? WHERE SEM_ID = ? AND SECTION_ID = ? AND STUDENT_ID = ?;";
        $statement = $db->prepare($sql);

        // foucs here
        // $studentId = intval($studentId);
        $sectionId = intval($sectionId);
        // $studentGrade = intval($studentGrade);
        $statement->bindParam(1, $studentGrade);
        $statement->bindParam(2, $currentSemesterId);
        $statement->bindParam(3, $sectionId);
        $statement->bindParam(4, $studentId);
        for ($i = 0; $i < count($studentIds); $i++) {
            $db->beginTransaction();
            $studentId = $studentIds[$i];
            $studentGrade = $studentGrades[$i];
            $statement->execute();
            $db->commit();
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
        $db->rollBack();
        return false;
    }
    // closing connection with the database
    $db = null;
    return true;
}

/**
 * Gets
 */
// function encodeGrade($grade)
// {
//     //   TODO: ADD COMMENT PHP DOC AND FIX THE RANGES
//     // GRADES ARE STORED IN THE DB AS NUMBERS
//     // THEY ARE DISPLAYED TO PROFESSORS AS NUMBERS
//     // AND TO STUDENTS AS LETTERS

//     if ($grade >= 90 and $grade <= 100)
//         return "A";
//     else if ($grade >= 87 and $grade <= 89)
//         return "A-";
//     else if ($grade >= 90 and $grade <= 100)
//         return "B+";
//     else if ($grade >= 90 and $grade <= 100)
//         return "B";
//     else if ($grade >= 90 and $grade <= 100)
//         return "B-";
//     else if ($grade >= 90 and $grade <= 100)
//         return "C+";
//     else if ($grade >= 90 and $grade <= 100)
//         return "C";
//     else if ($grade >= 90 and $grade <= 100)
//         return "C-";
//     else if ($grade >= 90 and $grade <= 100)
//         return "D";
//     else if ($grade <= 59)
//         return "F";
// }

// // transforms the letter to a value to help calculate the gpa
// function decodeGrade()
// {
// }
