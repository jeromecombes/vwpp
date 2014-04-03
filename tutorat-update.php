<?php
require_once "inc/config.php";
require_once "inc/class.tutorat.inc";

$t=new tutorat();
$t->update($_POST['tutorat']);
header("Location: {$_POST['afterSubmit']}?error=0&msg=update_success");
?>