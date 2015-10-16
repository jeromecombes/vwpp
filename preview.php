<?php
// Update : 2015-10-16

include "inc/config.php";
include "inc/class.doc.inc";

$id=filter_input(INPUT_GET,"id",FILTER_SANITIZE_STRING);

$d=new doc();
$d->fetch($id);

if(!$d->doc){
  echo "Vous n&apos;avez pas les autorisations n&eacute;cessaires pour consulter ce document.";
}else{
  header("Content-Disposition: inline; filename=".$d->name2);
  header("Content-type: ".$d->type);
  header('Cache-Control: private, max-age=0, must-revalidate');
  header('Pragma: public');
  echo $d->doc;
}
?>