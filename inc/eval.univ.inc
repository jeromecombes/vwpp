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

require_once "class.univ3.inc";

$u=new univ3();
$u->fetchCMById($courseId);

$data[1]=$u->elements['nom'];
$data[2]=$u->elements['ufr'];
$data[3]=$u->elements['code'];
$data[4]=$u->elements['prof'];
$data[5]=$u->elements['university'];

// $isForm=false;
$displayForm=$isForm?null:"style='display:none;'";
$displayText=$isForm?"style='display:none;'":"class='response'";
if(!$isForm){
  for($i=0;$i<count($data);$i++)
    $data[$i]=str_replace("\n","<br/>",$data[$i]);
}

$data["5b"]=$data[5]=="Other (please specify) :"?$data[6]:$data[5];
$input=array();
$input[]=array(5,"radio",array("UP3","UP4","UP7","SciencePo","CIPh","Other (please specify) :"));		// data_id, type, values
$input[]=array(7,"radio",array("Lecture","Discussion","Lecture and Discussion"));
$input[]=array(8,"radio",array("Strenuous","Fairly strenuous","Moderate","Light"));
$input[]=array(9,"radio",array("Comfortably","With some difficulty","With considerable difficulty","Not Applicable"));
$input[]=array(10,"radio",array("Comfortably","With some difficulty","With considerable difficulty","Not Applicable"));
$input[]=array(11,"radio",array("Yes","No"));
$input[]=array(13,"radio",array("Almost always","Most of the time","Some of the time","Almost never/never"));
$input[]=array(15,"radio",array("Almost always","Most of the time","Some of the time","Almost never/never"));
$input[]=array(17,"radio",array("Almost always","Most of the time","Some of the time","Almost never/never"));
$input[]=array(19,"radio",array("Very clear","Somewhat clear","Not clear","Not applicable"));
$input[]=array(20,"radio",array("Very clear","Somewhat clear","Not clear","Not applicable"));
$input[]=array(21,"radio",array("Very clear","Somewhat clear","Not clear","Not applicable"));
$input[]=array(23,"radio",array("Very clear","Somewhat clear","Not clear","Not applicable"));
$input[]=array(24,"radio",array("Yes","No"));
$input[]=array(25,"radio",array("Not applicable","Yes","No"));
$input[]=array(27,"radio",array("Excellent","Good","Fair","Rarely able"));
$input[]=array(28,"radio",array("Excellent","Good","Fair","Not organized"));
$input[]=array(29,"radio",array("Always open","Open sometimes","Rarely open","Never open"));
$input[]=array(30,"radio",array("Always fair","Mostly fair","Fair sometimes","Never fair"));
$input[]=array(31,"radio",array("Extremely helpful","Very helpful","Not helpful","Does not give comments"));
$input[]=array(32,"radio",array("Very encouraging","Encouraging","Not encouraging","Does not give any"));
$input[]=array(34,"radio",array("Absolutely","Mostly","Somewhat","Not effective"));



$input=input($input,$data,true);


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
University Course Evaluation Form, {$_SESSION['vwpp']['semester']}</h2>
<div style='font-style:italic;text-align:justify;'>
This form will not be shared with the university instructor. It is intended for VWPP directors 
and help future students make an informed decision in their choice of courses. We would appreciate 
a thoughtful response.
</div></td></tr>

<tr><td style='padding-top:20px;'><b>Name of course :</b></td>
<td class='response' style='padding-top:20px;'>{$data[1]}</td>
<td style='padding-top:20px;'><b>Professor :</b></td>
<td class='response' style='padding-top:20px;'>{$data[4]}</td>
</tr>

<tr><td><b>UFR :</b></td>
<td class='response'>{$data[2]}</td>
<td><b>Course code :</b></td>
<td class='response'>{$data[3]}</td></tr>

<tr><td><b>Institution :</b></td>
<td class='response'>{$data[5]}</td></tr>

<!-- 
<tr $displayForm>
<td><b>Institution :</b></td>
{$input[0]}{$input[1]}{$input[2]}</tr>
<tr $displayForm>
{$input[3]}{$input[4]}{$input[5]}
<td><input type='text' name='data[6]' value='{$data[6]}' /></td></tr>
<tr $displayText><td style='color:black;'><b>Institution :</b></td><td>{$data['5b']}</td></tr>
-->

<tr><td><b>Course Format :</b></td><td $displayText>{$data[7]}</td></tr>
<tr $displayForm>{$input[6]}{$input[7]}{$input[8]}</tr>

