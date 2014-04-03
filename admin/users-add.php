<?php
require_once "../inc/config.php";
access_ctrl(11);

$_POST['login']=strtolower($_POST['login']);
$_POST['password']=md5($_POST['password']);
unset($_POST['password2']);
$_POST['access']=isset($_POST['access'])?serialize($_POST['access']):serialize(array());
$_POST['email']=trim(strtolower($_POST['email']));
$_POST['token']=md5($_POST['email']);

$db=new db();
$db->insert2("users",$_POST);

//		send a email with a link and/or password

header("Location: users.php");
?>
