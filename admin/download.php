<?php
//	adapter ce script avec ctrl_access(); id du fichier (bdd) ....
if(isset($_GET["id"]))
{
//le fichier est généré si id possède une valeur
$chem="/home/jerome/php.ini";
$fichier = fopen($chem, "r+");
$nbre_vues = fgets($fichier);
if($nbre_vues == NULL)
$nbre_vues = 0;
$nbre_vues++;
fseek($fichier, 0);
fputs($fichier, $nbre_vues);
fclose($fichier);
$nom = "image.gif";
$type = "text/ini";

//header(.Cache-Control: public, must-revalidate.);

// header(.Pragma: public.);
header("Content-Type: ".$type); // le type
//header(.Content-Length: . . filesize($nom));
//header(.Content-Disposition: attachment; filename=...$nom....);
header("Content-Transfer-Encoding: binary");
readfile($chem);
}
else
        echo "denied";
?>