<?php
require_once "../header.php";
require_once "menu.php";
require_once "../inc/class.univ3.inc";

access_ctrl(23);

$id=isset($_GET['id'])?$_GET['id']:null;
$univ=new univ3();

$hoursStart=8;
$hoursEnd=20;
$jours=array();
$jours[]=array(1,"Lundi");
$jours[]=array(2,"Mardi");
$jours[]=array(3,"Mercredi");
$jours[]=array(4,"Jeudi");
$jours[]=array(5,"Vendredi");
$jours[]=array(6,"Samedi");
$jours[]=array(7,"Dimanche");

//	Autocomplete
// $univ->fetchAllSemesters();
// $univ->writeAutocompleteJS();


//	Data for this form
$univ->fetchCMById($id);
$univ=$univ->elements;

$submitDisabled=in_array(16,$_SESSION['vwpp']['access'])?null:"disabled='disabled'";
$submit=$id?"Save":"Add";

if($id){
  $dontDelete=false;
  $db=new db();
  $db->select("courses_choices","*","a1=$id or a2=$id or b1=$id or b2=$id");
  if($db->result)
    $dontDelete=true;

  $db=new db();
  $db->select("courses_attrib_rh","*","writing1=$id or writing2=$id or writing3=$id or seminar1=$id or seminar2=$id");
  if($db->result)
    $dontDelete=true;

  $delete=null;
  if($id and !$dontDelete){
    $delete="<input type='button' value='Delete' style='margin-right:30px;' onclick='location.href=\"courses-update.php?id=$id&amp;delete=\";'/>";
  }
}

$selected[0]=$univ['university']=="IEP"?"selected='selected'":null;
$selected[1]=$univ['university']=="UP3"?"selected='selected'":null;
$selected[2]=$univ['university']=="UP4"?"selected='selected'":null;
$selected[3]=$univ['university']=="UP7"?"selected='selected'":null;
$selected[4]=$univ['niveau']=="Licence 1"?"selected='selected'":null;
$selected[5]=$univ['niveau']=="Licence 2"?"selected='selected'":null;
$selected[6]=$univ['niveau']=="Licence 3"?"selected='selected'":null;
$selected[7]=$univ['niveau']=="Master 1"?"selected='selected'":null;
$selected[8]=$univ['niveau']=="Master 2"?"selected='selected'":null;
$selected[9]=$univ['credits']=="0.5"?"selected='selected'":null;
$selected[10]=$univ['credits']=="1"?"selected='selected'":null;
$selected[11]=$univ['credits']=="1.5"?"selected='selected'":null;
$selected[12]=$univ['credits']=="2"?"selected='selected'":null;
$university=str_replace("UP","Université Paris ",$univ['university']);

$keys=array_keys($univ);		// for data imported
foreach($keys as $key){
  $univ[$key]=html_entity_decode($univ[$key],ENT_QUOTES|ENT_IGNORE,"utf-8");
  $univ[$key]=htmlentities($univ[$key],ENT_QUOTES|ENT_IGNORE,"utf-8");
}

$back=isset($_GET['back'])?$_GET['back']:"courses3.php";

echo <<<EOD
<h3>University Courses for {$_SESSION['vwpp']['semester']}</h3>
<fieldset>
<form name='form' action='courses3-univ-update.php' method='post'>
<input type='hidden' name='back' value='$back' />
<!--
<input type='hidden' name='univ' value='univ' />
<input type='hidden' name='student' value='{$univ['student']}' />
-->
<input type='hidden' name='id' value='{$univ['id']}' />
<table style='width:1170px;'>
<tr><td style='width:570px;'><b>Nom de l'université / University name</b></td>
<td><b>$university</b></td></tr>
<!--
<td>
<select name='university' style='width:99%;'>
  <option value=''>&nbsp;</option>
  <option value='IEP' {$selected[0]} >IEP</option>
  <option value='UP3' {$selected[1]} >Université Paris 3</option>
  <option value='UP4' {$selected[2]} >Université Paris 4</option>
  <option value='UP7' {$selected[3]} >Université Paris 7</option>
  </select>
*  </td></tr>
-->
<!--
<tr><td><b>University name</b></td>
<td><input type='text' name='university_en' value='{$univ['university_en']}' onkeyup='js_autocomplete(this);' /></td></tr>
-->
<tr><td><b>Nom de l'UFR</b></td>
<td><input type='text' name='ufr' value='{$univ['ufr']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td><b>UFR Name</b></td>
<td><input type='text' name='ufr_en' value='{$univ['ufr_en']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td><b>Nom de la discipline</b></td>
<td><input type='text' name='discipline' value='{$univ['discipline']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td><b>Discipline name</b></td>
<td><input type='text' name='discipline_en' value='{$univ['discipline_en']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td><b>Nom du département</b></td>
<td><input type='text' name='departement' value='{$univ['departement']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td><b>Department name</b></td>
<td><input type='text' name='departement_en' value='{$univ['departement_en']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td><b>Nom du parcours</b></td>
<td><input type='text' name='parcours' value='{$univ['parcours']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td><b>Stream name</b></td>
<td><input type='text' name='parcours_en' value='{$univ['parcours_en']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td><b>Nom de la licence</b></td>
<td><input type='text' name='licence' value='{$univ['licence']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td><b>Licence name</b></td>
<td><input type='text' name='licence_en' value='{$univ['licence_en']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td><b>Niveau / Level</b></td>
<td>
<select name='niveau' style='width:99%;'>
    <option value=''>&nbsp;</option>
    <option value='Licence 1' {$selected[4]} >Licence 1</option>
    <option value='Licence 2' {$selected[5]} >Licence 2</option>
    <option value='Licence 3' {$selected[6]} >Licence 3</option>
    <option value='Master 1' {$selected[7]} >Master 1</option>
    <option value='Master 2' {$selected[8]} >Master 2</option>
  </select>

