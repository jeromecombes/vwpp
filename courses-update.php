<?php
require_once "inc/config.php";

unset($_POST['page']);


$db=new db();
//	Update Reid Hall
if($_POST['id'] and $_POST['univ']=="rh"){
  unset($_POST['univ']);
  $db->update2("courses_choices",$_POST,array("id"=>$_POST['id']));
  $msg=$db->error?"update_error":"update_success";
}
//	Insert Reid Hall
elseif($_POST['univ']=="rh"){
  unset($_POST['univ']);
  unset($_POST['id']);
  $insert=array_merge($_POST,array("semester"=>$_SESSION['vwpp']['semestre'],"student"=>$_SESSION['vwpp']['student']));
  $db->insert2("courses_choices",$insert);
  $msg=$db->error?"insert_error":"insert_success";
}
//	Delete University or CIPh
elseif(isset($_GET['delete'])){
  $table="courses_".$_GET['univ'];
  $db=new db();
  $db->delete($table,"id={$_GET['id']}");
  $msg=$db->error?"delete_error":"delete_success";
}
//	Update University or CIPh
elseif($_POST['id']){
  $table="courses_".$_POST['univ'];
  $student=$_SESSION['vwpp']['student'];
  $data=array(":id"=>$_POST['id']);
  $sql=array();

  unset($_POST['id']);
  unset($_POST['semester']);
  unset($_POST['student']);
  unset($_POST['univ']);

  $keys=array_keys($_POST);
  foreach($keys as $key){
    if(in_array($key,array("university","cm_code")))
      $data[":{$key}"]=encrypt(htmlentities($_POST[$key],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
    else
      $data[":{$key}"]=encrypt(htmlentities($_POST[$key],ENT_QUOTES | ENT_IGNORE,"UTF-8"),$student);
    $sql[]="{$key}=:{$key}";
  }

  $sql="UPDATE `{$dbprefix}{$table}` SET ".join(", ",$sql)." WHERE id=:id;";

  $db=new dbh();
  $db->prepare($sql);
  $db->execute($data);
  $msg=$db->error?"update_error":"update_success";
}
//	Insert University or CIPh
else{
  $table="courses_".$_POST['univ'];
  unset($_POST['univ']);
  unset($_POST['id']);
  $student=$_SESSION['vwpp']['student'];
  $data=array(":student"=>$student, ":semester"=>$_SESSION['vwpp']['semestre']);
  $keys=array_keys($_POST);
  foreach($keys as $key){
    if(in_array($key,array("university","cm_code")))
      $data[":{$key}"]=encrypt(htmlentities($_POST[$key],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
    else
      $data[":{$key}"]=encrypt(htmlentities($_POST[$key],ENT_QUOTES | ENT_IGNORE,"UTF-8"),$student);
  }
  $fields="(student, semester, ".join(", ",$keys).")";
  $values="(:student, :semester, :".join(", :",$keys).")";

  $sql="INSERT INTO `{$dbprefix}{$table}` $fields VALUES $values;";

  $db=new dbh();
  $db->prepare($sql);
  $db->execute($data);
  $msg=$db->error?"update_error":"update_success";
}

$error=$db->error?1:0;
header("Location: courses.php?error=$error&msg=$msg");
?>