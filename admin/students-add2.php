<?php
/*
VWPP Database V 3.0
Last update 13/06/2013, Jérôme Combes
*/

require_once "../inc/config.php";
require_once "../inc/class.mails.inc";
require_once "../inc/class.users.inc";
access_ctrl(4);

$password="password"; // 	faire mot de passe aleatoire
$semester=$_SESSION['vwpp']['semestre'];
$semesters=serialize(array($semester));
$studentsList=array();

foreach($_POST['students'] as $elem){
  if($elem!=array('','','')){
    $token=md5(trim($elem[2]));
    $password=md5("password");
    $visiting=$elem[3]==1?", Visiting":null;
    $studentsList[]="<li>{$elem[0]} {$elem[1]}, {$elem[2]}{$visiting}</li>";
    for($i=0;$i<3;$i++){		// Encrypt lastname, firstname and email
      $elem[$i]=encrypt(htmlentities(trim($elem[$i]),ENT_QUOTES | ENT_IGNORE,"UTF-8"));
    }
    $std[]=array(":lastname"=>$elem[0],":firstname"=>$elem[1],":email"=>$elem[2],
    ":token"=> $token, ":password"=>$password, ":university"=>$_SESSION['vwpp']['login_univ'],
    ":guest"=>$elem[3],":semestre"=>$semester,":semesters"=>$semesters);
  }
}

$sql="INSERT INTO {$dbprefix}students (lastname, firstname, email, token, password, university, guest, semestre, semesters) VALUES 
  (:lastname, :firstname, :email, :token, :password, :university, :guest, :semestre, :semesters);";
$db=new dbh();
$db->prepare($sql);
foreach($std as $elem){
  $db->execute($elem);
}

//	Envoi des alertes par emails en cas d'ajout d'étudiants
$error=0;
$msg="insert_success";
$u=new user();
$u->fetchUsersAlerts();
$users=$u->elements;

if(!empty($users)){
  $message="Les &eacute;tudiants suivants ont &eacute;t&eacute; enregistr&eacute;s dans la base de donn&eacute;es VWPP : <br/><ul>\n";
  $message.=join("\n",$studentsList);
  $message.="</ul><br/>Universit&eacute; : {$_SESSION['vwpp']['login_univ']}";
  $message.="<br/>Auteur : {$_SESSION['vwpp']['login_name']}";
  $message.="<br/><br/>The VWPP Database";

  $mail=new vwppMail();
  foreach($users as $elem){
    $mail->addAddress($elem);
  }
  $mail->subject="VWPP Database, Nouveaux étudiants enregistrés";
  $mail->body = $message;
  $mail->send();
  if($mail->error){
    $error=1;
    $msg="send_emails_error";
  }
}

header("Location: students-list.php?error=$error&msg=$msg");
?>
