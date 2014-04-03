<?php
require_once "inc/config.php";
require_once "inc/class.doc.inc";

$d=new doc();
$d->update($_FILES['files'],$_POST['docs']);

header("Location: documents.php?error={$d->error}&msg={$d->msg}");

?>