<?php
/*
This script needs :
- $isForm : true or false : display form or text
- $std_id : int (student id)
- $timestamp : timestamp
- $courseId : int (course id)
- $form : text : form's name
- $data : array("question (int)"=> "response (text)");
*/

$db=new db();
$db->select("courses","*","id=$courseId");
$title=decrypt($db->result[0]['title']);
$professor=decrypt($db->result[0]['professor']);


//$isForm=false;
$displayForm=$isForm?null:"style='display:none;'";
$displayText=$isForm?"style='display:none;'":"class='response'";

//	Init checked variables
$i=1;
$checked[$i++]=$data[3]=="Strenuous"?"checked='checked'":null;
$checked[$i++]=$data[3]=="Fairly strenuous"?"checked='checked'":null;
$checked[$i++]=$data[3]=="Moderate"?"checked='checked'":null;
$checked[$i++]=$data[3]=="Light"?"checked='checked'":null;
$checked[$i++]=$data[4]=="Comfortably"?"checked='checked'":null;
$checked[$i++]=$data[4]=="With some difficulty"?"checked='checked'":null;
$checked[$i++]=$data[4]=="With considerable difficulty"?"checked='checked'":null;
$checked[$i++]=$data[4]=="Not applicable"?"checked='checked'":null;
$checked[$i++]=$data[5]=="Comfortably"?"checked='checked'":null;
$checked[$i++]=$data[5]=="With some difficulty"?"checked='checked'":null;
$checked[$i++]=$data[5]=="With considerable difficulty"?"checked='checked'":null;
$checked[$i++]=$data[5]=="Not applicable"?"checked='checked'":null;
$checked[$i++]=$data[6]=="Yes"?"checked='checked'":null;
$checked[$i++]=$data[6]=="No"?"checked='checked'":null;
for($j=8;$j<13;$j=$j+2){
  $checked[$i++]=$data[$j]=="Almost always"?"checked='checked'":null;
  $checked[$i++]=$data[$j]=="Most of the time"?"checked='checked'":null;
  $checked[$i++]=$data[$j]=="Some of the time"?"checked='checked'":null;
  $checked[$i++]=$data[$j]=="Almost never/never"?"checked='checked'":null;
}
for($j=14;$j<17;$j++){
  $checked[$i++]=$data[$j]=="Very clear"?"checked='checked'":null;
  $checked[$i++]=$data[$j]=="Somewhat clear"?"checked='checked'":null;
  $checked[$i++]=$data[$j]=="Not clear"?"checked='checked'":null;
  $checked[$i++]=$data[$j]=="Not applicable"?"checked='checked'":null;
}
$checked[$i++]=$data[18]=="Very clear"?"checked='checked'":null;
$checked[$i++]=$data[18]=="Somewhat clear"?"checked='checked'":null;
$checked[$i++]=$data[18]=="Not clear"?"checked='checked'":null;
$checked[$i++]=$data[18]=="Not applicable"?"checked='checked'":null;

