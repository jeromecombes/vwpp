<?php
require_once "../inc/config.php";
$table=$_GET['table'];
$student=$_SESSION['vwpp']['std-id'];
$semester=$_SESSION['vwpp']['semester'];

$db=new db();
$db->select($table,"*","semester='$semester' AND student=$student");

if($db->result){
  $db=new db();
  $db->delete($table,"semester='$semester' AND student=$student");
  $success_msg="unlock_success";
}
else{
  $db=new db();
  $db->insert2($table,array("semester"=>$semester,"student"=>$student));
  $success_msg="lock_success";
}

echo $success_msg;
?>