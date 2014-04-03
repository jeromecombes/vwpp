<?php
require_once "class.univ4.inc";

$u=new univ4();
$u->fetch($_GET['id']);
$data=$u->elements;

$data=array_map("entity_decode",$data);

echo "&&&{$data['institution']}&&&{$data['institutionAutre']}&&&{$data['discipline']}&&&{$data['niveau']}&&&";
?>