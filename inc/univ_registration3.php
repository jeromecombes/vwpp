<?php
require_once "class.univ_reg.inc";

$u=new univ_reg();
$u->fetch();
$data=$u->elements;
$data[12]=str_replace("\n","<br/>",$data[11]);

$checked[0]=$data[5]=="Sophomore"?"checked='checked'":null;
$checked[1]=$data[5]=="Junior"?"checked='checked'":null;
$checked[2]=$data[5]=="Senior"?"checked='checked'":null;
$checked[3]=$data[10]=="Oui"?"checked='checked'":null;
$checked[4]=$data[10]=="Non"?"checked='checked'":null;

$displayText="style='font-weight:bold;color:blue;'";

$lock=false;

echo <<<EOD
<br/><br/><fieldset>
<form method='post' action='univ_reg_update.php' name='univreg_1' onsubmit='return ctrl_form_univreg();'>
<input type='hidden' id='category' value='{$_SESSION['vwpp']['category']}' />
<table style='width:1170px;'>

<tr><td>1. Diplôme de fin d'études (High school diploma, etc.)</td>
<td>
<input type='text' name='data[0]' value='{$data[0]}' style='display:none;'/>
<font class='response' id='univreg_1_0' >{$data[0]}</font>
</td></tr>

<tr><td style='padding-left:30px;width:500px;'>a. Année d'obtention</td>
<td>
<select name='data[1]' style='display:none;'>
<option value=''>&nbsp;</option>
EOD;
for($i=date("Y");$i>date("Y")-30;$i--){
  $selected=$data[1]==$i?"selected='selected'":null;
  echo "<option value='$i' $selected>$i</option>\n";
}
echo <<<EOD
</select>
<font class='response' id='univreg_1_1' >{$data[1]}</font></td></tr>
<tr><td style='padding-left:30px;'>b. Pays</td>
<td>
<select name='data[2]' style='display:none;'>
<option value=''>&nbsp;</option>
EOD;
foreach($GLOBALS['countries'] as $elem){
  $selected=$data[2]==htmlentities($elem,ENT_QUOTES|ENT_IGNORE,"utf-8")?"selected='selected'":null;
  echo "<option value='$elem' $selected>$elem</option>\n";
}
echo <<<EOD
</select>
<font class='response' id='univreg_1_2' >{$data[2]}</font></td></tr>
<tr><td style='padding-left:30px;'>c. Ville</td>
<td><input type='text' name='data[3]' value='{$data[3]}' style='display:none;'/>
<font class='response' id='univreg_1_3' >{$data[3]}</font></td></tr>
<tr><td style='padding-left:30px;'>d. Etat</td>
<td>
<select name='data[4]' style='display:none;'>
<option value=''>&nbsp;</option>
EOD;
foreach($GLOBALS['states'] as $elem){
  $selected=$data[4]==htmlentities($elem,ENT_QUOTES|ENT_IGNORE,"utf-8")?"selected='selected'":null;
  echo "<option value='$elem' $selected>$elem</option>\n";
}
echo <<<EOD
</select>
<font class='response' id='univreg_1_4' >{$data[4]}</font></td></tr>

<tr><td>&nbsp;</td></tr>
<tr><td>2. Etudes actuelles (at home institution)</td>
<td id='univreg_1_radio_0' style='display:none;'><input type='radio' name='data[5]' value='Sophomore' {$checked[0]} /> a. Sophomore</td>
<td id='univreg_1_5'><font class='response'>{$data[5]}</font></td></tr>
<tr id='univreg_1_radio_1' style='display:none;'><td>&nbsp;</td><td><input type='radio' name='data[5]' value='Junior' {$checked[1]} /> b. Junior</td></tr>
<tr id='univreg_1_radio_2' style='display:none;'><td>&nbsp;</td><td><input type='radio' name='data[5]' value='Senior' {$checked[2]} /> c. Senior</td></tr>

<tr><td>&nbsp;</td></tr>
<tr><td colspan='2'>3. Faculté/Ecole/Département dans l’Etablissement d'origine (major dept. at home institution)</td></tr>
<tr><td colspan='2'><input type='text' name='data[6]' value='{$data[6]}' style='display:none;'/>
<font class='response' id='univreg_1_6' >{$data[6]}</font></td></tr>


<tr><td>&nbsp;</td></tr>
<tr><td>4. Début des études dans cet établissement</td>
<td>
<select name='data[7]' style='display:none;'>
<option value=''>&nbsp;</option>
EOD;
for($i=date("Y");$i>date("Y")-30;$i--){
  $selected=$data[7]==$i?"selected='selected'":null;
  echo "<option value='$i' $selected>$i</option>\n";
}
echo <<<EOD
</select>
<font class='response' id='univreg_1_7' >{$data[7]}</font></td></tr>

<tr><td>5. Domaine disciplinaire (major) dans cet établissement</td>
<td><input type='text' name='data[8]' value='{$data[8]}' style='display:none;'/>
<font class='response' id='univreg_1_8' >{$data[8]}</font></td></tr>

<tr><td>6. Discipline voulue à l’université française (French University major, vous ne devez en mentionner qu'une seule) *</td>
<td><input type='text' name='data[9]' value='{$data[9]}' id='univ_reg_1_21' style='display:none;'/>
<font class='response' id='univreg_1_9' >{$data[9]}</font></td></tr>

<tr><td>&nbsp;</td></tr>
<tr><td>7. Avez-vous un handicap ou des besoins particuliers?</td>
<td class='response' id='univreg_1_10' >{$data[10]}</td>
<td id='univreg_1_radio_3' style='display:none;padding-left:30px;'><input type='radio' name='data[10]' value='Oui' {$checked[3]} /> Oui</td>
</tr>
<tr id='univreg_1_radio_4' style='display:none;'><td>&nbsp;</td>
<td style='padding-left:30px;'><input type='radio' name='data[10]' value='Non' {$checked[4]} /> Non</td></tr>

<tr><td colspan='2'>Si oui, précisez</td></tr>
<td colspan='2'><textarea name='data[11]' style='display:none;'>{$data[11]}</textarea>
<font class='response' id='univreg_1_11' colspan='2'>{$data[12]}</font></td></tr>


<tr><td>&nbsp;</td></tr>
<tr><td>8. Discipline</td>
<td><input type='text' name='data[13]' id='univreg_1_17' value='{$data[13]}' style='display:none;'/>
<font class='response' id='univreg_1_13' >{$data[13]}</font></td></tr>

<tr><td>9. UFR</td>
<td><input type='text' name='data[14]' id='univreg_1_18' value='{$data[14]}' style='display:none;'/>
<font class='response' id='univreg_1_14' >{$data[14]}</font></td></tr>

<tr><td>10. MoveOnLine Username</td>
<td><input type='text' name='data[15]' id='univreg_1_19' value='{$data[15]}' style='display:none;'/>
<font class='response' id='univreg_1_15' >{$data[15]}</font></td></tr>

<tr><td>11. MoveOnLine Password</td>
<td><input type='text' name='data[16]' id='univreg_1_20' value='{$data[16]}' style='display:none;'/>
<font class='response' id='univreg_1_16' >{$data[16]}</font></td></tr>


<tr><td colspan='2' style='text-align:right;'>
EOD;
if($_SESSION['vwpp']['category']=="admin" or !$lock){
  echo "<input id='univreg_1_12' type='button' value='Edit' onclick='displayForm(\"univreg\",1);'/>\n";
}
echo <<<EOD
<input type='submit' value='Valider' id='univreg_1_done' style='display:none;'/></td></tr>


</table>
</form>
</fieldset>
EOD;


?>