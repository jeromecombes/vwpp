<?php
// Last update : 2014-04-04, Jérôme Combes

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

echo "<a href='eval_index.php'>Back to Evaluations, main page</a>\n";
echo "<a href='eval_export.php' style='margin-left:100px;'>Export to Excel</a>\n";

echo "<br/><br/>\n";
echo "<table cellspacing='0' border='1'>\n";

echo "<tr class='th'>\n";
foreach($questions as $elem){
  echo "<td>$elem</td>\n";
}
echo "</tr>\n";

foreach($result as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'>\n";
  for($i=1;$i<count($questions)+1;$i++){
    if($form=="program" and $i==32){
      $elem[$i]=unserialize($elem[$i]);
      if(is_array($elem[$i])){
	$elem[$i]=join($elem[$i]," ; ");
      }
    }
    echo "<td>{$elem[$i]}</td>\n";
   }
  echo "</tr>\n";
}
echo "</table>\n";

require_once "../footer.php";
?>