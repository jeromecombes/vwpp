<?php
require_once "header.php";
require_once "menu.php";

$std_id=$_SESSION['vwpp']['student'];
$timestamp=isset($_GET['timestamp'])?$_GET['timestamp']:null;
$form=isset($_GET['form'])?$_GET['form']:null;

if(!$form){
  require_once "footer.php";
  exit;
}


$db=new db();
require_once "inc/eval.ciph.inc";

require_once "footer.php";
?>