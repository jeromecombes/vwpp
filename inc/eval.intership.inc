<?php
/*
This script needs :
- $isForm : true or false : display form or text
- $std_id : int (student id)
- $timestamp : timestamp
- $form : text : form's name
- $data : array("question (int)"=> "response (text)");
*/

$displayForm=$isForm?null:"style='display:none;'";
$displayText=$isForm?"style='display:none;'":"class='response'";

$i=1;
$checked[$i++]=$data[21]=="Yes"?"checked='checked'":null;
$checked[$i++]=$data[21]=="No"?"checked='checked'":null;
$checked[$i++]=$data[25]=="More than 80%"?"checked='checked'":null;
$checked[$i++]=$data[25]=="70-80%"?"checked='checked'":null;
$checked[$i++]=$data[25]=="50-70%"?"checked='checked'":null;
$checked[$i++]=$data[25]=="Less than 50%"?"checked='checked'":null;
$checked[$i++]=$data[26]=="More than 80%"?"checked='checked'":null;
$checked[$i++]=$data[26]=="70-80%"?"checked='checked'":null;
$checked[$i++]=$data[26]=="50-70%"?"checked='checked'":null;
$checked[$i++]=$data[26]=="Less than 50%"?"checked='checked'":null;
$checked[$i++]=$data[33]=="Yes"?"checked='checked'":null;
$checked[$i++]=$data[33]=="No"?"checked='checked'":null;
$checked[$i++]=$data[35]=="Yes"?"checked='checked'":null;
$checked[$i++]=$data[35]=="No"?"checked='checked'":null;
$checked[$i++]=$data[41]=="Yes"?"checked='checked'":null;
$checked[$i++]=$data[41]=="No"?"checked='checked'":null;

echo <<<EOD
<div class='fieldset'>
<form method='post' action='eval_update.php' name='form'>
<input type='hidden' name='std_id' value='$std_id' />
<input type='hidden' name='timestamp' value='$timestamp' />
<input type='hidden' name='form' value='$form' />
<table style='width:100%;'>
<tr><td style='width:25%;'>&nbsp;</td><td style='width:25%;'>&nbsp;</td>
<td style='width:25%;'>&nbsp;</td><td style='width:25%;'>&nbsp;</td></tr>
<tr><td colspan='4'>
<h2>VASSAR-WESLEYAN PROGRAM IN PARIS<br/>
Intership Evaluation Form, {$_SESSION['vwpp']['semester']}</h2>
</td></tr>

<tr><td colspan='2'><b>Your name :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[1]' value='{$data[1]}' /></td>
<td $displayText colspan='2'>{$data[1]}</td></tr>

<tr><td colspan='2'><b>Your University :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[2]' value='{$data[2]}' /></td>
<td $displayText colspan='2'>{$data[2]}</td></tr>

<tr><td colspan='4'><b>Place of intership (name of association, company, etc...) :</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[3]'>{$data[3]}</textarea>
<div $displayText>{$data[3]}</div></td></tr>

<tr><td colspan='4'><b>1. Work assignment,</b></td></tr>
<tr><td><b>Beginning date</b></td>
<td $displayForm><input type='text' name='data[4]' value='{$data[4]}' /></td>
<td $displayText>{$data[4]}</td>
<td><b>End date</b></td>
<td $displayForm><input type='text' name='data[5]' value='{$data[5]}' /></td>
<td $displayText>{$data[5]}</td></tr>
<tr><td><b>N° of hours per week</b></td>
<td $displayForm><input type='text' name='data[6]' value='{$data[6]}' /></td>
<td $displayText>{$data[6]}</td></tr>

<tr><td colspan='4'><b>Your weekly schedule :</b></td></tr>

