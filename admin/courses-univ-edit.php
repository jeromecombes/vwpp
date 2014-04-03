<?php
require_once "../header.php";
require_once "menu.php";
require_once "../inc/class.univ.inc";

access_ctrl(23);

$id=isset($_GET['id'])?$_GET['id']:null;
$univ=new univ();

//	Autocomplete
$univ->fetchAllSemesters();
$univ->writeAutocompleteJS();


//	Data for this form
$univ->fetch($id);
$univ=$univ->element;


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


$keys=array_keys($univ);		// for data imported
foreach($keys as $key){
  $univ[$key]=html_entity_decode($univ[$key],ENT_QUOTES|ENT_IGNORE,"utf-8");
  $univ[$key]=htmlentities($univ[$key],ENT_QUOTES|ENT_IGNORE,"utf-8");
}


echo <<<EOD
<h3>University Courses for {$_SESSION['vwpp']['semester']}</h3>
<fieldset>
<form name='form' action='courses-univ-update2.php' method='post'>
<input type='hidden' name='univ' value='univ' />
<input type='hidden' name='id' value='{$univ['id']}' />
<input type='hidden' name='student' value='{$univ['student']}' />
<table style='width:1170px;'>
<tr><td style='width:570px;'><b>Nom de l'université / University name</b></td>
<td>
<select name='university' style='width:99%;'>
  <option value=''>&nbsp;</option>
  <option value='IEP' {$selected[0]} >IEP</option>
  <option value='UP3' {$selected[1]} >Université Paris 3</option>
  <option value='UP4' {$selected[2]} >Université Paris 4</option>
  <option value='UP7' {$selected[3]} >Université Paris 7</option>
  </select>
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
  </select>

<tr><td colspan='2' style='padding-top:20px;'><b><u>Cours magistral / Lecture course </u></b></td></tr>
<tr><td style='padding-left:30px;'><b>Nom du cours<b></b></td>
<td><input type='text' name='cm_name' value='{$univ['cm_name']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td style='padding-left:30px;'><b>Course Title</b></td>
<td><input type='text' name='cm_name_en' value='{$univ['cm_name_en']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td style='padding-left:30px;'><b>Code du cours / Course code</b></td>
<td><input type='text' name='cm_code' value='{$univ['cm_code']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td style='padding-left:30px;'><b>Instructeur (Nom, Prénom) / Instructor (Lastname, Firstname)</b></td>
<td><input type='text' name='cm_prof' value='{$univ['cm_prof']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td style='padding-left:30px;'><b>Email</b></td>
<td><input type='text' name='cm_prof_en' value='{$univ['cm_prof_en']}' onkeyup='js_autocomplete(this);' /></td></tr>

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



<tr><td colspan='2' style='text-align:center;padding-top:10px;'>
<input type='button' value='Cancel' style='margin-right:30px;'onclick='history.back();' />
<input type='submit' value='$submit' $submitDisabled/></td></tr>

</table>
</form>
</fieldset>
EOD;

require_once "../footer.php";
?>