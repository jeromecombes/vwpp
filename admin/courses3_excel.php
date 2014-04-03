<?php
require_once "../inc/config.php";
require_once "../inc/class.univ3.inc";

// access_ctrl(16);

$fields=array("university","code","nom","nom_en","ufr","ufr_en","parcours","parcours_en","discipline","discipline_en","departement","departement_en","licence","licence_en","niveau","horaires1","horaires2","prof","email","std_lastname","std_firstname","std_email","std_homeInstitution");
$fields2=array("Université","Code","Nom","Name","UFR","UFR (EN)","Parcours","Stream","Discipline","Discipline (EN)","Département","Department","Licence","License name","Niveau / Level","Horaires 1","Horaires 2","Prof","Prof email","Std Lastname","Std Firstname","Std email","Home Institution");
$fields2=array_map("utf8_decode",$fields2);

$univ=new univ3();
$univ->fetchVeryAll($_SESSION['vwpp']['login_univ']);
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