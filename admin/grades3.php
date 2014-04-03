<?php
require_once("../inc/config.php");
require_once("../inc/class.courses.inc");
require_once("../header.php");
require_once("menu.php");

access_ctrl("18,19,20");

$_SESSION['vwpp']['student']=isset($_GET['student'])?$_GET['student']:$_SESSION['vwpp']['student'];

$c=new courses();
$c->getStudents($_SESSION['vwpp']['course']);
$students=$c->students_attrib;

$c->courseName($_SESSION['vwpp']['course']);
$course=$c->course;

echo <<<EOD
<h3>Grades, {$_SESSION['vwpp']['semester']}</h3>
<a href='grades.php'>Courses list</a> > <a href='grades2.php'>Students list</a>
<p>
{$course['code']} {$course['title']}, {$course['professor']}
</p>
EOD;

require_once("../footer.php");
?>