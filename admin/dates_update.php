<?php
// Last update : 2016-04-12

require_once "../inc/config.php";
require_once "../inc/class.dates.inc";

$data=array(
	"date1"=>$_POST["date1"],
	"date2"=>$_POST["date2"],
	"date3"=>$_POST["date3"],
	"date4"=>$_POST["date4"],
	"date5"=>$_POST["date5"],
	"date6"=>$_POST["date6"],
	"date7"=>$_POST["date7"],
	"date8"=>$_POST["date8"]);

$d=new dates();
$d->update($data);

header("Location: dates.php?msg=update_success&error=0");?>