$checked[$i++]=$data[19]=="Yes"?"checked='checked'":null;
$checked[$i++]=$data[19]=="No"?"checked='checked'":null;
$checked[$i++]=$data[20]=="Not applicable"?"checked='checked'":null;
$checked[$i++]=$data[20]=="Yes"?"checked='checked'":null;
$checked[$i++]=$data[20]=="No"?"checked='checked'":null;
$checked[$i++]=$data[22]=="Excellent"?"checked='checked'":null;
$checked[$i++]=$data[22]=="Good"?"checked='checked'":null;
$checked[$i++]=$data[22]=="Fair"?"checked='checked'":null;
$checked[$i++]=$data[22]=="Rarely able"?"checked='checked'":null;
$checked[$i++]=$data[23]=="Excellent"?"checked='checked'":null;
$checked[$i++]=$data[23]=="Good"?"checked='checked'":null;
$checked[$i++]=$data[23]=="Fair"?"checked='checked'":null;
$checked[$i++]=$data[23]=="Not organized"?"checked='checked'":null;
$checked[$i++]=$data[24]=="Always open"?"checked='checked'":null;
$checked[$i++]=$data[24]=="Open sometimes"?"checked='checked'":null;
$checked[$i++]=$data[24]=="Rarely open"?"checked='checked'":null;
$checked[$i++]=$data[24]=="Never open"?"checked='checked'":null;
$checked[$i++]=$data[25]=="Always fair"?"checked='checked'":null;
$checked[$i++]=$data[25]=="Mostly fair"?"checked='checked'":null;
$checked[$i++]=$data[25]=="Fair sometimes"?"checked='checked'":null;
$checked[$i++]=$data[25]=="Never fair"?"checked='checked'":null;
$checked[$i++]=$data[26]=="Extremely helpful"?"checked='checked'":null;
$checked[$i++]=$data[26]=="Very helpful"?"checked='checked'":null;
$checked[$i++]=$data[26]=="Not helpful"?"checked='checked'":null;
$checked[$i++]=$data[26]=="Does not give comments"?"checked='checked'":null;
$checked[$i++]=$data[27]=="Very encouraging"?"checked='checked'":null;
$checked[$i++]=$data[27]=="Encouraging"?"checked='checked'":null;
$checked[$i++]=$data[27]=="Not encouraging"?"checked='checked'":null;
$checked[$i++]=$data[27]=="Does not give any"?"checked='checked'":null;
$checked[$i++]=$data[29]=="Absolutely"?"checked='checked'":null;
$checked[$i++]=$data[29]=="Mostly"?"checked='checked'":null;
$checked[$i++]=$data[29]=="Somewhat"?"checked='checked'":null;
$checked[$i++]=$data[29]=="Not effective"?"checked='checked'":null;


echo <<<EOD
<div class='fieldset'>
<form method='post' action='eval_update.php' name='form' onsubmit='return ctrl_form3();'>
<input type='hidden' name='std_id' value='$std_id' />
<input type='hidden' name='timestamp' value='$timestamp' />
<input type='hidden' name='form' value='$form' />
<input type='hidden' name='courseId' value='$courseId' />
<table style='width:100%;'>
<tr><td style='width:25%;'>&nbsp;</td><td style='width:25%;'>&nbsp;</td>
<td style='width:25%;'>&nbsp;</td><td style='width:25%;'>&nbsp;</td></tr>
<tr><td colspan='4'>
<h2>VASSAR-WESLEYAN PROGRAM IN PARIS<br/>
VWPP Course Evaluation Form, {$_SESSION['vwpp']['semester']}</h2>
</td></tr>

<tr $displayForm><td colspan='4' style='padding-top:20px;text-align:justify;'><i>
This form will be shared with your instructor. It is also intended for VWPP to evaluate the 
work of the program's instructors. We would appreciate a thoughtful response.</i></td></tr>

<tr><td style='padding-top:20px;'><b>Course Name :</b></td>
<td colspan='3' style='padding-top:20px;color:blue; font-weight:bold;'>{$title}</td></tr>

<tr><td style='padding-top:20px;'><b>Insctructor :</b></td>
<td colspan='3' style='padding-top:20px;color:blue; font-weight:bold;'>{$professor}</td></tr>

<tr><td colspan='4' style='padding-top:20px;'><b>1. How would you describe your efforts in this course ?</b>
<font $displayText>{$data[3]}</font></td></tr>
<tr $displayForm>
<td><input type='radio' name='data[3]' {$checked[1]} value='Strenuous' />Strenuous</td>
<td><input type='radio' name='data[3]' {$checked[2]} value='Fairly strenuous' />Fairly strenuous</td>
<td><input type='radio' name='data[3]' {$checked[3]} value='Moderate' />Moderate</td>
<td><input type='radio' name='data[3]' {$checked[4]} value='Light' />Light</td></tr>

