<?php
// Last update : 2015-03-24, Jérôme Combes

require_once "../header.php";
require_once "menu.php";
require_once "../inc/eval.questions.inc";
require_once "../inc/class.eval.inc";

access_ctrl(15);

$_SESSION['vwpp']['eval_form']=isset($_GET['form'])?$_GET['form']:$_SESSION['vwpp']['eval_form'];
$form=$_SESSION['vwpp']['eval_form'];

$questions=$quest[$form];
$eval=new evaluation();
$eval->fetchAll($form,1,$_SESSION['vwpp']['login_univ']);
$result=$eval->elements;

switch($form){
  case "CIPH" : $title="CIPH and other institutions evaluations for {$_SESSION['vwpp']['semester']}"; break;
  case "intership" : $title="Intership evaluations for {$_SESSION['vwpp']['semester']}"; break;
  case "program" : $title="Program evaluations for {$_SESSION['vwpp']['semester']}"; break;
  case "ReidHall" : $title="VWPP Courses evaluations for {$_SESSION['vwpp']['semester']}"; break;
  case "tutorats" : $title="Tutorial evaluations for {$_SESSION['vwpp']['semester']}"; break;
  case "univ" : $title="University Courses evaluations for {$_SESSION['vwpp']['semester']}"; break;
  default : $title="Evaluations for {$_SESSION['vwpp']['semester']}"; break;
}

echo "<h3>$title</h3>\n";
echo "<a href='eval_index.php' class='myUI-button'>Back to Evaluations, main page</a>\n";
echo "<a href='eval_export.php' class='myUI-button'>Export to Excel</a>\n";

echo "<br/><br/>\n";
echo "<table class='datatable' data-sort='[[0,\"asc\"]]'>\n";
echo "<thead>\n";
echo "<tr>\n";
foreach($questions as $elem){
  echo "<th>$elem</th>\n";
}
echo "</tr>\n";
echo "</thead>\n";

echo "</tbody>\n";

foreach($result as $elem){
  echo "<tr>\n";
  for($i=1;$i<count($questions)+1;$i++){
    if($form=="program" and $i==32){
      $elem[$i]=unserialize($elem[$i]);
      if(is_array($elem[$i])){
	$elem[$i]=join($elem[$i]," ; ");
      }
    }
    echo "<td><div style='height:50px;overflow:hidden;' title='{$elem[$i]}'>{$elem[$i]}</div></td>\n";
   }
  echo "</tr>\n";
}
echo "</tbody>\n";
echo "</table>\n";

require_once "../footer.php";
?>