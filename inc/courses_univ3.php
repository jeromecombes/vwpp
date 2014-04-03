<?php
require_once "class.univ.inc";
require_once "class.univ3.inc";
/*	Needed :
$student (int)
$semster (varchar)
$isForm (boolean)
*/


//		faire CtrlAddTD		pour empecher validation par la touche ENTER lors de la recherche du TD

$displayForm=$isForm?null:"style='display:none;'";
$displayText=$isForm?"style='display:none;'":null;
$displayEdit=$isForm?"style='display:none;'":null;
$admin=$_SESSION['vwpp']['category']=="admin"?1:0;
$action=$admin?"../inc/courses_univ3Update.php":"inc/courses_univ3Update.php";
$displayLock=$admin?null:"style='display:none;'";
$deleteURL=$admin?"../inc/courses_univ3Delete.php":"inc/courses_univ3Delete.php";

$hoursStart=8;
$hoursEnd=20;
$days=array("Lundi","Mardi","Mercredi","Jeudi","Vendredi");


//		Get data (selected courses) from courses_univ3 ; courses_cm ; courses_td
$u=new univ3();
$u->fetchAll();
$courses=$u->elements;

//	Display Selected Courses
foreach($courses as $course){
  $univ=$course['cm']['university'];
  $course['cm']['university']=str_replace("UP","Universit&eacute; Paris ",$course['cm']['university']);
  $course['td']['university']=str_replace("UP","Universit&eacute; Paris ",$course['td']['university']);
  $course['cm']['niveau']=str_replace(array("L1","L2","L3","M1","M2"),array("Licence 1","Licence 2","Licence 3","Master 1","Master 2"),$course['cm']['niveau']);
  $course['td']['niveau']=str_replace(array("L1","L2","L3","M1","M2"),array("Licence 1","Licence 2","Licence 3","Master 1","Master 2"),$course['td']['niveau']);
  
  $displayTD=$course['td']['code']?"":"style='display:none;'";

  $lockCM=$course['cm']['lock'];
  $lockTD=$course['td']['lock'];
// var_dump($course['td']);


//	Lecture Course Info (CM)
  echo <<<EOD
  <form name='AddTd_{$course['cm']['id']}' action='$action' method='post' onsubmit='return ctrlAddTD(this);'>
  <div class='fieldset'>
  <table border='0' style='width:1140px;'>
  <tr><td style='width:300px;'>University</td>
  <td><b>{$course['cm']['university']}</b></td></tr>
  <tr><td>UFR</td>
  <td style='width:400px;'>{$course['cm']['ufr']}</td>
  <td>{$course['cm']['ufr_en']}</td>
  </tr>
  <tr><td>Parcours</td>
  <td>{$course['cm']['parcours']}</td>
  <td>{$course['cm']['parcours_en']}</td>
  </tr>
  <tr><td>Discipline</td>
  <td>{$course['cm']['discipline']}</td>
  <td>{$course['cm']['discipline_en']}</td>
  </tr>
  <tr><td>Departement</td>
  <td>{$course['cm']['departement']}</td>
  <td>{$course['cm']['departement_en']}</td>
  </tr>
  <tr><td>Licence</td>
  <td>{$course['cm']['licence']}</td>
  <td>{$course['cm']['licence_en']}</td>
  </tr>
  <tr><td>Niveau</td>
  <td>{$course['cm']['niveau']}</td></tr>
  <tr><td>Crédits</td>
  <td>{$course['cm']['credits']}</td></tr>

  <tr><td style='padding-top:10px;'><b><u>Cours Magistral</u></b></td></tr>
  <tr><td style='padding-left:30px;'>Code</td>
  <td><b>{$course['cm']['code']}</b></td></tr>
  <tr><td style='padding-left:30px;'>Nom du cours</td>
  <td>{$course['cm']['nom']}</td></tr>
  <tr><td style='padding-left:30px;'>Professeur (Nom, Prénom)</td></td>
  <td>{$course['cm']['prof']}</td>
  <td><a href='mailto:{$course['cm']['email']}'>{$course['cm']['email']}</a></tr>
  <tr><td style='padding-left:30px;'>Horaires</td>
    <td>{$course['cm']['horaires1']}</td></tr>
  <tr><td>&nbsp;</td>
    <td>{$course['cm']['horaires2']}</td></tr>
EOD;
  
//	Discussion Course Info (TD, Form)
    echo <<<EOD
  <tr style='display:none;' id='TD_{$course['cm']['id']}_5' >
    <td style='padding-top:10px;' colspan='3'>
      <a name='TD1_{$course['cm']['id']}'><br/></a>
      <u><b>Ajout d'un TD</b></u><br/><br/>
      <b>Etape 1. Entrez le code du cours de TD</b><br/><br/></td></tr>
  <tr style='display:none;' id='TD_{$course['cm']['id']}_6' ><td style='padding-left:30px;'>Code du cours de TD</td>
    <td><input type='text' name='td_code' id='TD_{$course['cm']['id']}_code' autocomplete='off' />
	<input type='hidden' id='TD_{$course['cm']['id']}_univ' value='$univ' /></td>
    <td><input type='button' value='Suivant' onclick='getTDInfo({$course['cm']['id']},$admin);'/></td></tr>

  <tr style='display:none;' id='TD_{$course['cm']['id']}_7' >
    <td style='padding-top:10px;' colspan='3'>
      <a name='TD2_{$course['cm']['id']}'><br/></a>
      <b>Etape 2. Veuillez compléter les informations suivantes</b></td></tr>
  <tr style='display:none;' id='TD_{$course['cm']['id']}_8' ><td style='padding-left:30px;'>Code</td>
    <td><b><div id='TD_{$course['cm']['id']}_9'>&nbsp;</div></b>
    <input type='hidden' name='code' id='TD_{$course['cm']['id']}_10' />
    <input type='hidden' name='university' id='TD_{$course['cm']['id']}_11' />
    <input type='hidden' name='action' value='addNewTD' /></td></tr>
    <input type='hidden' name='cm_id' value='{$course['cm']['id']}' /></td></tr>
  <tr style='display:none;' id='TD_{$course['cm']['id']}_12' ><td style='padding-left:30px;'>Nom du TD</td>
    <td><input type='text' name='nom' /></td></tr>
  <tr style='display:none;' id='TD_{$course['cm']['id']}_13' ><td style='padding-left:30px;'>Professeur (Nom, Prénom)</td>
    <td><input type='text' name='prof' /></td></tr>
  <tr style='display:none;' id='TD_{$course['cm']['id']}_14' ><td style='padding-left:30px;'>Email du professeur</td>
    <td><input type='text' name='email' /></td></tr>

  <tr style=display:none;' id='TD_{$course['cm']['id']}_15'>
    <td style='padding-left:30px;'>Horaires</td>
    <td colspan='2'>
    <select name='jour1' style='width:30%;'>
      <option value=''>Jour</option>
      <option value='1'>Lundi</option>
      <option value='2'>Mardi</option>
      <option value='3'>Mercredi</option>
      <option value='4'>Jeudi</option>
      <option value='5'>Vendredi</option>
      <option value='6'>Samedi</option>
      <option value='7'>Dimanche</option>
      </select>
    <select name='debut1' style='width:30%;'>
      <option value=''>Début</option>
EOD;
      for($i=$hoursStart;$i<$hoursEnd+1;$i++){
	for($j=0;$j<60;$j=$j+15){
	  $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
	  $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
	  echo "<option value='$h1'>de $h2</option>\n";
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
	  echo "<option value='$h1'>à $h2</option>\n";
	}
      }
      echo <<<EOD
      </select>
    </td></tr>

  <tr style=display:none;' id='TD_{$course['cm']['id']}_16'><td>&nbsp;</td>
    <td colspan='2'>
    <select name='jour2' style='width:30%;'>
      <option value=''>Jour</option>
      <option value='1'>Lundi</option>
      <option value='2'>Mardi</option>
      <option value='3'>Mercredi</option>
      <option value='4'>Jeudi</option>
      <option value='5'>Vendredi</option>
      <option value='6'>Samedi</option>
      <option value='7'>Dimanche</option>
      </select>
    <select name='debut2' style='width:30%;'>
      <option value=''>Début</option>
EOD;
      for($i=$hoursStart;$i<$hoursEnd+1;$i++){
	for($j=0;$j<60;$j=$j+15){
	  $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
	  $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
	  echo "<option value='$h1'>de $h2</option>\n";
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
	  echo "<option value='$h1'>à $h2</option>\n";
	}
      }
      echo <<<EOD
      </select></td></tr>

  <tr style=display:none;' id='TD_{$course['cm']['id']}_17'><td><br/></td>
    <td><br/><input type='submit' value='Valider' /></td></tr>
EOD;


//	Discussion Course Info (TD, Display)
    echo <<<EOD
  <tr style='display:none;' id='TD_{$course['cm']['id']}_18' ><td colspan='2'>
    <a name='TD3_{$course['cm']['id']}'><br/><br/></a>
    <b>Etape 2. Veuillez vérifier les informations suivantes</b><br/>
    Si elles correspondent parfaitement au TD souhaité, cliquez sur "Valider".<br/></td></tr>
  <tr $displayTD id='TD_{$course['cm']['id']}_1' ><td style='padding-top:10px;'><b><u>Cours de TD</u></b></td></tr>
  <tr $displayTD id='TD_{$course['cm']['id']}_2' ><td style='padding-left:30px;'>Code</td>
    <td><b><div id='TD_{$course['cm']['id']}_19'>{$course['td']['code']}</div></b></td></tr>
  <tr $displayTD id='TD_{$course['cm']['id']}_3' ><td style='padding-left:30px;'>Nom du TD</td>
    <td><div id='TD_{$course['cm']['id']}_20'>{$course['td']['nom']}</div></td></tr>
  <tr $displayTD id='TD_{$course['cm']['id']}_4' ><td style='padding-left:30px;'>Professeur (Nom, Prénom)</td>
    <td><div id='TD_{$course['cm']['id']}_21'>{$course['td']['prof']}</div></td>
    <td><div id='TD_{$course['cm']['id']}_22'><a href='mailto:{$course['td']['email']}'>{$course['td']['email']}</a></div></td></tr>
  <tr $displayTD id='TD_{$course['cm']['id']}_23'>
    <td style='padding-left:30px;'>Horaires</td>
    <td><div id='TD_{$course['cm']['id']}_24'>{$course['td']['horaires1']}</div></td></tr>
  <tr $displayTD id='TD_{$course['cm']['id']}_25'>
    <td>&nbsp;</td>
    <td><div id='TD_{$course['cm']['id']}_26'>{$course['td']['horaires2']}</div></td></tr>
  <tr style='display:none;' id='TD_{$course['cm']['id']}_27'><td colspan='3' style='text-align:right;'>
    <input type='hidden' id='TD_{$course['cm']['id']}_28' value='' />
    <input type='button' value='Valider' onclick='addTD({$course['cm']['id']},$admin);'/></td></tr>

  <tr><td><br/></td></tr>
EOD;
  


//	Add TD and Delete Buttons
  echo "<tr><td colspan='3' style='text-align:right'>\n";
//	Add TD Button
  if(!$course['td']['code']){
    echo "<input type='button' value='Ajouter le TD' onclick='displayTD({$course['cm']['id']});' id='TD_{$course['cm']['id']}_Add' />\n";
  }
  else{
    if($admin or !$lockTD)
      echo "<input type='button' value='Supprimer le TD' onclick='if(confirm(\"Etes vous sûr(e) de vouloir supprimer ce TD ?\")) location.href=\"$deleteURL?td={$course['cm']['id']}\";'id='TD_{$course['cm']['id']}_Add' />\n";
  }
//	Faire Function displayTD id=TDx_id

//	Modif Button
  if($admin)
      echo "<input type='button' value='Modifier le CM' onclick='location.href=\"courses3-univ-edit.php?id={$course['cm']['id']}&back=students-view2.php\";' id='Modif_{$course['cm']['id']}' />\n";


//	Delete Button

  if($course['td']['code']){
    if($admin or (!$lockTD and !$lockCM))
      echo "<input type='button' value='Supprimer le CM et le TD' onclick='if(confirm(\"Etes vous sûr(e) de vouloir supprimer ce cours ?\")) location.href=\"$deleteURL?cm={$course['cm']['id']}\";' id='Delete_{$course['cm']['id']}' />\n";
  }
  else{
    if($admin or !$lockCM)
      echo "<input type='button' value='Supprimer le CM' onclick='if(confirm(\"Etes vous sûr(e) de vouloir supprimer ce cours ?\")) location.href=\"$deleteURL?cm={$course['cm']['id']}\";' id='Delete_{$course['cm']['id']}' />\n";
  }
//	Lock / Unlock Buttons
  $displayLockCM="style='display:none;'";
  $displayUnLockCM="style='display:none;'";
  $displayLockTD="style='display:none;'";
  $displayUnLockTD="style='display:none;'";

  if($admin){
    $displayLockCM=$lockCM?"style='display:none;'":null;
    $displayUnLockCM=$lockCM?null:"style='display:none;'";
    $displayLockTD=$lockTD?"style='display:none;'":null;
    $displayUnLockTD=$lockTD?null:"style='display:none;'";
  }

  echo <<<EOD
  <input type='button' value='Unlock Lecture' onclick='unLockCM({$course['cm']['id']})' id='unLockCM_{$course['cm']['id']}' $displayUnLockCM/>
  <input type='button' value='Lock Lecture' onclick='lockCM({$course['cm']['id']})' id='lockCM_{$course['cm']['id']}' $displayLockCM/>
  <input type='button' value='Unlock Discussion' onclick='unLockTD({$course['cm']['id']})' id='unLockTD_{$course['cm']['id']}' $displayUnLockTD/>
  <input type='button' value='Lock Discussion' onclick='lockTD({$course['cm']['id']})' id='lockTD_{$course['cm']['id']}' $displayLockTD/>
EOD;

  echo <<<EOD
    </td></tr>
  </table>
  </div>
  </form>
  <br/>


EOD;
}

