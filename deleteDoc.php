<?php
require_once "inc/config.php";
require_once "inc/class.doc.inc";

$d=new doc();
$d->delete($_GET['id']);

header("Location: documents.php?error={$d->error}&msg={$d->msg}");

?>