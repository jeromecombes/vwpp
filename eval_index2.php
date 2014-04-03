<?php
// Last change : 2013-04-25, Jérôme Combes

require_once "header.php";
require_once "menu.php";

// $multiple_evals=array("CIPH","ReidHall","stages","univ","intership");
$multiple_evals=array("CIPH","ReidHall","univ");
$std_id=$_SESSION['vwpp']['student'];
$timestamp=isset($_GET['timestamp'])?$_GET['timestamp']:mktime();
$form=isset($_GET['form'])?$_GET['form']:null;
$isForm=true;
$courseId=isset($_GET['courseId'])?$_GET['courseId']:null;

if(!$form){
  require_once "footer.php";
  exit;
}

$filter="student='$std_id' AND form='$form' AND semester='{$_SESSION['vwpp']['semestre']}'";
if($courseId)
  $filter.=" AND courseId='$courseId'";		// AND CourseId If multiple evals
elseif(in_array($form,$multiple_evals))
  $filter.=" AND timestamp='$timestamp'";		// AND TIMESTAMP If multiple evals
$db=new db();
$db->select("evaluations","*",$filter,"ORDER BY question");
foreach($db->result as $elem){
  $data[$elem['question']]=decrypt($elem['response'],$std_id);
}

$isForm=$db->result[0]['closed']?false:true;	// display form with inputs or texts only

echo "<a href='eval_index.php'>Back to list</a><br/><br/>\n";

require_once "inc/eval.$form.inc";

require_once "footer.php";
?>