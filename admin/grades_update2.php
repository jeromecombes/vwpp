<?php
// Update 2016-01-07

ini_set('display_errors',0);
ini_set('error_reporting',E_ALL);

require_once "../inc/config.php";
require_once "../inc/class.grades.inc";

access_ctrl("18,19");

$course_id=$_SESSION['vwpp']['course_id'];
$course=$_SESSION['vwpp']['univ'];

$post=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

$tab=array();
foreach ($post as $key => $value){
  $tmp=explode("_",$key);
  $key=$tmp[0];
  $std=$tmp[1];
  if(is_numeric($std)){
    $tab[$std]["course"]=$course;
    $tab[$std]["course_id"]=$course_id;
    $tab[$std]["student"]=$std;
    $tab[$std][$key]=$value;
    $tab[$std][$key]=$value;
  }
}
/**
* $tab = array ( key => array ( student, course, course_id, note, date1, grade, date2), student_id2 => array (...
*/

$g=new grades();
$g->data=$tab;
$g->update();

$error=0;
$msg="update_success";
header("Location: grades3-2.php?error=$error&msg=$msg");
?>