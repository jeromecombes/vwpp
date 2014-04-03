<?php
require_once "../inc/config.php";
access_ctrl(12);

$db=new db();
$db->query("DELETE FROM users WHERE id='{$_GET['id']}';");

header("Location: users.php");
?>
