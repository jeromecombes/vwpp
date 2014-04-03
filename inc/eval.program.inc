<?php
/*
This script needs :
- $isForm : true or false : display form or text
- $std_id : int (student id)
- $timestamp : timestamp
- $form : text : form's name
- $data : array("question (int)"=> "response (text)");
*/
//$isForm=true;
$displayForm=$isForm?null:"style='display:none;'";
$displayText=$isForm?"style='display:none;'":"class='response'";

//	Init checked variables
$data[32]=unserialize($data[32]);

$i=1;
$checked[$i++]=$data[5]=="More than 80%"?"checked='checked'":null;
$checked[$i++]=$data[5]=="70-80%"?"checked='checked'":null;
$checked[$i++]=$data[5]=="50-70%"?"checked='checked'":null;
$checked[$i++]=$data[5]=="Less than 50%"?"checked='checked'":null;
$checked[$i++]=$data[6]=="Comprehension"?"checked='checked'":null;
$checked[$i++]=$data[6]=="Speaking"?"checked='checked'":null;
$checked[$i++]=$data[6]=="Reading"?"checked='checked'":null;
$checked[$i++]=$data[6]=="Writing"?"checked='checked'":null;
for($j=8;$j<13;$j++){
  $checked[$i++]=$data[$j]=="Often"?"checked='checked'":null;
  $checked[$i++]=$data[$j]=="Sometimes"?"checked='checked'":null;
  $checked[$i++]=$data[$j]=="Rarely"?"checked='checked'":null;
  $checked[$i++]=$data[$j]=="Never"?"checked='checked'":null;
}
for($j=13;$j<18;$j++){
  $checked[$i++]=$data[$j]=="Very helpful"?"checked='checked'":null;
  $checked[$i++]=$data[$j]=="Helpful"?"checked='checked'":null;
  $checked[$i++]=$data[$j]=="Not helpful"?"checked='checked'":null;
  $checked[$i++]=$data[$j]=="Not applicable"?"checked='checked'":null;
}
for($j=19;$j<27;$j++){
  $checked[$i++]=$data[$j]=="Yes"?"checked='checked'":null;
  $checked[$i++]=$data[$j]=="No"?"checked='checked'":null;
}
$checked[$i++]=$data[28]=="Yes"?"checked='checked'":null;
$checked[$i++]=$data[28]=="No"?"checked='checked'":null;
$checked[$i++]=$data[31]=="Yes"?"checked='checked'":null;
$checked[$i++]=$data[31]=="No"?"checked='checked'":null;

if(is_array($data[32])){						// Checkboxes
  $checked[$i++]=in_array("Club",$data[32])?"checked='checked'":null;
  $checked[$i++]=in_array("Team",$data[32])?"checked='checked'":null;
  $checked[$i++]=in_array("Group",$data[32])?"checked='checked'":null;
  $checked[$i++]=in_array("Activity",$data[32])?"checked='checked'":null;
}
else{
  $checked[$i++]=null;
  $checked[$i++]=null;
  $checked[$i++]=null;
  $checked[$i++]=null;
}

$checked[$i++]=$data[49]=="Yes"?"checked='checked'":null;
$checked[$i++]=$data[49]=="No"?"checked='checked'":null;

if(is_array($data[32]))
  $data[32]=join(" ; ",$data[32]);


echo <<<EOD
<div class='fieldset'>
<form method='post' action='eval_update.php' name='form' onsubmit='return ctrl_form3();'>
<input type='hidden' name='std_id' value='$std_id' />
<input type='hidden' name='timestamp' value='$timestamp' />
<input type='hidden' name='form' value='$form' />
<table style='width:100%;'>
<tr><td style='width:25%;'>&nbsp;</td><td style='width:25%;'>&nbsp;</td>
<td style='width:25%;'>&nbsp;</td><td style='width:25%;'>&nbsp;</td></tr>
<tr><td colspan='4'>
<h2>VASSAR-WESLEYAN PROGRAM IN PARIS<br/>
Program Evaluation Form, {$_SESSION['vwpp']['semester']}</h2>
</td></tr>

