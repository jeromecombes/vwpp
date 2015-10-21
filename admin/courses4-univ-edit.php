<?php
// Last update : 2015-10-21

require_once "../header.php";
require_once "menu.php";
require_once "../inc/class.univ4.inc";

access_ctrl(23);

$admin=$_SESSION['vwpp']['category']=="admin"?1:0;	// Droit en lecture
$admin2=in_array(16,$_SESSION['vwpp']['access']);	// Droits lecture et modification
$action="courses4-univ-update.php";
$displayLock=$admin?null:"style='display:none;'";
$deleteURL="courses4-univ-delete.php";

$semester=$_SESSION['vwpp']['semester'];
$hoursStart=8;
$hoursEnd=20;
$days=array(1=>array(1,"Lundi"),2=>array(2,"Mardi"),3=>array(3,"Mercredi"),4=>array(4,"Jeudi"),
	    5=>array(5,"Vendredi"),6=>array(6,"Samedi"),7=>array(7,"Dimanche"));


//		Get data (selected courses) from courses_univ3 ; courses_cm ; courses_td
$u=new univ4();
$u->fetchAll();
$courses=$u->elements;
$u->fetch($_GET['id']);
$course=$u->elements;
$student=$course['student'];

echo "<div id='course4'>\n";


//			LIST OF SELECTED COURSES
  $checked[0]=$course['note']==1?"checked='checked'":null;
  $checked[1]=$course['note']==0?"checked='checked'":null;
  $checked[2]=$course['modalites']=="Oui"?"checked='checked'":null;
  $checked[3]=$course['modalites']=="Non"?"checked='checked'":null;
  $institution=$course['institution']=="Autre"?$course['institutionAutre']:$course['institution'];
  $disabled=!empty($course['lien'])?"disabled='disabled'":null;


  $coursesForLink=array();
  foreach($courses as $elem){
    if(!$elem['lien']){
      $coursesForLink[]=$elem;
    }
  }
  unset($coursesForLink[$course['id']]);

//			COURSES SHOW
  $margin1=$course['lien']?50:0;
  $margin2=$course['lien']?0:50;
  
  echo <<<EOD
    <fieldset id='UnivCourse{$course['id']}' style='margin-left:{$margin1}px;'>
    <form name='UnivCourseFormModalites{$course['id']}' method='post' action='$action'>
    <input type='hidden' name='student' value='$student' />
    <input type='hidden' name='semester' value='$semester' />
    <input type='hidden' name='id' value='{$course['id']}' />
    <input type='hidden' name='modalitesOnly' value='{$course['id']}' />
    <table style='margin-left:{$margin2}px;width:905px;'>

    <tr><td>Code</td>
      <td class='response'>{$course['code']}</td></tr>

    <tr><td>Nom du cours</td>
      <td class='response'>{$course['nom']}</td></tr>

    <tr><td>Nature du cours</td>
      <td class='response'>{$course['nature']}</td></tr>
EOD;
    if($course['lien']){
      foreach($courses as $elem){
	if($course['lien']==$elem['id']){
	  $lien="{$elem['nom']}, {$elem['prof']} ({$elem['nature']})";
	}
      }
      echo "<tr><td style='padding-top:20px;'>Ce cours est rattaché au cours suivant :</td>\n";
      echo "<td style='padding-top:20px;'class='response'>$lien</td></tr>\n";
    }

    if(!$course['lien']){
    echo <<<EOD
    <tr><td style='padding-top:20px;'>Institution</td>
      <td style='padding-top:20px;' class='response'>$institution</td></tr>

    <tr><td>Discipline</td>
      <td class='response'>{$course['discipline']}</td></tr>

    <tr><td>Niveau</td>
      <td class='response'>{$course['niveau']}</td></tr>
EOD;
    }
    echo <<<EOD
    <tr><td style='padding-top:20px;'>Professeur (Nom, Prénom)</td>
      <td style='padding-top:20px;' class='response'>{$course['prof']}</td></tr>

    <tr><td>E-mail</td>
      <td class='response'>{$course['email']}</td></tr>

    <tr><td>Horaires</td>
      <td class='response'>{$days[$course['jour']][1]} {$course['debut']} {$course['fin']}</td></tr>

    <tr><td style='padding-top:20px;'>Aurez-vous une note pour ce cours ?</td>
      <td style='padding-top:20px;' class='response'>{$course['note2']}</td></tr>

    <tr><td colspan='2' style='padding-top:20px;'>Avez-vous discuté des modalités du devoir final avec votre professeur ?</td></tr>
    <tr id='modalites0_{$course['id']}'><td>&nbsp;</td>
      <td class='response'>{$course['modalites']}</td></tr>

    <tr id='modalitesRadio{$course['id']}' style='display:none;'><td>&nbsp;</td>
      <td><input type='radio' name='modalites' value='Oui' {$checked[2]} /> Oui
      <input type='radio' name='modalites' value='Non' {$checked[3]} /> Non</td></tr>


    <tr><td colspan='2'>Si oui, quelles sont-elles ?</td></tr>

    <tr id='modalitesText{$course['id']}'><td colspan='2' class='response'>{$course['modalites1Text']}</td></tr>

    <tr id='modalitesTextarea{$course['id']}' style='display:none;'>
      <td colspan='2'><textarea name='modalites1'>{$course['modalites1']}</textarea></td></tr>

    <tr><td colspan='2' style='font-size:9pt;'>Champ réservé aux administrateurs</td></tr>
    <tr><td colspan='2' class='response'>{$course['modalites2Text']}</td></tr>

