<?php
// ini_set('display_errors',1);
// ini_set('error_reporting',E_ALL);

require_once "config.php";
require_once "class.univ3.inc";

$u=new univ3();
$u->Lock($_GET['action'],$_GET['id']);

?>