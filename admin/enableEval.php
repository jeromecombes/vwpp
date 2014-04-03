<?php
include "../inc/config.php";
$semester=$_GET['semester'];
echo $semester;
$db=new db();
$db->select("eval_enabled","*","semester='$semester'");
if($db->result){
  $db=new db();
  $db->delete("eval_enabled","semester='$semester'");
}
else{
  $db=new db();
  $db->insert("eval_enabled",array("'$semester'"),"semester");
}
?>