EOD;
    if($admin or !$course['lock']){
      echo "<tr><td colspan='2' style='padding-top:20px;text-align:right;'>\n";
      echo "<input type='button' value='Retour' onclick='location.href=\"courses4.php\";' class='myUI-button-right' />\n";
      if($admin2){
	echo "<input type='button' value='Modifier' onclick='editCourse({$course['id']},true);' class='myUI-button-right' />\n";
      }

      if(!$course['liaison'] and $admin2){
	echo "<input type='button' value='Supprimer' onclick='dropCourse2({$course['id']},$admin);' class='myUI-button-right' />\n";
      }
      if($admin2){
	$lockButton=$course['lock']?"D&eacute;verrouiller":"Verrouiller";
	echo "<input type='button' value='$lockButton' id='lock{$course['id']}' onclick='lockCourse4({$course['id']});' class='myUI-button-right' />\n";
      }
      echo "</td></tr>\n";
    }
    if(!$admin and $course['lock']){
      echo "<tr><td colspan='2' style='padding-top:20px;text-align:right;'>\n";
      echo "<input type='button' value='Modifier' id='modalitesUpdate{$course['id']}' onclick='editModalites({$course['id']},true);' class='myUI-button-right' />\n";
      echo "<input type='reset' value='Annuler' style='display:none;' id='modalitesReset{$course['id']}' onclick='editModalites({$course['id']},false);' class='myUI-button-right' />\n";
      echo "<input type='submit' value='Valider' style='display:none;' id='modalitesSubmit{$course['id']}' class='myUI-button-right' />\n";
      echo "</td></tr>\n";
    }

echo <<<EOD
    </table>
    </form>
    </fieldset>
EOD;
//			END OF COURSES SHOW


//			COURSES EDIT
  echo <<<EOD


    <fieldset id='UnivCourseEdit{$course['id']}' style='display:none;margin-left:{$margin1}px;'>
    <form name='UnivCourseForm{$course['id']}' method='post' action='$action'>
    <input type='hidden' name='student' value='$student' />
    <input type='hidden' name='semester' value='$semester' />
    <input type='hidden' name='id' value='{$course['id']}' />

    <table style='margin-left:{$margin2}px;width:905px;'>

    <tr><td>Code</td>
      <td><input type='text' name='code' value='{$course['code']}'/></td></tr>

    <tr><td>Nom du cours</td>
      <td><input type='text' name='nom'  value='{$course['nom']}'/></td></tr>

    <tr><td>Nature du cours</td>
      <td><select name='nature'>
      <option value=''>&nbsp;</option>
EOD;
      foreach($GLOBALS['config']['univCoursNature'] as $elem){
	$selected=$elem==$course['nature']?"selected='selected'":null;
	echo "<option value='{$elem}' $selected >{$elem}</option>\n";
      }
      echo "</select></td></tr>\n";

    if(!empty($coursesForLink) and !$course['liaison']){
      echo <<<EOD
      <tr><td style='padding-top:20px;'>Si ce cours est rattaché à un autre cours déjà enregistré,<br/>
	veuillez le sélectionner dans cette liste</td>
      <td style='padding-top:20px;'><select name='lien' onchange='checkLink(this,$admin,{$course['id']});'>
	<option value=''>&nbsp;</option>
EOD;
	foreach($coursesForLink as $elem){
	  if(!$elem['lien']){
	    $selected=$elem['id']==$course['lien']?"selected='selected'":null;
	    echo "<option value='{$elem['id']}' $selected >{$elem['nom']} {$elem['prof']}</option>\n";
	  }
	}
	echo "</select></td></tr>\n";
    }

    echo <<<EOD
    <tr><td style='padding-top:20px;'>Institution</td>
      <td style='padding-top:20px;'>
      <select name='institution' id='institution{$course['id']}' onchange='checkInstitution(this,{$course['id']});' $disabled>
      <option value=''>&nbsp;</option>
