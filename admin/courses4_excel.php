<?php
require_once "../inc/config.php";
require_once "../inc/class.univ4.inc";

// access_ctrl(16);

$fields=array("institution2","discipline","niveau","code","nom","nature","prof","email","jour","debut","fin","modalites","modalites1","modalites2","studentName");
$fields2=array("Institution","Discipline","Niveau","Code","Nom","Nature","Professeur","E-mail","Jour","Début","Fin","Modalités","Modalités 1","Modalités 2","Student");
$fields2=array_map("utf8_decode",$fields2);

$univ=new univ4();
$univ->sort=$_SESSION['vwpp']['univSort'];
$univ->fetchAllStudents();
$univ=array_map("delete_rnt",$univ->elements);
$univ=array_map("entity_decode",$univ);
$univ=array_map("utf8_decode2",$univ);

foreach($univ as $elem){
  $tmp=array();
  foreach($fields as $field){
    $tmp[$field]=$elem[$field];
  }
  $tab[]=$tmp;
}
$univ=$tab;

$Fnm = "../data/courses_univ_{$_SESSION['vwpp']['semestre']}";

if($_GET['type']=="csv"){
  $separate="';'";
  $Fnm.=".csv";
}
else{
  $separate="\t";
  $Fnm.=".xls";
}

$lines=Array();
$lines[]=join($fields2,$separate);

foreach($univ as $elem){
  $lines[]=join($elem,$separate);
}


$inF = fopen($Fnm,"w");
foreach($lines as $elem){
  fputs($inF,$elem."\n");
}
fclose($inF);

header("Location: $Fnm");
?>