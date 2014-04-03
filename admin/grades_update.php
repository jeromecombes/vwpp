<?php
require_once "../inc/config.php";
require_once "../inc/class.grades.inc";

$student=$_POST['student'];
unset($_POST['student']);

$keys=array_keys($_POST);
foreach($keys as $key){
  $tmp=explode("_",$key);
  $course=$tmp[0];
  $course_id=$tmp[2];
  switch($tmp[1]){
    case "FRDATE" 	: $field="date1";	break;
    case "USDATE" 	: $field="date2";	break;
    default		: $field=null;		break;
  }
  $grade=$_POST[$key];

  $g=new grades();
  $g->update($student,$course,$course_id,$grade,$field);
}

$error=0;
$msg="update_success";
header("Location: students-view2.php?error=$error&msg=$msg");

?>