<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);

require_once "config.php";
require_once "class.univ3.inc";

if(isset($_GET['cm'])){
    $u=new univ3();
    $u->deleteCM($_GET['cm']);
    $error=$u->error;
    $msg=$u->msg;
}
elseif(isset($_GET['td'])){
    $u=new univ3();
    $u->deleteTD($_GET['td']);
    $error=$u->error;
    $msg=$u->msg;
}

$page=$_SESSION['vwpp']['category']=="admin"?"../admin/students-view2.php":"../courses.php";
header("Location: $page?error=$error&msg=$msg");




?>