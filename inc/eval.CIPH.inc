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
$db->select("courses_ciph","*","id=$courseId");
$data[1]=decrypt($db->result[0]['instructeur'],$std_id);
$data[2]=decrypt($db->result[0]['titre'],$std_id);

$displayForm=$isForm?null:"style='display:none;'";
$displayText=$isForm?"style='display:none;'":"class='response'";

//	Init checked variables
for($i=0;$i<36;$i++){
  for($j=0;$j<5;$j++){
    $checked["{$i}_{$j}"]=null;
  }
}

switch($data[4]){
  case "Strenuous" 			: $checked['4_1']="checked='checked'"; break;
  case "Fairly strenuous"	 	: $checked['4_2']="checked='checked'"; break;
  case "Moderate" 			: $checked['4_3']="checked='checked'"; break;
  case "Light" 				: $checked['4_4']="checked='checked'"; break;
}
switch($data[5]){
  case "Comfortably" 			: $checked['5_1']="checked='checked'"; break;
  case "With some difficulty" 		: $checked['5_2']="checked='checked'"; break;
  case "With considerable difficulty" 	: $checked['5_3']="checked='checked'"; break;
  case "Not Applicable" 		: $checked['5_4']="checked='checked'"; break;
}

switch($data[6]){
  case "Comfortably" 			: $checked['6_1']="checked='checked'"; break;
  case "With some difficulty" 		: $checked['6_2']="checked='checked'"; break;
  case "With considerable difficulty" 	: $checked['6_3']="checked='checked'"; break;
  case "Not Applicable" 		: $checked['6_4']="checked='checked'"; break;
}

switch($data[7]){
  case "Yes"				: $checked['7_1']="checked='checked'"; break;
  case "No"				: $checked['7_2']="checked='checked'"; break;
}

switch($data[9]){
  case "Yes"				: $checked['9_1']="checked='checked'"; break;
  case "No"				: $checked['9_2']="checked='checked'"; break;
}

switch($data[11]){
  case "Almost always"			: $checked['11_1']="checked='checked'"; break;
  case "Most of the time"		: $checked['11_2']="checked='checked'"; break;
  case "Some of the time"		: $checked['11_3']="checked='checked'"; break;
  case "Almost never/never"		: $checked['11_4']="checked='checked'"; break;
}

switch($data[13]){
  case "Almost always"			: $checked['13_1']="checked='checked'"; break;
  case "Most of the time"		: $checked['13_2']="checked='checked'"; break;
  case "Some of the time"		: $checked['13_3']="checked='checked'"; break;
  case "Almost never/never"		: $checked['13_4']="checked='checked'"; break;
}

switch($data[15]){
  case "Almost always"			: $checked['15_1']="checked='checked'"; break;
  case "Most of the time"		: $checked['15_2']="checked='checked'"; break;
  case "Some of the time"		: $checked['15_3']="checked='checked'"; break;
  case "Almost never/never"		: $checked['15_4']="checked='checked'"; break;
}

switch($data[17]){
  case "Very clear"			: $checked['17_1']="checked='checked'"; break;
  case "Somewhat clear"			: $checked['17_2']="checked='checked'"; break;
  case "Not clear"			: $checked['17_3']="checked='checked'"; break;
  case "Not applicable"			: $checked['17_4']="checked='checked'"; break;
}

switch($data[18]){
  case "Very clear"			: $checked['18_1']="checked='checked'"; break;
  case "Somewhat clear"			: $checked['18_2']="checked='checked'"; break;
  case "Not clear"			: $checked['18_3']="checked='checked'"; break;
  case "Not applicable"			: $checked['18_4']="checked='checked'"; break;
}

switch($data[19]){
  case "Very clear"			: $checked['19_1']="checked='checked'"; break;
  case "Somewhat clear"			: $checked['19_2']="checked='checked'"; break;
  case "Not clear"			: $checked['19_3']="checked='checked'"; break;
  case "Not applicable"			: $checked['19_4']="checked='checked'"; break;
}

