<?php
// Last Update : Jérôme Combes, 2016-03-13

require_once "class.univ_reg.inc";
require_once "class.dates.inc";

$d=new dates();
$d->fetch();
$dates=$d->elements;

$u=new univ_reg();
$u->getAttrib();
$university=$u->university;
$published=$u->published;
$u=array();
$u[0]=$university=="Paris 3"?"selected='selected'":null;
$u[1]=$university=="Paris 4"?"selected='selected'":null;
$u[2]=$university=="Paris 7"?"selected='selected'":null;
$u[3]=$university=="CIPh"?"selected='selected'":null;
$u[4]=$university=="IEP"?"selected='selected'":null;


$selected=array();
for($i=0;$i<25;$i++){
  $selected[$i]=null;
}

switch($data[5]){
  case "1st"	:	$selected[0]="selected='selected'";	break;
  case "2nd"	:	$selected[1]="selected='selected'";	break;
  case "3rd"	:	$selected[2]="selected='selected'";	break;
  case "4th"	:	$selected[3]="selected='selected'";	break;
  case "5th"	:	$selected[4]="selected='selected'";	break;
}

switch($data[6]){
  case "1st"	:	$selected[5]="selected='selected'";	break;
  case "2nd"	:	$selected[6]="selected='selected'";	break;
  case "3rd"	:	$selected[7]="selected='selected'";	break;
  case "4th"	:	$selected[8]="selected='selected'";	break;
  case "5th"	:	$selected[9]="selected='selected'";	break;
}

switch($data[7]){
  case "1st"	:	$selected[10]="selected='selected'";	break;
  case "2nd"	:	$selected[11]="selected='selected'";	break;
  case "3rd"	:	$selected[12]="selected='selected'";	break;
  case "4th"	:	$selected[13]="selected='selected'";	break;
  case "5th"	:	$selected[14]="selected='selected'";	break;
}

switch($data[8]){
  case "1st"	:	$selected[15]="selected='selected'";	break;
  case "2nd"	:	$selected[16]="selected='selected'";	break;
  case "3rd"	:	$selected[17]="selected='selected'";	break;
  case "4th"	:	$selected[18]="selected='selected'";	break;
  case "5th"	:	$selected[19]="selected='selected'";	break;
}

switch($data[10]){
  case "1st"	:	$selected[20]="selected='selected'";	break;
  case "2nd"	:	$selected[21]="selected='selected'";	break;
  case "3rd"	:	$selected[22]="selected='selected'";	break;
  case "4th"	:	$selected[23]="selected='selected'";	break;
  case "5th"	:	$selected[24]="selected='selected'";	break;
}

$textarea=array();
$textarea[9]=str_replace("\n","<br/>",$data[9]);
$textarea[11]=str_replace("\n","<br/>",$data[11]);

echo <<<EOD
<h3><b>University Registration</b></h3>
<fieldset>
<div style='text-align:center;margin-bottom:40px;'>
<h3>Vassar-Wesleyan Program in Paris<br/>
University Registration Request Form</h3>
</div>

<form name='stdform_5' action='update.php' method='post'>
<input type='hidden' name='acl' value='17' />
<input type='hidden' name='page' value='students-view2.php' />
<input type='hidden' name='std-page' value='univ_registration.php' />
<input type='hidden' name='table' value='univ_reg' />
<input type='hidden' name='std_id' value='$std_id' />
<input type='hidden' name='semestre' value='$semestre' />

