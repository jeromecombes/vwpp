<?php
require_once "../inc/config.php";
require_once "../inc/class.stage.inc";

access_ctrl(23);

$s=new stage();
$s->fetchAll($_SESSION['vwpp']['login_univ']);
$s=$s->elements;

foreach($_POST['students'] as $elem){
  if($s[$elem])
    $tab[$elem]=$s[$elem];
}

usort($tab,cmp_lastname);
$tab=array_map("entity_decode",$tab);
$tab=array_map("delete_rnt",$tab);


$Fnm = "../data/intership_{$_SESSION['vwpp']['semestre']}";

if($_GET['type']=="csv"){
  $separate="';'";
  $Fnm.=".csv";
}
else{
  $separate="\t";
  $Fnm.=".xls";
}

$lines=Array();

$title=array("Lastname","Firstname","Intership");
$lines[]=join($title,$separate);

foreach($tab as $elem){
  $cells=array($elem['lastname'],$elem['firstname'],$elem["stage"]);
  $lines[]=join($cells,$separate);
}

$inF = fopen($Fnm,"w");
foreach($lines as $elem){
  fputs($inF,$elem."\n");
}
fclose($inF);

header("Location: $Fnm");
?>