switch($data[20]){
  case "Very clear"			: $checked['21_1']="checked='checked'"; break;
  case "Somewhat clear"			: $checked['21_2']="checked='checked'"; break;
  case "Not clear"			: $checked['21_3']="checked='checked'"; break;
  case "Not applicable"			: $checked['21_4']="checked='checked'"; break;
}

switch($data[21]){
  case "Very clear"			: $checked['21_1']="checked='checked'"; break;
  case "Somewhat clear"			: $checked['21_2']="checked='checked'"; break;
  case "Not clear"			: $checked['21_3']="checked='checked'"; break;
  case "Not applicable"			: $checked['21_4']="checked='checked'"; break;
}

switch($data[22]){
  case "Yes"				: $checked['22_1']="checked='checked'"; break;
  case "No"				: $checked['22_2']="checked='checked'"; break;
}

switch($data[23]){
  case "Not applicable"			: $checked['23_1']="checked='checked'"; break;
  case "Yes"				: $checked['23_2']="checked='checked'"; break;
  case "No"				: $checked['23_3']="checked='checked'"; break;
}

switch($data[25]){
  case "Excellent"			: $checked['25_1']="checked='checked'"; break;
  case "Good"				: $checked['25_2']="checked='checked'"; break;
  case "Fair"				: $checked['25_3']="checked='checked'"; break;
  case "Rarely able"			: $checked['25_4']="checked='checked'"; break;
}

switch($data[26]){
  case "Excellent"			: $checked['26_1']="checked='checked'"; break;
  case "Good"				: $checked['26_2']="checked='checked'"; break;
  case "Fair"				: $checked['26_3']="checked='checked'"; break;
  case "Not organized"			: $checked['26_4']="checked='checked'"; break;
}

switch($data[27]){
  case "Always open"			: $checked['27_1']="checked='checked'"; break;
  case "Open sometimes"			: $checked['27_2']="checked='checked'"; break;
  case "Rarely open"			: $checked['27_3']="checked='checked'"; break;
  case "Never Open"			: $checked['27_4']="checked='checked'"; break;
}

switch($data[28]){
  case "Always fair"			: $checked['28_1']="checked='checked'"; break;
  case "Mostly fair"			: $checked['28_2']="checked='checked'"; break;
  case "Fair sometimes"			: $checked['28_3']="checked='checked'"; break;
  case "Never fair"			: $checked['28_4']="checked='checked'"; break;
}

switch($data[29]){
  case "Extremely helpful"		: $checked['29_1']="checked='checked'"; break;
  case "Very helpful"			: $checked['29_2']="checked='checked'"; break;
  case "Not Helpful"			: $checked['29_3']="checked='checked'"; break;
  case "Does not give comments"		: $checked['29_4']="checked='checked'"; break;
}

switch($data[30]){
  case "Very encouraging"		: $checked['30_1']="checked='checked'"; break;
  case "Encouraging"			: $checked['30_2']="checked='checked'"; break;
  case "Not encouraging"		: $checked['30_3']="checked='checked'"; break;
  case "Does not give any"		: $checked['30_4']="checked='checked'"; break;
}

switch($data[32]){
  case "Absolutely"			: $checked['32_1']="checked='checked'"; break;
  case "Mostly"				: $checked['32_2']="checked='checked'"; break;
  case "Somewhat"			: $checked['32_3']="checked='checked'"; break;
  case "Not effective"			: $checked['32_4']="checked='checked'"; break;
}

switch($data[35]){
  case "Yes"				: $checked['35_1']="checked='checked'"; break;
  case "No"				: $checked['35_2']="checked='checked'"; break;
}


echo <<<EOD
<div class='fieldset'>
<legend><b>CIPh Evalution Form</b></legend>
<form method='post' action='eval_update.php' name='form'>
<input type='hidden' name='std_id' value='$std_id' />
<input type='hidden' name='timestamp' value='$timestamp' />
<input type='hidden' name='form' value='$form' />
<input type='hidden' name='courseId' value='$courseId' />
<table style='width:100%;'>
<tr><td style='width:25%;'>&nbsp;</td><td style='width:25%;'>&nbsp;</td>
<td style='width:25%;'>&nbsp;</td><td style='width:25%;'>&nbsp;</td></tr>
<tr><td colspan='4'>
<h2>
VASSAR-WESLEYAN PROGRAM IN PARIS<br/>
College Internationnal De Philosophie Tutorial Evaluation Form, {$_SESSION['vwpp']['semester']}
</h2>
</td></tr>

