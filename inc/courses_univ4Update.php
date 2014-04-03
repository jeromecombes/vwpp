<?php
require_once "config.php";
require_once "class.univ4.inc";

$u=new univ4();
//	Delete
if(isset($_GET['delete'])){
  $u->delete($_GET['id']);
}
//	Add
elseif(!$_POST['id']){
  $u->add($_POST);
}
//	Update Modalites
elseif(isset($_POST['modalitesOnly'])){
  $u->updateModalites($_POST);
}
//	Update
else{
  $u->update($_POST);
}

$error=$u->error;
$msg=$u->msg;

$page=$_SESSION['vwpp']['category']=="admin"?"../admin/students-view2.php":"../courses.php";
header("Location: $page?error=$error&msg=$msg");

?>