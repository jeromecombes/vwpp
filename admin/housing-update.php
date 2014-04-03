<?php
require_once "../inc/config.php";
require_once "../inc/class.housing.inc";

$l=new housing();
$l->updateLogement($_POST['logement']);

$id=$_POST['logement']['id']?$_POST['logement']['id']:$l->maxID;

$msg="update_success";
$error=0;
header("Location: housing-edit.php?id=$id&error=$error&msg=$msg");
?>