<tr><td colspan='4' style='padding-top:30px;font-style:italic;text-align:justify;'>
This form will not be shared with the CIPh seminar organizer. It is intended for your tutor and 
VWPP directors to help future students make an informed decision in their choice of courses. 
We could appreciate a thoughtful response.</td></tr>

<tr><td colspan='2' style='padding-top:20px;'><b>Name of tutor :</td>
<td colspan='2' style='padding-top:20px;'>
<!-- <input $displayForm type='text' name='data[1]' value='{$data[1]}' />
<div $displayText>{$data[1]}</div> -->
<font class='response'>{$data[1]}</font>
</td></tr>

<tr><td colspan='2'><b>Name(s) of seminar(s) you attended :</td>
<td colspan='2'>
<!-- <input $displayForm type='text' name='data[2]' value='{$data[2]}' />
<div $displayText>{$data[2]}</div> -->
<font class='response'>{$data[2]}</font>

</td></tr>

<tr><td colspan='2'><b>Name(s) of seminar(s) organizer(s) :</td>
<td colspan='2'>
<input $displayForm type='text' name='data[3]' value='{$data[3]}' />
<div $displayText>{$data[3]}</div>
</td></tr>

<tr><td colspan='4' style='padding-top:20px;'>
<b>1. How would you describe your efforts in this course ?</b></td></tr>
<tr>
<td><div $displayForm >
<input type='radio' name='data[4]' {$checked['4_1']} value='Strenuous' /> Strenuous</div>
<div $displayText>&nbsp;</div></td>

<td><div $displayForm >
<input type='radio' name='data[4]' {$checked['4_2']} value='Fairly strenuous' /> Fairly strenuous</div>
<div $displayText>{$data[4]}</div></td>

<td><div $displayForm >
<input type='radio' name='data[4]' {$checked['4_3']} value='Moderate' /> Moderate</div></td>

<td><div $displayForm >
<input type='radio' name='data[4]' {$checked['4_4']} value='Light' /> Light</div></td>
</tr>


<tr><td colspan='4' style='padding-top:20px;text-align:justify;'>
<b>2. Do you think your French was at a level that allowed you understand and take notes ?</b></td></tr>

<tr><td colspan='1' style='padding-left:30px;'>
<b>a) <u>At the beginning</u> :</b></td>
<td colspan='2' $displayText >{$data[5]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[5]' {$checked['5_1']} value='Comfortably' /> Comfortably</td>
<td><input type='radio' name='data[5]' {$checked['5_2']} value='With some difficulty' /> With some difficulty</td>
<td><input type='radio' name='data[5]' {$checked['5_3']} value='With considerable difficulty' /> With considerable difficulty</td>
<td><input type='radio' name='data[5]' {$checked['5_4']} value='Not Applicable' /> Not Applicable</td>
</tr>

<tr><td colspan='1' style='padding-top:20px;padding-left:30px;'>
<b>b) <u>After half-term</u> :</b></td>
<td colspan='2' $displayText style='padding-top:20px;'>{$data[6]}</td></tr>
<tr $displayForm >
<td><input type='radio' name='data[6]' {$checked['6_1']} value='Comfortably' /> Comfortably</td>
<td><input type='radio' name='data[6]' {$checked['6_2']} value='With some difficulty' /> With some difficulty</td>
<td><input type='radio' name='data[6]' {$checked['6_3']} value='With considerable difficulty' /> With considerable difficulty</td>
<td><input type='radio' name='data[6]' {$checked['6_4']} value='Not Applicable' /> Not Applicable</td>
</tr>

<tr><td colspan='4' style='padding-top:20px;text-align:justify;'>
<b>3. a) Did you attend every seminar session at the CIPh ?</b>
<font $displayText style='margin-left:20px;'>{$data[7]}</font></td></tr>

