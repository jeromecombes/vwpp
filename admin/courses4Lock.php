<?php
include "../inc/class.univ4.inc";

$u=new univ4();
$u->lock($_GET['id']);

echo $u->result;

?>