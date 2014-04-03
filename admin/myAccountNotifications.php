<?php
/*
VWPP Database V 3.0
Last update 14/06/2013, Jérôme Combes
*/
session_start();
include "../inc/class.users.inc";

$notif=$_GET['notif']=="true"?1:0;
$u=new user();
$u->update(array("alerts"=>$notif,"id"=>$_SESSION['vwpp']['login_id']));
?>