<?php
// ini_set('display_errors',1);
// ini_set('error_reporting',E_ALL);

require_once "../inc/config.php";
require_once "../inc/class.doc.inc";
access_ctrl(8);

$d=new doc();
$d->update($_FILES['files'],$_POST['docs']);

header("Location: students-view2.php?error={$d->error}&msg={$d->msg}");

?>