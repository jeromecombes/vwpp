<?php
require_once "../header.php";
require_once "../inc/class.student.inc";
require_once "../inc/class.univ3.inc";
require_once "menu.php";
access_ctrl(15);

$_SESSION['vwpp']['eval_form']=isset($_GET['form'])?$_GET['form']:$_SESSION['vwpp']['eval_form'];
$form=$_SESSION['vwpp']['eval_form'];
$semester=$_SESSION['vwpp']['semestre'];
$semester2=str_replace("_"," ",$semester);

$result=array();


$s=new student();
$s->getByUniv($_SESSION["vwpp"]["login_univ"]);
$students=$s->byUnivList;

//	CIPh
if($form=="CIPH"){
  $db=new db();
  $db->query("SELECT {$dbprefix}courses_ciph.instructeur AS instructeur, {$dbprefix}courses_ciph.titre AS titre, 
    {$dbprefix}evaluations.id AS id, {$dbprefix}evaluations.student AS student 
    FROM {$dbprefix}evaluations INNER JOIN {$dbprefix}courses_ciph 
    ON {$dbprefix}courses_ciph.id={$dbprefix}evaluations.courseId 
    WHERE {$dbprefix}evaluations.closed='1' AND {$dbprefix}evaluations.form='ciph' 
    AND {$dbprefix}evaluations.semester='$semester' AND {$dbprefix}evaluations.student IN ($students) 
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
  $db=new db();
  $db->query("SELECT {$dbprefix}courses.professor AS professor, {$dbprefix}courses.title AS title, 
    {$dbprefix}evaluations.id AS id FROM {$dbprefix}evaluations INNER JOIN {$dbprefix}courses 
    ON {$dbprefix}courses.id={$dbprefix}evaluations.courseId 
    WHERE {$dbprefix}evaluations.closed='1' AND {$dbprefix}evaluations.form='ReidHall' 
    AND {$dbprefix}evaluations.semester='$semester' AND {$dbprefix}evaluations.student in ($students) 
    GROUP BY {$dbprefix}evaluations.timestamp,{$dbprefix}evaluations.student;");
  if($db->result){
    foreach($db->result as $elem){
      $result[]=array("id"=>$elem['id'],"title"=>decrypt($elem['title']),"professor"=>decrypt($elem['professor']));
    }
  }
  usort($result,"cmp_title");
}

elseif($form=="intership"){
  $db=new db();
  $db->select("evaluations","*","closed='1' AND semester='$semester' AND form='intership' AND student in ($students)","GROUP BY timestamp,student");
  $result=$db->result;
}

elseif($form=="tutorats"){
  $db=new db();
  $db->select("evaluations","*","closed='1' AND semester='$semester' AND form='tutorats' AND student in ($students)","GROUP BY timestamp,student");
  $result=$db->result;
}

//	University
elseif($form=="univ"){
  $db=new db();
  $db->query("SELECT * FROM {$dbprefix}evaluations
  WHERE {$dbprefix}evaluations.closed='1' AND {$dbprefix}evaluations.form='univ' 
  AND {$dbprefix}evaluations.semester='$semester' AND {$dbprefix}evaluations.student in ($students) 
  GROUP BY {$dbprefix}evaluations.timestamp,{$dbprefix}evaluations.student;");

  $u=new univ3();
  $u->fetchVeryAll();
  $univ=$u->elements;

  if($db->result){
    foreach($db->result as $elem){
      foreach($univ as $elem2){
	if($elem2['id']==$elem['courseId']){
	  $result[]=array("id"=>$elem['id'],"cm_name"=>$elem2['nom'],"cm_prof"=>$elem2['prof']);
	  break;
	}
      }
    }
  }
  usort($result,"cmp_title");
}

elseif($form=="program"){
  $db=new db();
  $db->select("evaluations","*","closed='1' AND semester='$semester' AND form='program' AND student in ($students)","GROUP BY timestamp,student");
  $result=$db->result;
}



echo "<h3>Evaluations for $semester2</h3>\n";
echo "<a href='eval_index.php' style='margin-left:30px;'>All evaluations</a>\n";

if($form=="program"){
  echo "<h3 style='margin-bottom:0px;'>Program Evaluations</h3><ul style='margin-left:20px;'>";
  foreach($result as $elem){
    echo "<li><a href='eval_view.php?id={$elem['id']}'>Program Evaluation ({$elem['id']})</a></li>\n";
  }
  echo "</ul>\n";
}
elseif($form=="ReidHall"){
  echo "<h3 style='margin-bottom:0px;'>VWPP Courses Evaluations</h3><ul>";
  foreach($result as $elem){
    echo "<li style='margin-left:20px;'><a href='eval_view.php?id={$elem['id']}'>{$elem['title']}, {$elem['professor']} ({$elem['id']})</a></li>\n";
  }
  echo "</ul>\n";
}
elseif($form=="univ"){
  echo "<h3 style='margin-bottom:0px;'>University Courses Evaluations</h3><ul style='margin-left:20px;'>";
  foreach($result as $elem){
    echo "<li style='margin-left:20px;'><a href='eval_view.php?id={$elem['id']}'>{$elem['cm_name']}, {$elem['cm_prof']} ({$elem['id']})</a></li>\n";
  }
  echo "</ul>\n";
}
elseif($form=="tutorats"){
  echo "<h3 style='margin-bottom:0px;'>Tutorats Evaluations</h3><ul style='margin-left:20px;'>";
  foreach($result as $elem){
    echo "<li style='margin-left:20px;'><a href='eval_view.php?id={$elem['id']}'>Tutorats Evaluation ({$elem['id']})</a></li>\n";
  }
  echo "</ul>\n";
}
elseif($form=="CIPH"){
  echo "<h3 style='margin-bottom:0px;'>CIPh Evaluations</h3><ul>";
  foreach($result as $elem){
    echo "<li style='margin-left:20px;'><a href='eval_view.php?id={$elem['id']}'>{$elem['titre']}, {$elem['instructeur']} ({$elem['id']})</a></li>\n";
  }
  echo "</ul>\n";
}
elseif($form=="intership"){
  echo "<h3 style='margin-bottom:0px;'>Intership Evaluations</h3><ul>";
  foreach($result as $elem){
    echo "<li style='margin-left:20px;'><a href='eval_view.php?id={$elem['id']}'>Intership Evaluation ({$elem['id']})</a></li>\n";
  }
  echo "</ul>\n";
}

require_once "../footer.php";
?>