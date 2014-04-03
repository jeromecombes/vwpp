<?php
require_once "../header.php";
require_once "menu.php";
require_once "../inc/class.univ3.inc";

//		Ajouter : rechercher $cm_id et fetchCMById($cm_id);
//		Tableau $cm pour affichage des info CM
//		A CONTINUER  : CM ne marche pas
access_ctrl(23);

$id=isset($_GET['id'])?$_GET['id']:null;

//	Data for this form	TD
$td=new univ3();
$td->fetchTD($id);
$td=$td->elements;

$cm=new univ3();
$cm->fetchCMById($td['cm_id']);
$cm=$cm->elements;

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


$submitDisabled=in_array(16,$_SESSION['vwpp']['access'])?null:"disabled='disabled'";
$submit=$id?"Save":"Add";

$university=str_replace("UP","Université Paris ",$td['university']);

$keys=array_keys($td);		// for data imported
foreach($keys as $key){
  $td[$key]=html_entity_decode($td[$key],ENT_QUOTES|ENT_IGNORE,"utf-8");
  $td[$key]=htmlentities($td[$key],ENT_QUOTES|ENT_IGNORE,"utf-8");
}


echo <<<EOD
<h3>Discussion Courses for {$_SESSION['vwpp']['semester']}</h3>
<fieldset>
<form name='form' action='courses3-univ-update.php' method='post'>
<input type='hidden' name='univ' value='TD' />
<input type='hidden' name='id' value='{$td['id']}' />
<table style='width:1170px;'>
<tr><td style='width:570px;'><b>Nom de l'université / University name</b></td>
  <td><b>$university</b></td></tr>
<tr><td><b>Nom de l'UFR</b></td>
  <td>{$cm['ufr']}</td></tr>
<tr><td><b>UFR Name</b></td>
  <td>{$cm['ufr_en']}</td></tr>
<tr><td><b>Nom de la discipline</b></td>
  <td>{$cm['discipline']}</td></tr>
<tr><td><b>Discipline name</b></td>
  <td>{$cm['discipline_en']}</td></tr>
<tr><td><b>Nom du département</b></td>
  <td>{$cm['departement']}</td></tr>
<tr><td><b>Department name</b></td>
  <td>{$cm['departement_en']}</td></tr>
<tr><td><b>Nom du parcours</b></td>
  <td>{$cm['parcours']}</td></tr>
<tr><td><b>Stream name</b></td>
  <td>{$cm['parcours_en']}</td></tr>
<tr><td><b>Nom de la licence</b></td>
  <td>{$cm['licence']}</td></tr>
<tr><td><b>Licence name</b></td>
  <td>{$cm['licence_en']}</td></tr>
<tr><td><b>Niveau / Level</b></td>
  <td>{$cm['niveau']}</td></tr>

<tr><td colspan='2' style='padding-top:20px;'><b><u>Cours magistral / Lecture course </u></b></td></tr>
<tr><td style='padding-left:30px;'><b>Nom du cours<b></b></td>
  <td>{$cm['nom']}</td></tr>
<tr><td style='padding-left:30px;'><b>Course Title</b></td>
  <td>{$cm['nom_en']}</td></tr>
<tr><td style='padding-left:30px;'><b>Code du cours / Course code</b></td>
  <td><b>{$cm['code']}</b></td></tr>
<tr><td style='padding-left:30px;'><b>Instructeur (Nom, Prénom) / Instructor (Lastname, Firstname)</b></td>
  <td>{$cm['prof']}</td></tr>
<tr><td style='padding-left:30px;'><b>Email</b></td>
  <td><a href='mailto:{$cm['email']}'>{$cm['email']}</a></td></tr>

<tr><td colspan='2' style='padding-top:20px;'><b><u>TD / Discussion Section</u></b></td></tr>
<tr><td style='padding-left:30px;'><b>Nom du TD<b></b></td>
  <td><input type='text' name='nom' value='{$td['nom']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td style='padding-left:30px;'><b>Discussion Section</b></td>
  <td><input type='text' name='nom_en' value='{$td['nom_en']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td style='padding-left:30px;'><b>Code du TD / Discussion section code</b></td>
  <td><b>{$td['code']}</b></td></tr>
<tr><td style='padding-left:30px;'><b>Instructeur (Nom, Prénom) / Instructor (Lastname, Firstname)</b></td>
  <td><input type='text' name='prof' value='{$td['prof']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td style='padding-left:30px;'><b>Email</b></td>
  <td><input type='text' name='email' value='{$td['email']}' onkeyup='js_autocomplete(this);' /></td></tr>
<tr><td style='padding-left:30px;'><b>Horaires</b></td>
  <td><select name='jour1' style='width:30%;'>
    <option value=''>Jour</option>
EOD;
    foreach($jours as $jour){
      $jourSelect=$td['jour1']==$jour[0]?"selected='selected'":null;
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
	$jourSelect=$td['debut1']==$h1?"selected='selected'":null;
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
	$jourSelect=$td['fin1']==$h1?"selected='selected'":null;
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
      $jourSelect=$td['jour2']==$jour[0]?"selected='selected'":null;
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
	$jourSelect=$td['debut2']==$h1?"selected='selected'":null;
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
	$jourSelect=$td['fin2']==$h1?"selected='selected'":null;
	echo "<option value='$h1' $jourSelect >à $h2</option>\n";
      }
    }
    echo <<<EOD
    </select></td>
  </tr>


<tr><td colspan='2' style='text-align:center;padding-top:10px;'>
<input type='button' value='Cancel' style='margin-right:30px;'onclick='history.back();' />
<input type='submit' value='$submit' $submitDisabled/></td></tr>

</table>
</form>
</fieldset>
EOD;

require_once "../footer.php";
?>