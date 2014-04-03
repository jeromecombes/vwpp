<?php
/*
VWPP Database V 3.0
Last update 27/09/2013, Jérôme Combes
*/

require_once "../inc/config.php";
require_once "../inc/class.student.inc";
require_once "../inc/class.users.inc";
require_once "../inc/class.mails.inc";

  //	ACL
access_ctrl($_POST['acl']);
  
//	Custom form
if(array_key_exists("input",$_POST)){
  $customInsert=array();
  $keys=array_keys($_POST['input']);
  foreach($keys as $elem){
    $customInsert[]=array("question"=>$elem,"student"=>$_POST['std_id'],"responses"=>$_POST['input'][$elem]);
  }
  unset($_POST['input']);

  if(!empty($keys)){
    $customDelete=join(",",$keys);
    $db=new db();
    $db->query("DELETE FROM {$dbprefix}responses WHERE student='{$_POST['std_id']}' AND question IN ($customDelete);");
  }
  
  $db=new db();
  $db->insert2("responses",$customInsert);
}

$table=$_POST['table'];
$page=$_POST['page'];


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


//	General Infos Form
if(array_key_exists("std",$_POST)){
//   $std=$_POST['std'];
//   $std['id']=$_POST['std_id'];
//   $s=new student();
//   $s->update($std);			// La fonction update ne gère pas (pour le moment) la date de naissance

  $dataUpdate=array(":id"=>$_POST['std_id']);

  $std=$_POST['std'];		//	Make a token with email for student logon
  $std['email']=trim(strtolower($std['email']));
  $std['email']=htmlentities($std['email'],ENT_QUOTES | ENT_IGNORE,"UTF-8");
  $dataUpdate[':token']=md5($std['email']);

			      //	Semesters
  $dataUpdate[':semesters']=serialize($std['semesters']);
  unset($std["semesters"]);

			      //	Date of birth
  if($std['dob']){
    $std['dob']=$std['yob']."-".$std['mob']."-".$std['dob'];
  }
  unset($std['mob']);
  unset($std['yob']);

			      //	Send a notification if the student's cellphone change
  $s=new student();
  $s->id=$_POST['std_id'];
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

  $keys=array_keys($std);	//	Encrypt data
  foreach($keys as $elem){
    $crypt_key=in_array($elem,array("lastname","firstname","email"))?null:$_POST['std_id'];
    $std[$elem]=encrypt(htmlentities(trim($std[$elem]),ENT_QUOTES | ENT_IGNORE,"UTF-8"),$crypt_key);
    $dataUpdate[":{$elem}"]=$std[$elem];
    $sql_tab[]="`{$elem}`=:{$elem}";
    }

  $sql=join(", ",$sql_tab);
  $sql="UPDATE `{$dbprefix}students` SET $sql, `token`=:token, `semesters`=:semesters WHERE `id`=:id;";
  $db=new dbh();
  $db->prepare($sql);
  $db->execute($dataUpdate);
}

$error=$error?1:0;
$msg=$error?"update_error":"update_success";
$page.="?error=$error&msg=$msg";

header("Location: $page");

?>