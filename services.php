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
    return array(
        "Manage Grades" => "/course-registration-system/professor/manage-grades.php",
        "Manage Appealing Requests" => "/course-registration-system/professor/appealing-requests.php",
        "View Section" => '/course-registration-system/professor/view-section.php',
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
    return array(
        // TODO: Fill the paths of these pages
        "Course Registration" => "/course-registration-system/student/course-registration.php",
        "View Course Schedule" => "/course-registration-system/student/",
        "View Course Prerequisites" => '/course-registration-system/student/view-prerequisites.php',
        "View Grades" => '/course-registration-system/student/',
        "View Transcript" => '/course-registration-system/student/',
        "View Program Courses" => '/course-registration-system/student/',
        "Simulate GPA" => '/course-registration-system/student/',
        "Request Summer Seat" => '/course-registration-system/student/',
        "Add Appealing Request" => '/course-registration-system/student/appealing-request.php',
        "View Appealing Requests" => '/course-registration-system/student/view-appealing-requests.php',
        "Pay Courses Fees" => '/course-registration-system/student/pay-fees.php',
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
        // TODO: Fill the paths of these pages
        // $basePath . FILE_NAME
        "Add Users" => $basePath . "add-user.php",
        "View Users" => $basePath . "view-user.php",
        "Update Users" => $basePath . "update-user.php", // this is the same as managing the profile of users
        "Delete Users" => $basePath . "delete-user.php",
        "0" => "break", // breaks to separate the options in the front-end
        "Add Course" => $basePath . "",
        "View Course" => $basePath . "",
        "Edit Course" => $basePath . "",
        "Delete Course" => $basePath . "",
        "1" => "break", // breaks to separate the options in the front-end
        "Add Section" => $basePath . 'add-section.php',
        "View Section" => $basePath . 'view-section.php',
        "Update Section" => $basePath . 'update-section.php',
        "Delete Section" => $basePath . 'delete-section.php',
        "2" => "break", // breaks to separate the options in the front-end
        "Add Semesters" => $basePath . "add-semester.php",
        "View Semesters" => $basePath . "view-semester.php",
        "Manage Semester Status" => $basePath . "semester-status.php",
        "Edit Semesters" => $basePath . "",
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
        "View Summer Seats" => $basePath . "",
        "Generate Reports" => $basePath . "",
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
    return array(
        "View Seat Requests" => "/course-registration-system/dean-hod/seat-requests.php",
        "View Students" => "/course-registration-system/dean-hod/view-students.php",
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
    return array(
        "View Seat Requests" => "/course-registration-system/dean-hod/seat-requests.php",
        "View Students" => "/course-registration-system/dean-hod/view-students.php",
        "View Staff" => '/course-registration-system/dean-hod/view-staff.php',
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
