<?php
require_once "inc/config.php";
require_once "inc/class.stage.inc";

$s=new stage();
// $s->student=$_POST['student'];
$s->update($_POST['stage']);
// print_r($_POST['stage']);
header("Location: {$_POST['afterSubmit']}?error=0&msg=update_success");
?>