<?php
require_once "../inc/config.php";
require_once "../inc/class.doc.inc";
access_ctrl(8);

$d=new doc();
$d->delete($_GET['id']);

header("Location: students-view2.php?error={$d->error}&msg={$d->msg}");

?>