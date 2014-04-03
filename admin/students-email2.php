<?php
require_once "../inc/config.php";
require_once "../inc/class.student.inc";
require_once "../inc/class.mails.inc";

$subject=$_POST["subject"];
$message=htmlentities($_POST["message"],ENT_QUOTES|ENT_IGNORE,"utf-8");
$message=str_replace("\n","<br/>",$message);
$students=unserialize($_POST["students"]);
$error=0;
$msg="send_email_success";

$s=new student();
$s->fetchAll();
$mail=new vwppMail();

foreach($students as $student){
  $mail->addAddress($s->elements[$student]['email']);
}

$mail->AddCC($_SESSION['vwpp']['email']);
$mail->subject=$subject;
$mail->body = $message;
$mail->from=$_SESSION['vwpp']['email'];
$mail->sender=$_SESSION['vwpp']['email'];
$mail->fromName=$_SESSION['vwpp']['login_name'];
$mail->send();
if($mail->error){		// Si erreur, met from et sender par défaut et essai de nouveau
  $mail->error=null;		//	(permet l'envoi même si l'adresse de l'expediteur est erronée)
  $mail->from=null;		
  $mail->sender=null;
  $mail->fromName=null;
  $mail->send();
}
if($mail->error){
  $error=1;
  $msg="send_email_error";
}

header("Location: students-list.php?error=$error&msg=$msg");
?>