<table>
<tr><td>Lastname :</td>
<td colspan='2'><font class='response'>{$std['lastname']}</font></td></tr>
<tr><td>Firstname :</td>
<td colspan='2'><font class='response'>{$std['firstname']}</font></td></tr>
<tr><td>Email :</td>
<td colspan='2'><font class='response'>{$std['email']}</font></td></tr>
<tr><td>Major 1:</td>
<td colspan='2'>
<input type='text' style='display:none;' name='data[1]' value='{$data[1]}' />
<font class='response' id='stdform_5_0'>{$data[1]}</font>
</td>
<td>Minor / Correlate 1</td>
<td colspan='2'>
<input type='text' style='display:none;' name='data[2]' value='{$data[2]}' />
<font class='response' id='stdform_5_1'>{$data[2]}</font>
</td></tr>
<tr><td>Major 2:</td>
<td colspan='2'>
<input type='text' style='display:none;' name='data[3]' value='{$data[3]}' />
<font class='response' id='stdform_5_2'>{$data[3]}</font>
</td>
<td>Minor / Correlate 2</td>
<td colspan='2'>
<input type='text' style='display:none;' name='data[4]' value='{$data[4]}' />
<font class='response' id='stdform_5_3'>{$data[4]}</font>
</td></tr>
EOD;

if($dates['date5'] or $dates['date6'] or $dates['date7']){
    echo <<<EOD
        <tr><td colspan='6' style='padding:20px 0 0 0;'text-align:justify';>
        Please note that each university has a different calendar :<br/>
        Paris 3, end of course <b>{$dates['date5']}</b><br/>
        Paris 4, end of course <b>{$dates['date6']}</b><br/>
        Paris 7, end of course <b>{$dates['date7']}</b><br/>
        </td></tr>
EOD;
}

echo <<<EOD
<tr><td colspan='6' style='padding:20px 0 0 0;'text-align:justify';>
Please rank your choices (fill in 1<sup>st</sup>, 2<sup>nd</sup>, 3<sup>rd</sup> and 4<sup>th</sup> in the appropriate boxes)</td></tr>

<tr><td>Paris 3</td>
<td colspan='2'>
<select style='display:none;' name='data[5]'>
<option value=''>&nbsp;</option>
<option value='1st' {$selected[0]}>1st Choice</option>
<option value='2nd' {$selected[1]}>2nd Choice</option>
<option value='3rd' {$selected[2]}>3rd Choice</option>
<option value='4th' {$selected[3]}>4th Choice</option>
<!--
<option value='5th' {$selected[19]}>5th Choice</option>
-->
</select>
<font class='response' id='stdform_5_4'>{$data[5]}</font>
</td></tr>

<tr><td>Paris 4</td>
<td colspan='2'>
<select style='display:none;' name='data[6]'>
<option value=''>&nbsp;</option>
<option value='1st' {$selected[5]}>1st Choice</option>
<option value='2nd' {$selected[6]}>2nd Choice</option>
<option value='3rd' {$selected[7]}>3rd Choice</option>
<option value='4th' {$selected[8]}>4th Choice</option>
<!--
<option value='5th' {$selected[19]}>5th Choice</option>
-->
</select>
<font class='response' id='stdform_5_5'>{$data[6]}</font>
</td></tr>

<tr><td>Paris 7</td>
<td colspan='2'>
<select style='display:none;' name='data[7]'>
<option value=''>&nbsp;</option>
<option value='1st' {$selected[10]}>1st Choice</option>
<option value='2nd' {$selected[11]}>2nd Choice</option>
<option value='3rd' {$selected[12]}>3rd Choice</option>
<option value='4th' {$selected[13]}>4th Choice</option>
<!--
<option value='5th' {$selected[19]}>5th Choice</option>
-->
</select>
<font class='response' id='stdform_5_6'>{$data[7]}</font>
</td></tr>

<tr><td>CIPh</td>
<td colspan='2'>
<select style='display:none;' name='data[8]'>
<option value=''>&nbsp;</option>
<option value='1st' {$selected[15]}>1st Choice</option>
<option value='2nd' {$selected[16]}>2nd Choice</option>
<option value='3rd' {$selected[17]}>3rd Choice</option>
<option value='4th' {$selected[18]}>4th Choice</option>
<!--
<option value='5th' {$selected[19]}>5th Choice</option>
-->
</select>
<font class='response' id='stdform_5_7'>{$data[8]}</font>
</td></tr>

