<?php		//	Hide Univ. Reg. for selected students
// 2016-03-13

session_start();
require_once "../inc/config.php";

access_ctrl(17);

$semester=str_replace("_"," ",$_SESSION['vwpp']['semester']);

foreach($_POST['students'] as $student){
  $db=new db();
  $db->delete("univ_reg_show","student='$student' AND semester='$semester'");
}

header("Location: students-list.php?error=0&msg=update_success");
?>