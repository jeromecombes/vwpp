<?php
require_once "../header.php";
require_once "../inc/class.reidhall.inc";
require_once "../inc/class.student.inc";
require_once "menu.php";

access_ctrl(23);

$id=isset($_GET['id'])?$_GET['id']:null;
$rh=new reidhall();
$rh->fetch($id);

$title=$rh->element['title'];
$nom=$rh->element['nom'];
$code=$rh->element['code'];
$professor=$rh->element['professor'];
$jour=$rh->element['jour'];
$debut=$rh->element['debut'];
$fin=$rh->element['fin'];
$selectW=$rh->element['type']=="Writing"?"selected='selected'":null;
$selectS=$rh->element['type']=="Seminar"?"selected='selected'":null;

// $days=array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
$days=array(array("Lundi","Monday"),array("Mardi","Tuesday"),array("Mercredi","Wednesday"),array("Jeudi","Thursday"),array("Vendredi","Friday"),array("Samedi","Saturday"),array("Dimanche","Sunday"));
$hoursStart=8;
$hoursEnd=22;

$submit=$id?"Change":"Add";
$submitDisabled=in_array(16,$_SESSION['vwpp']['access'])?null:"disabled='disabled'";
$delete=null;
$deleteAlert=null;

if($id){
  $dontDelete=false;
  $db=new db();
  $db->select("courses_choices","*","a1=$id or a2=$id or b1=$id or b2=$id");
  if($db->result){
    $alertDelete="Attention, les étudiants suivant ont choisi ce cours :\\n";
    foreach($db->result as $elem){
      $s=new student();
      $s->id=$elem['student'];
      $s->fetch();
      $students[]="- {$s->elements['firstname']} {$s->elements['lastname']}";
    }
    sort($students);
    $alertDelete.=join("\\n",$students);
    $alertDelete.="\\n\\nEtes vous sûr(e) de vouloir le supprimer ?\\n";
  }

  $db=new db();
  $db->select("courses_attrib_rh","*","writing1=$id or writing2=$id or writing3=$id or seminar1=$id or seminar2=$id");
  if($db->result)
    $dontDelete=true;

  if($id and !$dontDelete and !$alertDelete){
    $delete="<input type='button' value='Delete' style='margin-right:30px;' onclick='location.href=\"courses-update.php?id=$id&amp;delete=\";'/>";
  }
  elseif($id and !$dontDelete and $alertDelete){
    $delete="<input type='button' value='Delete' style='margin-right:30px;' onclick='alertDelete(\"$alertDelete\",$id);'/>";
  }
}

echo <<<EOD
<h3>VWPP Courses for {$_SESSION['vwpp']['semester']}</h3>
<fieldset>
<form name='form' action='courses-update.php' method='post'>
<input type='hidden' name='univ' value='rh' />
<input type='hidden' name='id' value='$id' />
<table style='width:1170px;'>
<tr><td style='width:300px;'><b>Code</b></td>
<td><input type='text' name='code' value='$code' /></td></tr>
<tr><td><b>Nom du cours</b></td>
<td><input type='text' name='nom' value='$nom' /></td></tr>
<tr><td><b>Course title</b></td>
<td><input type='text' name='title' value='$title' /></td></tr>
<tr><td><b>Professor (Lastname, Firstname)</b></td>
<td><input type='text' name='professor' value='$professor' /></td></tr>
<tr><td><b>Type</b></td>
<td><select name='type' style='width:99%;'>
<option value=''>&nbsp;</option>
<option value='Writing' $selectW >Writing-Intensive Course</option>
<option value='Seminar' $selectS >Seminar</option>
</select></td></tr>

<tr><td style='padding-top:5px;'><b>Schedule</b></td>
<td style='padding-top:5px;'>
On&nbsp;
<select name='jour' style='width:28%;'>
<option value=''>&nbsp;</option>
EOD;
foreach($days as $day){
  $selected=$jour==$day[0]?"selected='selected'":null;
  echo "<option value='$day[0]' $selected >$day[1]</option>\n";
}
echo <<<EOD
</select>

&nbsp;from&nbsp;
<select name='debut' style='width:28%;'>
<option value=''>&nbsp;</option>
EOD;
for($i=$hoursStart;$i<$hoursEnd+1;$i++){
  for($j=0;$j<60;$j=$j+15){
    $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
    $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
    $selected=$debut==$h1?"selected='selected'":null;
    echo "<option value='$h1' $selected >$h2</option>\n";
  }
}
echo <<<EOD
</select>

&nbsp;to&nbsp;
<select name='fin' style='width:28%;'>
<option value=''>&nbsp;</option>
EOD;

for($i=$hoursStart;$i<$hoursEnd+1;$i++){
  for($j=0;$j<60;$j=$j+15){
    $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
    $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
    $selected=$fin==$h1?"selected='selected'":null;
    echo "<option value='$h1' $selected >$h2</option>\n";
  }
}
echo <<<EOD
</select>

</td></tr>

<tr><td colspan='2' style='text-align:center;padding-top:10px;'>
<input type='button' value='Cancel' style='margin-right:30px;'onclick='history.back();' />
$delete
<input type='submit' value='$submit' $submitDisabled/></td></tr>

</table>
</form>
</fieldset>
EOD;

require_once "../footer.php";
?>