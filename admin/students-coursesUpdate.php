<?php
require_once "../inc/config.php";

unset($_POST['page']);

$db=new db();
//	Delete University or CIPh
if(isset($_GET['delete'])){ // and ($_GET['univ']=="univ" or $_GET['univ']=="ciph")){
  $table="courses_".$_GET['univ'];
  $db=new db();
  $db->delete($table,"id={$_GET['id']}");
  $msg=$db->error?array("delete_error",1):array("delete_success",0);
}
//	Update University or CIPh
elseif($_POST['id']){	// and ($_POST['univ']=="univ" or $_POST['univ']=="ciph")){
  $table="courses_".$_POST['univ'];
  $student=$_SESSION['vwpp']['std-id'];
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
  $msg=$db->error?array("update_error",1):array("update_success",0);
}
//	Insert University or CIPh
else{
  $table="courses_".$_POST['univ'];
  unset($_POST['univ']);
  unset($_POST['id']);
  $student=$_SESSION['vwpp']['std-id'];
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
  $msg=$db->error?array("update_error",1):array("update_success",0);
}

$error=$msg[1];
$msg=$msg[0];

header("Location: students-view2.php?error=$error&msg=$msg");
?>