<tr $displayForm><td><input type='radio' name='data[7]' {$checked['7_1']} value='Yes' /> Yes</td>
<td><input type='radio' name='data[7]' {$checked['7_2']} value='No' /> No</td></tr>
<tr><td colspan='4'><b>If not, why not ?</b></td></tr>

<tr $displayForm><td colspan='4'><textarea name='data[8]'>{$data[8]}</textarea></td></tr>
<tr $displayText><td colspan='4'>{$data[8]}</td></tr>

<tr><td colspan='4' style='padding-top:20px;padding-left:30px;text-align:justify;'>
<b>b) Did you attend every tutorial session (individual or collective) ?</b>
<font $displayText style='margin-left:20px;'>{$data[9]}</font></td></tr>

<tr $displayForm><td><input type='radio' name='data[9]' {$checked['9_1']} value='Yes' /> Yes</td>
<td><input type='radio' name='data[9]' {$checked['9_2']} value='No' /> No</td></tr>
<tr><td colspan='4'><b>If not, why not ?</b></td></tr>

<tr $displayForm><td colspan='4'><textarea name='data[10]'>{$data[10]}</textarea></td></tr>
<tr $displayText><td colspan='4'>{$data[10]}</td></tr>

<tr><td colspan='4' style='padding-top:20px;text-align:justify;'>
<b>4.Please evaluate your own work in the course. Did you :</b></td></tr>
<tr><td colspan='2' style='padding-left:30px;'><b>a) Keep up with assigned reading ?</b></td>
<td colspan='2' $displayText>{$data[11]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[11]' {$checked['11_1']} value='Almost always' /> Almost always</td>
<td><input type='radio' name='data[11]' {$checked['11_2']} value='Most of the time' /> Most of the time</td>
<td><input type='radio' name='data[11]' {$checked['11_3']} value='Some of the time' /> Some of the time</td>
<td><input type='radio' name='data[11]' {$checked['11_4']} value='Almost never/never' /> Almost never/never</td></tr>

<tr><td colspan='4' style='padding-top:20px;'><b>If not, why not ?</b></td></tr>
<tr $displayForm ><td colspan='4'><textarea name='data[12]' rows='10' cols='10'>{$data[12]}</textarea></tr>
<tr $displayText ><td colspan='4'>{$data[12]}</tr>


<tr><td colspan='2' style='padding-left:30px;'><b>b) Contribute to in-class discussion ?</b></td>
<td colspan='2' $displayText>{$data[13]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[13]' {$checked['13_1']} value='Almost always' /> Almost always</td>
<td><input type='radio' name='data[13]' {$checked['13_2']} value='Most of the time' /> Most of the time</td>
<td><input type='radio' name='data[13]' {$checked['13_3']} value='Some of the time' /> Some of the time</td>
<td><input type='radio' name='data[13]' {$checked['13_4']} value='Almost never/never' /> Almost never/never</td></tr>

<tr><td colspan='4' style='padding-top:20px;'><b>If not, why not ?</b></td></tr>
<tr $displayForm ><td colspan='4'><textarea name='data[14]' rows='10' cols='10'>{$data[14]}</textarea></tr>
<tr $displayText ><td colspan='4'>{$data[14]}</td></tr>


<tr><td colspan='2' style='padding-left:30px;'><b>c) Raise questions ?</b></td>
<td colspan='2' $displayText>{$data[15]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[15]' {$checked['15_1']} value='Almost always' /> Almost always</td>
<td><input type='radio' name='data[15]' {$checked['15_2']} value='Most of the time' /> Most of the time</td>
<td><input type='radio' name='data[15]' {$checked['15_3']} value='Some of the time' /> Some of the time</td>
<td><input type='radio' name='data[15]' {$checked['15_4']} value='Almost never/never' /> Almost never/never</td></tr>

<tr><td colspan='4' style='padding-top:20px;'><b>If not, why not ?</b></td></tr>
<tr $displayForm ><td colspan='4'><textarea name='data[16]' rows='10' cols='10'>{$data[16]}</textarea></tr>
<tr $displayText ><td colspan='4'>{$data[16]}</td></tr>


<tr><td colspan='4' ><b>
5. Did you have a clear understanding of what was expected from you in this course for the following :</b></td></tr>
<tr><td colspan='2' style='padding-left:30px;'><b>a) Readings :</b></td>
<td $displayText colspan='2'>{$data[17]}</td></tr>

