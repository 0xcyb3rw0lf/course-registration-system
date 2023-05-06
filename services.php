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
        "Manage Appealing Requests" => "professor/appeal-requests.php",
        "Manage Attendance" => 'professor/manage-attendance.php',
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
        "Course Registration" => "student/",
        "Course Schedule" => "student/",
        "View Grades" => 'student/',
        "View Attendance" => 'student/',
        "View Transcript" => 'student/',
        "Simulate GPA" => 'student/',
        "Request Summer Seat" => 'student/',
        "Add Appealing Request" => 'student/',
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
        "Manage Profile" => "admin/",
        "Add Users" => "admin/",
        // ******* These can be done in the same page
        "Delete Users" => "admin/",
        "View/Update Users" => 'admin/',
        // *********
        "Manage Rooms" => 'admin/',
        "Generate Reports" => 'admin/',
        "Manage Semesters" => 'admin/',
        "Add Course" => 'admin/',
        "View/Edit Course" => 'admin/',
        "Delete Course" => 'admin/',
        "Add Section" => 'admin/add-section.php',
        "View Section" => 'admin/view-section.php',
        "Update Section" => 'admin/',
        "Delete Section" => 'admin/delete-section.php',
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
        "Close Section" => 'dean-hod/',
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
