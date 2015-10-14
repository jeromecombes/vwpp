<?php
// Last update : 2015-10-14

require_once "../header.php";
require_once "../inc/class.housing.inc";
require_once "menu.php";
access_ctrl(2);

$l=new housing();
$l->getLogement($_GET['id']);
$logement=$l->logement;
$submit=$logement['id']?"Sauvegarder":"Ajouter";

$_SESSION['vwpp']['logement_id']=$logement['id'];	// Used in housing-delete.php

$fields=array();
$fields[]=array("lastname","Nom","lastname2","Nom 2");
$fields[]=array("firstname","Prénom","firstname2","Prénom 2");
$fields[]=array("address","Adresse");
$fields[]=array("zipcode","Code Postal");
$fields[]=array("city","Ville");
$fields[]=array("phonenumber","Téléphone");
$fields[]=array("cellphone","Portable","cellphone2","Portable 2");
$fields[]=array("email","E-mail","email2","E-mail 2");
?>
<h3>Housing - <?php echo $_SESSION['vwpp']['semester']; ?></h3>
<a href='housing.php'>Housing Home</a> > <a href='housing-list.php'>Liste des logements</a>
<br/><br/>

<form method='post' action='housing-update.php' name='form_1'>
<input type='hidden' name='logement[id]' value='<?php echo $logement['id']; ?>' />
<fieldset>
<table class='myTab'>

<?php
$i=0;
foreach($fields as $elem){
  echo "<tr><td>{$elem[1]}</td>\n";
  echo "<td style='width:300px;'><input type='text' name='logement[{$elem[0]}]' value='{$logement[$elem[0]]}' style='display:none;' tabindex='1$i'/>\n";
  echo "<font id='form_1_$i'>{$logement[$elem[0]]}</font></td>\n";
  $i++;
  if(array_key_exists(2,$elem)){
    echo "<td>{$elem[3]}</td>\n";
    echo "<td style='width:300px;'><input type='text' name='logement[{$elem[2]}]' value='{$logement[$elem[2]]}' style='display:none;' tabindex='100$i'/>\n";
    echo "<font id='form_1_$i'>{$logement[$elem[2]]}</font></td>\n";
    $i++;
  }
  echo "</tr>\n";
}

echo "<tr><td colspan='4' style='padding-top:20px;'>Etudiant(e) attribué(e) : {$logement["studentName"]}</td></tr>";
?>

<tr><td colspan='4' style='text-align:right;padding-top:20px;'>
<input type='button' value='Retour' onclick='document.location.href="housing-list.php";' id='form_1_<?php echo $i++; ?>' class='myUI-button-right' />

<?php
if(in_array(7,$_SESSION['vwpp']['access'])){
  echo "<input type='button' value='Supprimer' onclick='if(confirm(\"Etes-vous sûr(e) de vouloir supprimer ce logement ?\")) location.href=\"housing-delete.php\";' id='form_1_$i' class='myUI-button-right' />\n";
  $i++;
  echo "<input type='button' value='Modifier' onclick='displayForm(\"form\",1);' id='form_1_$i' class='myUI-button-right' />\n";
  $i++;
}
?>
<input type='button' value='Annuler' onclick='document.location.reload(false);' style='display:none;' class='myUI-button-right' />
<input type='submit' value='<?php echo $submit; ?>' style='display:none;'  class='myUI-button-right' />
</table>
</fieldset>
</form>

<?php
if(!$logement['id'] and !$_GET['msg'])
  echo "<script type='text/JavaScript'>displayForm('form',1);</script>\n";

require_once "../footer.php";
?>