echo <<<EOD

<!--		Form Find A Course 			-->

<div style='display:none;' id='fieldSetUniv' class='fieldset'>
<a name='CM'><br/></a>
<u><b>Ajout d'un cours à l'université</b></u><br/><br/>
<b>Etape 1. Sélectionnez l'université et entrez le code du cours magistral</b>
<br/><br/>
<form name='formCM' method='post' onsubmit='return getCMInfo($admin);'>
<table>
<tr><td style='width:300px;'>Université</td>
<td style='width:300px;'><select name='university' style='width:99%;'>
  <option value=''>&nbsp;</option>
  <option value='UP3'>Universit&eacute; Paris 3</option>
  <option value='UP4'>Universit&eacute; Paris 4</option>
  <option value='UP7'>Universit&eacute; Paris 7</option>
  <option value='IEP'>IEP</option>
</select></td>
<td>&nbsp;</td></tr>

<tr><td>Code du cours magistral</td>
<td><input type='text' name='code' autocomplete='off'/></td></tr>

<tr><td>&nbsp;</td><td><input type='submit' value='Suivant' /></td></tr>
</table>
</form>
</div>

<!--		Form Display The course if finded		-->

<div style='display:none;' id='fieldSetUniv2' class='fieldset'>
<b>Etape 2. Veuillez vérifier les informations ci-dessous.</b><br/>
Si elles correspondent parfaitement au cours souhaité, cliquez sur "Valider".<br/>
Sinon, recommencez l'étape 1.<br/><br/>

