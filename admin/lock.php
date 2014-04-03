<?php
require_once "../inc/config.php";
$db=new db();
$db->update($_GET['table'],"`lock`='{$_GET['lock']}'","id='{$_GET['id']}'");
$success_msg=$_GET['lock']==0?"Unlock success":"Lock success";
echo $db->error?$db->error:$success_msg;
?>