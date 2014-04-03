<?php
require_once "../inc/config.php";
require_once "../inc/class.univ3.inc";

// access_ctrl(16);

$fields=array("university","code","nom","nom_en","horaires1","horaires2","prof","email","std_lastname","std_firstname","std_email","cm_code","cm_nom","cm_nom_en","cm_prof");
$fields2=array("Université","Code","Nom","Name","Horaires 1","Horaires 2","Prof","Prof email","Std Lastname","Std Firstname","Std email","Lecture Code","Lecture Nom","Lecture Name","Lecture Prof");
$fields2=array_map("utf8_decode",$fields2);

$univ=new univ3();
$univ->fetchVeryAllTD($_SESSION['vwpp']['login_univ']);
$univ=array_map("entity_decode",$univ->elements);
$univ=array_map("utf8_decode2",$univ);


foreach($univ as $elem){
  $tmp=array();
  foreach($fields as $field){
    $tmp[$field]=$elem[$field];
  }
  $tab[]=$tmp;
}
$univ=$tab;



$Fnm = "../data/courses_td_{$_SESSION['vwpp']['semestre']}";

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