<form name='formCM2' action='$action' method='post'>
<input type='hidden' name='action' value='addCM' />
<input type='hidden' name='cm' />
<table>
<tr><td style=width:300px;'>Université</td>
<td style=width:300px;'><div id='CM2_university'></div></td></tr>
<tr><td>UFR</td>
<td><div id='CM2_ufr'></div></td>
<td><div id='CM2_ufr_en'></div></td></tr>
<tr><td>Parcours</td>
<td><div id='CM2_parcours'></div></td>
<td><div id='CM2_parcours_en'></div></td></tr>
<tr><td>Discipline</td>
<td><div id='CM2_discipline'></div></td>
<td><div id='CM2_discipline_en'></div></td></tr>
<tr><td>Département</td>
<td><div id='CM2_departement'></div></td>
<td><div id='CM2_departement_en'></div></td></tr>
<tr><td>Licence</td>
<td><div id='CM2_licence'></div></td>
<td><div id='CM2_licence_en'></div></td></tr>
<tr><td>Niveau</td>
<td><div id='CM2_niveau'></div></td></tr>
<tr><td>Crédits</td>
<td><div id='CM2_credits'></div></td></tr>

<tr><td style='padding-top:10px;'><b><u>Cours Magistral</u></b></td></tr>
<tr><td style='padding-left:30px;'>Code</td>
<td><div id='CM2_code'></div></td>
<tr><td style='padding-left:30px;'>Nom du cours</td>
<td><div id='CM2_nom'></div></td>
<td><div id='CM2_nom_en'></div></td></tr>
<tr><td style='padding-left:30px;'>Professeur (Nom, Prénom)</td>
<td><div id='CM2_prof'></div></td>
<td><div id='CM2_email'></div></td></tr>
<tr><td style='padding-left:30px;'>Horaires</td>
<td id='CM2_horaires1' style='display:none;'>Le <font id='CM2_jour1'></font> de <font id='CM2_debut1'></font> à <font id='CM2_fin1'></font></td></tr>
<tr><td>&nbsp;</td>
<td id='CM2_horaires2' style='display:none;'>Le <font id='CM2_jour2'></font> de <font id='CM2_debut2'></font> à <font id='CM2_fin2'></font></td></tr>
<tr><td><br/></td><td><br/><input type='submit' value='Valider' />
</table>
</form>
</div>


