<?php
/*	Needed :
$student (int)
$semster (varchar)
$isForm (boolean)
*/

$displayForm=$isForm?null:"style='display:none;'";
$displayText=$isForm?"style='display:none;'":null;
$displayEdit=$isForm?"style='display:none;'":null;
$admin=$_SESSION['vwpp']['category']=="admin"?1:0;
$action=$admin?"students-coursesUpdate.php":"courses-update.php";
$displayLock=$admin?null:"style='display:none;'";

$hoursStart=8;
$hoursEnd=20;
$days=array("Lundi","Mardi","Mercredi","Jeudi","Vendredi");

//		Get data from courses_ciph
$stdCourses=array();
$db=new db();
$db->select("courses_ciph","*","student='$student' AND semester='$semester'");
if($db->result[0]){
  $keys=array_keys($db->result[0]);
  for($i=0;$i<$db->nb;$i++){		// decrypt data and store it into $stdCourses
    foreach($keys as $key){
      if(!in_array($key,array('id','student','semester','lock'))){
	if(!empty($db->result[$i][$key])){
	  $stdCourses[$i][$key]=decrypt($db->result[$i][$key],$db->result[$i]['student']);
	}
	else{
	  $stdCourses[$i][$key]=null;
	 }
      }
      else
	$stdCourses[$i][$key]=$db->result[$i][$key];
    }
    if(!$stdCourses[$i]['titre']){	// delete if empty
      unset($stdCourses[$i]);
    }
  }
}

usort($stdCourses,cmp_univ);
//	Add a blank form
$stdCourses[]=array();


