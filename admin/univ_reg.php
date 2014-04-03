<?php
require_once "../header.php";
require_once "../inc/class.univ_reg.inc";
require_once "menu.php";

access_ctrl(17);

$u=new univ_reg();
$u->fetchAll($_SESSION['vwpp']['login_univ']);
$tab=$u->elements;

usort($tab,cmp_lastname);

$title=array("Lastname","Firstname","Major 1","Minor 1","Major 2","Minor 2","Paris 3","Paris 4","Paris 7",
  "CIPh","IEP","Justification","Motivated by the calendar","Final Reg.","Diplome","Obtention","Pays","Ville","Etat","Etudes actuelles",
  "Faculté","Début des études","Domaine","Discipline voulue","Handicap","Handicap, précisez");
echo "<h3>University Registration, {$_SESSION['vwpp']['semester']}</h3>\n";
echo "<input type='button' onclick='location.href=\"univ_reg_export.php\";' value='Export to excel'/><br/><br/>\n";
echo "<table cellspacing='0' id='myTab'>\n";
echo "<tr class='th'>\n";
foreach($title as $elem)
  echo "<td>$elem</td>";
echo "</tr>\n";
foreach($tab as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'><td>{$elem['lastname']}</td><td>{$elem['firstname']}</td>";
  foreach($elem[0] as $elem2) 	//	Univ. Reg 1
    echo "<td>$elem2</td>\n";
  echo "<td>{$elem[2]}</td>\n"; //	Univ. Reg 3 (University)
  foreach($elem[1] as $elem2)  	//	Univ. Reg 2
    echo "<td>$elem2</td>\n";
  echo "</tr>\n";
}
echo "</table>\n";


require_once "../footer.php";
?>