<tr><td colspan='3' style='padding-top:20px;'><b>1. How would you describe your efforts in this course ?</b></td>
<td $displayText style='padding-top:20px;'>{$data[8]}</td></tr>
<tr $displayForm style='padding-top:20px;'>{$input[9]}{$input[10]}{$input[11]}{$input[12]}</tr>

<tr><td colspan='4' style='padding-top:20px;'><b>2. Do you think your French was at a level that allowed you to 
understand and take notes ?</b></td></tr>
<tr><td colspan='2' style='padding-left:30px;'>
<b>a) At the beginning :</b></td><td $displayText>{$data[9]}</td></tr>
<tr $displayForm>{$input[13]}{$input[14]}{$input[15]}{$input[16]}</tr>

<tr><td colspan='2' style='padding-left:30px;'>
<b>b) After half-term :</b></td><td $displayText>{$data[10]}</td></tr>
<tr $displayForm>{$input[17]}{$input[18]}{$input[19]}{$input[20]}</tr>

<tr><td colspan='2' style='padding-top:20px;'>
<b>Did you attend every class at the University ?</b></td>
<td $displayText style='padding-top:20px;'>{$data[11]}</td></tr>
<tr $displayForm>{$input[21]}{$input[22]}
<td colspan='2'><b>If not, why not ?</b></td></tr>
<tr $displayText><td colspan='2' style='color:black;'><b>If not, why not ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[12]'>{$data[12]}</textarea>
<div $displayText>{$data[12]}</div></td></tr>

<tr><td colspan='4' style='padding-top:20px;'>
<b>4. Please evaluate your own work in the course. Did you :</b></td></tr>
<tr><td colspan='2' style='padding-left:30px;'>
<b>a) Keep up with assigned reading ?</b></td>
<td $displayText colspan='2'>{$data[13]}</td></tr>
<tr $displayForm>{$input[23]}{$input[24]}{$input[25]}{$input[26]}</tr>

<tr><td colspan='4'><b>If not, why not ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[]'>{$data[14]}</textarea>
<div $displayText>{$data[14]}</div></td></tr>

<tr><td colspan='2' style='padding-left:30px;'>
<b>b) Contribute to in-class discussion ?</b></td>
<td $displayText colspan='2'>{$data[15]}</td></tr>
<tr $displayForm>{$input[27]}{$input[28]}{$input[29]}{$input[30]}</tr>

<tr><td colspan='4'><b>If not, why not ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[]'>{$data[16]}</textarea>
<div $displayText>{$data[16]}</div></td></tr>

<tr><td colspan='2' style='padding-left:30px;'>
<b>C) Raise questions ?</b></td>
<td $displayText colspan='2'>{$data[17]}</td></tr>
<tr $displayForm>{$input[31]}{$input[32]}{$input[33]}{$input[34]}</tr>

<tr><td colspan='4'><b>If not, why not ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[]'>{$data[18]}</textarea>
<div $displayText>{$data[18]}</div></td></tr>

<tr><td colspan='4'><b>5. Did you have a clear understanding of what was expected from you in this 
course for the following :</b></td></tr>
<tr><td colspan='2' style='padding-left:30px;'>Readings :</td>
<td $displayText colspan='2'>{$data[19]}</td></tr>
<tr $displayForm>{$input[35]}{$input[36]}{$input[37]}{$input[38]}</tr>

<tr><td colspan='2' style='padding-left:30px;'>Written work :</td>
<td $displayText colspan='2'>{$data[20]}</td></tr>
<tr $displayForm>{$input[39]}{$input[40]}{$input[41]}{$input[42]}</tr>

<tr><td colspan='2' style='padding-left:30px;'>Oral presentation :</td>
<td $displayText colspan='2'>{$data[21]}</td></tr>
<tr $displayForm>{$input[43]}{$input[44]}{$input[45]}{$input[46]}</tr>

<tr><td colspan='2' style='padding-left:30px;'>Other (Please specify) :</td>
<td $displayForm colspan='2'><input type='text' name='data[22]' value='{$data[22]}'/></td>
<td $displayText colspan='2'>{$data[22]}</td></tr>
<tr $displayText><td colspan='2'>&nbsp;</td><td>{$data[23]}</td></tr>
<tr $displayForm>{$input[47]}{$input[48]}{$input[49]}{$input[50]}</tr>

