<?php
// Last Change : 2013-04-25, Jérôme Combes

require_once "class.tutorat.inc";
$t=new tutorat();
$t->student=$std_id;
$t->fetch();
$data[1]=$t->elements['tuteur'];

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

if(!$isForm){
  $data[3]=str_replace("\n","<br/>",$data[3]);
  $data[6]=str_replace("\n","<br/>",$data[6]);
  $data[7]=str_replace("\n","<br/>",$data[7]);
}

$input=array();
$input[]=array(2,"radio",array("Yes","No"));		// data_id, type, values
$input[]=array(4,"radio",array("Extremely helpful","Very helpful","Helpful","Not very helpful"));
$input[]=array(5,"radio",array("Extremely helpful","Very helpful","Helpful","Not very helpful"));

$input=input($input,$data,true);

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
Tutorats Evaluation Form, {$_SESSION['vwpp']['semester']}</h2>
</td></tr>



<tr><td colspan='4' style='text-align:justify;'><i>This form is intended to assist your 
instructor in evaluating his or her teaching effectiveness. We would appreciate a thoughtful response.</i></td></tr>

<tr><td colspan='2' style='padding-top:20px;'><b>Name of instructor :</b></td>
<td colspan='2' style='padding-top:20px;' class='response'>{$data[1]}</td></tr>

<tr><td colspan='2' style='padding-top:20px;'><b>Did you attend every session ?</b></td>
<td $displayText colspan='2'  style='padding-top:20px;'>{$data[2]}</td></tr>

<tr $displayForm>
{$input[0]}
{$input[1]}
<td colspan='2'><b>If not, why not ?</b></td></tr>

<tr $displayText><td colspan='4' style='color:black;'>If not, why not ?</td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[3]'>{$data[3]}</textarea>
<div $displayText>{$data[3]}</div></td></tr>

<tr><td colspan='4'><b>2. Please comment on the <i>content</i> of the sessions and their 
<i>usefulness</i> to <i>you</i>. To what extent did they help you to :</b></td></tr>
<tr><td colspan='3' style='padding-left:30px;'><b>a) Develop a mastery of the French language</b></td>
<td $displayText>{$data[4]}</td></tr>
<tr $displayForm>{$input[2]}{$input[3]}{$input[4]}{$input[5]}</tr>

<tr><td colspan='3' style='padding-left:30px;'><b>b) Understand French culture :</b></td>
<td $displayText>{$data[5]}</td></tr>
<tr $displayForm>{$input[6]}{$input[7]}{$input[8]}{$input[9]}</tr>

<tr><td colspan='4' style='padding-top:20px;' ><b>3. What aspect of the "Tutorat" did you find most helpful ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[6]'>{$data[6]}</textarea>
<div $displayText>{$data[6]}</div></td></tr>

<tr><td colspan='4' ><b>4. Do you have any suggestions for how the "Tutorats" could be 
modified to faciliate your experience in Paris ?</b></td></tr>
<tr><td colspan='4'>
<textarea $displayForm name='data[7]'>{$data[7]}</textarea>
<div $displayText>{$data[7]}</div></td></tr>

<tr><td colspan='4'><b>MERCI BEAUCOUP !</b></td></tr>
<tr><td colspan='2'><b>Your name (optional) :</b></td>
<td $displayForm><input type='text' name='data[8]' value='{$data[8]}' /></td>
<td $displayText>{$data[8]}</td></tr>


<tr $displayForm><td colspan='4' style='text-align:center;padding-top:20px;'>
<!--
<input type='hidden' name='closed' value='0' />
<input type='submit' value='Save to continue later' style='margin-right:30px;'/>
<input type='button' value='Submit' onclick='document.form.closed.value="1";document.form.submit();'/></td></tr>
-->
<input type='hidden' name='closed' value='1' />
<input type='submit' value='Submit' /></td></tr>
</table></form>
</div>
EOD;

?>