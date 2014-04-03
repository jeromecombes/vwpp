<?php
// Last change : 2013-04-25, Jérôme Combes

require_once "inc/class.eval.inc";
require_once "inc/class.tutorat.inc";
require_once "inc/class.univ3.inc";
require_once "inc/class.stage.inc";

require_once "header.php";
if($_SESSION['vwpp']['category']=="admin"){
  $std_id=$std['id'];
  $_SESSION['vwpp']['student']=$std['id'];
  $folder="../";
}
else{
  require_once "menu.php";
  $std_id=$_SESSION['vwpp']['student'];
  $folder=null;
}

$showClosed=false;
$semester=$_SESSION['vwpp']['semestre'];

$db=new db();
$db->select("evaluations","*","student='$std_id' AND form='program' AND semester='$semester'","GROUP BY timestamp");
$program=$db->result;
$db=new db();
$db->select("evaluations","*","student='$std_id' AND form='intership' AND semester='$semester'","GROUP BY timestamp");
$intership=$db->result;
$db=new db();
$db->select("evaluations","*","student='$std_id' AND form='tutorats' AND semester='$semester'","GROUP BY timestamp");
$tutorats=$db->result;

//	VWPP Courses
$RHcourses=array();
$courses=array();
// echo "student='$std_id' AND semester='$semester'";
$db=new db();
$db->select("courses_attrib_rh","*","student='$std_id' AND semester='$semester'");
if($db->result){
  $fields=array("writing1","writing2","writing3","seminar1","seminar2");
  foreach($fields as $field){
    if($db->result[0][$field]){
      $courses[]=$db->result[0][$field];
    }
  }
  if(!empty($courses)){
    $courses=join(",",$courses);
    $db=new db();
    $db->select("courses","*","id in ($courses)");
    foreach($db->result as $elem){
      $db2=new db();
      $db2->select("evaluations","*","courseId='{$elem['id']}' AND form='ReidHall' AND student='$std_id' AND semester='$semester'");
      $RHcourses[]=array("id"=>$elem['id'],"title"=>decrypt($elem['title']),"professor"=>decrypt($elem['professor']),"closed"=>$db2->result[0]['closed']);
    }
  }
}


// Univ courses
$u=new univ3();
$u->fetchAll();
foreach($u->elements as $elem){
  $db2=new db();
  $db2->select("evaluations","*","courseId='{$elem['cm']['id']}' AND form='univ' AND student='$std_id' AND semester='$semester'");
  $closed=$db2->result[0]['closed'];
  $univCourses[]=array("id"=>$elem['cm']['id'],"cm_name"=>$elem['cm']['nom'],"cm_prof"=>$elem['cm']['prof'],"closed"=>$closed);
}


// CIPh courses
$ciphCourses=array();
$db=new db();
$db->select("courses_ciph","*","student='$std_id' AND semester='{$_SESSION['vwpp']['semestre']}'");
if($db->result){
  foreach($db->result as $elem){
    if(decrypt($elem['cm_name'],$std_id)){
      $titre=decrypt($elem['titre'],$std_id);
      $instructeur=decrypt($elem['instructeur'],$std_id);
      $db2=new db();
      $db2->select("evaluations","*","courseId='{$elem['id']}' AND form='ciph' AND student='$std_id' AND semester='$semester'");
      $closed=$db2->result[0]['closed'];
      $ciphCourses[]=array("id"=>$elem['id'],"titre"=>$titre,"instructeur"=>$instructeur,"closed"=>$closed);
    }
  }
}

// Tutorial
$t=new tutorat();
$t->fetch();
$tuteur=$t->elements['tuteur'];


// Intership
$s=new stage();
$s->fetch();
$intershipInfo=$s->elements;

$closed=$program[0]['closed']?"(done)":null;
echo <<<EOD
<p style='text-align:justify;'>Thank you for taking the time to fill out the following evaluation forms to the best of your ability.<br/>
<br/>
Please note that evaluations for program, VWPP courses, and tutors will all be anonymous, unless you choose to identify yourself.<br/>
Evaluations for university courses are for VWPP use only.  They will not be shared with your university professor.<br/>
<br/>
You must complete these evaluation forms in order for your final grades to be sent to your institution.<br/><br/></p>

