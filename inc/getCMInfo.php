<?php
/*ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);*/
require_once "config.php";
require_once "class.univ3.inc";

$u=new univ3();
$u->fetchCM($_GET['univ'],$_GET['code']);
if($u->elements){
  $cm=$u->elements;
  $keys=array_keys($cm);
  foreach($keys as $key){
    $tab[]="$key!%={$cm[$key]}";
  }
  $vars=join("=%!",$tab);
  echo $vars;
}
?>