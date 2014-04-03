<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ERROR | E_WARNING | E_PARSE);
// ini_set('error_reporting',E_ALL);

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

$c=new ciph();
$c->fetchAll($_SESSION['vwpp']['login_univ']);
$ciph=$c->elemExcel;
$ciph=array_map("utf8_decode2",$ciph);
usort($ciph,"cmp_institution");

$Fnm = "../data/grades_{$_SESSION['vwpp']['semestre']}";

if($_GET['type']=="csv"){
  $separate="';'";
  $Fnm.=".csv";
}
else{
  $separate="\t";
  $Fnm.=".xls";
}

$lines=Array();
$cells=array("Type","Code","Title","Nom","Professor","Student's lastname","Student's Firstname","Student's Univ.","Note","Date received","Grade","Date sent");
$lines[]=join($cells,$separate);

foreach($reidhall as $course){
  if(!empty($course)){
    $g=new grades();
    $g->fetchCourse("VWPP",$course["id"]);
    foreach($g->grades as $grade){
      $cells=array("VWPP {$course["type"]}",$course["code"],$course["title"],$course["nom"],$course["professor"],$grade['lastExcel'],$grade['firstExcel'],$grade['university'],$grade['note'],$grade['date1'],$grade['grade'],$grade['date2']);
      $lines[]=join($cells,$separate);
    }
  }
}

foreach($univ as $course){
  if(!empty($course)){
    $g=new grades();
    $g->fetchCourse("univ",$course['id']);
    foreach($g->grades as $grade){
      $cells=array("University",$course["code"],$course["nom"],$course["nom"],$course["prof"],$grade["lastExcel"],$grade["firstExcel"],$grade['university'],$grade['note'],$grade['date1'],$grade['grade'],$grade['date2']);
      $lines[]=join($cells,$separate);
    }
  }
}

/*foreach($ciph as $course){
  if(!empty($course)){
    $g=new grades();
    $g->fetchCourse("ciph",$course['id']);
    foreach($g->grades as $grade){
      $cells=array("CIPh (or other)",$course["domaine"],$course["titre"],$course["titre2"],$course["instructeur"],$grade["lastExcel"],$grade["firstExcel"],$grade['university'],$grade['note'],$grade['date1'],$grade['grade'],$grade['date2']);
      $lines[]=join($cells,$separate);
    }
  }
}
*/
$inF = fopen($Fnm,"w");
foreach($lines as $elem){
  fputs($inF,$elem."\n");
}
fclose($inF);

// header("Location: $Fnm");
?>