//		Show selected courses
foreach($stdCourses as $course){
  $title=$course['titre']?$course['titre']:"New Course";
  $submit=$course['titre']?"Change":"Add";
  $delete=$course['titre']?null:"display:none;";

  $selected=array();
  $selected[0]=$course['university']=="IEP"?"selected='selected'":null;
  $selected[1]=$course['university']=="UP3"?"selected='selected'":null;
  $selected[2]=$course['university']=="UP4"?"selected='selected'":null;
  $selected[3]=$course['university']=="UP7"?"selected='selected'":null;
  $selected[4]=$course['niveau']=="Licence 1"?"selected='selected'":null;
  $selected[5]=$course['niveau']=="Licence 2"?"selected='selected'":null;
  $selected[6]=$course['niveau']=="Licence 3"?"selected='selected'":null;

  $displayFieldset=empty($course)?"style='display:none;' id='fieldSetCiph'":null;
  $displayEdit=($course['lock'] and $_SESSION['vwpp']['category']!="admin")?"style=display:none;'":null;
  $lock=$course['lock']?0:1;
  $lock_msg=$course['lock']?"Déverrouiller":"Vérrouiller";

  $course['hours1']=$course['start1']?"{$course['day1']} de {$course['start1']} à {$course['end1']}":null;
  $course['hours2']=$course['start2']?"{$course['day2']} de {$course['start2']} à {$course['end2']}":null;
  $course['hours3']=$course['start3']?"{$course['day3']} de {$course['start3']} à {$course['end3']}":null;
  $course['hours4']=$course['start4']?"{$course['day4']} de {$course['start4']} à {$course['end4']}":null;
  $course['hours5']=$course['start5']?"{$course['day5']} de {$course['start5']} à {$course['end5']}":null;
  $course['hours6']=$course['start6']?"{$course['day6']} de {$course['start6']} à {$course['end6']}":null;

  $course['notes2']=str_replace("\n","<br/>",$course['notes']);

  echo <<<EOD
  <fieldset $displayFieldset>
  <legend><b><u>$title</u></b></legend>
  <form name='formCiph_{$course['id']}' action='$action' method='post'>
  <input type='hidden' name='univ' value='ciph' />
  <input type='hidden' name='id' value='{$course['id']}' />
  <table style='width:1100px;'>
  <tr><td style='width:400px;'><b>Nom de l'institution française</b></td>
  <td style='width:400px;'><input type='text' name='institution' value='{$course['institution']}' $displayForm/>
  <div $displayText id='formCiph_{$course['id']}_0'>{$course['institution']}</div></td>
EOD;
  if(in_array(21,$_SESSION['vwpp']['access'])){
    echo <<<EOD
    <td rowspan='17' style='width:250px;'>
    <textarea name='notes' $displayForm style='width:100%;'>{$course['notes']}</textarea>
    <div $displayText id='formCiph_{$course['id']}_19'>{$course['notes2']}</div>
    </td>
EOD;
  }
  echo <<<EOD
  </tr>
  <tr><td><b>Domaine général</b></td>
  <td><input type='text' name='domaine' value='{$course['domaine']}' $displayForm/>
  <div $displayText id='formCiph_{$course['id']}_1'>{$course['domaine']}</div></td></tr>

  <tr><td colspan='3' style='padding-top:10px;'><b><u>Séminaire 1</u></b></td></tr>
  <tr><td style='padding-left:30px;'><b>Titre / Sujet du séminaire </b></td>
  <td><input type='text' name='titre' value='{$course['titre']}' $displayForm/>
  <div $displayText id='formCiph_{$course['id']}_2'>{$course['titre']}</div></td></tr>
  <tr><td style='padding-left:30px;'><b>Instructeur </b></td>
  <td><input type='text' name='instructeur' value='{$course['instructeur']}' $displayForm/>
  <div $displayText id='formCiph_{$course['id']}_3'>{$course['instructeur']}</div></td></tr>
  <tr><td style='padding-left:30px;'><b>Date de début du séminaire </b></td>
  <td><input type='text' name='debut' value='{$course['debut']}' $displayForm/>
  <div $displayText id='formCiph_{$course['id']}_4'>{$course['debut']}</div></td></tr>
  <tr><td style='padding-left:30px;'><b>Date de conclusion </b></td>
  <td><input type='text' name='fin' value='{$course['fin']}' $displayForm/>
  <div $displayText id='formCiph_{$course['id']}_5'>{$course['fin']}</div></td></tr>
  <tr><td style='padding-left:30px;'><b>Durée </b></td>
  <td><input type='text' name='duree' value='{$course['duree']}' $displayForm/>
  <div $displayText id='formCiph_{$course['id']}_6'>{$course['duree']}</div></td></tr>

  <tr><td style='padding-left:30px;'><b>Jours et heures du séminaire</b></td>
  <td>

  <select name='day1' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  foreach($days as $day){
    $hourSelect=$course['day1']==$day?"selected='selected'":null;
    echo "<option value='$day' $hourSelect >$day</option>\n";
  }
  echo <<<EOD
  </select>

  <select name='start1' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['start1']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >de $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <select name='end1' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['end1']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >à $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <div $displayText id='formCiph_{$course['id']}_13'>{$course['hours1']}</div>
  </td></tr>

  <tr><td>&nbsp;</td>
  <td>

  <select name='day2' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  foreach($days as $day){
    $hourSelect=$course['day2']==$day?"selected='selected'":null;
    echo "<option value='$day' $hourSelect >$day</option>\n";
  }
  echo <<<EOD
  </select>

  <select name='start2' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['start2']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >de $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <select name='end2' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['end2']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >à $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <div $displayText id='formCiph_{$course['id']}_14'>{$course['hours2']}</div>
  </td></tr>

  <tr><td style='padding-left:30px;'><b>Jours et heures du tutorat</b></td>
  <td>

  <select name='day3' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  foreach($days as $day){
    $hourSelect=$course['day3']==$day?"selected='selected'":null;
    echo "<option value='$day' $hourSelect >$day</option>\n";
  }
  echo <<<EOD
  </select>

  <select name='start3' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['start3']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >de $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <select name='end3' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['end3']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >à $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <div $displayText id='formCiph_{$course['id']}_15'>{$course['hours3']}</div>
  </td></tr>



  <tr><td colspan='3' style='padding-top:10px;'><b><u>Séminaire 2</u></b></td></tr>
  <tr><td style='padding-left:30px;'><b>Titre / Sujet du séminaire </b></td>
  <td><input type='text' name='titre2' value='{$course['titre2']}' $displayForm/>
  <div $displayText id='formCiph_{$course['id']}_7'>{$course['titre2']}</div></td></tr>
  <tr><td style='padding-left:30px;'><b>Instructeur </b></td>
  <td><input type='text' name='instructeur2' value='{$course['instructeur2']}' $displayForm/>
  <div $displayText id='formCiph_{$course['id']}_8'>{$course['instructeur2']}</div></td></tr>
  <tr><td style='padding-left:30px;'><b>Date de début du séminaire </b></td>
  <td><input type='text' name='debut2' value='{$course['debut2']}' $displayForm/>
  <div $displayText id='formCiph_{$course['id']}_9'>{$course['debut2']}</div></td></tr>
  <tr><td style='padding-left:30px;'><b>Date de conclusion </b></td>
  <td><input type='text' name='fin2' value='{$course['fin2']}' $displayForm/>
  <div $displayText id='formCiph_{$course['id']}_10'>{$course['fin2']}</div></td></tr>
  <tr><td style='padding-left:30px;'><b>Durée </b></td>
  <td><input type='text' name='duree2' value='{$course['duree2']}' $displayForm/>
  <div $displayText id='formCiph_{$course['id']}_11'>{$course['duree2']}</div></td></tr>

  <tr><td style='padding-left:30px;'><b>Jours et heures du séminaire</b></td>
  <td>

  <select name='day4' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  foreach($days as $day){
    $hourSelect=$course['day4']==$day?"selected='selected'":null;
    echo "<option value='$day' $hourSelect >$day</option>\n";
  }
  echo <<<EOD
  </select>

  <select name='start4' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['start4']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >de $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <select name='end4' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['end4']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >à $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <div $displayText id='formCiph_{$course['id']}_16'>{$course['hours4']}</div>
  </td></tr>

  <tr><td>&nbsp;</td>
  <td>

  <select name='day5' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  foreach($days as $day){
    $hourSelect=$course['day5']==$day?"selected='selected'":null;
    echo "<option value='$day' $hourSelect >$day</option>\n";
  }
  echo <<<EOD
  </select>

  <select name='start5' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['start5']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >de $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <select name='end5' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['end5']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >à $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <div $displayText id='formCiph_{$course['id']}_17'>{$course['hours5']}</div>
  </td></tr>

  <tr><td style='padding-left:30px;'><b>Jours et heures du tutorat</b></td>
  <td>

  <select name='day6' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  foreach($days as $day){
    $hourSelect=$course['day6']==$day?"selected='selected'":null;
    echo "<option value='$day' $hourSelect >$day</option>\n";
  }
  echo <<<EOD
  </select>

  <select name='start6' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['start6']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >de $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <select name='end6' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['end6']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >à $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <div $displayText id='formCiph_{$course['id']}_18'>{$course['hours6']}</div>
  </td></tr>

  <tr $displayForm><td colspan='3' style='text-align:center;padding-top:10px;'>
  <input type='button' value='Delete' onclick='delete_course("ciph",{$course['id']},$admin);' style='$delete'/>
  <input type='submit' value='$submit' /></td></tr>
  <tr $displayEdit id='formCiph_{$course['id']}_12'><td colspan='3' style='text-align:right;'><br/>
  <input type='button' onclick='delete_course("ciph",{$course['id']},$admin);' style='margin-left:30px;' value='Supprimer' />
  <input type='button' onclick='displayForm("formCiph",{$course['id']});' style='margin-left:30px;' value='Modifier' />
  <input type='button' onclick='lock_registration("ciph",{$course['id']},$lock);' $displayLock id='lock_ciph_{$course['id']}' style='margin-left:30px;' value='$lock_msg' />
  </td></tr>
  <tr style='display:none;' id='formCiph_{$course['id']}_done'><td colspan='3' style='text-align:right;'>
  <br/><input type='button' onclick='location.reload(false);' style='margin-left:30px;' value='Annuler' />
  <input type='button' onclick='document.formCiph_{$course['id']}.submit();' style='margin-left:30px;' value='Valider' /></td></tr>
  </table>
  </form>
  </fieldset>
EOD;
}

?>
<div style='margin:20px 0 0 0'>
<input type='button' onclick='displayAdd("Ciph");' value="Ajouter un cours au CIPh ou autre institution" />
</div>
