<?php
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
        // TODO: Fill the paths of these pages
        "Manage Grades" => "professor/manage-grades.php",
        "Manage Appealing Requests" => "professor/appealing-requests.php",
        "View Section" => 'professor/view-section.php',
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
        "Add Users" => "admin/",
        "View Users" => 'admin/',
        "Update Users" => 'admin/', // this is the same as managing the profile of users
        "Delete Users" => "admin/",
        "0" => "break", // breaks to separate the options in the front-end
        "Add Course" => 'admin/',
        "View Course" => 'admin/',
        "Edit Course" => 'admin/',
        "Delete Course" => 'admin/',
        "1" => "break", // breaks to separate the options in the front-end
        "Add Section" => 'admin/add-section.php',
        "View Section" => 'admin/view-section.php',
        "Update Section" => 'admin/update-section.php',
        "Delete Section" => 'admin/delete-section.php',
        "2" => "break", // breaks to separate the options in the front-end
        "Add Semesters" => 'admin/',
        "View Semesters" => 'admin/',
        "Edit Semesters" => 'admin/',
        "Delete Semesters" => 'admin/',
        "3" => "break", // breaks to separate the options in the front-end
        "Add Buildings" => 'admin/',
        "Delete Buildings" => 'admin/',
        "Add Room" => 'admin/',
        "Delete Room" => 'admin/',
        "4" => "break", // breaks to separate the options in the front-end
        "View Summer Seats" => 'admin/',
        "Generate Reports" => 'admin/',
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
    // TODO: Fill the paths of these pages
    return array(
        "View Seat Requests" => "dean-hod/",
        "View Students" => "dean-hod/",
        "Close Section" => 'dean-hod/',
        "Edit Course Details" => 'dean-hod/',
        "Generate Reports" => 'dean-hod/'
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
        // TODO: Fill the paths of these pages
        "View Seat Requests" => "dean-hod/",
        "View Students" => "dean-hod/",
        "View Staff" => 'dean-hod/',
        "Edit Course Details" => 'dean-hod/',
        "Generate Reports" => 'dean-hod/'
    );
}

/**
 * returns the list of servies
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
