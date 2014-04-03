<?php
/*
VWPP Database V 3.0
Last update 14/06/2013, Jérôme Combes
*/

require_once "../inc/config.php";
require_once "../inc/class.student.inc";
access_ctrl(5);

$s=new student();
$s->delete2($_POST['students']);

header("Location: students-list.php?error=0&msg=delete_success");
?>