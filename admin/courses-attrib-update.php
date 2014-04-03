<?php
require_once "../inc/config.php";
$semester=$_POST['semester'];
$student=$_POST['student'];
$univ=$_POST['univ'];
unset($_POST['univ']);

if($univ=="rh"){
  $db=new db();
  $db->delete("courses_attrib_rh","student='$student' AND semester='$semester'");
  
  $db=new db();
  $db->insert2("courses_attrib_rh",$_POST);
}

$error=0;
$msg="update_success";

header("Location: students-view2.php?error=$error&msg=$msg");
?>