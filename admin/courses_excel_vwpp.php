<?php
// Last update : 2015-09-14

require_once "../inc/config.php";
require_once "../inc/class.courses.inc";
require_once "../inc/class.reidhall.inc";

// access_ctrl(16);

$c=new reidhall();
$c->fetchAll();
$courses=$c->elements;

$tab=array();
foreach($courses as $course){
  $c=new courses();
  $c->getStudents($course['id']);
  foreach($c->students_attrib as $student){
    $tab[]=array_merge($course,array("studentLastname"=>$student['lastname'],"studentFirstname"=>$student['firstname'],"studentEmail"=>$student['email']));
  }
}

$fields=array("type","code","title","nom","professor","studentLastname","studentFirstname","studentEmail");

$Fnm = "../data/courses_vwpp_{$_SESSION['vwpp']['semestre']}";

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

$tab=array_map("entity_decode",$tab);
$tab=array_map("utf8_decode2",$tab);

foreach($tab as $elem){
  $cells=array();
  for($i=0;$i<count($fields);$i++){
    $cells[]=$elem[$fields[$i]];
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