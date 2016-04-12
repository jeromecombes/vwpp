<?php
// Last update : 2016-04-12

require_once "../header.php";
require_once "../inc/class.univ_reg.inc";
require_once "menu.php";

access_ctrl(17);

$u=new univ_reg();
$u->fetchAll($_SESSION['vwpp']['login_univ']);
$tab=$u->elements;

usort($tab,"cmp_lastname");

$title=array("Lastname","Firstname","Major 1","Minor 1","Major 2","Minor 2","Paris 3","Paris 4","Paris 7","Paris 12",
  "CIPh","Justification","Motivated by the calendar","Final Reg.","Diplome","Obtention","Pays","Ville","Etat","Etudes actuelles",
  "Faculté","Début des études","Domaine","Discipline voulue","Handicap","Handicap, précisez");
$max=count($title);

echo "<h3>University Registration, {$_SESSION['vwpp']['semester']}</h3>\n";
echo "<input type='button' onclick='location.href=\"univ_reg_export.php\";' value='Export to excel' class='myUI-button'/>\n";
echo "<br/><br/>\n";
echo "<table class='datatable'>\n";
echo "<thead>\n";
echo "<tr>\n";
foreach($title as $elem)
  echo "<th>$elem</th>";
echo "</tr>\n";
echo "</thead>\n";
echo "<tbody>\n";
foreach($tab as $elem){
  echo "<tr><td>{$elem['lastname']}</td><td>{$elem['firstname']}</td>";
  $nb=2;
  //foreach($elem[0] as $elem2){ 	//	Univ. Reg 1
  for($i=1;$i<8;$i++){
    $div="<div style='height:50px;max-height:50px;overflow:hidden' title='{$elem[0][$i]}'>{$elem[0][$i]}</div>\n";
    echo "<td>$div</td>\n";
    $nb++;
  }
  $div="<div style='height:50px;max-height:50px;overflow:hidden' title='{$elem[0][12]}'>{$elem[0][12]}</div>\n";
  echo "<td>$div</td>\n";
  $nb++;
  $div="<div style='height:50px;max-height:50px;overflow:hidden' title='{$elem[0][8]}'>{$elem[0][8]}</div>\n";
  echo "<td>$div</td>\n";
  $nb++;
/*
// IEP
  $div="<div style='height:50px;max-height:50px;overflow:hidden' title='{$elem[0][10]}'>{$elem[0][10]}</div>\n";
  echo "<td>$div</td>\n";
  $nb++;
  */
  $div="<div style='height:50px;max-height:50px;overflow:hidden' title='{$elem[0][9]}'>{$elem[0][9]}</div>\n";
  echo "<td>$div</td>\n";
  $nb++;
  $div="<div style='height:50px;max-height:50px;overflow:hidden' title='{$elem[0][11]}'>{$elem[0][11]}</div>\n";
  echo "<td>$div</td>\n";
  $nb++;

  $div="<div style='height:50px;max-height:50px;overflow:hidden' title='{$elem[2]}'>{$elem[2]}</div>\n";
  echo "<td>$div</td>\n";
  $nb++;
  foreach($elem[1] as $elem2){  	//	Univ. Reg 2
		// Si le nombre de cellules par ligne est différent du nombre de cellule dans l'entête : erreur dataTable.
		// Les 3 lignes suivantes permettent d'éviter ceci
    if($nb==$max){
      continue 2;
    }
    $div="<div style='height:50px;max-height:50px;overflow:hidden' title='{$elem2}'>{$elem2}</div>\n";
    echo "<td>$div</td>\n";
    $nb++;
  }
	// Si le nombre de cellules par ligne est différent du nombre de cellule dans l'entête : erreur dataTable.
	// Les 4 lignes suivantes permettent d'éviter ceci
	while($nb<$max){
		echo "<td>&nbsp;</td>\n";
		$nb++;
	}

  echo "</tr>\n";
}
echo "</tbody>\n";
echo "</table>\n";


require_once "../footer.php";
?>
