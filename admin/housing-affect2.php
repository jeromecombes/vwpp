<?php
require_once "../inc/config.php";
require_once "../inc/class.housing.inc";

access_ctrl(7);

$student=$_POST['student'];
$page=$_POST['page'];

$h=new housing();
$h->affect($student,$_POST['logement']);
$error=$h->error?1:0;
$msg=$error?"update_error":"update_success";

header("Location: $page?student=$student&error=$error&msg=$msg");




?>