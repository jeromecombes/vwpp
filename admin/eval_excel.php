<?php
// require_once "../header.php";
// require_once "menu.php";
// require_once "../inc/eval.questions.inc";
require_once "../inc/config.php";

access_ctrl(15);

$_SESSION['vwpp']['eval_form']=isset($_GET['form'])?$_GET['form']:$_SESSION['vwpp']['eval_form'];
$form=$_SESSION['vwpp']['eval_form'];

$questions=array();
$result=array();

//	CIPh
if($form=="CIPH"){
  $db=new db();
  $db->query("SELECT {$dbprefix}courses_ciph.instructeur AS instructeur, {$dbprefix}courses_ciph.titre AS titre, 
    {$dbprefix}evaluations.id AS id, {$dbprefix}evaluations.student AS student 
    FROM {$dbprefix}evaluations INNER JOIN {$dbprefix}courses_ciph 
    ON {$dbprefix}courses_ciph.id={$dbprefix}evaluations.courseId 
    WHERE {$dbprefix}evaluations.closed='1' AND {$dbprefix}evaluations.form='ciph' 
    AND {$dbprefix}evaluations.semester='{$_SESSION['vwpp']['semestre']}' 
    GROUP BY {$dbprefix}evaluations.timestamp,{$dbprefix}evaluations.student;");
  if($db->result){
    foreach($db->result as $elem){
      $result[]=array("id"=>$elem['id'],"titre"=>decrypt($elem['titre'],$elem['student']),"instructeur"=>decrypt($elem['instructeur'],$elem['student']));
    }
  }
  usort($result,"cmp_title");
}


//	Reid Hall
elseif($form=="ReidHall"){
  $questions=$questRH;

  $db=new db();
  $db->query("SELECT {$dbprefix}courses.professor AS professor, {$dbprefix}courses.title AS title, 
    {$dbprefix}evaluations.id AS id, {$dbprefix}evaluations.student AS student, 
    {$dbprefix}evaluations.timestamp AS timestamp, {$dbprefix}evaluations.question AS question, 
    {$dbprefix}evaluations.response AS response
    FROM {$dbprefix}evaluations INNER JOIN {$dbprefix}courses 
    ON {$dbprefix}courses.id={$dbprefix}evaluations.courseId 
    WHERE {$dbprefix}evaluations.closed='1' AND {$dbprefix}evaluations.form='ReidHall' 
    AND {$dbprefix}evaluations.semester='{$_SESSION['vwpp']['semestre']}' 
    ORDER BY title,professor,student,timestamp,question;");

  if($db->result)
  foreach($db->result as $elem){
      $result["{$elem['student']}_{$elem['timestamp']}"][1]=decrypt($elem['title']);
      $result["{$elem['student']}_{$elem['timestamp']}"][2]=decrypt($elem['professor']);
      $result["{$elem['student']}_{$elem['timestamp']}"][$elem['question']]=decrypt($elem['response'],$elem['student']);
  }
}

elseif($form=="intership"){
  $db=new db();
  $db->select("evaluations","*","closed='1' AND semester='{$_SESSION['vwpp']['semestre']}' AND form='intership'","ORDER BY courseId,student,timestamp");
  $result=$db->result;
}

elseif($form=="tutorats"){
  $db=new db();
  $db->select("evaluations","*","closed='1' AND semester='{$_SESSION['vwpp']['semestre']}' AND form='tutorats'","ORDER BY courseId,student,timestamp");
  $result=$db->result;
}

//	University
elseif($form=="univ"){
  $questions=$questUniv;

  $db=new db();
  $db->query("SELECT {$dbprefix}courses_univ.cm_prof AS cm_prof, {$dbprefix}courses_univ.cm_name AS cm_name, 
    {$dbprefix}courses_univ.ufr AS ufr, {$dbprefix}courses_univ.cm_code AS cm_code, 
    {$dbprefix}evaluations.id AS id, {$dbprefix}evaluations.student AS student , 
    {$dbprefix}evaluations.timestamp AS timestamp , {$dbprefix}evaluations.question AS question, 
    {$dbprefix}evaluations.response AS response
    FROM {$dbprefix}evaluations INNER JOIN {$dbprefix}courses_univ 
    ON {$dbprefix}courses_univ.id={$dbprefix}evaluations.courseId 
    WHERE {$dbprefix}evaluations.closed='1' AND {$dbprefix}evaluations.form='univ' 
    AND {$dbprefix}evaluations.semester='{$_SESSION['vwpp']['semestre']}' 
    ORDER BY timestamp,student,cm_name;");
  if($db->result)
  foreach($db->result as $elem){
      $result["{$elem['student']}_{$elem['timestamp']}"][1]=decrypt($elem['cm_name'],$elem['student']);
      $result["{$elem['student']}_{$elem['timestamp']}"][2]=decrypt($elem['ufr'],$elem['student']);
      $result["{$elem['student']}_{$elem['timestamp']}"][3]=decrypt($elem['cm_code'],$elem['student']);
      $offset=$elem['question']<11?2:3;
      $result["{$elem['student']}_{$elem['timestamp']}"][$elem['question']-$offset]=decrypt($elem['response'],$elem['student']);
  }
}

elseif($form=="program"){
  $questions=$questPrg;

  $db=new db();
  $db->select("evaluations","*","closed='1' AND semester='{$_SESSION['vwpp']['semestre']}' AND form='program'","ORDER BY student,timestamp,question");
  if($db->result)
  foreach($db->result as $elem){
    $result["{$elem['student']}_{$elem['timestamp']}"][$elem['question']]=decrypt($elem['response'],$elem['student']);
  }
}

$Fnm = "../data/eval_{$_GET['form']}_{$_SESSION['vwpp']['semestre']}";

if($_GET['type']=="csv")
	{
	$separate="';'";
	$Fnm.=".csv";
	}
else
	{
	$separate="\t";
	$Fnm.=".xls";
	}

$lines=Array();
$lines[]=join($questions,$separate);

foreach($result as $elem){
  $cells=array();
  for($i=1;$i<count($questions)+1;$i++){
    $cells[]=$elem[$questions[$i]];
   }
  $lines[]=join($cells,$separate);
}


$inF = fopen($Fnm,"w");
foreach($lines as $elem){
  fputs($inF,$elem."\n");
}
fclose($inF);

print_r($lines);
exit;
/*echo <<<EOD
<script type='text/JavaScript'>
document.location.href='$inf';
</script>
EOD;*/
header("Location: $Fnm");
// require_once "../footer.php";
?>