<!--			Form Add a new course			-->

<div style='display:none;' id='fieldSetUniv3' class='fieldset'>
<form name='formCM3' action='$action' method='post'>
<input type='hidden' name='action' value='addNewCourse' />
<input type='hidden' name='university' />
<input type='hidden' name='code' />

<a name='CM3'><br/></a>
<b>Etape 2. Veuillez compléter les informations suivantes</b>
<br/><br/>

<table>
<tr><td style='width:300px;'>Université</td>
  <td style='width:300px;'><b><div id='CM3_university'></div></b></td>
  <td>&nbsp;</td></tr>
<tr><td>UFR</td>
  <td><input type='text' name='ufr' /></td></tr>
<tr><td>Parcours</td>
  <td><input type='text' name='parcours' /></td></tr>
<tr><td>Discipline</td>
  <td><input type='text' name='discipline' /></td></tr>
<tr><td>Département</td>
  <td><input type='text' name='departement' /></td></tr>
<tr><td>Licence</td>
  <td><input type='text' name='licence' /></td></tr>
<tr><td>Niveau</td>
  <td><select name='niveau'>
    <option value=''>&nbsp;</option>
    <option value='Licence 1'>Licence 1</option>
    <option value='Licence 2'>Licence 2</option>
    <option value='Licence 3'>Licence 3</option>
    <option value='Master 1'>Master 1</option>
    <option value='Master 2'>Master 2</option>
    </select>
  </td></tr>