<tr><td colspan='4'><b>I. BENEFITS</b></td></tr>
<tr><td colspan='4'><b>1) What do you see as the main benefits you derived from your semester 
in France ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[1]'>{$data[1]}</textarea>
<div $displayText >{$data[1]}</div>
</td></tr>

<tr><td colspan='4'><b>2) In retrospect, is there anything you would have done differently ?
</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[2]'>{$data[2]}</textarea>
<div $displayText >{$data[2]}</div>
</td></tr>

<tr><td colspan='4'><b>II. UNIVERSITY COURSES</b></td></tr>
<tr><td colspan='4'><b>3) What did you learn about the French university by taking a course in 
the French system ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[3]'>{$data[3]}</textarea>
<div $displayText >{$data[3]}</div>
</td></tr>

<tr><td colspan='4'><b>4) What was the most positive aspect taking a course in the French 
university for you personally ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[4]'>{$data[4]}</textarea>
<div $displayText >{$data[4]}</div>
</td></tr>

<tr><td colspan='4'><b>III. LANGUAGE SKILS.</b></td></tr>
<tr><td colspan='4'><b>5) About what percentage of the time did you speak French in your 
interactions with people ?</b></td></tr>
<tr $displayText><td colspan='2'>&nbsp;</td>
<td colspan='2'>{$data[5]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[5]' {$checked[1]} value='More than 80%' />More than 80%</td>
<td><input type='radio' name='data[5]' {$checked[2]} value='70-80%' />70-80%</td>
<td><input type='radio' name='data[5]' {$checked[3]} value='50-70%' />50-70%</td>
<td><input type='radio' name='data[5]' {$checked[4]} value='Less than 50%' />Less than 50%<br/><br/></td>
</tr>

<tr><td colspan='4' style='padding-top:20px;'><b>6) In which aspects of your French have noticed the most significant 
improvement ?</b></td></tr>
<tr $displayText><td colspan='2'>&nbsp;</td>
<td colspan='2'>{$data[6]}</td></tr>
<tr $displayForm>
<td><input type='radio' name='data[6]' {$checked[5]} value='Comprehension' />Comprehension</td>
<td><input type='radio' name='data[6]' {$checked[6]} value='Speaking' />Speaking</td>
<td><input type='radio' name='data[6]' {$checked[7]} value='Reading' />Reading</td>
<td><input type='radio' name='data[6]' {$checked[8]} value='Writing' />Writing<br/><br/></td>
</tr>

<tr><td colspan='4' style='padding-top:20px;'><b>To what factors do you attribute the improvements ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[7]'>{$data[7]}</textarea>
<div $displayText >{$data[7]}</div>
</td></tr>

<tr><td colspan='4'><b>IV. INTERACTIONS WITH ADMINISTRATION</b></td></tr>
<tr><td colspan='4'><b>7) Did you solicit help from Program administrators for </b></td></tr>
<tr><td colspan='2' style='padding-left:30px;'><b>a) Practical matters ?</b></td>
<td $displayText colspan='2'>{$data[8]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[8]' {$checked[9]} value='Often' />Often</td>
<td><input type='radio' name='data[8]' {$checked[10]} value='Sometimes' />Sometimes</td>
<td><input type='radio' name='data[8]' {$checked[11]} value='Rarely' />Rarely</td>
<td><input type='radio' name='data[8]' {$checked[12]} value='Never' />Never<br/><br/></td>
</tr>

<tr><td colspan='2' style='padding-left:30px;'><b>b) Extra-curricular activities ?</b></td>
<td $displayText colspan='2'>{$data[9]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[9]' {$checked[13]} value='Often' />Often</td>
<td><input type='radio' name='data[9]' {$checked[14]} value='Sometimes' />Sometimes</td>
<td><input type='radio' name='data[9]' {$checked[15]} value='Rarely' />Rarely</td>
<td><input type='radio' name='data[9]' {$checked[16]} value='Never' />Never<br/><br/></td>
</tr>

<tr><td colspan='2' style='padding-left:30px;'><b>c) Social interactions ?</b></td>
<td $displayText colspan='2'>{$data[10]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[10]' {$checked[17]} value='Often' />Often</td>
<td><input type='radio' name='data[10]' {$checked[18]} value='Sometimes' />Sometimes</td>
<td><input type='radio' name='data[10]' {$checked[19]} value='Rarely' />Rarely</td>
<td><input type='radio' name='data[10]' {$checked[20]} value='Never' />Never<br/><br/></td>
</tr>

<tr><td colspan='2' style='padding-left:30px;'><b>d) Academic issues ?</b></td>
<td $displayText colspan='2'>{$data[11]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[11]' {$checked[21]} value='Often' />Often</td>
<td><input type='radio' name='data[11]' {$checked[22]} value='Sometimes' />Sometimes</td>
<td><input type='radio' name='data[11]' {$checked[23]} value='Rarely' />Rarely</td>
<td><input type='radio' name='data[11]' {$checked[24]} value='Never' />Never<br/><br/></td>
</tr>

<tr><td colspan='2' style='padding-left:30px;'><b>e) Housing matters ?</b></td>
<td $displayText colspan='2'>{$data[12]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[12]' {$checked[25]} value='Often' />Often</td>
<td><input type='radio' name='data[12]' {$checked[26]} value='Sometimes' />Sometimes</td>
<td><input type='radio' name='data[12]' {$checked[27]} value='Rarely' />Rarely</td>
<td><input type='radio' name='data[12]' {$checked[28]} value='Never' />Never<br/><br/></td>
</tr>

<tr><td colspan='4' style='padding-top:20px;'><b>8) In general, how helpful was the advice 
given to you for</b></td></tr>

