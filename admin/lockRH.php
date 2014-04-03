<?php		//	Lock or Unlock VWPP Courses Choices for 1 student
session_start();
require_once "../inc/config.php";

access_ctrl(16);

$semester=str_replace("_"," ",$_SESSION['vwpp']['semester']);
$student=$_GET['student'];
$lock=$_GET['lock'];

$db=new db();
$db->delete("courses_rh","student='$student' AND semester='$semester'");

if($lock=="Lock"){
  $db=new db();
  $db->insert2("courses_rh",array("semester"=>$semester,"student"=>$student));
}
?>