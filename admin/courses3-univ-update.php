<?php
// ini_set('display_errors',1);
// ini_set('error_reporting',E_ALL);

require_once "../inc/config.php";
require_once "../inc/class.univ3.inc";

$back=isset($_POST['back'])?$_POST['back']:"courses3.php";
unset($_POST['back']);

$univ=new univ3();

if($_POST['univ']=="TD"){
  unset($_POST['univ']);
  $univ->updateTD($_POST);
}
else{
  $univ->update($_POST);
}

header("Location: $back?error={$univ->error}&msg={$univ->msg}");

?>