<?php
/*ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);*/
require_once "config.php";
require_once "class.univ3.inc";

$u=new univ3();
$u->fetchTD($_GET['univ'],$_GET['code']);
if($u->elements){
  $td=$u->elements;
  $keys=array_keys($td);
  foreach($keys as $key){
/*    if($key=="jour1" or $key=="jour2"){
      $td[$key]=str_replace(array(1,2,3,4,5,6,7),array("lundi","mardi","mercredi","jeudi","vendredi","samedi","dimanche"),$td[$key]);
    }*/
    $tab[]="$key!%={$td[$key]}";
  }
  $vars=join("=%!",$tab);
  echo $vars;
}
?>