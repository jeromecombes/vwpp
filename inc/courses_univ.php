<?php
// Update : 2015-10-14
require_once "class.univ.inc";
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

//		Get data from courses_univ
$u=new univ();
$u->fetchAll();
foreach($u->elements as $elem){
  if($elem['student']==$student){
    $stdCourses[]=$elem;
  }
}
// $stdCourses=array();
// $db=new db();
// $db->select("courses_univ","*","student='$student' AND semester='$semester'");
// if($db->result[0]){
//   $keys=array_keys($db->result[0]);
//   for($i=0;$i<$db->nb;$i++){		// decrypt data and store it into $stdCourses
//     foreach($keys as $key){
//       if(!in_array($key,array('id','student','semester','lock','ref')))
// 	 if(!empty($db->result[$i][$key])){
// 	  if(in_array($key,array("university","cm_code")))
// 	    $stdCourses[$i][$key]=decrypt($db->result[$i][$key]);
// 	  else
// 	    $stdCourses[$i][$key]=decrypt($db->result[$i][$key],$db->result[$i]['student']);
// 	 }
// 	  else{
// 	  $stdCourses[$i][$key]=null;
// 	 }
//       else
// 	$stdCourses[$i][$key]=$db->result[$i][$key];
//     }
//     if(!$stdCourses[$i]['cm_name']){	// delete if empty
//       unset($stdCourses[$i]);
//     }
//   }
// }

usort($stdCourses,"cmp_univ");
//	Blank Form to Add
$stdCourses[]=array();