<tr><td colspan='4' style='padding-top:20px;'><b>2. Do you think your French was at a level that allowed you to understand 
and take notes ?</b></td></tr>
<tr><td colspan='2' style='padding-left:30px;'><b>a) At the begining :</b></td>
<td $displayText colspan='2'>{$data[4]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[4]' {$checked[5]} value='Comfortably' />Comfortably</td>
<td><input type='radio' name='data[4]' {$checked[6]} value='With some difficulty' />With some difficulty</td>
<td><input type='radio' name='data[4]' {$checked[7]} value='With considerable difficulty' />With considerable difficulty</td>
<td><input type='radio' name='data[4]' {$checked[8]} value='Not applicable' />Not applicable</td></tr>

<tr><td colspan='2' style='padding-left:30px;'><b>b) After half-term :</b></td>
<td $displayText colspan='2'>{$data[5]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[5]' {$checked[9]} value='Comfortably' />Comfortably</td>
<td><input type='radio' name='data[5]' {$checked[10]} value='With some difficulty' />With some difficulty</td>
<td><input type='radio' name='data[5]' {$checked[11]} value='With considerable difficulty' />With considerable difficulty</td>
<td><input type='radio' name='data[5]' {$checked[12]} value='Not applicable' />Not applicable</td></tr>

<tr><td colspan='2' style='padding-top:20px;' ><b>3) Did you attend every class at the University ?</b></td>
<td $displayText>{$data[6]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[6]' {$checked[13]} value='Yes' />Yes</td>
<td><input type='radio' name='data[6]' {$checked[14]} value='No' />No</td>
</tr>

<tr><td colspan='4' ><b>If not, why not ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[7]'>{$data[7]}</textarea>
<div $displayText>{$data[7]}</div>
</td></tr>

<tr><td colspan='4' style='padding-top:20px;' ><b>4) Please evaluate your own work in the course. Did you :</b></td></tr>
<tr><td colspan='2' style='padding-left:30px;'><b>a) Keep up with assigned reading ?</b></td>
<td $displayText>{$data[8]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[8]' {$checked[15]} value='Almost always' />Almost always</td>
<td><input type='radio' name='data[8]' {$checked[16]} value='Most of the time' />Most of the time</td>
<td><input type='radio' name='data[8]' {$checked[17]} value='Some of the time' />Some of the time</td>
<td><input type='radio' name='data[8]' {$checked[18]} value='Almost never/never' />Almost never/never</td></tr>

<tr><td colspan='4' ><b>If not, why not ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[9]'>{$data[9]}</textarea>
<div $displayText>{$data[9]}</div>
</td></tr>

<tr><td colspan='2' style='padding-left:30px;'><b>b) Contribute to in-class discussion ?</b></td>
<td $displayText>{$data[10]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[10]' {$checked[19]} value='Almost always' />Almost always</td>
<td><input type='radio' name='data[10]' {$checked[20]} value='Most of the time' />Most of the time</td>
<td><input type='radio' name='data[10]' {$checked[21]} value='Some of the time' />Some of the time</td>
<td><input type='radio' name='data[10]' {$checked[22]} value='Almost never/never' />Almost never/never</td></tr>

<tr><td colspan='4' ><b>If not, why not ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[11]'>{$data[11]}</textarea>
<div $displayText>{$data[11]}</div>
</td></tr>

<tr><td colspan='2' style='padding-left:30px;'><b>c) Raise questions ?</b></td>
<td $displayText>{$data[12]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[12]' {$checked[23]} value='Almost always' />Almost always</td>
<td><input type='radio' name='data[12]' {$checked[24]} value='Most of the time' />Most of the time</td>
<td><input type='radio' name='data[12]' {$checked[25]} value='Some of the time' />Some of the time</td>
<td><input type='radio' name='data[12]' {$checked[26]} value='Almost never/never' />Almost never/never</td></tr>

<tr><td colspan='4' ><b>If not, why not ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[13]'>{$data[13]}</textarea>
<div $displayText>{$data[13]}</div>
</td></tr>

<tr><td colspan='4' style='text-align:justify;'><b>5) Did you have a clear understanding of 
what was expected from you in this course for the following :</b></td></tr>
<tr><td colspan='2' style='padding-left:30px;'>Readings :</td>
<td $displayText>{$data[14]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[14]' {$checked[27]} value='Very clear' />Very clear</td>
<td><input type='radio' name='data[14]' {$checked[28]} value='Somewhat clear' />Somewhat clear</td>
<td><input type='radio' name='data[14]' {$checked[29]} value='Not clear' />Not clear</td>
<td><input type='radio' name='data[14]' {$checked[30]} value='Not applicable' />Not applicable</td></tr>

<tr><td colspan='2' style='padding-left:30px;padding-top:20px;'>Written work :</td>
<td $displayText>{$data[15]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[15]' {$checked[31]} value='Very clear' />Very clear</td>
<td><input type='radio' name='data[15]' {$checked[32]} value='Somewhat clear' />Somewhat clear</td>
<td><input type='radio' name='data[15]' {$checked[33]} value='Not clear' />Not clear</td>
<td><input type='radio' name='data[15]' {$checked[34]} value='Not applicable' />Not applicable</td></tr>

<tr><td colspan='2' style='padding-left:30px;padding-top:20px;'>Oral presentation :</td>
<td $displayText>{$data[16]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[16]' {$checked[35]} value='Very clear' />Very clear</td>
<td><input type='radio' name='data[16]' {$checked[36]} value='Somewhat clear' />Somewhat clear</td>
<td><input type='radio' name='data[16]' {$checked[37]} value='Not clear' />Not clear</td>
<td><input type='radio' name='data[16]' {$checked[38]} value='Not applicable' />Not applicable</td></tr>

<tr><td colspan='2' style='padding-left:30px;padding-top:20px;'>Other (Please specify)</td>
<td $displayText style='padding-top:20px;'>{$data[17]}</td>
<td $displayForm style='padding-top:20px;'><input type='text' name='data[17]' value='{$data[17]}'/></td>
</tr>
<tr $displayText><td colspan='2'>&nbsp;</td><td>{$data[18]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[18]' {$checked[39]} value='Very clear' />Very clear</td>
<td><input type='radio' name='data[18]' {$checked[40]} value='Somewhat clear' />Somewhat clear</td>
<td><input type='radio' name='data[18]' {$checked[41]} value='Not clear' />Not clear</td>
<td><input type='radio' name='data[18]' {$checked[42]} value='Not applicable' />Not applicable</td></tr>

<tr><td colspan='4' style='padding-top:20px;'><b>6.a) Where there visits or events outside of 
class that formed part of this course ?</b><font $displayText>{$data[19]}</font></td></tr>

<tr $displayForm>
<td><input type='radio' name='data[19]' {$checked[43]} value='Yes' />Yes</td>
<td><input type='radio' name='data[19]' {$checked[44]} value='No' />No</td></tr>

<tr><td colspan='2' style='padding-top:20px;padding-left:30px;'><b>b) Did you attend all of 
them ?</b></td>
<td $displayText style='padding-top:20px;'>{$data[20]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[20]' {$checked[45]} value='Not applicable' />Not applicable</td>
<td><input type='radio' name='data[20]' {$checked[46]} value='Yes' />Yes</td>
<td><input type='radio' name='data[20]' {$checked[47]} value='No' />No</td>
<td><b>If not, why not</b></td></tr>
<tr $displayText><td colspan='4' style='color:black;'><b>If not, why not</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[21]'>{$data[21]}</textarea>
<div $displayText>{$data[21]}</div></td></tr>

<tr><td colspan='4' style='text-align:justify;'><b>
7. Please comment on the nature/quality of the teaching in this course</b></td></tr>
<tr><td colspan='2' style='padding-left:30px;'><b>
a) Ability to explain difficult material</b></td>
<td $displayText colspan='2'>{$data[22]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[22]' {$checked[48]} value='Excellent' />Excellent</td>
<td><input type='radio' name='data[22]' {$checked[49]} value='Good' />Good</td>
<td><input type='radio' name='data[22]' {$checked[50]} value='Fair' />Fair</td>
<td><input type='radio' name='data[22]' {$checked[51]} value='Rarely able' />Rarely able</td></tr>

<tr><td colspan='2' style='padding-left:30px;'><b>
b) Organization</b></td>
<td $displayText colspan='2'>{$data[23]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[23]' {$checked[52]} value='Excellent' />Excellent</td>
<td><input type='radio' name='data[23]' {$checked[53]} value='Good' />Good</td>
<td><input type='radio' name='data[23]' {$checked[54]} value='Fair' />Fair</td>
<td><input type='radio' name='data[23]' {$checked[55]} value='Not organized' />Not organized</td></tr>

<tr><td colspan='2' style='padding-left:30px;'><b>
c) Openness to student's remarks</b></td>
<td $displayText colspan='2' >{$data[24]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[24]' {$checked[56]} value='Always open' />Always open</td>
<td><input type='radio' name='data[24]' {$checked[57]} value='Open sometimes' />Open sometimes</td>
<td><input type='radio' name='data[24]' {$checked[58]} value='Rarely open' />Rarely open</td>
<td><input type='radio' name='data[24]' {$checked[59]} value='Never open' />Never open</td></tr>

<tr><td colspan='2' style='padding-left:30px;'><b>
d) Fairness</b></td>
<td $displayText colspan='2'>{$data[25]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[25]' {$checked[60]} value='Always fair' />Always fair</td>
<td><input type='radio' name='data[25]' {$checked[61]} value='Mostly fair' />Mostly fair</td>
<td><input type='radio' name='data[25]' {$checked[62]} value='Fair sometimes' />Fair sometimes</td>
<td><input type='radio' name='data[25]' {$checked[63]} value='Never fair' />Never fair</td></tr>

<tr><td colspan='3' style='padding-left:30px;'><b>
e) Comments and suggestions on papers or exposés</b>
<font $displayText>{$data[26]}</font></td></tr>
<tr $displayForm>
<td><input type='radio' name='data[26]' {$checked[64]} value='Extremely helpful' />Extremely helpful</td>
<td><input type='radio' name='data[26]' {$checked[65]} value='Very helpful' />Very helpful</td>
<td><input type='radio' name='data[26]' {$checked[66]} value='Not helpful' />Not helpful</td>
<td><input type='radio' name='data[26]' {$checked[67]} value='Does not give comments' />Does not give comments</td></tr>

<tr><td colspan='2' style='padding-left:30px;'><b>
f) Encouragement to learn more</b></td>
<td $displayText colspan='2'>{$data[27]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[27]' {$checked[68]} value='Very encouraging' />Very encouraging</td>
<td><input type='radio' name='data[27]' {$checked[69]} value='Encouraging' />Encouraging</td>
<td><input type='radio' name='data[27]' {$checked[70]} value='Not encouraging' />Not encouraging</td>
<td><input type='radio' name='data[27]' {$checked[71]} value='Does not give any' />Does not give any</td></tr>


<tr><td colspan='4' style='text-align:justify;padding-top:20px;'><b>8. Assignments.</b> Please list the written 
and oral work you were assigned in this course</td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[28]'>{$data[28]}</textarea>
<div $displayText>{$data[28]}</div></td></tr>

<tr><td colspan='4' style='text-align:justify;'><b>9. Were the assignments effective for 
archieving the stated goals of the course ?
<font $displayText>{$data[29]}</font></td></tr>
<tr $displayForm>
<td><input type='radio' name='data[29]' {$checked[72]} value='Absolutely' />Absolutely</td>
<td><input type='radio' name='data[29]' {$checked[73]} value='Mostly' />Mostly</td>
<td><input type='radio' name='data[29]' {$checked[74]} value='Somewhat' />Somewhat</td>
<td><input type='radio' name='data[29]' {$checked[75]} value='Not effective' />Not effective</td></tr>

<tr><td colspan='4'><b>Comments :</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[30]'>{$data[30]}</textarea>
<div $displayText>{$data[30]}</div></td></tr>

<tr><td colspan='4' style='text-align:justify;'><b>10. Please share any other observations 
or comments you would like to make, including on the content of the course and its organization</b> 
(Amount of work, class meetings, content of, and approach to, the materials studied ...)</td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[31]'>{$data[31]}</textarea>
<div $displayText>{$data[31]}</div></td></tr>

<tr><td colspan='4'><b>MERCI BEAUCOUP !</b></td></tr>
<tr><td colspan='2'><b>Your name (optional) :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[32]' value='{$data[32]}'/></td>
<td $displayText colspan='2'>{$data[32]}</td></tr>



<tr $displayForm><td colspan='4' style='text-align:center;padding-top:20px;'>
<!-- <input type='hidden' name='closed' value='0' />
<input type='submit' value='Save to continue later' style='margin-right:30px;'/>
<input type='button' value='Submit' onclick='document.form.closed.value="1";document.form.submit();'/></td></tr> -->
<input type='hidden' name='closed' value='1' />
<input type='submit' value='Submit' /></td></tr>
</table></form>
</div> <!--	class='fieldset'	-->
EOD;

?>