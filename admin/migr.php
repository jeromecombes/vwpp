<?php
require_once "../inc/config.php";
$db=new db();
$db->select("students","id,semestre");

foreach($db->result as $elem){
  $semester=serialize(array($elem['semestre']));
  $data[]=array(":id"=>$elem['id'],":semesters"=>$semester);
}

$sql="UPDATE `students` SET semesters=:semesters WHERE `id`=:id;";
$db=new dbh();
$db->prepare($sql);
$db->execute($data);

print_r($data);
?>