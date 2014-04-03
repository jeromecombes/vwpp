<?php
require_once "inc/config.php";
require_once "inc/class.housing.inc";
$h=new housing;
$h->student=$_SESSION['vwpp']['student'];
$h->accept_charte();
?>