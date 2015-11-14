<?php
// Update : 2015-11-14

require_once "../inc/config.php";
require_once "../inc/class.student.inc";

$students=new student();
$students->list=$_POST['students'];
$students->deleteTIN();

if($students->error){
  $msg="deleteTIN_error";
  $error=1;
}
else{
  $msg="deleteTIN_success";
  $error=0;
}

header("Location: students-list.php?msg=$msg&error=$error");
?>