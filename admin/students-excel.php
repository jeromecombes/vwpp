<?php
// Last update : 2015-05-29
// ini_set('display_errors',1);
// ini_set('error_reporting',E_ALL);

require_once "../inc/config.php";
require_once "../inc/class.housing.inc";
require_once "../inc/class.student.inc";

$s=new student();
$s->fetchAll();

$students=array();
foreach($_POST['students'] as $elem){
  $students[]=$s->elements[$elem];
}
$students=array_map("entity_decode",$students);
$students=array_map("delete_rnt",$students);
$students=array_map("utf8_decode2",$students);

for($i=0;$i<count($students);$i++){
  $h=new housing();
  $h->getStudentLogement($students[$i]['id']);
  $logement=$h->logement;
  $keys=array_keys($logement);
  $tmp=array();
  foreach($keys as $key){
    $tmp["h_$key"]=$logement[$key];
  }
  $tmp=array_map("entity_decode",$tmp);
  $tmp=array_map("delete_rnt",$tmp);
  $tmp=array_map("utf8_decode2",$tmp);

  $students[$i]=array_merge($students[$i],$tmp);
}

$Fnm = "../data/students_{$_SESSION['vwpp']['semestre']}";

if($_GET['type']=="csv"){
  $separate="';'";
  $Fnm.=".csv";
}
else{
  $separate="\t";
  $Fnm.=".xls";
}


$fields=Array ("lastname","firstname","gender","homeInstitution","semestersJoin","frenchUniv","frenchNumber",
  "citizenship1","citizenship2","dob","placeOB","countryOB","tin","email","cellphone","contactlast",
  "contactfirst","street","city","zip","state","country","contactemail","contactphone","contactmobile",
  "h_address","h_zipcode","h_city","h_phonenumber","h_lastname","h_firstname","h_cellphone","h_email",
  "h_lastname2","h_firstname2","h_cellphone2","h_email2");

$line1=Array ("Lastname","Firstname","Gender","Home Institution","Semesters","French Univ.","French Univ. Number",
  "Citizenship1","Citizenship2","DOB","Place OB","Country OB","TIN","Email","Cellphone","Contact Lastname",
  "Contact Firstname","C Street","C City","C Zip","C State","C Country","C Email","C Phone","C Mobile",
  "Address FR","Zip code FR","City FR","Phone numer FR","H Lastname","H Firstname","H cellphone","H email",
  "H Lastname 2","H Firstname 2","H Cellphone 2","H Email 2");

$lines=Array();
$lines[]=join($line1,$separate);



foreach($students as $student){
  $cells=array();
  foreach($fields as $field){
    $cells[]=$student[$field];
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