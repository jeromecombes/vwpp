<?php
// Last Update : 2015-10-29, Jérôme Combes

require_once "class.tutorat.inc";

if($_SESSION['vwpp']['category']=="admin"){
  $student=$_SESSION['vwpp']['std-id'];
  $action="../tutorat-update.php";
  $admin=true;						// Admin, droit en lecture
  $admin2=in_array(16,$_SESSION['vwpp']['access']);	// Admin, droits lecture et modification
  $afterSubmit="admin/students-view2.php";
  $cancel="students-view2.php";
  $displayLock=null;
}
else{
  $student=$_SESSION['vwpp']['student'];
  $admin=false;
  $admin2=false;
  $action="tutorat-update.php";
  $afterSubmit="courses.php";
  $cancel="courses.php";
  $displayLock="style='display:none;'";
}

$t=new tutorat();
$t->fetch();
$tutorat=$t->elements;
$lock_msg=$tutorat['lock']?"Déverrouiller":"Vérrouiller";
$lock=$tutorat['lock']?0:1;

echo <<<EOD
<h3 style='margin-top:50px;'>Tutorat</h3>
<fieldset>
<form name='formTutorat_1' method='post' action='$action'>
<input type='hidden' name='afterSubmit' value='$afterSubmit' />
<input type='hidden' name='student' value='$student' />
<table>
<tr><td><b>Tuteur</b></td>
<td><input type='text' name='tutorat[tuteur]' value='{$tutorat['tuteur']}' style='display:none;'/>
<font id='formTutorat_1_0'>{$tutorat['tuteur']}</td></tr>


<tr><td><b>Jour et heures du tutorat</b></td>
<td>

<select name='tutorat[day]' style='width:33%;display:none; '>
<option value=''>&nbsp;</option>
EOD;

foreach($days as $day){
  $hourSelect=$tutorat['day']==$day[1]?"selected='selected'":null;
  echo "<option value='{$day[1]}' $hourSelect >{$day[1]}</option>\n";
}
echo <<<EOD
</select>

<select name='tutorat[start]' style='width:32%;display:none; '>
<option value=''>&nbsp;</option>
EOD;
for($i=$hoursStart;$i<$hoursEnd+1;$i++){
  for($j=0;$j<60;$j=$j+15){
    $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
    $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
    $hourSelect=$tutorat['start']==$h1?"selected='selected'":null;
    echo "<option value='$h1' $hourSelect >de $h2</option>\n";
  }
}
echo <<<EOD
</select>
<select name='tutorat[end]' style='width:32%;display:none; '>
<option value=''>&nbsp;</option>
EOD;
for($i=$hoursStart;$i<$hoursEnd+1;$i++){
  for($j=0;$j<60;$j=$j+15){
    $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
    $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
    $hourSelect=$tutorat['end']==$h1?"selected='selected'":null;
    echo "<option value='$h1' $hourSelect >à $h2</option>\n";
  }
}
echo <<<EOD
</select>
<div $displayText id='formTutorat_1_1'>{$tutorat['day']} de {$tutorat['start']} à {$tutorat['end']}</div>
</td></tr>
EOD;

if(!$admin or $admin2){
  echo <<<EOD
  <tr><td colspan='2' style='text-align:right;' id='formTutorat_1_2' >
  <input type='button' id='formTutorat_1_3' onclick='displayForm("formTutorat",1);' style='margin-left:30px;'  value='Modifier' class='myUI-button-right' />
  <input type='button' id='formTutorat_1_4' onclick='lock_registration("tutorats",{$tutorat['id']},$lock);' $displayLock id='lock_tutorat_1'  style='margin-left:30px;' value='$lock_msg' class='myUI-button-right' />
  </td></tr>
  <tr style='display:none;' id='formTutorat_1_done'><td colspan='2' style='text-align:right;'>
  <br/><input type='button' onclick='location.href="$cancel";' style='margin-left:30px;' value='Annuler' class='myUI-button-right' />
  <input type='submit' style='margin-left:30px;' value='Valider' class='myUI-button-right' /></td></tr>
EOD;
}

echo "</table>\n";
echo "</form>\n";
echo "</fieldset>\n";
?>