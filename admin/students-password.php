<?php
require_once "../inc/config.php";
require_once "../inc/class.student.inc";

$students=new student();
$students->list=$_POST['students'];
$students->createPassword(true);	// create password and send mail if arg is true.

if($students->error){
  $msg=count($_POST['students'])>1?"send_emails_error":"send_email_error";
  $error=1;
}
else{
  $msg=count($_POST['students'])>1?"send_emails_success":"send_email_success";
  $error=0;
}

header("Location: students-list.php?msg=$msg&error=$error");
?>