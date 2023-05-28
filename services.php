<?php

/**
 * Services.php file
 * A php file that contains
 * functions that return the
 * list of services for each
 * user type the arrays store
 * the title and service path
 * for each service.
 * 
 * @author Omar Eldanasoury
 */
require_once("functions.php");

/**
 * Returns the list of services
 * that should be shown to professors.
 * 
 * @author Omar Eldanasoury
 * @return array<string> Professor's list of services
 */
function getProfessorList()
{
    $basePath = "/course-registration-system/professor/";
    return array(
        "Manage Grades" => $basePath . "manage-grades.php",
        "Manage Appealing Requests" => $basePath . "appealing-requests.php",
        "View Section" => $basePath . 'view-section.php',
    );
}

/**
 * Returns the list of services
 * that should be shown to students.
 * 
 * @author Omar Eldanasoury
 * @return array<string> Student's list of services
 */
function getStudentList()
{
    $basePath = "/course-registration-system/student/";
    return array(
        "Course Registration" => $basePath . "course-registration.php",
        "View Course Schedule" => $basePath . "course-schedule.php",
        "View Course Prerequisites" => $basePath . 'view-prerequisites.php',
        "View Grades" => $basePath . 'view-grades.php',
        "View Transcript" => $basePath . 'view-transcript.php',
        "View Program Courses" => $basePath . 'program-courses.php',
        "Simulate GPA" => $basePath . 'simulate-gpa.php',
        "Add Appealing Request" => $basePath . 'appealing-request.php',
        "View Appealing Requests" => $basePath . 'view-appealing-requests.php',
        "Pay Courses Fees" => $basePath . 'pay-fees.php',
    );
}

/**
 * Returns the list of services
 * that should be shown to admins.
 * 
 * @author Omar Eldanasoury
 * @return array<string> Admin's list of services
 */
function getAdminList()
{
    $basePath = "/course-registration-system/admin/";
    return array(
        "Add Users" => $basePath . "add-user.php",
        "View Users" => $basePath . "view-user.php",
        "Update Users" => $basePath . "update-user.php", // this is the same as managing the profile of users
        "Delete Users" => $basePath . "delete-user.php",

        "0" => "break", // breaks to separate the options in the front-end

        "Add Course" => $basePath . "add-course.php",
        "Update Course" => $basePath . "update-course.php",
        "Delete Course" => $basePath . "delete-course.php",

        "1" => "break", // breaks to separate the options in the front-end

        "Add Section" => $basePath . 'add-section.php',
        "View Section" => $basePath . 'view-section.php',
        "Update Section" => $basePath . 'update-section.php',
        "Delete Section" => $basePath . 'delete-section.php',

        "2" => "break", // breaks to separate the options in the front-end

        "Add Semesters" => $basePath . "add-semester.php",
        "View Semesters" => $basePath . "view-semester.php",
        "Manage Semester Status" => $basePath . "semester-status.php",
        "Delete Semesters" => $basePath . "delete-semester.php",

        "3" => "break", // breaks to separate the options in the front-end

        "Add Buildings" => $basePath . 'add-building.php',
        "Delete Buildings" => $basePath . 'delete-building.php',
        "Add Room" => $basePath . 'add-room.php',
        "Delete Room" => $basePath . 'delete-room.php',

        "4" => "break", // breaks to separate the options in the front-end

        "Add College" => $basePath . "add-college.php",
        "Delete College" => $basePath . "delete-college.php",
        "Add Department" => $basePath . "add-department.php",
        "Delete Department" => $basePath . "delete-department.php",

        "5" => "break", // breaks to separate the options in the front-end

        "Add Program" => $basePath . "add-program.php",
        "Delete Program" => $basePath . "delete-program.php",
    );
}

/**
 * Returns the list of services
 * that should be shown to head
 * of departmentusers.
 * 
 * @author Omar Eldanasoury
 * @return array<string> HOD's list of services
 */
function getHodList()
{
    $basePath = "/course-registration-system/dean-hod/";
    return array(
        "View Seat Requests" => $basePath . "seat-requests.php",
        "View Students" => $basePath . "view-students.php",
    );
}

/**
 * Returns the list of services
 * that should be shown to dean
 * users.
 * 
 * @author Omar Eldanasoury
 * @return array<string> Dean's list of services
 * 
 */
function getDeanList()
{
    $basePath = "/course-registration-system/dean-hod/";
    return array(
        "View Seat Requests" => $basePath . "seat-requests.php",
        "View Students" => $basePath . "view-students.php",
        "View Staff" => $basePath . 'view-staff.php',
    );
}

/**
 * Returns the list of servies
 * based on the type of the current
 * logged in user
 * 
 * @author Omar Eldanasoury
 * @return array<string> User's List as an array of string
 */
function getUserServicesList($userType)
{
    if ($userType == 'student')
        return getStudentList();
    else if ($userType == 'admin')
        return getAdminList();
    else if (($userType == 'head of department'))
        return getHodList();
    else if ($userType == 'professor')
        return getProfessorList();
    else
        return getDeanList();
}
