<?php
// ini_set('display_errors',1);
// ini_set('error_reporting',E_ALL);

require_once "inc/config.php";
require_once "inc/class.univ_reg.inc";


$u=new univ_reg();
$u->update($_POST['data']);

$error=0;
$msg="update_success";

header("Location: univ_registration.php?error=$error&msg=$msg");

?>