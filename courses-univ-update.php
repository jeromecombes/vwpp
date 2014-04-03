<?php
require_once "header.php";
require_once "menu.php";

$db=new db();
if($_POST['id'] and $_POST['form']=="rh"){		//	Update
  $db->update2("courses_choices",$_POST,array("id"=>$_POST['id']));
  $msg=$db->error?array("Error while updating","red"):array("Update success","green");
}
elseif($_POST['form']=="rh"){				//	Insert
  unset($_POST['id']);
  $insert=array_merge($_POST,array("semester"=>$_SESSION['vwpp']['semestre'],"student"=>$_SESSION['vwpp']['student']));
  $db->insert2("courses_choices",$insert);
  $msg=$db->error?array("Error while updating","red"):array("Update success","green");
}


echo <<<EOD
<div class='information' style='color:{$msg[1]};'>{$msg[0]}</div>
<script type='text/JavaScript'>
setTimeout("document.location.href='courses.php'",3000);
</script>
EOD;

require_once "footer.php";
?>