<tr><td>Crédits</td>
  <td><select name='credits'>
    <option value=''>&nbsp;</option>
    <option value='0.5'>0.5</option>
    <option value='1'>1</option>
    <option value='1.5'>1.5</option>
    <option value='2'>2</option>
    </select>
  </td></tr>

<tr><td style='padding-top:10px;'><b><u>Cours magistral</u></b></td></tr>
<tr><td style='padding-left:30px;'>Code</td>
  <td><b><div id='CM3_code'></div></b></td></tr>
<tr><td style='padding-left:30px;'>Nom du cours</td>
  <td><input type='text' name='nom' /></td></tr>
<tr><td style='padding-left:30px;'>Professeur (Nom, prénom)</td>
  <td><input type='text' name='prof' /></td></tr>
<tr><td style='padding-left:30px;'>Email</td>
  <td><input type='text' name='email' /></td></tr>
<tr><td style='padding-left:30px;'>Horaires</td>
  <td colspan='2'>
  <select name='jour1' style='width:30%;'>
    <option value=''>Jour</option>
    <option value='1'>Lundi</option>
    <option value='2'>Mardi</option>
    <option value='3'>Mercredi</option>
    <option value='4'>Jeudi</option>
    <option value='5'>Vendredi</option>
    <option value='6'>Samedi</option>
    <option value='7'>Dimanche</option>
    </select>
  <select name='debut1' style='width:30%;'>
    <option value=''>Début</option>
