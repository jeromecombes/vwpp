<?php
// Last update : 2015-03-23

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
<b>{$course['title']}, {$course['professor']}</b><br/>

<div style='display:inline-block;width:500px;vertical-align:top;'>
<br/><b>Student choice ($std_choices_nb)</b><br/><br/>
<table class='datatable'>
<thead>
<tr><th>Lastname</th><th>Firstname</th><th>Choice</th></tr>
</thead>

<tbody>
EOD;

foreach($std_choices as $elem){
  echo "<tr><td>{$elem['lastname']}</td><td>{$elem['firstname']}</td><td>{$elem['choice']}</td></tr>\n";
}
echo "</tbody>\n";
echo "</table>\n";
echo "</div>\n";

echo "<div style='display:inline-block;width:400px%;vertical-align:top;position:absolute; right:15px;'>\n";
echo "<br/><b>Final Registration ($std_attrib_nb)</b><br/><br/>";
echo "<table class='datatable'>\n";
echo "<thead>\n";
echo "<tr><th>Lastname</th><th>Firstname</th></tr>\n";
echo "</thead>\n";

echo "<tbody>\n";
foreach($std_attrib as $elem){
  echo "<tr><td>{$elem['lastname']}</td><td>{$elem['firstname']}</td></tr>\n";
}
?>
</tbody>
</table>
</div>

<div style='text-align:right;margin-top:30px;'>
<a href='courses4.php' class='myUI-button-right'>Back</a>
</div>
