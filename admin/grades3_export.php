<?php
require_once("../inc/config.php");
require_once("../inc/class.ciph.inc");
require_once("../inc/class.reidhall.inc");
require_once("../inc/class.univ4.inc");
require_once("../inc/class.student.inc");
require_once("../inc/class.grades.inc");

access_ctrl("18,19,20");

//	Reid Hall Courses
$r=new reidhall();
$r->fetchAll();
$reidhall=$r->elemExcel;
$reidhall=array_map("utf8_decode2",$reidhall);
usort($reidhall,"cmp_title");

//	Univ. Courses
$u=new univ4();
$u->fetchAllStudents(true);
$univ=$u->elements;
$univ=array_map("entity_decode",$univ);
$univ=array_map("utf8_decode2",$univ);
// usort($univ,"cmp_code");

//	CIPh. Courses
$c=new ciph();
$c->fetchAll($_SESSION['vwpp']['login_univ']);
$ciph=$c->elemExcel;
$ciph=array_map("utf8_decode2",$ciph);
usort($ciph,"cmp_institution");

//	File Name
$Fnm = "../data/grades_{$_SESSION['vwpp']['semestre']}";

//	File Format
if($_GET['type']=="csv"){
  $separate="';'";
  $Fnm.=".csv";
}
else{
  $separate="\t";
  $Fnm.=".xls";
}

//	First Line
$lines=Array();
$cells=array("University","Type / Level","Code","Title","Nom","Professor","Credits","Student's lastname","Student's Firstname","Student's Univ.","Note","Date received","US Grade","Date recorded");
$lines[]=join($cells,$separate);

//	Reid Hall Lines
foreach($reidhall as $course){
  if(!empty($course)){
    $g=new grades();
    $g->fetchCourse("VWPP",$course["id"]);
    $grades=array_map("utf8_decode2",$g->grades);
    foreach($grades as $grade){
      $cells=array("VWPP",$course["type"],$course["code"],$course["title"],$course["nom"],$course["professor"],"",$grade['lastExcel'],$grade['firstExcel'],$grade['university'],$grade['note'],$grade['date1'],$grade['grade'],$grade['date2']);
      $lines[]=join($cells,$separate);
    }
  }
}

//	Univ. Lines
foreach($univ as $course){
  if(!empty($course)){
    $g=new grades();
    $g->fetchCourse("univ",$course['id']);
    $grades=array_map("utf8_decode2",$g->grades);
    foreach($grades as $grade){
      $course["nom_en"]=$course["nom_en"]?$course["nom_en"]:$course["nom"];
      $cells=array($course["institution"],$course["niveau"],$course["code"],$course["nom_en"],$course["nom"],$course["prof"],$course["credits"],$grade["lastExcel"],$grade["firstExcel"],$grade['university'],$grade['note'],$grade['date1'],$grade['grade'],$grade['date2']);
      $lines[]=join($cells,$separate);
    }
  }
}

//	CIPh Lines
foreach($ciph as $course){
  if(!empty($course)){
    $g=new grades();
    $g->fetchCourse("ciph",$course['id']);
    $grades=array_map("utf8_decode2",$g->grades);
    foreach($grades as $grade){
      $cells=array("CIPh (or other)","",$course["domaine"],$course["titre"],$course["titre"],$course["instructeur"],"",$grade["lastExcel"],$grade["firstExcel"],$grade['university'],$grade['note'],$grade['date1'],$grade['grade'],$grade['date2']);
      $lines[]=join($cells,$separate);
    }
  }
}

//	Write In File
$inF = fopen($Fnm,"w");
foreach($lines as $elem){
  fputs($inF,$elem."\n");
}
fclose($inF);

//	Open the file
header("Location: $Fnm");
?>