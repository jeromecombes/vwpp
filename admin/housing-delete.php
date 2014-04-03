<?php
require_once "../inc/config.php";
require_once "../inc/class.housing.inc";

access_ctrl(7);

$id=$_SESSION['vwpp']['logement_id'];
$h=new housing();
$h->deleteLogement($id);

$error=$h->error?1:0;
$msg=$h->error?"delete_error":"delete_success";

header("Location: housing-list.php?error=$error&msg=$msg");


?>