<tr><td colspan='4' style='padding-top:20px;'>
<b>6. a) Wherether were visits or events outside of class that formed part of this course ?</b>
<font $displayText>{$data[24]}</font></td></tr>
<tr $displayForm >{$input[51]}{$input[52]}</tr>

<tr><td colspan='2' style='padding-left:30px;padding-top:20px;'><b>b) Did you attend all of them</b></td>
<td $displayText style='padding-top:20px;'>{$data[25]}</td></tr>
<tr $displayForm>{$input[53]}{$input[54]}{$input[55]}
<td><b>If not, why not ?</b></td></tr>
<tr $displayText><td colspan='4'><b>If not, why not ?</b></td></tr>

<tr><td colspan='4'>
<textarea $displayForm name='data[26]'>{$data[26]}</textarea>
<div $displayText >{$data[26]}</div></td></tr>

<tr><td colspan='4'><b>7. Please comment on the nature/quality of the teaching in this course</b></td></tr>
<tr><td colspan='2' style='padding-left:30px;'><b>a) Ability to explain difficult material</b></td>
<td $displayText>{$data[27]}</td></tr>
<tr $displayForm>{$input[56]}{$input[57]}{$input[58]}{$input[59]}</tr>

<tr><td colspan='2' style='padding-left:30px;padding-top:20px;'>
<b>b) Organization</b></td>
<td $displayText style='padding-top:20px;'>{$data[28]}</td></tr>
<tr $displayForm>{$input[60]}{$input[61]}{$input[62]}{$input[63]}</tr>

<tr><td colspan='2' style='padding-left:30px;padding-top:20px;'>
<b>c) Openess to student's remarks</b></td>
<td $displayText style='padding-top:20px;'>{$data[29]}</td></tr>
<tr $displayForm>{$input[64]}{$input[65]}{$input[66]}{$input[67]}</tr>

<tr><td colspan='2' style='padding-left:30px;padding-top:20px;'>
<b>d) Fairness</b></td>
<td $displayText style='padding-top:20px;'>{$data[30]}</td></tr>
<tr $displayForm>{$input[68]}{$input[69]}{$input[70]}{$input[71]}</tr>

<tr><td colspan='4' style='padding-left:30px;padding-top:20px;'>
<b>e) Comments and suggestions on papers or exposés</b>
<font $displayText style='padding-top:20px;'>{$data[31]}</font></td></tr>
<tr $displayForm>{$input[72]}{$input[73]}{$input[74]}{$input[75]}</tr>

<tr><td colspan='2' style='padding-left:30px;padding-top:20px;'>
<b>f) Encouragement to learn more</b></td>
<td $displayText style='padding-top:20px;'>{$data[32]}</td></tr>
<tr $displayForm>{$input[76]}{$input[77]}{$input[78]}{$input[79]}</tr>

<tr><td colspan='4' style='padding-top:20px;'><b>8. Assignments.</b> Please list the written and oral work you were assigned 
in this course</td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[33]'>{$data[33]}</textarea>
<div $displayText>{$data[33]}</div></td></tr>

<tr><td colspan='4'><b>9. Were the assignments effective for archieving the stated goals of 
the course ?</b><font $displayText>{$data[34]}</font></td></tr>
<tr $displayForm>{$input[80]}{$input[81]}{$input[82]}{$input[83]}</tr>
<tr><td colspan='4'><b>Comments :</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[35]'>{$data[35]}</textarea>
<div $displayText>{$data[35]}</div></td></tr>

<tr><td colspan='4'><b>10. Please share any other observation or comments you would like to make, 
including on the content of the course and its organization</b> (Amount of work, class meetings, 
content of, and approach to, the materials studied ...)</td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[36]'>{$data[36]}</textarea>
<div $displayText>{$data[36]}</div></td></tr>

<tr><td colspan='4'><b>MERCI BEAUCOUP !</td></tr>
<tr><td colspan='2'><b>Your Name (optional) :</td>
<td $displayForm colspan='2'><input type='text' name='data[37]' value='{$data[37]}' /></td>
<td $displayText colspan='2'>{$data[37]}</td></tr>



<tr $displayForm><td colspan='4' style='text-align:center;padding-top:20px;'>
<!-- <input type='hidden' name='closed' value='0' />
<input type='submit' value='Save to continue later' style='margin-right:30px;'/>
<input type='button' value='Submit' onclick='document.form.closed.value="1";document.form.submit();'/>
-->
<input type='hidden' name='closed' value='1' />
<input type='submit' value='Submit' />
</td></tr>
</table></form>
</div>
EOD;

?>