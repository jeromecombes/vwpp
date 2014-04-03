<?php
require_once "../inc/config.php";
require_once "../inc/class.dates.inc";

$d=new dates();
$d->update($_POST);

header("Location: dates.php?msg=update_success&error=0");?>