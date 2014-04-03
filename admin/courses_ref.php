<?php
require_once "../inc/config.php";
require_once "../inc/class.univ.inc";

$db=new db();
$db->select("courses_univ","ref","id={$_GET['id']}");
$ref=$db->result[0]['ref']==0?1:0;
$db=new db();
$db->update("courses_univ","ref=$ref","id={$_GET['id']}");

if($ref){			// Sélectionne les infos du cours pour les copier dans une autre table à créer
  $c=new univ();		// Créer la table courses_univ_ref
  $c->fetch($_GET['id']);	// ID, semestre, code + les infos récoltées sans student, lastname ..., notes ...
 $course=$c->element;
}

?>