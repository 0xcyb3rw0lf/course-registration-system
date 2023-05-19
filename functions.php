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
        $sql = "SELECT SEM_ID FROM SEMESTER WHERE NOW() >= APPEAL_START AND NOW() <= APPEAL_END;";
        $statement = $db->prepare($sql);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";
        $db = null;
    }
    $db = null;
    return $statement->fetch(PDO::FETCH_NUM) != null; // if the database returns nothing, so the student is out of appealing period 
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
 * @param mixed $
 * @return mixed professor name
 */
function getBuildingName($roomId)
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
 * @param mixed $
 * @return mixed professor name
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
