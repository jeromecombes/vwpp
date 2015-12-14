<?php
// Last update : 2015-12-10
session_start();

if(in_array(22,$_SESSION['vwpp']['access'])){		// voir qui a rempli les évaluations
  header("Location: eval_index3.php");
  exit;
}

require_once "../header.php";
require_once "menu.php";
access_ctrl(15);

$semester=$_SESSION['vwpp']['semestre'];
$semester2=str_replace("_"," ",$semester);
//	CIPh
$db=new db();
$db->query("SELECT {$dbprefix}courses_ciph.instructeur AS instructeur, {$dbprefix}courses_ciph.titre AS titre, 
  {$dbprefix}evaluations.id AS id, {$dbprefix}evaluations.student AS student 
  FROM {$dbprefix}evaluations INNER JOIN {$dbprefix}courses_ciph 
  ON {$dbprefix}courses_ciph.id={$dbprefix}evaluations.courseId 
  WHERE {$dbprefix}evaluations.closed='1' AND {$dbprefix}evaluations.form='ciph' 
  AND {$dbprefix}evaluations.semester='$semester' 
  GROUP BY {$dbprefix}evaluations.timestamp,{$dbprefix}evaluations.student;");
$ciph=array();
if($db->result){
  foreach($db->result as $elem){
    $ciph[]=array("id"=>$elem['id'],"titre"=>decrypt($elem['titre'],$elem['student']),"instructeur"=>decrypt($elem['instructeur'],$elem['student']));
  }
}
usort($ciph,"cmp_title");


//	Reid Hall
$db=new db();
$db->query("SELECT {$dbprefix}courses.professor AS professor, {$dbprefix}courses.title AS title, 
  {$dbprefix}evaluations.id AS id FROM {$dbprefix}evaluations INNER JOIN {$dbprefix}courses 
  ON {$dbprefix}courses.id={$dbprefix}evaluations.courseId 
  WHERE {$dbprefix}evaluations.closed='1' AND {$dbprefix}evaluations.form='ReidHall' 
  AND {$dbprefix}evaluations.semester='$semester' 
  GROUP BY {$dbprefix}evaluations.timestamp,{$dbprefix}evaluations.student;");
$reidHall=array();
if($db->result){
  foreach($db->result as $elem){
    $reidHall[]=array("id"=>$elem['id'],"title"=>decrypt($elem['title']),"professor"=>decrypt($elem['professor']));
  }
}
usort($reidHall,"cmp_title");

$db=new db();
$db->select("evaluations","*","closed='1' AND semester='$semester' AND form='intership'","GROUP BY timestamp,student");
$intership=$db->result;
$db=new db();
$db->select("evaluations","*","closed='1' AND semester='$semester' AND form='tutorats'","GROUP BY timestamp,student");
$tutorats=$db->result;

//	University
$db=new db();
$db->query("SELECT {$dbprefix}courses_univ.cm_prof AS cm_prof, {$dbprefix}courses_univ.cm_name AS cm_name, 
  {$dbprefix}evaluations.id AS id, {$dbprefix}evaluations.student AS student 
  FROM {$dbprefix}evaluations INNER JOIN {$dbprefix}courses_univ 
  ON {$dbprefix}courses_univ.id={$dbprefix}evaluations.courseId 
  WHERE {$dbprefix}evaluations.closed='1' AND {$dbprefix}evaluations.form='univ' 
  AND {$dbprefix}evaluations.semester='$semester' 
  GROUP BY {$dbprefix}evaluations.timestamp,{$dbprefix}evaluations.student;");
$univ=array();
if($db->result){
  foreach($db->result as $elem){
    $univ[]=array("id"=>$elem['id'],"cm_name"=>decrypt($elem['cm_name'],$elem['student']),"cm_prof"=>decrypt($elem['cm_prof'],$elem['student']));
  }
}
usort($univ,"cmp_title");


$db=new db();
$db->select("evaluations","*","closed='1' AND semester='$semester' AND form='program'","GROUP BY timestamp,student");
$program=$db->result;

$db=new db();
$db->select("eval_enabled","*","semester='$semester'");
$buttonValue=$db->result?"Disable evaluations":"Enable evaluations";
$buttonData=$db->result?1:0;

echo "<h3>$semester2 Evaluation Forms :\n";
echo "<span style='font-weight:normal;font-size:11pt;margin-left:150px;'>\n";
echo "<input type='button' id='enableEvaluation' data-semester='$semester' data-enabled='$buttonData' value='$buttonValue' class='myUI-button' />\n";

echo "<h4 style='margin-bottom:0px;'>Program Evaluations</h4><p style='margin:0 0 0 30px;'>";
echo "<a href='eval_tab.php?form=program'>Table</a>,&nbsp;\n";
echo "<a href='eval_all.php?form=program'>Individual evaluations</a>\n";
echo "</p>\n";

echo "<h4 style='margin-bottom:0px;'>VWPP Course Evaluations</h4><p style='margin:0 0 0 30px;'>";
echo "<a href='eval_tab.php?form=ReidHall'>Table</a>,&nbsp;\n";
echo "<a href='eval_all.php?form=ReidHall'>Individual evaluations</a>\n";
echo "</p>\n";

echo "<h4 style='margin-bottom:0px;'>University Course Evaluation</h4><p style='margin:0 0 0 30px;'>";
echo "<a href='eval_tab.php?form=univ'>Table</a>,&nbsp;\n";
echo "<a href='eval_all.php?form=univ'>Individual evaluations</a>\n";
echo "</p>\n";

echo "<h4 style='margin-bottom:0px;'>Tutorial Evaluations</h4><p style='margin:0 0 0 30px;'>";
echo "<a href='eval_tab.php?form=tutorats'>Table</a>,&nbsp;\n";
echo "<a href='eval_all.php?form=tutorats'>Individual evaluations</a>\n";
echo "</p>\n";

echo "<h4 style='margin-bottom:0px;'>CIPh (and other institutions) Evaluations</h4><p style='margin:0 0 0 30px;'>";
echo "<a href='eval_tab.php?form=CIPH'>Table</a>,&nbsp;\n";
echo "<a href='eval_all.php?form=CIPH'>Individual evaluations</a>\n";
echo "</p>\n";

echo "<h4 style='margin-bottom:0px;'>Intership Evaluations</h4><p style='margin:0 0 0 30px;'>";
echo "<a href='eval_tab.php?form=intership'>Table</a>,&nbsp;\n";
echo "<a href='eval_all.php?form=intership'>Individual evaluations</a>\n";
echo "</p>\n";


require_once "../footer.php";
?>