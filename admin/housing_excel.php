<?php
require_once "../inc/config.php";
require_once "../inc/class.housing.inc";

access_ctrl(2);

$h=new housing();
$h->fetchAll();
$elements=$h->excelElem;
$questions=$h->questions;
$questions_Ids=$h->questions_Ids;

$Fnm = "../data/housing_{$_SESSION['vwpp']['semester']}";

if($_GET['type']=="csv"){
  $separate="';'";
  $Fnm.=".csv";
}
else{
  $separate="\t";
  $Fnm.=".xls";
}

$questions=array_merge(array("Lastname","Firstname"),$questions);
$lines=Array();
$lines[]=join($questions,$separate);

foreach($elements as $elem){
  $cells=array();
  $cells[]=$elem['lastname'];
  $cells[]=$elem['firstname'];
  foreach($questions_Ids as $id){
    $cells[]=$elem[$id];
  }
  $lines[]=join($cells,$separate);
}


$inF = fopen($Fnm,"w");
foreach($lines as $elem){
  fputs($inF,$elem."\n");
}
fclose($inF);

header("Location: $Fnm");







?>