<tr $displayForm >
<td><input type='radio' name='data[17]' {$checked['17_1']} value='Very clear' /> Very clear</td>
<td><input type='radio' name='data[17]' {$checked['17_2']} value='Somewhat clear' /> Somewhat clear</td>
<td><input type='radio' name='data[17]' {$checked['17_3']} value='Not clear' /> Not clear</td>
<td><input type='radio' name='data[17]' {$checked['17_4']} value='Not applicable' /> Not applicable</td></tr>

<tr><td colspan='2' style='padding-top:20px;padding-left:30px;'><b>b) Written work :</b></td>
<td $displayText colspan='2' style='padding-top:20px;'>{$data[18]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[18]' {$checked['18_1']} value='Very clear' /> Very clear</td>
<td><input type='radio' name='data[18]' {$checked['18_2']} value='Somewhat clear' /> Somewhat clear</td>
<td><input type='radio' name='data[18]' {$checked['18_3']} value='Not clear' /> Not clear</td>
<td><input type='radio' name='data[18]' {$checked['18_4']} value='Not applicable' /> Not applicable</td></tr>

<tr><td colspan='2' style='padding-top:20px;padding-left:30px;'><b>c) Oral presentation :</b></td>
<td $displayText colspan='2' style='padding-top:20px;'>{$data[19]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[19]' {$checked['19_1']} value='Very clear' /> Very clear</td>
<td><input type='radio' name='data[19]' {$checked['19_2']} value='Somewhat clear' /> Somewhat clear</td>
<td><input type='radio' name='data[19]' {$checked['19_3']} value='Not clear' /> Not clear</td>
<td><input type='radio' name='data[19]' {$checked['19_4']} value='Not applicable' /> Not applicable</td></tr>

<tr><td colspan='2' style='padding-top:20px;padding-left:30px;'><b>d) Other (Please specify):</b></td>
<td colspan='2' style='padding-top:20px;'>
<input $displayForm type='text' name='data[20]' value='{$data[20]}' />
<div $displayText>{$data[20]}</div></td></tr>

<tr $displayForm >
<td><input type='radio' name='data[21]' {$checked['21_1']} value='Very clear' /> Very clear</td>
<td><input type='radio' name='data[21]' {$checked['21_2']} value='Somewhat clear' /> Somewhat clear</td>
<td><input type='radio' name='data[21]' {$checked['21_3']} value='Not clear' /> Not clear</td>
<td><input type='radio' name='data[21]' {$checked['21_4']} value='Not applicable' /> Not applicable</td></tr>

<tr $displayText >
<td colspan='2'>&nbsp;</td>
<td colspan='2'>{$data[21]}</td></tr>


<tr><td colspan='4' style='padding-top:20px;'><b>6. a) Where there visits or events outside of class that formed part of this course ?</b>
<font $displayText>{$data[22]}</font></td></tr>

<tr $displayForm>
<td><input type='radio' name='data[22]' {$checked['22_1']} value='Yes' /> Yes</td>
<td><input type='radio' name='data[22]' {$checked['22_2']} value='No' /> No</td></tr>

<tr><td colspan='2' style='padding-top:20px;padding-left:30px;'><b>b) Did you attend all of them ?</b></td>
<td colspan='2' style='padding-top:20px;' $displayText>{$data[23]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[23]' {$checked['23_1']} value='Not applicable' /> Not applicable</td>
<td><input type='radio' name='data[23]' {$checked['23_2']} value='Yes' /> Yes</td>
<td><input type='radio' name='data[23]' {$checked['23_3']} value='No' /> No</td></tr>

<tr><td colspan='4'><b>If not, why not ?</b></td></tr>
<tr $displayForm ><td colspan='4'><textarea name='data[24]'>{$data[24]}</textarea></td></tr>
<tr $displayText ><td colspan='4'>{$data[24]}</td></tr>

<tr><td colspan='4' style='padding-top:20px;text-align:justify;'><b>7. Please comment on the following aspects of your interaction
with your tutor (not seminar).</b></td></tr>

<tr><td colspan='3' style='padding-top:20px;padding-left:30px;'><b>a)Ability to explain difficult material</b></td>
<td $displayText style='padding-top:20px;'>{$data[25]}</td></tr>

