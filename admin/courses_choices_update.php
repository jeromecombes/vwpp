<?php
require_once "../inc/config.php";
$semester=$_POST['semester'];
$student=$_POST['student'];
$univ=$_POST['univ'];

if($univ=="rh"){
  $db=new db();
  $db->delete("courses_attrib_rh","student='$student' AND semester='$semester'");
  
  $data=array("student"=>$student,"semester"=>$semester,"course1"=>$
  $db=new db();
  $db->insert2("courses_attrib_rh",$data);



}
else{


}
?>