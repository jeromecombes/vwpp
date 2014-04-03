<?php
require_once "../header.php";
require_once "../inc/class.courses.inc";
require_once "menu.php";

$c=new courses();
$c->getStudents($_GET['id']);
$std_attrib=$c->students_attrib;
$std_choices=$c->students_choices;
$std_attrib_nb=count($std_attrib);
$std_choices_nb=count($std_choices);

$c->courseName($_GET['id']);
$course=$c->course;

echo <<<EOD
<h3>VWPP Courses for {$_SESSION['vwpp']['semester']}</h3>
<b>{$course['title']}, {$course['professor']}</b>
<table><tr><td style='width:350px;'>
<br/><b>Student choice ($std_choices_nb)</b><br/><br/>
<table id='myTab' cellspacing='0' style='width:500px;'><tr class='th'><td>Lastname</td><td>Firstname</td><td>Choice</td></tr>
EOD;

foreach($std_choices as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'><td>{$elem['lastname']}</td><td>{$elem['firstname']}</td><td>{$elem['choice']}</td></tr>\n";
}
echo "</table>\n";
echo "</td><td>\n";
echo "<br/><b>Final Registration ($std_attrib_nb)</b><br/><br/>";
echo "<table id='myTab' cellspacing='0' style='width:500px;'><tr class='th'><td>Lastname</td><td>Firstname</td></tr>\n";
foreach($std_attrib as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'><td>{$elem['lastname']}</td><td>{$elem['firstname']}</td></tr>\n";
}
echo "</table>\n";
echo "</td></tr></table>\n";
echo "<br/><a href='courses3.php'>Back</a>\n";



?>