<tr $displayForm >
<td><input type='radio' name='data[25]' {$checked['25_1']} value='Excellent' /> Excellent</td>
<td><input type='radio' name='data[25]' {$checked['25_2']} value='Good' /> Good</td>
<td><input type='radio' name='data[25]' {$checked['25_3']} value='Fair' /> Fair</td>
<td><input type='radio' name='data[25]' {$checked['25_4']} value='Rarely able' /> Rarely able</td></tr>

<tr><td colspan='3' style='padding-top:20px;padding-left:30px;'><b>b) Organization</b></td>
<td $displayText style='padding-top:20px;'>{$data[26]}</td></tr>

<tr $displayForm >
<td><input type='radio' name='data[26]' {$checked['26_1']} value='Excellent' /> Excellent</td>
<td><input type='radio' name='data[26]' {$checked['26_2']} value='Good' /> Good</td>
<td><input type='radio' name='data[26]' {$checked['26_3']} value='Fair' /> Fair</td>
<td><input type='radio' name='data[26]' {$checked['26_4']} value='Not organized' /> Not organized</td></tr>

<tr><td colspan='3' style='padding-top:20px;padding-left:30px;'><b>c) Openness to student's remarks</b></td>
<td $displayText style='padding-top:20px;'>{$data[27]}</td></tr>

<tr $displayForm >
<td><input type='radio' name='data[27]' {$checked['27_1']} value='Always open' /> Always open</td>
<td><input type='radio' name='data[27]' {$checked['27_2']} value='Open sometimes' /> Open sometimes</td>
<td><input type='radio' name='data[27]' {$checked['27_3']} value='Rarely open' /> Rarely open</td>
<td><input type='radio' name='data[27]' {$checked['27_4']} value='Never Open' /> Never Open</td></tr>

<tr><td colspan='3' style='padding-top:20px;padding-left:30px;'><b>d) Fairness</b></td>
<td $displayText style='padding-top:20px;'>{$data[28]}</td></tr>

<tr $displayForm >
<td><input type='radio' name='data[28]' {$checked['28_1']} value='Always fair' /> Always fair</td>
<td><input type='radio' name='data[28]' {$checked['28_2']} value='Mostly fair' /> Mostly fair</td>
<td><input type='radio' name='data[28]' {$checked['28_3']} value='Fair sometimes' /> Fair sometimes</td>
<td><input type='radio' name='data[28]' {$checked['28_4']} value='Never fair' /> Never fair</td></tr>

<tr><td colspan='3' style='padding-top:20px;padding-left:30px;'><b>e) Comments and suggestions on papers or exposés</b></td>
<td $displayText style='padding-top:20px;'>{$data[29]}</td></tr>

<tr $displayForm >
<td><input type='radio' name='data[29]' {$checked['29_1']} value='Extremely helpful' /> Extremely helpful</td>
<td><input type='radio' name='data[29]' {$checked['29_2']} value='Very helpful' /> Very helpful</td>
<td><input type='radio' name='data[29]' {$checked['29_3']} value='Not Helpful' /> Not Helpful</td>
<td><input type='radio' name='data[29]' {$checked['29_4']} value='Does not give comments' /> Does not give comments</td></tr>

<tr><td colspan='3' style='padding-top:20px;padding-left:30px;'><b>f) Encouragement to learn more</b></td>
<td $displayText style='padding-top:20px;'>{$data[30]}</td></tr>

