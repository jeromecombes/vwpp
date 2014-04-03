<?php
// ini_set('display_errors',1);
// ini_set('error_reporting',E_ALL);

require_once "config.php";
require_once "class.univ3.inc";


switch($_REQUEST['action']){
  case "addCM" :
    $u=new univ3();
    $u->addCM($_POST['cm']);
    $error=$u->error;
    $msg=$u->msg;
    break;

  case "addNewCourse" :
    $u=new univ3();
    $u->addNewCourse($_POST);
    $error=$u->error;
    $msg=$u->msg;
    break;

  case "addNewTD" :
    $u=new univ3();
    $u->addNewTD($_POST);
    $error=$u->error;
    $msg=$u->msg;
    break;

  case "addTD" :
    $td=$_GET['td'];
    $cm=$_GET['cm'];
    $u=new univ3();
    $u->addTD($td,$cm);
    $error=$u->error;
    $msg=$u->msg;
    break;
}

$page=$_SESSION['vwpp']['category']=="admin"?"../admin/students-view2.php":"../courses.php";
header("Location: $page?error=$error&msg=$msg");




?>