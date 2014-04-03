<?php
/*
require_once "header.php";
require_once "menu.php";
*/

$student=$_SESSION['vwpp']['student'];
$semester=$_SESSION['vwpp']['semestre'];
$isForm=false;


//include "inc/courses_{$univ}.php";
include "inc/courses_{$univ}2.php";
// include "inc/courses_{$_GET['univ']}.php";

// require_once "footer.php";
?>