<tr><td colspan='4'>
<table border='1' style='width:100%;' cellspacing='0' >
<tr><td>&nbsp;</td>
<td><b>Monday</b></td>
<td><b>Tuesday</b></td>
<td><b>Wednesday</b></td>
<td><b>Thursday</b></td>
<td><b>Friday</b></td>
<td><b>Saturday</b></td>
<td><b>Sunday</b></td></tr>
<tr><td><b>From</b></td>
<td $displayForm style='padding: 2px 5px 0 2px;'><input type='text' name='data[7]' value='{$data[7]}' /></td>
<td $displayText>{$data[7]}</td>
<td $displayForm style='padding: 2px 5px 0 2px;'><input type='text' name='data[8]' value='{$data[8]}' /></td>
<td $displayText>{$data[8]}</td>
<td $displayForm style='padding: 2px 5px 0 2px;'><input type='text' name='data[9]' value='{$data[9]}' /></td>
<td $displayText>{$data[9]}</td>
<td $displayForm style='padding: 2px 5px 0 2px;'><input type='text' name='data[10]' value='{$data[10]}' /></td>
<td $displayText>{$data[10]}</td>
<td $displayForm style='padding: 2px 5px 0 2px;'><input type='text' name='data[11]' value='{$data[11]}' /></td>
<td $displayText>{$data[11]}</td>
<td $displayForm style='padding: 2px 5px 0 2px;'><input type='text' name='data[12]' value='{$data[12]}' /></td>
<td $displayText>{$data[12]}</td>
<td $displayForm style='padding: 2px 5px 0 2px;'><input type='text' name='data[13]' value='{$data[13]}' /></td>
<td $displayText>{$data[13]}</td></tr>
<tr><td><b>To</b></td>
<td $displayForm style='padding: 2px 5px 0 2px;'><input type='text' name='data[14]' value='{$data[14]}' /></td>
<td $displayText>{$data[14]}</td>
<td $displayForm style='padding: 2px 5px 0 2px;'><input type='text' name='data[15]' value='{$data[15]}' /></td>
<td $displayText>{$data[15]}</td>
<td $displayForm style='padding: 2px 5px 0 2px;'><input type='text' name='data[16]' value='{$data[16]}' /></td>
<td $displayText>{$data[16]}</td>
<td $displayForm style='padding: 2px 5px 0 2px;'><input type='text' name='data[17]' value='{$data[17]}' /></td>
<td $displayText>{$data[17]}</td>
<td $displayForm style='padding: 2px 5px 0 2px;'><input type='text' name='data[18]' value='{$data[18]}' /></td>
<td $displayText>{$data[18]}</td>
<td $displayForm style='padding: 2px 5px 0 2px;'><input type='text' name='data[19]' value='{$data[19]}' /></td>
<td $displayText>{$data[19]}</td>
<td $displayForm style='padding: 2px 5px 0 2px;'><input type='text' name='data[20]' value='{$data[20]}' /></td>
<td $displayText>{$data[20]}</td></tr>
</table>
</td></tr>

<tr><td colspan='3' style='padding-top:20px;'><b>Where there any special events you participated in ?</b></td>
<td $displayText style='padding-top:20px;'>{$data[21]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[21]' {$checked[1]} value='Yes' />Yes</td>
<td><input type='radio' name='data[21]' {$checked[2]} value='No' />No</td>
<td colspan='2'><b>If yes, which one(s) :</b></td></tr>
<tr $displayText><td colspan='4' style='color:black;'><b>If yes, which one(s) :</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[23]'>{$data[23]}</textarea>
<div $displayText>{$data[23]}</div></td></tr>

<tr><td colspan='4'><b>2. What regular tasks were included in your intership ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[24]'>{$data[24]}</textarea>
<div $displayText>{$data[24]}</div></td></tr>

<tr><td colspan='4'><b>3.a) Please estimate the amount of time (in %) you used French 
in your intership</b>
<font $displayText>{$data[25]}</font></td></tr>
<tr $displayForm>
<td><input type='radio' name='data[25]' {$checked[3]} value='More than 80%' />More than 80%</td>
<td><input type='radio' name='data[25]' {$checked[4]} value='70-80%' />70-80%</td>
<td><input type='radio' name='data[25]' {$checked[5]} value='50-70%' />50-70%</td>
<td><input type='radio' name='data[25]' {$checked[6]} value='Less than 50%' />Less than 50%</td></tr>

<tr><td colspan='4' style='padding-left:30px;'><b>b) Please estimate the amount of time (in %) 
you used English in your intership</b>
<font $displayText>{$data[26]}</font></td></tr>
<tr $displayForm>
<td><input type='radio' name='data[26]' {$checked[7]} value='More than 80%' />More than 80%</td>
<td><input type='radio' name='data[26]' {$checked[8]} value='70-80%' />70-80%</td>
<td><input type='radio' name='data[26]' {$checked[9]} value='50-70%' />50-70%</td>
<td><input type='radio' name='data[26]' {$checked[10]} value='Less than 50%' />Less than 50%</td></tr>

