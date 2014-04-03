<?php
require_once "../header.php";
require_once "students-menu2.php";

access_ctrl(16);

//	Delete University
if(isset($_GET['delete']) and isset($_GET['id'])){
  $db=new db();
  $db->delete("courses_univ","id='{$_GET['id']}'");
  $msg=$db->error?array("Error while deleting","red"):array("Delete successful","green");
}
//	Update University
elseif($_POST['id'] and $_POST['univ']=="univ"){
  $student=$_POST['student'];
  $data=array(":id"=>$_POST['id']);
  $sql=array();

  unset($_POST['id']);
  unset($_POST['semester']);
  unset($_POST['student']);
  unset($_POST['univ']);

  $keys=array_keys($_POST);
  foreach($keys as $key){
    $data[":{$key}"]=encrypt($_POST[$key],$student);
    $sql[]="{$key}=:{$key}";
  }

  $sql="UPDATE `{$dbprefix}courses_univ` SET ".join(", ",$sql)." WHERE id=:id;";
  $db=new dbh();
  $db->prepare($sql);
  $db->execute($data);
  $msg=$db->error?array("Error while updating","red"):array("Update successful","green");
}
//	Insert University
elseif($_POST['univ']=="univ"){
  $student=$_POST['student'];
  unset($_POST['student']);
  unset($_POST['univ']);
  unset($_POST['id']);
  $data=array(":student"=>$student, ":semester"=>$_SESSION['vwpp']['semestre']);
  $keys=array_keys($_POST);
  foreach($keys as $key){
    $data[":{$key}"]=encrypt($_POST[$key],$student);
  }
  $fields="(student, semester, ".join(", ",$keys).")";
  $values="(:student, :semester, :".join(", :",$keys).")";

  $sql="INSERT INTO `{$dbprefix}courses_univ` $fields VALUES $values;";
  $db=new dbh();
  $db->prepare($sql);
  $db->execute($data);
  $msg=$db->error?array("Error while updating","red"):array("Update successful","green");
}

echo <<<EOD
<div class='information' style='color:{$msg[1]};'>{$msg[0]}</div>
<script type='text/JavaScript'>
setTimeout("document.location.href='students-view2.php'",1500);
</script>
EOD;

require_once "../footer.php";
?>