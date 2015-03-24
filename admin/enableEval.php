<?php
// Last update : 2015-03-24

include "../inc/config.php";
$semester=$_POST['semester'];

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

echo json_encode("ok");
?>