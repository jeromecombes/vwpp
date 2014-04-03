<?php
require_once "header.php";
require_once "inc/class.student.inc";
require_once "menu.php";

$std=new student;
$std->id=$_SESSION['vwpp']['student'];
$std->fetch();
$std=$std->elements;

//	Settings for inc/std-generals.php	//
$display=null;
$id=1;
//	include form inc/std-generals.php	//
include "inc/std-generals.php";

require_once "footer.php";
?>