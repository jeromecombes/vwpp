<?php
require_once "class.stage.inc";

if($_SESSION['vwpp']['category']=="admin"){
  $student=$_SESSION['vwpp']['std-id'];
  $action="../stage-update.php";
  $afterSubmit="admin/students-view2.php";
  $cancel="students-view2.php";
}
else{
  $student=$_SESSION['vwpp']['student'];
  $action="stage-update.php";
  $afterSubmit="courses.php";
  $cancel="courses.php";
}

$s=new stage();
$s->student=$student;
$s->fetch();
$stage=$s->elements;
$chk1=$stage[0]=="Oui"?"checked='checked'":null;
$chk2=$stage[0]=="Non"?"checked='checked'":null;

echo <<<EOD
<h3 style='margin-top:50px;'>Stage</h3>
<fieldset>
<form name='formStage_1' method='post' action='$action'>
<input type='hidden' name='afterSubmit' value='$afterSubmit' />
<input type='hidden' name='student' value='$student' />
<table style='width:950px;'>
<tr><td style='width:400px;'><b>Faites-vous un stage</b></td>
<td>
<font style='display:none;' id='formStage_1_radio_0'>
<input type='radio' name='stage[0]' value='Oui' $chk1 />Oui
<input type='radio' name='stage[0]' value='Non' $chk2 style='margin-left:30px;'/>Non</font>
<font id='formStage_1_0'>{$stage[0]}</td></tr>
<tr><td><b>Lequel ?</b></td>
<td><input type='text' name='stage[1]' value='{$stage[1]}' style='display:none;'/>
<font id='formStage_1_1'>{$stage[1]}</td></tr>
<tr><td colspan='2' style='text-align:right;' id='formStage_1_2' >
<input type='button' id='formStage_1_edit' onclick='displayForm("formStage",1);' style='margin-left:30px;' value='Modifier' />
<input type='button' id='formStage_1_lock' onclick='lock_registration("stage",1,$lock);' $displayLock id='lock_stage_1'  style='margin-left:30px;' value='$lock_msg' />
</td></tr>
<tr style='display:none;' id='formStage_1_done'><td colspan='2' style='text-align:right;'>
<br/><input type='button' onclick='location.href="$cancel";' style='margin-left:30px;' value='Annuler' />
<input type='submit' style='margin-left:30px;' value='Valider' /></td></tr>
</table>
</form>
</fieldset>
EOD;
?>