<?php
require_once "inc/config.php";
require_once "inc/class.doc.inc";

$d=new doc();
$d->fetch($_GET['id']);
$type=$d->type;
$size=$d->size;
$name=$d->name.".".$d->type2;
$doc=$d->doc;

if($d->error){
  header("Location: documents.php?error=1&msg={$d->msg}");
}
else{
  header("Content-length: $size");
  header("Content-Type: ".$type);
  header("Content-Transfer-Encoding: binary");
  header("Content-Disposition: attachment; filename=$name");
  echo $doc;
}


?>