EOD;
    for($i=$hoursStart;$i<$hoursEnd+1;$i++){
      for($j=0;$j<60;$j=$j+15){
	$h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
	$h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
	echo "<option value='$h1'>de $h2</option>\n";
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
	echo "<option value='$h1'>à $h2</option>\n";
      }
    }
    echo <<<EOD
    </select>
  </td></tr>

<tr><td>&nbsp;</td>
  <td colspan='2'>
  <select name='jour2' style='width:30%;'>
    <option value=''>Jour</option>
    <option value='1'>Lundi</option>
    <option value='2'>Mardi</option>
    <option value='3'>Mercredi</option>
    <option value='4'>Jeudi</option>
    <option value='5'>Vendredi</option>
    <option value='6'>Samedi</option>
    <option value='7'>Dimanche</option>
    </select>
  <select name='debut2' style='width:30%;'>
    <option value=''>Début</option>
EOD;
    for($i=$hoursStart;$i<$hoursEnd+1;$i++){
      for($j=0;$j<60;$j=$j+15){
	$h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
	$h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
	echo "<option value='$h1'>de $h2</option>\n";
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
	echo "<option value='$h1'>à $h2</option>\n";
      }
    }
    echo <<<EOD
    </select>
  </td></tr>

<!-- <tr><td style='padding-top:10px;'><b><u>Cours de TD</u></b></td></tr>
<tr><td style='padding-left:30px;'>Code</td>
  <td><input type='text' name='td_code' /></td></tr>
<tr><td style='padding-left:30px;'>Nom du TD</td>
  <td><input type='text' name='td_nom' /></td></tr>
<tr><td style='padding-left:30px;'>Professeur (Nom, prénom)</td>
  <td><input type='text' name='td_prof' /></td></tr>
-->
<tr><td><br/></td>
  <td><br/><input type='submit' value='Valider' /></td></tr>

</table>
</form>
</div>

<div style='margin:10px 0 0 0;'>
<input type='button' onclick='this.style.display="none";displayAdd("Univ");document.location.href="#CM";' value="Ajouter un cours à l'université" />
</div>

EOD;
/*

exit;

$u=new univ();
$u->fetchAll();
foreach($u->elements as $elem){
  if($elem['student']==$student){
    $stdCourses[]=$elem;
  }
}

usort($stdCourses,cmp_univ);
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
*/