<tr><td colspan='2' style='padding-left:30px;'><b>a) Practical matters ?</b></td>
<td $displayText colspan='2'>{$data[13]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[13]' {$checked[29]} value='Very helpful' />Very helpful</td>
<td><input type='radio' name='data[13]' {$checked[30]} value='Helpful' />Helpful</td>
<td><input type='radio' name='data[13]' {$checked[31]} value='Not helpful' />Not helpful</td>
<td><input type='radio' name='data[13]' {$checked[32]} value='Not applicable' />Not applicable<br/><br/></td>
</tr>

<tr><td colspan='2' style='padding-left:30px;'><b>b) Extra-curricular activities ?</b></td>
<td $displayText colspan='2'>{$data[14]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[14]' {$checked[33]} value='Very helpful' />Very helpful</td>
<td><input type='radio' name='data[14]' {$checked[34]} value='Helpful' />Helpful</td>
<td><input type='radio' name='data[14]' {$checked[35]} value='Not helpful' />Not helpful</td>
<td><input type='radio' name='data[14]' {$checked[36]} value='Not applicable' />Not applicable<br/><br/></td>
</tr>

<tr><td colspan='2' style='padding-left:30px;'><b>c) Social interactions ?</b></td>
<td $displayText colspan='2'>{$data[15]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[15]' {$checked[37]} value='Very helpful' />Very helpful</td>
<td><input type='radio' name='data[15]' {$checked[38]} value='Helpful' />Helpful</td>
<td><input type='radio' name='data[15]' {$checked[39]} value='Not helpful' />Not helpful</td>
<td><input type='radio' name='data[15]' {$checked[40]} value='Not applicable' />Not applicable<br/><br/></td>
</tr>

<tr><td colspan='2' style='padding-left:30px;'><b>d) Academic issues ?</b></td>
<td $displayText colspan='2'>{$data[16]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[16]' {$checked[41]} value='Very helpful' />Very helpful</td>
<td><input type='radio' name='data[16]' {$checked[42]} value='Helpful' />Helpful</td>
<td><input type='radio' name='data[16]' {$checked[43]} value='Not helpful' />Not helpful</td>
<td><input type='radio' name='data[16]' {$checked[44]} value='Not applicable' />Not applicable<br/><br/></td>
</tr>

<tr><td colspan='2' style='padding-left:30px;'><b>e) Housing matters ?</b></td>
<td $displayText colspan='2'>{$data[17]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[17]' {$checked[45]} value='Very helpful' />Very helpful</td>
<td><input type='radio' name='data[17]' {$checked[46]} value='Helpful' />Helpful</td>
<td><input type='radio' name='data[17]' {$checked[47]} value='Not helpful' />Not helpful</td>
<td><input type='radio' name='data[17]' {$checked[48]} value='Not applicable' />Not applicable<br/><br/></td>
</tr>

<tr><td colspan='4' style='padding-top:20px;'><b>Comments (optional) :</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[18]'>{$data[18]}</textarea>
<div $displayText >{$data[18]}</div>
</td></tr>

<tr><td colspan='4'><b>V. SOCIAL, CULTURAL ACTIVITIES AND EXCURSIONS SPONSORED BY THE 
PROGRAM</b></td></tr>
<tr><td colspan='4'><b>9) a) Which of the following cultural activities sponsored by the 
program did you participate in ?</b></td></tr>
<tr><td colspan='2' style='padding-left:30px;'><b>Excursions outside of Paris</b></td>