<!--
<tr><td>IEP</td>
<td colspan='2'>
<select style='display:none;' name='data[10]'>
<option value=''>&nbsp;</option>
<option value='1st' {$selected[20]}>1st Choice</option>
<option value='2nd' {$selected[21]}>2nd Choice</option>
<option value='3rd' {$selected[22]}>3rd Choice</option>
<option value='4th' {$selected[23]}>4th Choice</option>
<option value='5th' {$selected[24]}>5th Choice</option>
</select>
<font class='response' id='stdform_5_10'>{$data[10]}</font>
</td></tr>
-->

<tr><td colspan='6' style='padding:20px 0 0 0;text-align:justify';>
Please provide an academic justification for your 1<sup>st</sup> and 2<sup>nd</sup> choices 
in the text box below (Maximum 1200 characters with spaces) :</td></tr>

<tr><td colspan='6'>
<textarea name='data[9]' style='display:none;'>{$data[9]}</textarea>
<font class='response' id='stdform_5_8'>{$textarea[9]}</font>
</td></tr>

EOD;
if($dates['date5'] or $dates['date6'] or $dates['date7']){
    echo <<<EOD
        <tr><td colspan='6' style='padding:20px 0 0 0;text-align:justify';>
        Please indicate if your choice of university is motivated by the calendar and explain your reason : 
        job, intership, graduation ...</td></tr>

        <tr><td colspan='6'>
        <textarea style='display:none;' name='data[11]'>{$data[11]}</textarea>
        <font class='response' id='stdform_5_11'>{$textarea[11]}</font>
        </td></tr>
EOD;
}

echo <<<EOD
<tr><td colspan='6' style='padding:20px 0 0 0;'text-align:justify';>
Your wishes will be taken into account but university placement cannot be guaranteed as each university 
has a specific number of spots for our students.<br/>
</td></tr>

<tr><td colspan='6' style='text-align:right;'>
<div id='stdform_5_done' style='display:none;'>
<br/>
<input style='display:none;' type='button' value='Cancel' onclick='displayText("stdform",5);' class='myUI-button-right' />
<input style='display:none;' type='submit' value='Submit' class='myUI-button-right' />
</div>
EOD;
if($_SESSION['vwpp']['category']=="admin" or !$university){
  echo "<br/><input id='stdform_5_9' type='button' value='Edit' onclick='displayForm(\"stdform\",5);' class='myUI-button-right' />\n";
}
echo <<<EOD
</td></tr>
</table>
</form>
EOD;
if($_SESSION['vwpp']['category']=="admin"){
  echo <<<EOD
  <form method='post' action='univ_reg_update.php'>
  <table>
  <tr><td colspan='2'><h3>University Registration</h3></td></tr>
  <tr><td>University</td>
  <td>
  <input type='hidden' name='action' value='attrib' />
  <select name='university' style='width:800px;'>
  <option value=''>&nbsp;</option>
  <option value='Paris 3' {$u[0]} >Paris 3</option>
  <option value='Paris 4' {$u[1]} >Paris 4</option>
  <option value='Paris 7' {$u[2]} >Paris 7</option>
  <option value='CIPh' {$u[3]} >CIPh</option>
<!--
  <option value='IEP' {$u[4]} >IEP</option>
-->
  </select>
  <span style='position: absolute; right: 20px; margin:-10px 0; padding:0; text-align:right;'>
  <input type='submit' value='Save' class='myUI-button-right' />
  </span>
  </td></tr>
  </table>
  </form>
EOD;
}
elseif($university and $published){
  echo <<<EOD
  <table>
  <tr><td colspan='2'><h3>University Registration</h3></td></tr>
  <tr><td>University</td>
  <td class='response'>$university</td></tr></table>
EOD;
}
echo "</fieldset>\n";
?>
