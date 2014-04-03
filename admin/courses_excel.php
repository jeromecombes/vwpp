<?php
require_once "../inc/config.php";
require_once "../inc/class.univ.inc";

// access_ctrl(16);

$univ=new univ();
$univ->fetchAll();
$univ=$univ->elements;
$fields=array_keys($univ[0]);
unset($fields[2]);	// 0
unset($fields[3]);	// id
unset($fields[4]);	// student_id
unset($fields[5]);	// semester

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
$lines[]=join($fields,$separate);

foreach($univ as $elem){
  $cells=array();
  $cells[]=html_entity_decode($elem[$fields[0]],ENT_QUOTES,"utf-8");	// student Lastname
  $cells[]=html_entity_decode($elem[$fields[1]],ENT_QUOTES,"utf-8");	// student Firstname
  for($i=6;$i<count($fields);$i++){					// Other info whitout id, student_id, semester
    $cells[]=html_entity_decode($elem[$fields[$i]],ENT_QUOTES,"utf-8");
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