<?php
require_once "../inc/config.php";
require_once "../inc/class.univ4.inc";

$u=new univ4();
//	Delete
if(isset($_GET['delete'])){
  $u->delete($_GET['id']);
}
//	Update
else{
  $u->update($_POST);
}

$error=$u->error;
$msg=$u->msg;

$page="courses4.php";
header("Location: $page?error=$error&msg=$msg");









?>