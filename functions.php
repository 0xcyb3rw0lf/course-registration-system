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
        $query = "SELECT SEM_NAME FROM SEMESTER WHERE SEM_STATUS = 1";
        $rows = $db->prepare($query);
        $rows->execute();
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
            // getting the list of professors if the query was successful
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
 * @return array of rooms
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
 * @param $semId the semester id
 * @param $cid the course id
 * @param $secNum the section number id
 * @param $pid the id of the professor
 * @param $roomId room id for the section
 * @param $days the semester id
 * @param $datetime the time of the section
 * @param $capacity the number of seats available in the section
 * 
 * @return bool true if the operation was true, otherwise false
 */
function addSection($semId, $cid, $secNum, $pid, $roomId, $days, $datetime, $capacity)
{
    // checking for time conflict
    $timeConflict = hasTimeConflictAddSection($days, $roomId, $datetime);
    if ($timeConflict == 'conflict')
        throw new Exception();;

    // if there is no time conflicts, we process with adding the section
    require("connection.php");
    try {
        $sql = "INSERT INTO COURSE_SECTION VALUES(null, ?, ?, ?, ?, ?, ?, ?, ?);";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($semId, $cid, $secNum, $pid, $roomId, $days, $datetime, $capacity));
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        echo $e->getMessage() . "<br>";
        $db = null;
        return false;
    }

    return ($statement->rowCount() == 1);
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
        $query = $db->query("SELECT SEM_ID FROM SEMESTER WHERE SEM_STATUS = 1;");
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
 * when updating a section by the admin
 * 
 * @author Omar Eldanasoury
 * @param mixed $sectionId the id of the section which user is updating
 * @param mixed $sectionDays the days of the section
 * @param mixed $sectionRoomId the id of the room in which section is present
 * @param mixed $sectionTime the time of the section
 * @return string existing state of the conflict (conflict, sameAsPrevious, or none)
 */