<td $displayText colspan='2'>{$data[19]}</td>
<td $displayForm ><input type='radio' name='data[19]' {$checked[49]} value='Yes' />Yes</td>
<td $displayForm ><input type='radio' name='data[19]' {$checked[50]} value='No' />No</td>
</tr>

<tr><td colspan='4' style='padding-left:30px;'><b>Extracurricular Visits in Paris 
(Croisière sur la seine, Louvre etc.)</b>
<font $displayText>{$data[20]}</font></td></tr>

<tr $displayForm>
<td colspan='2'>&nbsp;</td>
<td><input type='radio' name='data[20]' {$checked[51]} value='Yes' />Yes</td>
<td><input type='radio' name='data[20]' {$checked[52]} value='No' />No</td>
</tr>

<tr><td colspan='2' style='padding-left:30px;'><b>Cooking Classes / Cheese tasting</b></td>
<td $displayText colspan='2'>{$data[21]}</td>
<td $displayForm><input type='radio' name='data[21]' {$checked[53]} value='Yes' />Yes</td>
<td $displayForm><input type='radio' name='data[21]' {$checked[54]} value='No' />No</td>
</tr>

<tr><td colspan='2' style='padding-left:30px;'><b>Lunches at the Lycée Hôtelier</b></td>
<td $displayText colspan='2'>{$data[22]}</td>
<td $displayForm><input type='radio' name='data[22]' {$checked[55]} value='Yes' />Yes</td>
<td $displayForm><input type='radio' name='data[22]' {$checked[56]} value='No' />No</td>
</tr>

<tr><td colspan='2' style='padding-left:30px;'><b>Receptions</b></td>
<td $displayText colspan='2'>{$data[23]}</td>
<td $displayForm><input type='radio' name='data[23]' {$checked[57]} value='Yes' />Yes</td>
<td $displayForm><input type='radio' name='data[23]' {$checked[58]} value='No' />No</td>
</tr>

<tr><td colspan='2' style='padding-left:30px;'><b>Opera</b></td>
<td $displayText colspan='2'>{$data[24]}</td>
<td $displayForm ><input type='radio' name='data[24]' {$checked[59]} value='Yes' />Yes</td>
<td $displayForm ><input type='radio' name='data[24]' {$checked[60]} value='No' />No</td>
</tr>

<tr><td colspan='2' style='padding-left:30px;'><b>Theatre</b></td>
<td $displayText colspan='2'>{$data[25]}</td>
<td $displayForm ><input type='radio' name='data[25]' {$checked[61]} value='Yes' />Yes</td>
<td $displayForm ><input type='radio' name='data[25]' {$checked[62]} value='No' />No</td>
</tr>

<tr><td colspan='2' style='padding-left:30px;'><b>Dance / Ballet</b></td>
<td $displayText colspan='2'>{$data[26]}</td>
<td $displayForm ><input type='radio' name='data[26]' {$checked[63]} value='Yes' />Yes</td>
<td $displayForm ><input type='radio' name='data[26]' {$checked[64]} value='No' />No</td>
</tr>

<tr><td colspan='4' style='padding-top:20px;'>
<b>b) Which of these were the most memorable / rewarding ? Why did you find them so ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[27]'>{$data[27]}</textarea>
<div $displayText >{$data[27]}</div>
</td></tr>

