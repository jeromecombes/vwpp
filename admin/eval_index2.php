<?php
require_once "../header.php";
require_once "menu.php";
access_ctrl(15);


$db=new db();
$db->select("evaluations","*","id='{$_GET['id']}'");
$student=$db->result[0]['student'];
$timestamp=$db->result[0]['timestamp'];
$form=$db->result[0]['form'];
$courseId=$db->result[0]['courseId'];
$std_id=$db->result[0]['student'];

$db=new db();
$db->select("evaluations","*","student='$student' AND timestamp='$timestamp'");

foreach($db->result as $elem){
  $data[$elem['question']]=decrypt($elem['response'],$student);
}

$isForm=$db->result[0]['closed']?false:true;	// display form with inputs or texts only

require_once "../inc/eval_$form.php";

require_once "../footer.php";
?>