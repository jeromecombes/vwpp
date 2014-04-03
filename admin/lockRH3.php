<?php		//	Lock VWPP Courses choices for selected students
session_start();
require_once "../inc/config.php";

access_ctrl(16);

$semester=str_replace("_"," ",$_SESSION['vwpp']['semester']);

foreach($_POST['students'] as $student){
  $db=new db();
  $db->delete("courses_rh","student='$student' AND semester='$semester'");

  $db=new db();
  $db->insert2("courses_rh",array("semester"=>$semester,"student"=>$student));
}

header("Location: students-list.php?error=0&msg=update_success");
?>