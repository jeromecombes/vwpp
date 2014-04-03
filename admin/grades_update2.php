<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);

require_once "../inc/config.php";
require_once "../inc/class.grades.inc";

access_ctrl("18,19");

$course_id=$_SESSION['vwpp']['course_id'];
$course=$_SESSION['vwpp']['univ'];
// unset($_POST['course']);
  
$keys=array_keys($_POST);
// print_r($keys);
foreach($keys as $key){
  $tmp=explode("_",$key);
  $field=$tmp[0];
  $student=$tmp[1];
  $grade=$_POST[$key];
  
  $g=new grades();
  $g->update($student,$course,$course_id,$grade,$field);
}

$error=0;
$msg="update_success";
header("Location: grades3-2.php?error=$error&msg=$msg");

?>