function hasTimeConflict($sectionId, $sectionDays, $sectionRoomId, $sectionTime)
{
    require("connection.php");
    try {
        $query = $db->prepare("SELECT SECTION_ID FROM COURSE_SECTION WHERE LEC_DAYS LIKE ? AND ROOM_ID = ? AND LEC_TIME = ?;");
        $query->execute(array($sectionDays, $sectionRoomId, $sectionTime));
        if ($secId = $query->fetch(PDO::FETCH_NUM)) {
            if ($secId[0] == $sectionId) { // if the user already selected the same time, days, and room; and didnt change any value
                return "sameAsPrevious"; // then there is no conflict, and the user will be prompted to enter another time 
            }
            // if the conflicted section is not the same section
            $db = null; // closing the connection
            return "conflict";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    return "none"; // otherwise, there is no conflict
}

/**
 * Returns if there is a time conflict
 * when adding a section by the admin
 * 
 * @author Omar Eldanasoury
 * @param mixed $sectionDays the days of the section
 * @param mixed $sectionRoomId the id of the room in which section is present
 * @param mixed $sectionTime the time of the section
 * @return string existing state of the conflict (conflict, sameAsPrevious, or none)
 */
function hasTimeConflictAddSection($sectionDays, $sectionRoomId, $sectionTime)
{
    require("connection.php");
    try {
        $query = $db->prepare("SELECT * FROM COURSE_SECTION WHERE LEC_DAYS LIKE ? AND ROOM_ID = ? AND LEC_TIME = ?;");
        $query->execute(array($sectionDays, $sectionRoomId, $sectionTime));
        if ($result = $query->fetch(PDO::FETCH_NUM)) { // if there is a time conflict
            $db = null; // closing the connection
            return "conflict";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    return "none"; // otherwise, there is no conflict
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
        $query = $db->query("SELECT RC.STUDENT_ID, U.USERNAME, RC.GRADE, RC.APPEAL_STATE FROM REGISTRATION_COURSES AS RC, USERS AS U WHERE U.USER_ID = RC.STUDENT_ID AND RC.SECTION_ID = $sectionId AND RC.SEM_ID = $currentSemesterId");
        while ($studentData = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $grade = $studentData[2] == "" ? "Not Inserted Yet" : $studentData[2];
            $appealRequest = $studentData[3] == 0  ? "No" : ($studentData[3] == 1 ? "Pending Re-grading" : "Completed");
            $students .= $studentData[0] . "@" . $studentData[1] . "@" . $grade . "@" . $appealRequest .  "#";
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
 * Returns the students informaiton
 * as well as the grade of each student,
 * as a number. it only returns the list
 * of students who has made an appealing
 * request.
 * 
 * @author Omar Eldanasoury
 * @param mixed $sectionId id of the section of students
 * @return string string of students, each student is separated by #, and data is separated by @
 */
function getAppealingRequests($sectionId)
{
    $currentSemesterId = getCurrentSemesterId();
    $students = "";
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT RC.STUDENT_ID, U.USERNAME, RC.GRADE FROM REGISTRATION_COURSES AS RC, USERS AS U WHERE U.USER_ID = RC.STUDENT_ID AND RC.SECTION_ID = $sectionId AND RC.SEM_ID = $currentSemesterId AND RC.APPEAL_STATE = 1");
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
 * in the database and closes
 * the appealing request
 * 
 * @author Omar Eldanasoury
 * @param mixed $studentId id of the student
 */
function closeAppealingRequest($sectionId, $studentIds, $studentGrades)
{
    $currentSemesterId = intval(getCurrentSemesterId());
    require("connection.php");
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $sql = "UPDATE REGISTRATION_COURSES SET GRADE = ?, APPEAL_STATE = 2 WHERE SEM_ID = ? AND SECTION_ID = ? AND STUDENT_ID = ?;";
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
 * Updates sections' information
 * inside the system's database
 * 
 * @author Omar Eldanasoury
 * @param mixed $sectionId the section id
 * @param mixed $courseId the course id
 * @param mixed $professorId the professor id
 * @param mixed $time the new time
 * @param mixed $sectionNumber the new section number
 * @param mixed $room the new room
 * @param mixed $days the new days
 * @param mixed $capacity the new capacity foof the section
 * @return bool true if the operation was successfull, otherwise false
 */
function updateSection($sectionId, $courseId, $professorId, $time, $sectionNumber, $roomId, $days, $capacity)
{
    $timeConflict = hasTimeConflict($sectionId, $days, $roomId, $time);
    if ($timeConflict == 'conflict')
        throw new Exception();
    else if (($timeConflict == 'sameAsPrevious'))
        throw new LogicException();

    try {
        require("connection.php");
        $sql = "UPDATE COURSE_SECTION SET COURSE_ID = ?, SEC_NUM = ?, PROFESSOR_ID = ?, ROOM_ID = ?, LEC_DAYS = ?, LEC_TIME = ? , CAPACITY = ? WHERE SECTION_ID = ?;";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($courseId, $sectionNumber, $professorId, $roomId, $days, $time, $capacity, $sectionId));
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        echo $e->getMessage() . "<br>";

        $db = null;
        return false;
    }

    return ($statement->rowCount() == 1);
}

/**
 * Returns all section information
 * from the system
 * 
 * @author Omar Eldanasoury
 * @param $sectionId the id of the section
 * @return mixed an array of the section data, and returns null if the section does not exist in the system 
 */
function getSectionData($sectionId)
{
    try {
        require("connection.php");
        $sql = "SELECT * FROM COURSE_SECTION WHERE SECTION_ID = $sectionId";
        $statement = $db->prepare($sql);
        $statement->execute();

        if ($section = $statement->fetch(PDO::FETCH_ASSOC)) {
            return $section;
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";

        $db = null;
    }
    return null;
}


/**
 * Returns an associative array
 * of elligible courses to add
 * appeal requests on by student
 * 
 * @author Omar Eldanasoury
 * @param mixed $studentId
 * @return array of associative arrays (course id => course code)
 */
function getEligibleCourses($studentId)
{
    $semId = getCurrentSemesterId();
    $courses = array();
    try {
        require("connection.php");
        // getting the courses that belong to the student, in the current semester, and have no appealing requests issued yet
        $sql = "SELECT RC.COURSE_ID, C.COURSE_CODE FROM COURSE AS C, REGISTRATION_COURSES AS RC WHERE RC.COURSE_ID = C.COURSE_ID AND RC.SEM_ID = ? AND RC.STUDENT_ID = ? AND APPEAL_STATE = 0;";
        $statement = $db->prepare($sql);
        $statement->execute(array($semId, $studentId));

        while ($course = $statement->fetch(PDO::FETCH_NUM)) {
            array_push($courses, array($course[0] => $course[1]));
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";
        $db = null;
    }
    $db = null;
    return $courses;
}

/**
 * Adds an appeal request for the students
 * for the selected course
 * 
 * @author Omar Eldanasoury
 * @param mixed $studentId the id of student
 * @param mixed $courseId the course id
 * @return bool whether the operatio was successful or not!
 */
function addAppealRequest($studentId, $courseId)
{
    $semId = getCurrentSemesterId();
    try {
        require("connection.php");
        $sql = "UPDATE REGISTRATION_COURSES SET APPEAL_STATE = 1 WHERE SEM_ID = ? AND STUDENT_ID = ? AND COURSE_ID = ?";
        $statement = $db->prepare($sql);
        $statement->execute(array($semId, $studentId, $courseId));
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";
        $db = null;
    }
    $db = null;

    return ($statement->rowCount() == 1);
}

/**
 * Reutrns the appealing requests done
 * by a student in the form array
 * 
 * @author Omar Eldanasoury
 * @param mixed $studentId
 * @return array array for each request information
 */
function getStudentAppealingRequests($studentId)
{
    $semId = getCurrentSemesterId();
    $requests = array();
    try {
        require("connection.php");
        // getting the courses that belong to the student, in the current semester, and have no appealing requests issued yet
        $sql = "SELECT C.COURSE_CODE, C.COURSE_NAME, RC.APPEAL_STATE, RC.GRADE FROM COURSE AS C, REGISTRATION_COURSES AS RC WHERE RC.COURSE_ID = C.COURSE_ID AND RC.SEM_ID = ? AND RC.STUDENT_ID = ? AND (APPEAL_STATE = 1 OR APPEAL_STATE = 2);";
        $statement = $db->prepare($sql);
        $statement->execute(array($semId, $studentId));

        while ($request = $statement->fetch(PDO::FETCH_NUM)) {
            $state = "Not Re-Graded Yet!";
            $grade = "N/A";
            if ($request[2] == 2) {
                $state = "Re-graded!";
                $grade = $request[3];
            } // if the request has been re-graded by professor


            array_push($requests, array($request[0], $request[1], $state, $grade));
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";
        $db = null;
    }
    $db = null;
    return $requests;
}

/**
 * Checks if the student is out
 * of the appeal period
 * 
 * @author Omar Eldanasoury
 * @return bool true if the student is out of appeal period, false otherwise
 */
function isInAppealPeriod()
{
    try {
        require("connection.php");
        $sql = "SELECT COUNT(*) FROM SEMESTER WHERE NOW() >= APPEAL_START AND NOW() <= APPEAL_END;";
        $statement = $db->prepare($sql);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";
        $db = null;
    }
    $db = null;
    return $statement->fetch(PDO::FETCH_NUM)[0] == 1; // if the database returns nothing, so the student is out of appealing period 
}

/**
 * Returns and array of courses
 * that are the prerequisites of it
 * 
 * @author Omar Eldanasoury
 * @param mixed $courseId the id of a course
 * @return array of array of courses
 */
function getPrerequisites($courseId)
{
    $courses = array();
    try {
        require("connection.php");
        // getting the courses that belong to the student, in the current semester, and have no appealing requests issued yet
        $sql = "SELECT C.COURSE_CODE, C.COURSE_NAME, C.CREDITS FROM COURSE AS C, COURSE_PREREQ AS CP WHERE C.COURSE_ID = CP.PREREQ_ID AND CP.COURSE_ID = ?";
        $statement = $db->prepare($sql);
        $statement->execute(array($courseId));

        while ($course = $statement->fetch(PDO::FETCH_NUM)) {
            array_push($courses, array($course[0], $course[1], $course[2]));
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";
        $db = null;
    }
    $db = null;
    return $courses;
}


/**
 * Returns the courses that are
 * in a program
 * 
 * @author Omar Eldanasoury
 * @param mixed $programId the id of a course
 * @return array of array of courses
 */
function getProgramCourses($programId)
{
    $courses = array();
    try {
        require("connection.php");
        // getting the courses that belong to the student, in the current semester, and have no appealing requests issued yet
        $sql = "SELECT C.COURSE_ID, C.COURSE_CODE FROM PROGRAM_COURSE AS PC, COURSE AS C WHERE C.COURSE_ID = PC.COURSE_ID AND PC.PROGRAM_ID = ?";
        $statement = $db->prepare($sql);
        $statement->execute(array($programId));

        while ($course = $statement->fetch(PDO::FETCH_NUM)) {
            array_push($courses, array($course[0] => $course[1]));
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";
        $db = null;
    }
    $db = null;
    return $courses;
}

/**
 * Returns the id of the program that student
 * is enrolled in
 * 
 * @author Omar Eldanasoury <email>
 * @param mixed $studentId
 * @return mixed the id of the student's program 
 */
function getStudentProgramId($studentId)
{
    try {
        require("connection.php");
        // getting the courses that belong to the student, in the current semester, and have no appealing requests issued yet
        $sql = "SELECT PROG_ID FROM STUDENT_INFO WHERE STUDENT_ID = $studentId";
        $statement = $db->prepare($sql);
        $statement->execute();

        if ($programId = $statement->fetch(PDO::FETCH_NUM)) {
            return $programId[0];
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";
        $db = null;
    }
    $db = null;
    return null;
}

/**
 * Returns the course name based on course id
 * 
 * @author Omar Eldanasoury <email>
 * @param mixed $courseId
 * @return mixed course name
 */
function getCourseCode($courseId)
{
    try {
        require("connection.php");
        // getting the courses that belong to the student, in the current semester, and have no appealing requests issued yet
        $sql = "SELECT COURSE_CODE FROM COURSE WHERE COURSE_ID = $courseId";
        $statement = $db->prepare($sql);
        $statement->execute();

        if ($courseName = $statement->fetch(PDO::FETCH_NUM)) {
            return $courseName[0];
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";
        $db = null;
    }
    $db = null;
    return null;
}

/**
 * Returns the professor name based on professor id
 * 
 * @author Omar Eldanasoury
 * @param mixed $professorId
 * @return mixed professor name
 */
function getProfessorName($professorId)
{
    try {
        require("connection.php");
        // getting the courses that belong to the student, in the current semester, and have no appealing requests issued yet
        $sql = "SELECT USERNAME FROM USERS WHERE USER_ID = $professorId";
        $statement = $db->prepare($sql);
        $statement->execute();

        if ($professorName = $statement->fetch(PDO::FETCH_NUM)) {
            return $professorName[0];
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";
        $db = null;
    }
    $db = null;
    return null;
}

/**
 * Returns the building name based on room id
 * 
 * @author Omar Eldanasoury
 * @param mixed $roomId
 * @return mixed building name
 */
function getBuildingNameByRoomId($roomId)
{
    try {
        require("connection.php");
        // getting the courses that belong to the student, in the current semester, and have no appealing requests issued yet
        $sql = "SELECT B.BUILDING_NAME FROM BUILDING AS B, ROOM AS R WHERE B.BUILDING_ID = R.BUILDING_ID AND R.ROOM_ID = $roomId";
        $statement = $db->prepare($sql);
        $statement->execute();

        if ($buildingName = $statement->fetch(PDO::FETCH_NUM)) {
            return $buildingName[0];
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";
        $db = null;
    }
    $db = null;
    return null;
}

/**
 * Returns the room name based on room id
 * 
 * @author Omar Eldanasoury
 * @param mixed $roomId the id of the room
 * @return mixed room name
 */
function getRoomName($roomId)
{
    try {
        require("connection.php");
        // getting the courses that belong to the student, in the current semester, and have no appealing requests issued yet
        $sql = "SELECT ROOM_NAME FROM ROOM WHERE ROOM_ID = $roomId";
        $statement = $db->prepare($sql);
        $statement->execute();

        if ($roomName = $statement->fetch(PDO::FETCH_NUM)) {
            return $roomName[0];
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";
        $db = null;
    }
    $db = null;
    return null;
}

/**
 * Returns a list of all the courses
 * of the college
 * available in the database
 * 
 * @author Omar Eldanasoury
 * @param $collegeId the id of the college
 * @return array course id, and course code = as an associative array
 */
function getCollegeCourses($collegeId)
{
    $courses = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        // select course id and code from all programs related to the college of the dean
        $query = $db->query("SELECT DISTINCT C.COURSE_ID, C.COURSE_CODE FROM COURSE AS C, PROGRAM_COURSE AS PCRS, PROGRAM_COLLEGE AS PCLG WHERE PCLG.COLLEGE_ID = $collegeId AND PCLG.PROGRAM_ID = PCRS.PROGRAM_ID;");
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
 * Returns a list of all the courses
 * of the department
 * available in the database
 * 
 * @author Omar Eldanasoury
 * @return array course id, and course code = as an associative array
 */
function getDepartmentCourses($departmentId)
{
    $courses = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        // gets all courses related to the department
        $query = $db->query("SELECT DISTINCT C.COURSE_ID, C.COURSE_CODE FROM COURSE AS C, PROGRAM_COURSE AS PCRS, PROGRAM_COLLEGE AS PCLG, DEPARTMENT AS DEP WHERE PCLG.COLLEGE_ID = DEP.COLLEGE_ID AND PCLG.PROGRAM_ID = PCRS.PROGRAM_ID AND DEP.DEP_ID = $departmentId;");
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
 * Retrieves the college id
 * of the user from the database.
 * 
 * @author Omar Eldanasoury
 * @param int $userId
 * @return string college id that the user belongs to
 */
function getCollegeId($userId)
{
    $collegeId = null;

    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT COLLEGE_ID FROM USERS WHERE USER_ID = $userId");
        if ($result = $query->fetch(PDO::FETCH_NUM)) {
            $collegeId = $result[0]; // getting the name if the query was successful
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;

    return $collegeId;
}

/**
 * Retrieves the department id
 * of the user from the database.
 * 
 * @author Omar Eldanasoury
 * @param int $userId the id of the head of department
 * @return string department id that the user belongs to
 */
function getDepartmentId($userId)
{
    $collegeId = null;

    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT DEP_ID FROM USERS WHERE USER_ID = $userId");
        if ($result = $query->fetch(PDO::FETCH_NUM)) {
            $collegeId = $result[0]; // getting the name if the query was successful
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;

    return $collegeId;
}

/**
 * Returns the programs of a certain college
 * 
 * @author Omar Eldanasoury
 * 
 */
function getCollegePrograms($collegeId)
{
    $programs = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        // gets all courses related to the department
        $query = $db->query("SELECT PROGRAM_ID, PROGRAM_NAME FROM PROGRAM_COLLEGE WHERE COLLEGE_ID = $collegeId;");
        while ($allPrograms = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $program = array($allPrograms[0] => $allPrograms[1]);
            array_push($programs, $program);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $programs;
}

/**
 * Returns true if the course
 * already exists in the db,
 * false otherwise.
 * 
 * @author Omar Eldanasoury
 * @param mixed $courseCode the course's code
 * @return bool true if the course already exists in the db, otherwise false
 */
function doesCourseExist($courseCode)
{
    require("connection.php");
    try {
        $query = $db->prepare("SELECT COURSE_ID FROM COURSE WHERE COURSE_CODE LIKE ?");
        $query->execute(array($courseCode));
        if ($result = $query->fetch(PDO::FETCH_NUM)) { // if there is a time conflict
            $db = null; // closing the connection
            return true;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $db = null; // closing the connection
    return false;
}

/**
 * Returns an array that have the course_id,
 *  section_id, and Payment Status for All 
 * Registered courses in current semester
 * @author Abdulmohsen Abbas
 * @param $userId the student id 
 * @return array that have information of each
 * registered course for the student in current semester
 *  stroed in arrays of type string each one of them
 *  have (Course id, Section id, PaymentStatus) 
 */
function getCourseSSectionsPaymentStatusArray($userId) //done
{
    $studentinfoSarray = array();
    $studentinfoLarray = array();
    $currentSemId = getCurrentSemesterId();
    try {
        require("connection.php");
        $query = $db->query("SELECT course_id, section_id, payment_status FROM registration_courses WHERE student_id = $userId AND sem_id = $currentSemId");
        // setting and running the query
        while ($allStudentInfo = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $courseId = $allStudentInfo[0];
            $sectionId =  $allStudentInfo[1];
            $paymentStatus =  $allStudentInfo[2];
            array_push($studentinfoSarray, $courseId, $sectionId, $paymentStatus);
            array_push($studentinfoLarray, $studentinfoSarray);
            $studentinfoSarray = array();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();

        $db = null;
    }
    return $studentinfoLarray;
}

/**
 * Returns the id of the building
 * @author Abdulmohsen Abbas
 * @param  $roomId the id of the room
 * @return string The building id
 */
function getBuildingId($room_id)
{
    $buildingId = null;
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT building_id FROM room WHERE room_id = $room_id");
        if ($query->rowCount() != 0 and $name = $query->fetch(PDO::FETCH_NUM)) {
            $buildingId = $name[0]; // getting the name if the query was successful
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $buildingId;
}

/**
 * Returns the name of the building
 * @author Abdulmohsen Abbas
 * @param  $buildingId the id of the building
 * @return string The building name
 */
function getBuildingNameByRoomIdById($buildingId)
{
    $buildingName = null;
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT building_name FROM building WHERE building_id = $buildingId");
        if ($query->rowCount() != 0 and $name = $query->fetch(PDO::FETCH_NUM)) {
            $buildingName = $name[0]; // getting the name if the query was successful
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $buildingName;
}

/**
 * Returns an array that have the course code,
 *  course name, and course credit for the wanted course  
 * @author Abdulmohsen Abbas
 * @param $courseId the course id 
 * @return string array that have
 * ( course code,course name, course credit)
 */
function getCourseInfo($courseId)
{
    $courseInfo = array();
    try {
        require("connection.php");
        $query = $db->query("SELECT * FROM course WHERE course_id = $courseId");
        // setting and running the query
        if ($info = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $courseCode = $info[1];
            $courseName = $info[2];
            $courseCredit = $info[3];
            array_push($courseInfo, $courseCode, $courseName, $courseCredit);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        $db = null;
    }
    return $courseInfo;
}
/**
 * Returns the course credit 
 * @author Abdulmohsen Abbas
 * @param $courseId the course id 
 * @return string course credit
 */
function getCourseCredit($courseId) //done
{
    $credit = 0;
    try {
        require("connection.php");
        $query = $db->query("SELECT credits FROM course WHERE course_id = $courseId");
        // setting and running the query
        if ($credit = $query->fetch(PDO::FETCH_NUM)) {
            return $credit[0];
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        $db = null;
    }
}
/**
 * Returns an array that have associative arrays 
 * with the key equal  semster id and value equal semester name   
 * @author Abdulmohsen Abbas
 * @return string array that have multiple arrays 
 * with these values seperated by ',' for all available semesters  [semster_id, semster_name ]
 */
function getSemesters()
{
    $semesters = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT sem_id, sem_name FROM semester");
        while ($allsems = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of courses if the query was successful
            $sems = array($allsems[0], $allsems[1]);
            array_push($semesters, $sems);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $semesters;
}
/**
 * this function will take the semester Id value and the student Id and
 *  will return the grades and course credits for the wanted semester
 * @author Abdulmohsen Abbas
 * @param $semesterId the semester Id
 * @param $studentId the student Id
 * @return string numeric array that contain associative arrays with( course credit, and course grade)
 *  for all the courses in the wanted semester and student
 * and here simple output for the inner array:
 */
function getStudentGradesCredits($semesterId, $studentId) //done  // this function will help in gpa calculation
{   // There will be seperate function instead of this one 
    $gw = array();
    $gradesAndCredits = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT course_id, grade FROM REGISTRATION_COURSES WHERE sem_id = $semesterId AND student_id = $studentId");
        while ($grwe = $query->fetch(PDO::FETCH_NUM)) {
            $ch = getCourseCredit($grwe[0]);
            $grade = $grwe[1];
            $gw = [$grade => $ch];
            array_push($gradesAndCredits, $gw);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $gradesAndCredits;
}
/**
 * this function will take the grade value and will return the grade name
 * @author Abdulmohsen Abbas
 * @param $gradeValue the grade value out of 100 example :"77"
 * @return string the grade name example :"B-"
 */
function getGradeName($gradeValue)
{
    if ($gradeValue >= 90) {
        return "A";
    } elseif ($gradeValue >= 87) {
        return "A-";
    } elseif ($gradeValue >= 84) {
        return "B+";
    } elseif ($gradeValue >= 80) {
        return "B";
    } elseif ($gradeValue >= 77) {
        return "B-";
    } elseif ($gradeValue >= 74) {
        return "C+";
    } elseif ($gradeValue >= 70) {
        return "C";
    } elseif ($gradeValue >= 67) {
        return "C-";
    } elseif ($gradeValue >= 64) {
        return "D+";
    } elseif ($gradeValue >= 60) {
        return "D";
    } else {
        return "F";
    }
}
/**
 * this function will take the grade Name and will return the grade Weight
 * @author Abdulmohsen
 * @param $gradeName the grade Name example "A-"
 * @return mixed grade Weight if the operation completed successfully, otherwise 
 * will return the message "Grade not found!" 
 */
function getGradeWeight($gradeName)
{
    $grades = array(
        "A" => 4.0,
        "A-" => 3.67,
        "B+" => 3.33,
        "B" => 3.0,
        "B-" => 2.67,
        "C+" => 2.33,
        "C" => 2.0,
        "C-" => 1.67,
        "D+" => 1.33,
        "D" => 1.0,
        "F" => 0.0
    );
    // Check if the grade name exists in the array
    if (array_key_exists($gradeName, $grades)) {
        return $grades[$gradeName];
    } else {
        return "Grade not found!";
    }
}

/**
 * this function will take the program id and will return the Program name
 * @author Abdulmohsen
 * @param $programId the program id
 * @return string program name if the operation completed successfully, otherwise null 
 */
function getProgramName($programId)
{
    $ProgramName = null;
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT PROGRAM_NAME FROM PROGRAM_COLLEGE WHERE PROGRAM_ID = $programId");
        if ($query->rowCount() != 0 and $name = $query->fetch(PDO::FETCH_NUM)) {
            $ProgramName = $name[0]; // getting the name if the query was successful
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $ProgramName;
}

/**
 * This function returns the student's info in numeric array for the desired semester
 * @author Abdulmohsen Abbas
 * @param string  $semesterId the semester id
 * @param string  $userId the id of the student
 * @param string $userType the type of the user example "student,professor,etc ..."
 * @return string numeric array that contain the program Name, cgpa, sgpa, total Credits, semester Credits
 *  in the wanted semester
 * it will return the name of the grade example " (67 || 68 || 69) will return "C-"
 */
function getStudentRecord($userId, $semId, $userType) // There is some change that happend in the database 
// so we will not be able to use this function (missing columns)
{
    $stuRecord = array();
    if ($userType == "student") { // only for student users
        try {
            // establishing connection
            require("connection.php");
            // setting and running the query
            $query = $db->query("SELECT * FROM student_info WHERE student_id = $userId and sem_id = $semId");
            if ($info = $query->fetch(PDO::FETCH_NUM)) {
                $programName = getProgramName($info[3]);
                $cgpa = $info[2];
                $sgpa = $info[4];
                $totalCredit = $info[5];
                $semesterCredit = $info[6];
                array_push($stuRecord, $programName, $cgpa, $sgpa, $totalCredit, $semesterCredit);
            }
        } catch (PDOException $ex) {
            // printing the error message if error happens
            echo $ex->getMessage();
        }
        // closing connection with the database
        $db = null;
    }
    return $stuRecord;
}

/**
 * This function returns the student's grades info in numeric array for the desired semester
 * @author Abdulmohsen Abbas
 * @param string  $semesterId the semester id
 * @param string  $studentId the id of the student
 * @return string numeric array that contain numeric arrays with ( the course code,
 *  course name, course credit, and course grade) for all the courses in the wanted semester and student
 * and here simple output for the inner array:
 *  { [0]=> string(7) "ITCS389" [1]=> string(22) "SOFTWARE ENGINEERING I" [2]=> string(1) "3" [3]=> string(2) "B-" }
 */
function getStudentGradesinfo($semesterId, $studentId)
{
    $arr = array();
    $gradesInfo = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT course_id, grade FROM REGISTRATION_COURSES WHERE sem_id = $semesterId AND student_id = $studentId");
        while ($grwe = $query->fetch(PDO::FETCH_NUM)) {
            $coursedata = getCourseInfo($grwe[0]);
            $ccode = $coursedata[0];
            $cname = $coursedata[1];
            $ch = $coursedata[2];
            $grade = getGradeName($grwe[1]);
            $arr = [$ccode, $cname, $ch, $grade];
            array_push($gradesInfo, $arr);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $gradesInfo;
}
/**
 * This function returns the student's grades in numeric array for the desired semester
 * @author Abdulmohsen Abbas
 * @param string  $semesterId the semester id
 * @param string  $studentId the id of the student
 * @return array numeric array that contain the grades for the registered courses in the wanted semester
 * it will return the name of the grade example " (67 || 68 || 69) will return "C-"
 */
function getStudentGrades($semesterId, $studentId)
{
    $grades = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT grade FROM REGISTRATION_COURSES WHERE sem_id = $semesterId AND student_id = $studentId");
        while ($gr = $query->fetch(PDO::FETCH_NUM)) {
            $gname = getGradeName($gr[0]);
            array_push($grades, $gname);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $grades;
}

/**
 * This function returns the student's courses credits in numeric array for the desired semester
 * @author Abdulmohsen Abbas
 * @param string  $semesterId the semester id
 * @param string  $studentId the id of the student
 * @return string numeric array that contain the credits for the registered courses in the wanted semester
 */
function getStudentCredits($semesterId, $studentId)
{
    $Credits = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT course_id FROM REGISTRATION_COURSES WHERE sem_id = $semesterId AND student_id = $studentId");
        while ($cr = $query->fetch(PDO::FETCH_NUM)) {
            $ch = getCourseCredit($cr[0]);
            array_push($Credits, $ch);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $Credits;
}
/**
 * This function calculate and returns the student's gpa 
 * @author Abdulmohsen Abbas
 * @param array  $grades is a numeric array that contain student's grades 
 * @param array  $credits is a numeric array that contain the credit for each grade in $grades array
 * @return float gpa 
 */
function getGPA($grades, $credits)
{
    $totalCR = 0;
    $gpa = 0;
    for ($i = 0; $i < count($grades); ++$i) {
        $gradew = getGradeWeight($grades[$i]);
        $cr = floatval($credits[$i]);
        $totalCR += $cr;
        $gpa += ($gradew * $cr);
    }
    $gpa = $gpa / $totalCR;
    return $gpa;
}

/**
 * Returns an array that contains associative arrays such that each one of them contains
 *  the semester id as a key and semester name as a value for all previous semesters
 * @author Abdulmohsen Abbas
 * @author Omar Eldanasoury
 * @return string array that contain the previous semesters info(sem_id,sem_name)s
 */
function getPreviousSemesters()
{
    $PrevSemesters = array();
    $currentSemId = getCurrentSemesterId();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT sem_id, sem_name FROM semester where sem_id != $currentSemId AND SEM_ID < $currentSemId");
        while ($allsems = $query->fetch(PDO::FETCH_NUM)) {

            $sems = array($allsems[0], $allsems[1]);
            array_push($PrevSemesters, $sems);
        }
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $PrevSemesters;
}

/**
 * Returns the courses that the student
 * can Register
 * @author Abdulmohsen Abbas
 * @param mixed $userId the student id
 * @return string array of available courses for the student to register
 * the available courses are the courses that the student have not registered
 *  before or they registered it but got grade less than C .
 */
function getStudentAvailableCourses($studentId)
{
    $courses = array();
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $query = $db->query("SELECT CS.prog_id, C.course_id FROM student_info AS CS, program_course AS C WHERE CS.prog_id = C.program_id AND CS.student_id = $studentId");
        while ($idAndCode = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of course_id if the query was successful
            array_push($courses, $idAndCode[1]); // puts all the student's program courses in the array
        }
        $courses = filterCourses($studentId, $courses); // then we filter the array to remove previously taken courses
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
    }
    // closing connection with the database
    $db = null;
    return $courses;
}

/**
 * Removes previously registered courses that the student got in them >= C 
 * @author Abdulmohsen Abbas
 * @param int $studentId the student id
 * @param mixed $courses array of courses
 * @return string Edited array of available courses for the student to register
 * the available courses are the courses that the student have not registered
 *  before or they registered it but got grade less than C .
 */
function filterCourses($studentId, $courses)
{
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        // here we query all the previously taken courses by student
        $query = $db->query("SELECT course_id, grade FROM registration_courses WHERE student_id = $studentId");
        while ($idAndGrade = $query->fetch(PDO::FETCH_NUM)) {
            // getting the list of grades and course_id if the query was successful
            $gr = $idAndGrade[1];
            if ($gr >= 70 || $gr == null) { // $gr==null this in case the grade wasn't recorded yet mean the student just registered the course
                for ($i = count($courses) - 1; $i >= 0; $i--) {
                    // We started from the last element to the first one so the indexes of the unchecked 
                    // elements will not changed when we unset an element from the array
                    if ($courses[$i] == $idAndGrade[0]) {
                        unset($courses[$i]);
                    }
                }
            }
            $courses = array_values($courses); //  array_values will rearrange the indexes of the array 
            // in assending order in case of missing element(s)
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
 * this function will return the section info in numeric array in this order [ (sec_id), (sem_id), (course_id), 
 * (sec_num), (professor_id), (room_id), (lecture_days), (lecture_time), (capacity) ]
 * 
 * @author Abdulmohsen
 * @param $sectionId the section id
 * @return string numeric array that contains the section infocif the operation completed 
 * successfully, otherwise bool false 
 */
function getSectionInfo($sectionId)
{
    try {
        require("connection.php");
        $sql = "SELECT * FROM COURSE_SECTION WHERE SECTION_ID = $sectionId";
        $statement = $db->prepare($sql);
        $statement->execute();

        if ($section = $statement->fetch(PDO::FETCH_NUM)) {
            return $section;
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";

        $db = null;
    }
    return null;
}


/**
 * Register course in the schedule of the student 
 * 
 * @author Abdulmohsen
 * @param $semId the semester id
 * @param $courseid the course id
 * @param $secid the section id
 * @param $userid the id of the student
 * @return bool true if the operation was true, otherwise false
 */
function RegisterSection($semid, $courseid, $secid, $userid)
{
    require("connection.php");
    try {
        $sql = "INSERT INTO REGISTRATION_COURSES VALUES(?, ?, ?, ?, ?, ?, ?);";
        $db->beginTransaction();
        $statement = $db->prepare($sql);
        $statement->execute(array($semid, $courseid, $secid, $userid, null, 0, 0));
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        echo $e->getMessage() . "<br>";
        $db = null;
        return false;
    }
    return ($statement->rowCount() == 1);
}
/**
 * Reducing the Capacity of a section after the student take the seat
 * this is the value of the new capacity ' Capacity= Capacity -1 '
 * @author Abdulmohsen
 * @param $sectionId the section id
 * @param $capacity of the section
 * @return bool true if the operation was true, otherwise false
 */
function ReduceCapacity($sectionId, $capacity)
{
    require("connection.php");
    try {
        // establishing connection
        require("connection.php");
        // setting and running the query
        $sql = "UPDATE course_section SET capacity = ? WHERE section_id = ?";
        $statement = $db->prepare($sql);
        $sectionId = intval($sectionId);
        $capacity = intval($capacity);
        $capacity--;
        $statement->bindParam(1, $capacity);
        $statement->bindParam(2, $sectionId);

        $statement->execute();
    } catch (PDOException $ex) {
        // printing the error message if error happens
        echo $ex->getMessage();
        return false;
    }
    // closing connection with the database
    $db = null;
    return true;
}

/**
 * Returns the gpa of the
 * student given his/her id
 * 
 * @author Omar Eldanasoury
 * @param mixed $studentId
 * @return mixed student GPA
 */
function getStudentGPA($studentId)
{
    try {
        require("connection.php");
        // getting the courses that belong to the student, in the current semester, and have no appealing requests issued yet
        $sql = "SELECT GPA FROM STUDENT_INFO WHERE STUDENT_ID = $studentId";
        $statement = $db->prepare($sql);
        $statement->execute();

        if ($studentGPA = $statement->fetch(PDO::FETCH_NUM)) {
            return $studentGPA[0];
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";
        $db = null;
    }
    $db = null;
    return null;
}
