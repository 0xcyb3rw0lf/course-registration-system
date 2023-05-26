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
    return array(
        // TODO: Fill the paths of these pages
        "Add Users" => "/course-registration-system/admin/",
        "View Users" => '/course-registration-system/admin/',
        "Update Users" => '/course-registration-system/admin/', // this is the same as managing the profile of users
        "Delete Users" => "/course-registration-system/admin/",
        "0" => "break", // breaks to separate the options in the front-end
        "Add Course" => '/course-registration-system/admin/',
        "View Course" => '/course-registration-system/admin/',
        "Edit Course" => '/course-registration-system/admin/',
        "Delete Course" => '/course-registration-system/admin/',
        "1" => "break", // breaks to separate the options in the front-end
        "Add Section" => '/course-registration-system/admin/add-section.php',
        "View Section" => '/course-registration-system/admin/view-section.php',
        "Update Section" => '/course-registration-system/admin/update-section.php',
        "Delete Section" => '/course-registration-system/admin/delete-section.php',
        "2" => "break", // breaks to separate the options in the front-end
        "Add Semesters" => '/course-registration-system/admin/',
        "View Semesters" => '/course-registration-system/admin/',
        "Edit Semesters" => '/course-registration-system/admin/',
        "Delete Semesters" => '/course-registration-system/admin/',
        "3" => "break", // breaks to separate the options in the front-end
        "Add Buildings" => '/course-registration-system/admin/add-building.php',
        "Delete Buildings" => '/course-registration-system/admin/delete-building.php',
        "Add Room" => '/course-registration-system/admin/add-room.php',
        "Delete Room" => '/course-registration-system/admin/delete-room.php',
        "4" => "break", // breaks to separate the options in the front-end
        "Add Program" => "",
        "Delete Program" => "",
        "View Summer Seats" => '/course-registration-system/admin/',
        "Generate Reports" => '/course-registration-system/admin/',
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