<h3 style='margin-bottom:0px;'>Program Evaluation</h3>
<ul><li>
EOD;

if($showClosed or !$closed){ echo "<a href='{$folder}eval_index2.php?form=program'>\n";}
echo "Program Evaluation $closed";
if($showClosed or !$closed){ echo "</a>"; }
echo "</li></ul>\n";

echo "<h3 style='margin-bottom:0px;'>VWPP Course Evaluation</h3><ul>";
if(empty($RHcourses)){
  echo "<li style='color:red;font-weight:bold;'>No VWPP courses selected</li>\n";
}
foreach($RHcourses as $elem){
  $closed=$elem['closed']?"(done)":null;
  echo "<li>\n";
  if($showClosed or !$closed){ 
    echo "<a href='{$folder}eval_index2.php?form=ReidHall&amp;courseId={$elem['id']}'>\n";
  }
  echo "Evaluation for {$elem['title']}, {$elem['professor']} $closed";
  if($showClosed or !$closed){ echo "</a>"; }
  echo "</li>\n";
}
echo "</ul>\n";

echo "<h3 style='margin-bottom:0px;'>University Course Evaluation</h3>";
echo "<ul>\n";
if($univCourses){
    foreach($univCourses as $elem){
      $closed=$elem['closed']?"(done)":null;
      echo "<li>\n";
      if($showClosed or !$closed){
        echo "<a href='{$folder}eval_index2.php?form=univ&amp;courseId={$elem['id']}'>\n";
      }
      echo "University Course Evaluation : {$elem['cm_name']}, {$elem['cm_prof']} $closed";
      if($showClosed or !$closed){ echo "</a>"; }
      echo "</li>\n";
    }
}
echo "</ul>\n";

echo "<h3 style='margin-bottom:0px;'>Evaluation of courses taken at CIPh or other institutions</h3>";
echo "<ul>\n";
foreach($ciphCourses as $elem){
//   if($elem['titre']){
    $closed=$elem['closed']?"(done)":null;
    echo "<li>";
    if($showClosed or !$closed){
      echo "<a href='{$folder}eval_index2.php?form=CIPH&amp;courseId={$elem['id']}'>";
    }
    echo "CIPh Evaluation : {$elem['titre']}, {$elem['instructeur']} $closed\n";
    if($showClosed or !$closed){ echo "</a>"; }
    echo "</li>\n";
//   }
}
echo "</ul>\n";


$closed=!empty($tutorats)?"(done)":null;
echo "<h3 style='margin-bottom:0px;'>Tutorial Evaluations</h3>";
echo "<ul><li style='margin:20px 0 0 0;'>\n";
if($showClosed or !$closed){
  echo "<a href='{$folder}eval_index2.php?form=tutorats'>";
}
echo "Tutorial Evaluations : $tuteur $closed\n";
if($showClosed or !$closed){
  echo "</a>\n";
}
echo "</li>\n";

/*foreach($tutorats as $elem){
  $date=date("M,d Y",$elem['timestamp']);
  $hour= date("H:i", $elem['timestamp']);
  $closed=$elem['closed']?"(done)":null;
  $e=new evaluation();
  $e->fetch($elem['id']);
  $instructor=$e->elements[1];
  echo "<li>Tutorats Evaluation : $instructor $closed</li>\n";
}*/
echo "</ul>\n";

// Intership : sélectionner le stage enregistré (comme univ, ciph, Reid Hall)
// 

if($intershipInfo[0]=="Oui"){
    echo "<h3 style='margin-bottom:0px;'>Intership Evaluation</h3>";
    echo "<ul>";
    if(empty($intership)){
        echo "<li style='margin:20px 0 0 0;'><a href='{$folder}eval_index2.php?form=intership'>Intership Evaluation {$intershipInfo[1]}</a></li>\n";
    }
    foreach($intership as $elem){
      $date=date("M,d Y",$elem['timestamp']);
      $hour= date("H:i", $elem['timestamp']);
      $closed=$elem['closed']?"(done)":null;
      $e=new evaluation();
      $e->fetch($elem['id']);
      $place=$e->elements[3];
      echo "<li>Intership Evaluation : {$intershipInfo[1]} $closed</li>\n";
    }
    echo "</ul>\n";
}


require_once "footer.php";
?>