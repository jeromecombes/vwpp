<?php
require_once "lang.en.inc";
if($_SESSION['vwpp']['language'])
  require_once "lang.{$_SESSION['vwpp']['language']}.inc";
?>
