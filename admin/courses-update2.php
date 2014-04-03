<?php
require_once "../header.php";
require_once "menu.php";

unset($_POST['page']);

$db=new db();
//	Delete University or CIPh
if(isset($_GET['delete'])){ // and ($_GET['univ']=="univ" or $_GET['univ']=="ciph")){
  $table="courses_".$_GET['univ'];
  $db=new db();
  $db->delete($table,"id={$_GET['id']}");
  $msg=$db->error?array("Error while deleting","red"):array("Delete successful","green");
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
    $data[":{$key}"]=encrypt(htmlentities($_POST[$key],ENT_QUOTES | ENT_IGNORE,"UTF-8"),$student);
    $sql[]="{$key}=:{$key}";
  }

  $sql="UPDATE `{$dbprefix}{$table}` SET ".join(", ",$sql)." WHERE id=:id;";

  $db=new dbh();
  $db->prepare($sql);
  $db->execute($data);
  $msg=$db->error?array("Error while updating","red"):array("Update successful","green");
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
    $data[":{$key}"]=encrypt(htmlentities($_POST[$key],ENT_QUOTES | ENT_IGNORE,"UTF-8"),$student);
  }
  $fields="(student, semester, ".join(", ",$keys).")";
  $values="(:student, :semester, :".join(", :",$keys).")";

  $sql="INSERT INTO `{$dbprefix}{$table}` $fields VALUES $values;";

  $db=new dbh();
  $db->prepare($sql);
  $db->execute($data);
  $msg=$db->error?array("Error while updating","red"):array("Update successful","green");
}

// echo $sql;
// echo "<br>";
// print_r($data);
// 

  

echo <<<EOD
<div class='information' style='color:{$msg[1]};'>{$msg[0]}</div>
<script type='text/JavaScript'>
setTimeout("document.location.href='courses.php'",1500);
</script>
EOD;

require_once "../footer.php";
?>