<?php
// Update : 2015-10-14
require_once "../inc/config.php";
require_once "../inc/class.univ_reg.inc";

access_ctrl(17);

$u=new univ_reg();
$u->fetchAll($_SESSION['vwpp']['login_univ']);
$u=$u->elements;

foreach($_POST['students'] as $elem){
  $tab[$elem]=$u[$elem];
  
}

usort($tab,"cmp_lastname");
$tab=array_map("entity_decode",$tab);
$tab=array_map("delete_rnt",$tab);


$Fnm = "../data/univ_reg_{$_SESSION['vwpp']['semestre']}";

if($_GET['type']=="csv"){
  $separate="';'";
  $Fnm.=".csv";
}
else{
  $separate="\t";
  $Fnm.=".xls";
}

$lines=Array();

$title=array("Lastname","Firstname","Major 1","Minor 1","Major 2","Minor 2","Paris 3","Paris 4","Paris 7",
  "CIPh","IEP","Justification","Final Reg.","Diplome","Obtention","Pays","Ville","Etat","Etudes actuelles",
  "Faculté","Début des études","Domaine","Discipline voulue","Handicap","Handicap, précisez");
$lines[]=join($title,$separate);


foreach($tab as $elem){
  $cells=array($elem['lastname'],$elem['firstname']);
  foreach($elem[0] as $elem2) 	//	Univ. Reg 1
    $cells[]=$elem2;
  $cells[]=$elem[2]; 		//	Univ. Reg 3 (University)
  foreach($elem[1] as $elem2)  	//	Univ. Reg 2
    $cells[]=$elem2;
  $lines[]=join($cells,$separate);
}

$inF = fopen($Fnm,"w");
foreach($lines as $elem){
  fputs($inF,$elem."\n");
}
fclose($inF);

header("Location: $Fnm");
?>