EOD;
      foreach($GLOBALS['config']['institutions'] as $elem){
	$selected=htmlentities($elem,ENT_QUOTES|ENT_IGNORE,"utf-8")==$course['institution']?"selected='selected'":null;
	echo "<option value='$elem' $selected >$elem</option>\n";
      }
      $selected="Autre"==$course['institution']?"selected='selected'":null;
      echo "<option value='Autre' $selected >Autre (Précisez)</option>\n";
      echo "</select></td></tr>\n";

    $displayOther=$course['institution']=="Autre"?null:"style='display:none;'";
    echo <<<EOD
    <tr id='institutionAutreTr{$course['id']}' $displayOther ><td>Autre institution</td>
      <td><input type='text' name='institutionAutre' id='institutionAutre{$course['id']}' value='{$course['institutionAutre']}' $disabled/></td></tr>

    <tr><td>Discipline</td>
      <td>
      <select name='discipline' $disabled id='discipline{$course['id']}'>
      <option value=''>&nbsp;</option>
EOD;
      foreach($GLOBALS['config']['disciplines'] as $elem){
	$selected=htmlentities($elem,ENT_QUOTES|ENT_IGNORE,"utf-8")==$course['discipline']?"selected='selected'":null;
	echo "<option value='$elem' $selected >$elem</option>\n";
      }
      echo "</select></td></tr>\n";

    echo <<<EOD
    <tr><td>Niveau</td>
      <td><select name='niveau' $disabled id='niveau{$course['id']}'>
      <option value=''>&nbsp;</option>
EOD;
      foreach($GLOBALS['config']['niveaux'] as $elem){
	$selected=$elem==$course['niveau']?"selected='selected'":null;
	echo "<option value='$elem' $selected >$elem</option>\n";
      }
      echo "</select></td></tr>\n";

    echo <<<EOD

    <tr><td style='padding-top:20px;'>Professeur (Nom, Prénom)</td>
      <td style='padding-top:20px;'><input type='text' name='prof' value='{$course['prof']}' /></td></tr>

    <tr><td>E-mail</td>
      <td><input type='text' name='email' value='{$course['email']}' /></td></tr>

    <tr><td>Horaires</td>
      <td>
      <select name='jour' style='width:31%;'>
	<option value=''>Jour</option>
EOD;
	foreach($days as $day){
	  $selected=$day[0]==$course['jour']?"selected='selected'":null;
	  echo "<option value='{$day[0]}' $selected >{$day[1]}</option>\n";
	}
	echo <<<EOD
	</select>
      <select name='debut' style='width:33%;'>
	<option value=''>Début</option>
EOD;
	for($i=$hoursStart;$i<$hoursEnd+1;$i++){
	  for($j=0;$j<60;$j=$j+15){
	    $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
	    $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
	    $selected=$h1==$course['debut']?"selected='selected'":null;
	    echo "<option value='$h1' $selected>de $h2</option>\n";
	  }
	}
	echo <<<EOD
	</select>
      <select name='fin' style='width:33%;'>
	<option value=''>Fin</option>
EOD;
	for($i=$hoursStart;$i<$hoursEnd+1;$i++){
	  for($j=0;$j<60;$j=$j+15){
	    $h1=sprintf("%02d",$i).":".sprintf("%02d",$j);
	    $h2=sprintf("%02d",$i)."h".sprintf("%02d",$j);
	    $selected=$h1==$course['fin']?"selected='selected'":null;
	    echo "<option value='$h1' $selected >à $h2</option>\n";
	  }
	}
	echo <<<EOD
	</select>
      </td></tr>

    <tr><td style='padding-top:20px;'>Aurez-vous une note pour ce cours ?</td>
      <td style='padding-top:20px;'><input type='radio' name='note' value='1' {$checked[0]} /> Oui
	<input type='radio' name='note' value='0' {$checked[1]} /> Non</td></tr>

    <tr><td colspan='2' style='padding-top:20px;'>Avez-vous discuté des modalités du devoir final avec votre professeur ?</td></tr>
    <tr><td>&nbsp;</td>
      <td><input type='radio' name='modalites' value='Oui' {$checked[2]} /> Oui
	<input type='radio' name='modalites' value='Non' {$checked[3]} /> Non</td></tr>

    <tr><td colspan='2'>Si oui, quelles sont-elles ?</td></tr>
    <tr><td colspan='2'><textarea name='modalites1'>{$course['modalites1']}</textarea></td></tr>
EOD;
    if($admin){
      echo "<tr><td colspan='2' style='font-size:9pt;'>Champ réservé aux administrateurs</td></tr>\n";
      echo "<tr><td colspan='2'><textarea name='modalites2'>{$course['modalites2']}</textarea></td></tr>\n";
    }

    echo <<<EOD
    <tr><td colspan='2' style='text-align:right;'>
      <input type='reset' value='Annuler' onclick='editCourse({$course['id']},false);' class='myUI-button-right' />
      <input type='submit' value='Valider' class='myUI-button-right' /></td></tr>

    </table>
    </form>
    </fieldset>
    <br/>
EOD;
//			END OF COURSES EDIT
//			END OF LIST OF SELECTED COURSES


echo "</div>\n";

require_once "../footer.php";
?>