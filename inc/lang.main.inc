<?php
// Upate : 2015-10-13
require_once "lang.en.inc";
if(array_key_exists("vwpp",$_SESSION) and array_key_exists("language",$_SESSION['vwpp'])){
  $language=$_SESSION['vwpp']['language'];
}else{
  $language="en";
}

require_once "lang.{$language}.inc";
?>
