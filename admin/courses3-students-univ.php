<?php
require_once "../header.php";
require_once "../inc/class.univ3.inc";
require_once "menu.php";


$u=new univ3();
$u->fetchCMById($_GET['id']);
$univ=$u->elements;
$univ['nom_en']=$univ['nom_en']?$univ['nom_en']:$univ['nom'];

$u->fetchStudents($_GET['id'],$_SESSION['vwpp']['login_univ']);
$students=$u->students;
$nb=count($students);

echo <<<EOD
<h3>University Courses for {$_SESSION['vwpp']['semester']}</h3>
<b>{$univ['nom_en']}, {$univ['prof']}</b>

<br/><br/><b>Students ($nb)</b><br/><br/>
EOD;

if(is_array($students)){
  echo "<table id='myTab' cellspacing='0' style='width:500px;'>\n";
  echo "<tr class='th'><td>Lastname</td><td>Firstname</td><td>Email</td></tr>\n";

  foreach($students as $elem){
    $class=$class=="tr1"?"tr2":"tr1";
    echo "<tr class='$class'><td>{$elem['lastname']}</td><td>{$elem['firstname']}</td><td><a href='mailto:{$elem['email']}'>{$elem['email']}</a></td></tr>\n";
  }
  echo "</table>\n";
}

echo "<br/><a href='javascript:history.back();'>Back</a>\n";
?>