<tr><td colspan='4'><b>PROGRAM SPONSORED ACTIVITIES THAT PUT YOU IN TOUCH WITH 
FRENCH PEOPLE : </b></td></tr>
<tr><td colspan='4'><b>10) Did you participate in any CIJP Excursions and/or 
activities ?</b>
<font $displayText>{$data[28]}</font></td></tr>
<tr $displayForm>
<td><input type='radio' name='data[28]' {$checked[65]} value='Yes' />Yes</td>
<td><input type='radio' name='data[28]' {$checked[66]} value='No' />No</td>
</tr>

<tr><td colspan='4' style='padding-top:20px;'><b>If yes, please give details and what you gained from the 
experience.</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[29]'>{$data[29]}</textarea>
<div $displayText >{$data[29]}</div>
</td></tr>

<tr><td colspan='4'><b>11) OTHER EXTRACURRICULAR ACTIVITIES :</b></td></tr>
<tr><td colspan='4'>Did you try to meet French people informally ? If so, 
what did you do to mee them ?</td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[30]'>{$data[30]}</textarea>
<div $displayText >{$data[30]}</div>
</td></tr>

<tr><td colspan='4'><b>12) Did you join a specific club, team, group, or activity ?</b>
<font $displayText>{$data[31]}</font></td></tr>
<tr $displayText><td colspan='4' >{$data[32]}</td></tr>

<tr $displayForm>
<td><input type='radio' name='data[31]' {$checked[67]} value='Yes' />Yes</td>
<td><input type='radio' name='data[31]' {$checked[68]} value='No' />No</td>
<td colspan='2'><b>If Yes, please check all appropriate boexes below :</td></tr>
<tr $displayForm>
<td><input type='checkbox' name='data[32][]' {$checked[69]} value='Club' />Club</td>
<td><input type='checkbox' name='data[32][]' {$checked[70]} value='Team' />Team</td>
<td><input type='checkbox' name='data[32][]' {$checked[71]} value='Group' />Group</td>
<td><input type='checkbox' name='data[32][]' {$checked[72]} value='Activity' />Activity</td></tr>



<tr><td colspan='4' style='padding-top:30px;'><b>Please give the following details for the benefit of future 
students there :</b></td></tr>
<tr><td colspan='2'><b>Name of organization 1 :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[33]' value='{$data[33]}'/></td>
<td $displayText colspan='2'>{$data[33]}</td></tr>
<tr><td colspan='2'><b>Address :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[34]' value='{$data[34]}'/></td>
<td $displayText colspan='2'>{$data[34]}</td></tr>
<tr><td colspan='2'><b>tel. n°/e-mail address :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[35]' value='{$data[35]}'/></td>
<td $displayText colspan='2'>{$data[35]}</td></tr>
<tr><td colspan='2'><b>Name of Person to contact :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[36]' value='{$data[36]}'/></td>
<td $displayText colspan='2'>{$data[36]}</td></tr>

<tr><td colspan='2' style='padding-top:25px;'><b>Name of organization 2 :</b></td>
<td $displayForm colspan='2' style='padding-top:25px;'>
<input type='text' name='data[37]' value='{$data[37]}'/></td>
<td $displayText colspan='2' style='padding-top:25px;'>{$data[37]}</td></tr>
<tr><td colspan='2'><b>Address :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[38]' value='{$data[38]}'/></td>
<td $displayText colspan='2'>{$data[38]}</td></tr>
<tr><td colspan='2'><b>tel. n°/e-mail address :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[39]' value='{$data[39]}'/></td>
<td $displayText colspan='2'>{$data[39]}</td></tr>
<tr><td colspan='2'><b>Name of Person to contact :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[40]' value='{$data[40]}'/></td>
<td $displayText colspan='2'>{$data[40]}</td></tr>

<tr><td colspan='2' style='padding-top:25px;'><b>Name of organization 3 :</b></td>
<td $displayForm colspan='2' style='padding-top:25px;'>
<input type='text' name='data[41]' value='{$data[41]}'/></td>
<td $displayText colspan='2' style='padding-top:25px;'>{$data[41]}</td></tr>
<tr><td colspan='2'><b>Address :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[42]' value='{$data[42]}'/></td>
<td $displayText colspan='2'>{$data[42]}</td></tr>
<tr><td colspan='2'><b>tel. n°/e-mail address :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[43]' value='{$data[43]}'/></td>
<td $displayText colspan='2'>{$data[43]}</td></tr>
<tr><td colspan='2'><b>Name of Person to contact :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[44]' value='{$data[44]}'/></td>
<td $displayText colspan='2'>{$data[44]}</td></tr>

