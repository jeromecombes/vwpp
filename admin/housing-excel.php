<?php
// ini_set('display_errors',1);
// ini_set('error_reporting',E_ALL);

require_once "../inc/config.php";
require_once "../inc/class.housing.inc";

$h=new housing();
$h->getLogements($_SESSION['vwpp']['login_univ']);
$housing=array_map("entity_decode",$h->logements);
usort($housing,cmp_lastname);
$housing=array_map("utf8_decode2",$housing);
$housing=array_map("delete_rnt",$housing);

$Fnm = "../data/housing_{$_SESSION['vwpp']['semestre']}";

if($_GET['type']=="csv"){
  $separate="';'";
  $Fnm.=".csv";
}
else{
  $separate="\t";
  $Fnm.=".xls";
}

$fields=Array ("lastname","firstname","address","zipcode","city","phonenumber","cellphone",
  "email","lastname2","firstname2","cellphone2","email2","studentLastname","studentFirstname");

$line1=Array ("Lastname","Firstname","Address","Zip Code","City","Phone Number","Cellphone",
  "Email","Lastname 2","Firstname 2","Cellphone 2","Email 2","Student Lastname","Student Firstname");

$lines=Array();
$lines[]=join($line1,$separate);

foreach($housing as $elem){
  $cells=array();
  if(in_array($elem['id'],$_POST['housing'])){
    foreach($fields as $field){
      $cells[]=$elem[$field];
    }
    $lines[]=join($cells,$separate);
  }
}

$inF = fopen($Fnm,"w");
foreach($lines as $elem){
  fputs($inF,$elem."\n");
}
fclose($inF);

header("Location: $Fnm");
?>