<?php
/*
This script needs :
- $isForm : true or false : display form or text
- $std_id : int (student id)
- $timestamp : timestamp
- $form : text : form's name
- $data : array("question (int)"=> "response (text)");
*/

// $isForm=false;
$displayForm=$isForm?null:"style='display:none;'";
$displayText=$isForm?"style='display:none;'":"class='response'";

echo <<<EOD
<fieldset>
<legend><b>Stages Evaluation Form</b></legend>
<form method='post' action='eval_update.php' name='form'>
<input type='hidden' name='std_id' value='$std_id' />
<input type='hidden' name='timestamp' value='$timestamp' />
<input type='hidden' name='form' value='$form' />
<table style='width:950px;'>
<tr><td style='width:25%;'>&nbsp;</td><td style='width:25%;'>&nbsp;</td>
<td style='width:25%;'>&nbsp;</td><td style='width:25%;'>&nbsp;</td></tr>
<tr><td colspan='4'>
<h2>VASSAR-WESLEYAN PROGRAM IN PARIS<br/>
Stages Evaluation Form</h2>
</td></tr>


<tr $displayForm><td colspan='4' style='text-align:center;padding-top:20px;'>
<input type='hidden' name='closed' value='0' />
<input type='submit' value='Save to continue later' style='margin-right:30px;'/>
<input type='button' value='Submit' onclick='document.form.closed.value="1";document.form.submit();'/></td></tr>
</table></form>
</fieldset>
EOD;

?>