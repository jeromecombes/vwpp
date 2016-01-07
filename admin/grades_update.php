<?php
// Last update 2016-01-07

ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);

require_once "../inc/config.php";
require_once "../inc/class.grades.inc";

$post=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

$std=$post['student'];
unset($post['student']);

$tab=array();
foreach($post as $key => $value){
  $tmp=explode("_",$key);
  $course=$tmp[0];
  $course_id=$tmp[2];

  switch($tmp[1]){
    case "FR" 		: $key="note";		break;
    case "US" 		: $key="grade";		break;
    case "FRDATE" 	: $key="date1";		break;
    case "USDATE" 	: $key="date2";		break;
  }

  $tab[$course."_".$course_id]["course"]=$course;
  $tab[$course."_".$course_id]["course_id"]=$course_id;
  $tab[$course."_".$course_id]["student"]=$std;
  $tab[$course."_".$course_id][$key]=$value;
}

/**
* $tab = array ( key => array ( student, course, course_id, note, date1, grade, date2), student_id2 => array (...
*/

$g=new grades();
$g->data=$tab;
$g->update();

$error=0;
$msg="update_success";
header("Location: students-view2.php?error=$error&msg=$msg");
?>