<?php
// Last Update 27/09/2013, Jérôme Combes

require_once "inc/config.php";
require_once "inc/class.student.inc";

  //	ACL if admin
if($_SESSION['vwpp']['category']!="student")
  access_ctrl($_POST['acl']);
  

$std_id=$_POST['std_id'];
$error=false;

//	Custom form
if(array_key_exists("input",$_POST)){
  $customInsert=array();
  $keys=array_keys($_POST['input']);
  foreach($keys as $elem){
    $customInsert[]=array(":question"=>$elem,":student"=>$_POST['std_id'],":responses"=>$_POST['input'][$elem]);
  }
  unset($_POST['input']);

  if(!empty($keys)){
    $customDelete=join(",",$keys);
    $db=new db();
    $db->query("DELETE FROM {$dbprefix}responses WHERE student='{$_POST['std_id']}' AND question IN ($customDelete);");
  }

  $sql="INSERT INTO {$dbprefix}responses (question,student,responses) VALUES 
    (:question, :student, :responses);";
  $db=new dbh();
  $db->prepare($sql);
  foreach($customInsert as $elem)
    $db->execute($elem);
  
}

$table=$_POST['table'];
$page=$_SESSION['vwpp']['category']=="admin"?$_POST['page']:$_POST['std-page'];


//	Original form
if(array_key_exists("data",$_POST)){
  $dataInsert=array();
  $keys=array_keys($_POST['data']);
  foreach($keys as $elem){
    $crypt_key=in_array($elem,array("lastname","firstname","email"))?null:$_POST['std_id'];
    $response=encrypt(htmlentities(trim($_POST['data'][$elem]),ENT_QUOTES | ENT_IGNORE,"UTF-8"),$crypt_key);
    $dataInsert[]=array(":student"=>$_POST['std_id'],":semestre"=>$_POST['semestre'],":question"=>$elem,":response"=>$response);
  }

  $db=new db();
  $db->delete($table,"student='{$_POST['std_id']}' AND semestre='{$_POST['semestre']}'");
  
  $sql="INSERT INTO {$dbprefix}$table (student,semestre,question,response) VALUES 
    (:student, :semestre, :question, :response);";
  $db=new dbh();
  $db->prepare($sql);
  foreach($dataInsert as $elem)
    $db->execute($elem);

}


//	Student form
if(array_key_exists("std",$_POST)){
  $_POST['std']['id']=$_POST['std_id'];
  $std=$_POST['std'];

			      //	Send a notification if the student's cellphone change
  $s=new student();
  $s->id=$std_id;
  $s->fetch();
  if(strcmp($s->elements['cellphone'],$std['cellphone'])){
    $u=new user();
    $u->fetchUsersAlerts();
    $users=$u->elements;

    if(!empty($users)){
      $message="Le num&eacute;ro de t&eacute;l&eacute;phone de <b>{$std['firstname']} {$std['lastname']}</b> a chang&eacute; : <br/>\n";
      $message.="Son nouveau num&eacute;ro est le \"<b>{$std['cellphone']}</b>\"";
      $message.="<br/><br/>Auteur : {$_SESSION['vwpp']['login_name']}";
      $message.="<br/><br/>The VWPP Database";
      $mail=new vwppMail();
      foreach($users as $elem){
	$mail->addAddress($elem);
      }
      $mail->subject="VWPP Database, Numéro de téléphone modifié";
      $mail->body = $message;
      $mail->send();
    }
  }

			      //	Date of birth
  if($_POST['std']['dob']){
    $_POST['std']['dob']=$_POST['std']['yob']."-".$_POST['std']['mob']."-".$_POST['std']['dob'];
  }
  unset($_POST['std']['mob']);
  unset($_POST['std']['yob']);

  $std=new student();
  $std->update($_POST['std']);
  if($std->error){
    $error=true;
  }
}


$error=$error?1:0;
$msg=$error?"update_error":"update_success";
$page.="?error=$error&msg=$msg";

header("Location: $page");

?>