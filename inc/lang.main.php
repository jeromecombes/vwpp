<?php
$lang=$_SESSION['vwpp']['language'];
require_once "lang.en.inc";
if($lang)
  require_once "lang.$lang.inc";
?>