<tr><td><b>Crédits / Credits</b></td>
<td>
<select name='credits' style='width:99%;'>
    <option value=''>&nbsp;</option>
    <option value='0.5' {$selected[9]} >0.5</option>
    <option value='1' {$selected[10]} >1</option>
    <option value='1.5' {$selected[11]} >1.5</option>
    <option value='2' {$selected[12]} >2</option>
  </select>

<tr><td colspan='2' style='padding-top:20px;'><b><u>Cours magistral / Lecture course </u></b></td></tr>
<tr><td style='padding-left:30px;'><b>Nom du cours<b></b></td>
<td><input type='text' name='nom' value='{$univ['nom']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td style='padding-left:30px;'><b>Course Title</b></td>
<td><input type='text' name='nom_en' value='{$univ['nom_en']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td style='padding-left:30px;'><b>Code du cours / Course code</b></td>
<!-- <td><input type='text' name='code' value='{$univ['code']}' onkeyup='js_autocomplete(this);' /></td></tr> -->
<td><b>{$univ['code']}</b></td></tr>
<tr><td style='padding-left:30px;'><b>Instructeur (Nom, Prénom) / Instructor (Lastname, Firstname)</b></td>
<td><input type='text' name='prof' value='{$univ['prof']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td style='padding-left:30px;'><b>Email</b></td>
<td><input type='text' name='email' value='{$univ['email']}' onkeyup='js_autocomplete(this);' /></td></tr>

<tr><td style='padding-left:30px;'><b>Horaires</b></td>
  <td><select name='jour1' style='width:30%;'>
    <option value=''>Jour</option>
EOD;
    foreach($jours as $jour){
      $jourSelect=$univ['jour1']==$jour[0]?"selected='selected'":null;
      echo "<option value='{$jour[0]}' $jourSelect>{$jour[1]}</option>\n";
    }
    echo <<<EOD
    </select>
  <select name='debut1' style='width:30%;'>
    <option value=''>Début</option>
EOD;
    for($i=$hoursStart;$i<$hoursEnd+1;$i++){
      for($j=0;$j<60;$j=$j+15){
	$h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
	$h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
	$jourSelect=$univ['debut1']==$h1?"selected='selected'":null;
	echo "<option value='$h1' $jourSelect >de $h2</option>\n";
      }
    }
    echo <<<EOD
    </select>
  <select name='fin1' style='width:30%;'>
    <option value=''>Fin</option>
EOD;
    for($i=$hoursStart;$i<$hoursEnd+1;$i++){
      for($j=0;$j<60;$j=$j+15){
	$h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
	$h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
	$jourSelect=$univ['fin1']==$h1?"selected='selected'":null;
	echo "<option value='$h1' $jourSelect >à $h2</option>\n";
      }
    }
    echo <<<EOD
    </select></td>
  </tr>
<tr><td style='padding-left:30px;'>&nbsp;</td>
  <td><select name='jour2' style='width:30%;'>
    <option value=''>Jour</option>
EOD;
    foreach($jours as $jour){
      $jourSelect=$univ['jour2']==$jour[0]?"selected='selected'":null;
      echo "<option value='{$jour[0]}' $jourSelect>{$jour[1]}</option>\n";
    }
    echo <<<EOD
    </select>
  <select name='debut2' style='width:30%;'>
    <option value=''>Début</option>
EOD;
    for($i=$hoursStart;$i<$hoursEnd+1;$i++){
      for($j=0;$j<60;$j=$j+15){
	$h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
	$h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
	$jourSelect=$univ['debut2']==$h1?"selected='selected'":null;
	echo "<option value='$h1' $jourSelect >de $h2</option>\n";
      }
    }
    echo <<<EOD
    </select>
  <select name='fin2' style='width:30%;'>
    <option value=''>Fin</option>
EOD;
    for($i=$hoursStart;$i<$hoursEnd+1;$i++){
      for($j=0;$j<60;$j=$j+15){
	$h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
	$h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
	$jourSelect=$univ['fin2']==$h1?"selected='selected'":null;
	echo "<option value='$h1' $jourSelect >à $h2</option>\n";
      }
    }
    echo <<<EOD
    </select></td>
  </tr>


<!--
<tr><td colspan='2' style='padding-top:20px;'><b><u>TD / Discussion Section</u></b></td></tr>
<tr><td style='padding-left:30px;'><b>Nom du TD<b></b></td>
<td><input type='text' name='td_name' value='{$univ['td_name']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td style='padding-left:30px;'><b>Discussion Section</b></td>
<td><input type='text' name='td_name_en' value='{$univ['td_name_en']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td style='padding-left:30px;'><b>Code du TD / Discussion section code</b></td>
<td><input type='text' name='td_code' value='{$univ['td_code']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td style='padding-left:30px;'><b>Instructeur (Nom, Prénom) / Instructor (Lastname, Firstname)</b></td>
<td><input type='text' name='td_prof' value='{$univ['td_prof']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td style='padding-left:30px;'><b>Email</b></td>
<td><input type='text' name='td_prof_en' value='{$univ['td_prof_en']}' onkeyup='js_autocomplete(this);' /></td></tr>

-->

<tr><td colspan='2' style='text-align:center;padding-top:10px;'>
<input type='button' value='Cancel' style='margin-right:30px;'onclick='history.back();' />
<input type='submit' value='$submit' $submitDisabled/></td></tr>

</table>
</form>
</fieldset>
EOD;

require_once "../footer.php";
?>