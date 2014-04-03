<?php
require_once "../header.php";
require_once "../inc/class.eval.inc";
require_once "menu.php";
access_ctrl(15);


$eval=new evaluation();
$eval->fetch($_GET['id']);
$data=$eval->elements;
$form=$eval->form;
$courseId=$eval->courseId;
$std_id=$eval->student;
$isForm=$eval->closed?false:true;	// display form with inputs or texts only

$semester2=str_replace("_"," ",$_SESSION['vwpp']['semestre']);

switch($form){
  case "program"	: $back="Program Evaluations";			break;
  case "ReidHall"	: $back="VWPP Courses Evaluations";		break;
  case "univ"		: $back="University Courses Evaluations";	break;
  case "tutorats"	: $back="Tutorats Evaluations";			break;
  case "CIPH"		: $back="CIPh Evaluations";			break;
  case "intership"	: $back="Intership Evaluations";		break;
  default 		: $back="Back";					break;
}


echo "<div class='noprint'>\n";
echo "<h3>Evaluations for $semester2</h3>\n";
echo "<a href='eval_index.php' style='margin-left:30px;'>All evaluations</a>\n";
echo ">";
echo "<a href='eval_all.php'>$back</a><br/><br/>\n";
echo "</div>\n";
require_once "../inc/eval.$form.inc";

require_once "../footer.php";
?>