//		Show selected courses
foreach($stdCourses as $course){
  $title=$course['cm_name']?$course['cm_name']:"New Course";
  $submit=$course['cm_name']?"Change":"Add";
  $delete=$course['cm_name']?null:"display:none;";

  $selected=array();
  $selected[0]=$course['university']=="IEP"?"selected='selected'":null;
  $selected[1]=$course['university']=="UP3"?"selected='selected'":null;
  $selected[2]=$course['university']=="UP4"?"selected='selected'":null;
  $selected[3]=$course['university']=="UP7"?"selected='selected'":null;
  $selected[4]=$course['niveau']=="Licence 1"?"selected='selected'":null;
  $selected[5]=$course['niveau']=="Licence 2"?"selected='selected'":null;
  $selected[6]=$course['niveau']=="Licence 3"?"selected='selected'":null;

  $displayFieldset=empty($course)?"style='display:none;' id='fieldSetUniv'":null;
  $displayEdit=($course['lock'] and $_SESSION['vwpp']['category']!="admin")?"style=display:none;'":null;
  $lock=$course['lock']?0:1;
  $lock_msg=$course['lock']?"Déverrouiller":"Vérrouiller";

  $course['cm_hours1']=$course['cm_start1']?"{$course['cm_day1']} de {$course['cm_start1']} à {$course['cm_end1']}":null;
  $course['cm_hours2']=$course['cm_start2']?"{$course['cm_day2']} de {$course['cm_start2']} à {$course['cm_end2']}":null;
  $course['td_hours1']=$course['td_start1']?"{$course['td_day1']} de {$course['td_start1']} à {$course['td_end1']}":null;
  $course['td_hours2']=$course['td_start2']?"{$course['td_day2']} de {$course['td_start2']} à {$course['td_end2']}":null;

  $course['notes2']=str_replace("\n","<br/>",$course['notes']);


  echo <<<EOD
  <fieldset $displayFieldset>
  <legend><b><u>$title</u></b></legend>
  <form name='formUniv_{$course['id']}' action='$action' method='post'>
  <input type='hidden' name='univ' value='univ' />
  <input type='hidden' name='id' value='{$course['id']}' />
  <table style='width:1100px;'>
  <tr><td style='width:400px;'><b>Nom de l'université</b></td>
  <td style='width:450px;'><select name='university' $displayForm>
  <option value=''>&nbsp;</option>
  <option value='IEP' {$selected[0]} >IEP</option>
  <option value='UP3' {$selected[1]} >Université Paris 3</option>
  <option value='UP4' {$selected[2]} >Université Paris 4</option>
  <option value='UP7' {$selected[3]} >Université Paris 7</option>
  </select>
  <div $displayText id='formUniv_{$course['id']}_0'>{$course['university']}</div></td>
EOD;
  if(in_array(21,$_SESSION['vwpp']['access'])){
    echo <<<EOD
    <td rowspan='17' style='width:250px;'>
    <textarea name='notes' $displayForm style='width:100%;'>{$course['notes']}</textarea>
    <div $displayText id='formUniv_{$course['id']}_18'>{$course['notes2']}</div>
    </td>
EOD;
  }
  echo <<<EOD
  </tr>
  <tr><td><b>Nom de l'UFR</b></td>
  <td><input type='text' name='ufr' value='{$course['ufr']}' $displayForm/>
  <div $displayText id='formUniv_{$course['id']}_1'>{$course['ufr']}</div></td></tr>
  <tr><td><b>Nom de la discipline</b></td>
  <td><input type='text' name='discipline' value='{$course['discipline']}' $displayForm/>
  <div $displayText id='formUniv_{$course['id']}_2'>{$course['discipline']}</div></td></tr>
  <tr><td><b>Nom du département</b></td>
  <td><input type='text' name='departement' value='{$course['departement']}' $displayForm/>
  <div $displayText id='formUniv_{$course['id']}_3'>{$course['departement']}</div></td></tr>
  <tr><td><b>Nom du parcours</b></td>
  <td><input type='text' name='parcours' value='{$course['parcours']}' $displayForm/>
  <div $displayText id='formUniv_{$course['id']}_4'>{$course['parcours']}</div></td></tr>
   <tr><td><b>Nom de la licence</b></td>
  <td><input type='text' name='licence' value='{$course['licence']}' $displayForm/>
  <div $displayText id='formUniv_{$course['id']}_5'>{$course['licence']}</div></td></tr>
  <tr><td><b>Niveau</b></td>
  <td><select name='niveau' $displayForm>
    <option value=''>&nbsp;</option>
    <option value='Licence 1' {$selected[4]} >Licence 1</option>
    <option value='Licence 2' {$selected[5]} >Licence 2</option>
    <option value='Licence 3' {$selected[6]} >Licence 3</option>
  </select>
  <div $displayText id='formUniv_{$course['id']}_6'>{$course['niveau']}</div></td></tr>
  <tr><td><b>Nom du cours magistral</b></td>
  <td><input type='text' name='cm_name' value='{$course['cm_name']}' $displayForm/>
  <div $displayText id='formUniv_{$course['id']}_7'>{$course['cm_name']}</div></td></tr>
  <tr><td><b>Code du cours magistral</b></td>
  <td><input type='text' name='cm_code' value='{$course['cm_code']}' $displayForm/>
  <div $displayText id='formUniv_{$course['id']}_8'>{$course['cm_code']}</div></td></tr>

  <tr><td><b>Jours et heures du cours magistral</b></td>
  <td>

  <select name='cm_day1' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  foreach($days as $day){
    $hourSelect=$course['cm_day1']==$day?"selected='selected'":null;
    echo "<option value='$day' $hourSelect >$day</option>\n";
  }
  echo <<<EOD
  </select>

  <select name='cm_start1' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['cm_start1']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >de $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <select name='cm_end1' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['cm_end1']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >à $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <div $displayText id='formUniv_{$course['id']}_9'>{$course['cm_hours1']}</div>
  </td></tr>

  <tr><td>&nbsp;</td>
  <td>

  <select name='cm_day2' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  foreach($days as $day){
    $hourSelect=$course['cm_day2']==$day?"selected='selected'":null;
    echo "<option value='$day' $hourSelect >$day</option>\n";
  }
  echo <<<EOD
  </select>

  <select name='cm_start2' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['cm_start2']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >de $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <select name='cm_end2' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['cm_end2']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >à $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <div $displayText id='formUniv_{$course['id']}_16'>{$course['cm_hours2']}</div>
  </td></tr>


  <tr><td><b>Nom de l'instructeur du cours magistral</b></td>
  <td><input type='text' name='cm_prof' value='{$course['cm_prof']}' $displayForm/>
  <div $displayText id='formUniv_{$course['id']}_10'>{$course['cm_prof']}</div></td></tr>
  <tr><td><b>Nom du cours de TD</b></td>
  <td><input type='text' name='td_name' value='{$course['td_name']}' $displayForm/>
  <div $displayText id='formUniv_{$course['id']}_11'>{$course['td_name']}</div></td></tr>
  <tr><td><b>Code du cours de TD</b></td>
  <td><input type='text' name='td_code' value='{$course['td_code']}' $displayForm/>
  <div $displayText id='formUniv_{$course['id']}_12'>{$course['td_code']}</div></td></tr>
  
  <tr><td><b>Jours et heures du cours de TD</b></td>
  <td>

  <select name='td_day1' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  foreach($days as $day){
    $hourSelect=$course['td_day1']==$day?"selected='selected'":null;
    echo "<option value='$day' $hourSelect >$day</option>\n";
  }
  echo <<<EOD
  </select>

  <select name='td_start1' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['td_start1']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >de $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <select name='td_end1' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['td_end1']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >à $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <div $displayText id='formUniv_{$course['id']}_13'>{$course['td_hours1']}</div>
  </td></tr>

  <tr><td><b>&nbsp;</b></td>
  <td>

  <select name='td_day2' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  foreach($days as $day){
    $hourSelect=$course['td_day2']==$day?"selected='selected'":null;
    echo "<option value='$day' $hourSelect >$day</option>\n";
  }
  echo <<<EOD
  </select>

  <select name='td_start2' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['td_start2']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >de $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <select name='td_end2' style='width:120px;display:none; '>
  <option value=''>&nbsp;</option>
EOD;
  for($i=$hoursStart;$i<$hoursEnd+1;$i++){
    for($j=0;$j<60;$j=$j+15){
      $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
      $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
      $hourSelect=$course['td_end2']==$h1?"selected='selected'":null;
      echo "<option value='$h1' $hourSelect >à $h2</option>\n";
    }
  }
echo <<<EOD
  </select>
  <div $displayText id='formUniv_{$course['id']}_17'>{$course['td_hours2']}</div>
  </td></tr>


  <tr><td><b>Nom de l'instructeur du cours de TD</b></td>
  <td><input type='text' name='td_prof' value='{$course['td_prof']}' $displayForm/>
  <div $displayText id='formUniv_{$course['id']}_14'>{$course['td_prof']}</div></td></tr>
  <tr $displayForm><td colspan='3' style='text-align:center;padding-top:10px;'>
  <input type='button' value='Delete' onclick='delete_course("univ",{$course['id']},$admin);' style='$delete'/>
  <input type='submit' value='$submit' /></td></tr>
  <tr $displayEdit id='formUniv_{$course['id']}_15'><td colspan='3' style='text-align:right;'><br/>
  <input type='button' id='formUniv_{$course['id']}_delete' onclick='delete_course("univ",{$course['id']},$admin);' style='margin-left:30px;' value='Supprimer' />
  <input type='button' id='formUniv_{$course['id']}_edit' onclick='displayForm("formUniv",{$course['id']});' style='margin-left:30px;' value='Modifier' />
  <input type='button' id='formUniv_{$course['id']}_lock' onclick='lock_registration("univ",{$course['id']},$lock);' $displayLock id='lock_univ_{$course['id']}'  style='margin-left:30px;' value='$lock_msg' />
  </td></tr>
  <tr style='display:none;' id='formUniv_{$course['id']}_done'><td colspan='3' style='text-align:right;'>
  <br/><input type='button' onclick='location.reload(false);' style='margin-left:30px;' value='Annuler' />
  <input type='button' onclick='document.formUniv_{$course['id']}.submit();' style='margin-left:30px;' value='Valider' /></td></tr>
  </table>
  </form>
  </fieldset>
EOD;
}
?>
<div style='margin:10px 0 0 0;'>
<input type='button' onclick='displayAdd("Univ");' value="Ajouter un cours à l'université" />
</div>
