<?php
require_once "../inc/config.php";
require_once "../inc/class.univ.inc";

$univ=new univ();
$univ->update($_POST);

header("Location: courses.php?error={$univ->error}&msg={$univ->msg}");

?>