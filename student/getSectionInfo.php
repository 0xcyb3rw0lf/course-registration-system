<?php 
session_start();
require_once("../functions.php"); 
if (!isset($_GET["secid"])){
    return null;
}
        $secid = $_GET["secid"]; 
        $sectionData=getSectionInfo($secid); //sec_id, sem_id, course_id, (sec_num), (professor_id), room_id, (lecture_days), (lecture_time), (capacity)
        $courseId=$sectionData[2];
        $courseinfo=getCourseInfo($courseId); // (code), (name) , (ch)
        $roomId=$sectionData[5];
        $room_name=getRoomName($roomId);
        $course_code=$courseinfo[0];
        $course_name=$courseinfo[1];
        $course_ch=$courseinfo[2];
        $sec_number=$sectionData[3];
        $professor_id=$sectionData[4];
        $prfessor_name=getProfessorName($professor_id);
        $lecture_days=$sectionData[6];
        $lecture_time=$sectionData[7];
        $capacity=$sectionData[8];
        $buildingName = getBuildingNameByRoomId($roomId);
echo "$course_name#$course_code#$prfessor_name#$course_ch#$capacity#$sec_number#$lecture_time#$lecture_days#$room_name#$buildingName";