<tr><td colspan='2' style='padding-top:25px;'><b>Name of organization 4 :</b></td>
<td $displayForm colspan='2' style='padding-top:25px;'>
<input type='text' name='data[45]' value='{$data[45]}'/></td>
<td $displayText colspan='2' style='padding-top:25px;'>{$data[45]}</td></tr>
<tr><td colspan='2'><b>Address :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[46]' value='{$data[46]}'/></td>
<td $displayText colspan='2'>{$data[46]}</td></tr>
<tr><td colspan='2'><b>tel. n°/e-mail address :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[47]' value='{$data[47]}'/></td>
<td $displayText colspan='2'>{$data[47]}</td></tr>
<tr><td colspan='2'><b>Name of Person to contact :</b></td>
<td $displayForm colspan='2'><input type='text' name='data[48]' value='{$data[48]}'/></td>
<td $displayText colspan='2'>{$data[48]}</td></tr>

<tr><td colspan='4' style='padding-top:25px;'><b>13) INTERSHIP/EXPERIENTIAL LEARNING : 
Did you undertake a "stage" ?</b>
<font $displayText>{$data[49]}</font></td></tr>

<tr $displayForm>
<td><input type='radio' name='data[49]' {$checked[73]} value='Yes'>Yes</td>
<td><input type='radio' name='data[49]' {$checked[74]} value='No'>No</td>
<td colspan='2'><b>If Yes, please fill out the stage evaluation as well.</td></tr>

<tr $displayText><td colspan='4' style='color:black;'>
<b>If Yes, please fill out the stage evaluation as well.</td></tr>

<tr><td colspan='4'>
<textarea $displayForm name='data[50]'>{$data[50]}</textarea>
<div $displayText>{$data[50]}</div></td></tr>

<tr><td colspan='4'><b>VI. BORDEAU ORIENTATION</b> (For Fall semester only)</td></tr>
<tr><td colspan='4'><b>14) What features of the Bordeaux program did you find most useful ?
</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[51]'>{$data[51]}</textarea>
<div $displayText>{$data[51]}</div></td></tr>

<tr><td colspan='4'><b>15) Please comment on housing and cultural activities in Bordeaux.</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[52]'>{$data[52]}</textarea>
<div $displayText>{$data[52]}</div></td></tr>

<tr><td colspan='4'><b>16) Do you have any suggestions for the Bordeaux orientation session ?
</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[53]'>{$data[53]}</textarea>
<div $displayText>{$data[53]}</div></td></tr>

<tr><td colspan='4'><b>VII. FINAL COMMENTS</b></td></tr>
<tr><td colspan='4'><b></b>17) What advice would you give to students to help them to 
prepare to study abraod in Paris ?</td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[54]'>{$data[54]}</textarea>
<div $displayText>{$data[54]}</div></td></tr>

<tr><td colspan='4'><b>18) If you wish, you, please add comments on any aspects of the VWPP 
not covered in this evaluation.</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[55]'>{$data[55]}</textarea>
<div $displayText>{$data[55]}</div></td></tr>

<tr><td colspan='4'><b>MERCI BEAUCOUP !</b></td></tr>
<tr><td colspan='2'><b>Your Name (optional) :</b></td>
<td $displayForm><input type='text' name='data[56]' value='{$data[56]}' /></td>
<td $displayText>{$data[56]}</td></tr>



<tr $displayForm><td colspan='4' style='text-align:center;padding-top:20px;'>
<!--
<input type='hidden' name='closed' value='0' />
<input type='submit' value='Save to continue later' style='margin-right:30px;'/>
<input type='button' value='Submit' onclick='document.form.closed.value="1";document.form.submit();'/></td></tr>
-->
<input type='hidden' name='closed' value='1' />
<input type='submit' value='Submit' /></td></tr>
</table></form>
</div>	<!-- class=fieldset	-->
EOD;

?>