<tr $displayForm >
<td><input type='radio' name='data[30]' {$checked['30_1']} value='Very encouraging' /> Very encouraging</td>
<td><input type='radio' name='data[30]' {$checked['30_2']} value='Encouraging' /> Encouraging</td>
<td><input type='radio' name='data[30]' {$checked['30_3']} value='Not encouraging' /> Not encouraging</td>
<td><input type='radio' name='data[30]' {$checked['30_4']} value='Does not give any' /> Does not give any</td></tr>

<tr><td colspan='4' style='padding-top:20px;text-align:justify;'><b>8 Assignments. Please list the written and oral work 
you were assigned in this course.</b></td></tr>
<tr $displayForm><td colspan='4'><textarea name='data[31]'>{$data[31]}</textarea></td></tr>
<tr $displayText><td colspan='4'>{$data[31]}</td></tr>

<tr><td colspan='4' style='padding-top:20px;text-align:justify;'><b>9. Wherethe assignements effective 
for archieving the goals stated for the course stated by your tutor ?</b>
<font $displayText>{$data[32]}</font></td></tr>

<tr $displayForm>
<td><input type='radio' name='data[32]' {$checked['32_1']} value='Absolutely' />Absolutely</td>
<td><input type='radio' name='data[32]' {$checked['32_2']} value='Mostly' />Mostly</td>
<td><input type='radio' name='data[32]' {$checked['32_3']} value='Somewhat' />Somewhat</td>
<td><input type='radio' name='data[32]' {$checked['32_4']} value='Not effective' />Not effective</td></tr>

<tr><td colspan='4'><b>Comments :</b></td></tr>
<tr $displayForm><td colspan='4'><textarea name='data[33]'>{$data[33]}</textarea></td></tr>
<tr $displayText><td colspan='4'>{$data[33]}</td></tr>


<tr><td colspan='4' style='padding-top:20px;text-align:justify;'><b>10. a) Format of the course: What do you 
think of the general (original) format of the CIPH seminar/tutorial ? What was the most positive aspect of 
this course for you personally ?</b>
<tr $displayForm><td colspan='4'><textarea name='data[34]'>{$data[34]}</textarea></td></tr>
<tr $displayText><td colspan='4'>{$data[34]}</td></tr>

<tr><td colspan='4' style='padding-top:20px;padding-left:30px;text-align:justify;'><b>b) Would you 
recommend such an academic experience to others ? Why (not) ?</b>
<font $displayText>{$data[35]}</font></td></tr>

<tr $displayForm>
<td><input type='radio' name='data[35]' {$checked['35_1']} value='Yes' />Yes</td>
<td><input type='radio' name='data[35]' {$checked['35_2']} value='No' />No</td>
<td colspan='2'><b>Why or why not ?</b></td></tr>

<tr $displayForm><td colspan='4'><textarea name='data[36]'>{$data[36]}</textarea></td></tr>
<tr $displayText><td colspan='4'>{$data[36]}</td></tr>

<tr><td colspan='4' style='padding-top:20px;text-align:justify;'><b>11.Please share any other observations 
or comments you would like to make, including on the content of the course and its organization</b> 
(Amount of work, class meetings, content of, and approach to, the materials studied ...)</td></tr>

<tr $displayForm><td colspan='4'><textarea name='data[37]'>{$data[37]}</textarea></td></tr>
<tr $displayText><td colspan='4'>{$data[37]}</td></tr>

<tr><td colspan='4' style='padding-top:20px;text-align:justify;'><b>MERCI BEAUCOUP !</b></<td></tr>
<tr><td colspan='2'>Your Name (optional) :</td>
<td $displayForm colspan='2'><input type='text' name='data[38]' value='{$data[38]}' /></td>
<td $displayText colspan='2'>{$data[38]}</td>
</tr>

<tr $displayForm><td colspan='4' style='text-align:center;padding-top:20px;'>
<input type='hidden' name='closed' value='0' />
<!--
<input type='submit' value='Save to continue later' style='margin-right:30px;'/>
<input type='button' value='Submit' onclick='document.form.closed.value="1";document.form.submit();'/></td></tr>
-->
<input type='submit' value='Submit' onclick='document.form.closed.value="1";document.form.submit();'/></td></tr>
</table></form>
</div>
EOD;

?>