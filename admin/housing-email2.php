<?php
require_once "../inc/config.php";
require_once "../inc/class.housing.inc";
require_once "../inc/class.mails.inc";

$subject=$_POST["subject"];
$message=$_POST["message"];
$housing=unserialize($_POST["housing"]);
$error=0;
$msg="send_email_success";

$h=new housing();
$h->getLogements();
$mail=new vwppMail();

$mailExist=false;

$mail->AddCC($_SESSION['vwpp']['email']);

foreach($housing as $elem){
  if($h->logements[$elem]['email']){
    $mail->addAddress($h->logements[$elem]['email']);
    $mailExist=true;
  }
  if($h->logements[$elem]['email2']){
    $mail->addAddress($h->logements[$elem]['email2']);
    $mailExist=true;
  }
}

if(!$mailExist){
  $error=1;
  $msg="send_email_error";		// a tester
}
else{
  $mail->subject=$subject;
  $mail->body = str_replace("\n","<br/>",$message);
  $mail->send();
  if($mail->error){
    $error=1;
    $msg="send_email_error";		// a tester
  }
}

header("Location: housing-list.php?error=$error&msg=$msg");
?>