<tr><td colspan='4'><b>4. Describe your interaction with the local population and/or 
colleagues</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[27]'>{$data[27]}</textarea>
<div $displayText>{$data[27]}</div></td></tr>

<tr><td colspan='4'><b>5. How was the intership pertinent to your interests and/or 
background or experience ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[28]'>{$data[28]}</textarea>
<div $displayText>{$data[28]}</div></td></tr>

<tr><td colspan='4'><b>6. Did you take any relevant courses previously or concomitantly 
that you would recommend ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[29]'>{$data[29]}</textarea>
<div $displayText>{$data[29]}</div></td></tr>

<tr><td colspan='4'><b>7. Please comment on how your supervisor directed your work.</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[30]'>{$data[30]}</textarea>
<div $displayText>{$data[30]}</div></td></tr>

<tr><td colspan='4'><b>8. How did your "stage" experience influence your semester abroad ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[31]'>{$data[31]}</textarea>
<div $displayText>{$data[31]}</div></td></tr>

<tr><td colspan='4'><b>9. What did you learn about local institutions, business, society, 
and people through your experience ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[32]'>{$data[32]}</textarea>
<div $displayText>{$data[32]}</div></td></tr>

<tr><td colspan='4'><b>10. Did your "stage" experience influence your plans for your future 
(career, other) ?</b><font $displayText>{$data[33]}</font></td></tr>
<tr $displayForm>
<td><input type='radio' name='data[33]' {$checked[11]} value='Yes' />Yes</td>
<td><input type='radio' name='data[33]' {$checked[12]} value='No' />No</td>
<td colspan='2'>if yes, please explain how :</td></tr>
<tr $displayText><td colspan='4' style='color:black;font-weight:normal;'>If yes, please explain how :</td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[34]'>{$data[34]}</textarea>
<div $displayText>{$data[34]}</div></td></tr>


<tr><td colspan='4'><b>11. Did you receive any perks ?</b>
<font $displayText>{$data[35]}</font></td></tr>
<tr $displayForm>
<td><input type='radio' name='data[35]' {$checked[13]} value='Yes' />Yes</td>
<td><input type='radio' name='data[35]' {$checked[14]} value='No' />No</td></tr>
<tr><td colspan='4'>If yes, please list them below (meal tickets, or meal or travel reimbursements, 
payments, or other) at your "stage" :</td></tr>
<tr><td colspan='2'>1. 
<input $displayForm type='text' name='data[36]' value='{$data[36]}' style='width:90%;'/>
<font $displayText>{$data[36]}</font></td>
<td colspan='2'>3. 
<input $displayForm type='text' name='data[38]' value='{$data[38]}' style='width:90%;'/>
<font $displayText>{$data[38]}</font></td></tr>
<tr><td colspan='2'>2. 
<input $displayForm type='text' name='data[37]' value='{$data[37]}' style='width:90%;'/>
<font $displayText>{$data[37]}</font></td>
<td colspan='2'>4. 
<input $displayForm type='text' name='data[39]' value='{$data[39]}' style='width:90%;'/>
<font $displayText>{$data[39]}</font></td></tr>

<tr><td colspan='4' style='padding-top:20px;'><b>12. Other observations or comments :</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[40]'>{$data[40]}</textarea>
<div $displayText>{$data[40]}</div></td></tr>

<tr><td colspan='4' style='margin-top:20px;'><b>I authorize the program to quote form my "stage" 
evaluation for a college publication/site.</b><font $displayText>{$data[41]}</font></td></tr>
<tr $displayForm>
<td><input type='radio' name='data[41]' {$checked[15]} value='Yes'/>Yes</td>
<td><input type='radio' name='data[41]' {$checked[16]} value='No'/>No</td></tr>



<tr $displayForm><td colspan='4' style='text-align:center;padding-top:20px;'>
<!--
<input type='hidden' name='closed' value='0' />
<input type='submit' value='Save to continue later' style='margin-right:30px;'/>
<input type='button' value='Submit' onclick='document.form.closed.value="1";document.form.submit();'/></td></tr>
-->
<input type='hidden' name='closed' value='1' />
<input type='submit' value='Submit' />
</table></form>
</div>
EOD;

?>	