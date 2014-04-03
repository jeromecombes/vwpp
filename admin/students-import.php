<?php
require_once "../header.php";
require_once "menu.php";

$semestre=$_GET['semestre'];
echo "Import students for ".str_replace("_"," ",$semestre);
echo "<br/>\n";

//	Importation des donnees apres validation
if(isset($_POST['tableau']))
	{
	$tab=unserialize($_POST['tableau']);
	$col=array();				// $col = nom des champs
	for($i=1;$i<6;$i++)
		$col[$i]=$_POST["col$i"];
	
	for($i=1;$i<count($col)+1;$i++)		// reperation du login pour verifier s'il n'existe pas
		if($col[$i]=="login")
			{
			$login=$i;
			break;
			}
						// Requete INSERT
	$req="INSERT INTO `{$dbprefix}personnel` (`{$col[1]}`,`{$col[2]}`,`{$col[3]}`,`{$col[4]}`,`{$col[5]}`,`droits`,`arrivee`,`postes`,`actif`,`commentaires`) VALUES ";
	foreach($tab as $elem)
		{
		$db1=new db();			// Verif si le login existe dans la base
		$db1->query("SELECT * FROM `{$dbprefix}personnel` WHERE `login`='{$elem[$login]}';");
		if($db1->result)
			echo "<br/>{$elem[1]} {$elem[2]} {$elem[3]} {$elem[4]} {$elem[5]} : <font style='color:red;'>Existe</font> \n";
		else				// Sinon insertion
			{
			$values="('".$elem[1]."','".$elem[2]."','".$elem[3]."','".$elem[4]."','".$elem[5]."','a:2:{i:0;i:99;i:1;i:100;}',SYSDATE(),'a:1:{i:0;s:0:\"\";}','Actif',CONCAT('Importation Tableur ',SYSDATE()))";
			$db=new db();
			$db->query($req.$values);
			if(!$db->error)		// Affichage du resultat
				echo "<br/>{$elem[1]} {$elem[2]} {$elem[3]} {$elem[4]} {$elem[5]} : <font style='color:green;'>OK</font> \n";
			else
				echo "<br/>{$elem[1]} {$elem[2]} {$elem[3]} {$elem[4]} {$elem[5]} : <font style='color:red;'>Erreur</font> \n";
			}
		}
	echo "</div>\n";
	include "include/footer.php";
	exit;
	}

//	Upload du fichier
$tmp_file = $_FILES['file']['tmp_name'];
$type_file = $_FILES['file']['type'];
global $tmp_file;
global $type_file;
if(!is_uploaded_file($tmp_file) )
	echo "Le fichier est introuvable";

//	Verification du type
switch($type_file)
	{
	case "text/comma-separated-values"	: $tab=import_csv();	break;
	case "application/vnd.ms-excel"		: $tab=import_excel();	break;
	default 				: type_inconnu();	break;
	}

if(!empty($tab))
	{
	echo "<form name='form' method='post' action='index.php'/>\n";
	echo "<input type='hidden' name='page' value='personnel/import-excel.php' />\n";
	echo "<input type='hidden' name='tableau' value='".serialize($tab)."' />\n";
	echo "<table cellspacing='0'>\n";
	echo "<tr class='th'>\n";
	echo "<td><input type='checkbox' onclick='checkall(\"form\",this);' /></td>\n";
	echo "<td><select name='col1'>
	<option value='nom'>Nom</option>
	<option value='prenom'>Pr&eacute;nom</option>
	<option value='mail'>E-mail</option>
	<option value='login'>Login</option>
	<option value='password'>Password</option>
	</select></td>\n";
	echo "<td><select name='col2'>
	<option value='nom'>Nom</option>
	<option value='prenom' selected='selected'>Pr&eacute;nom</option>
	<option value='mail'>E-mail</option>
	<option value='login'>Login</option>
	<option value='password'>Password</option>
	</select></td>\n";
	echo "<td><select name='col3'>
	<option value='nom'>Nom</option>
	<option value='prenom'>Pr&eacute;nom</option>
	<option value='mail' selected='selected'>E-mail</option>
	<option value='login'>Login</option>
	<option value='password'>Password</option>
	</select></td>\n";
	echo "<td><select name='col4'>
	<option value='nom'>Nom</option>
	<option value='prenom'>Pr&eacute;nom</option>
	<option value='mail'>E-mail</option>
	<option value='login' selected='selected'>Login</option>
	<option value='password'>Password</option>
	</select></td>\n";
	echo "<td><select name='col5'>
	<option value='nom'>Nom</option>
	<option value='prenom'>Pr&eacute;nom</option>
	<option value='mail'>E-mail</option>
	<option value='login'>Login</option>
	<option value='password' selected='selected'>Password</option>
	</select></td>\n";
	echo "</tr>\n";
	$class="tr1";
	$i=0;
	foreach($tab as $ligne)
		{
		$class=$class=="tr1"?"tr2":"tr1";
		echo "<tr class='$class'>\n";
		echo "<td><input type='checkbox' name='chk$i' value='$i' /></td>\n";
		echo "<td>{$ligne[1]}</td>\n";
		echo "<td>{$ligne[2]}</td>\n";
		echo "<td>{$ligne[3]}</td>\n";
		echo "<td>{$ligne[4]}</td>\n";
		echo "<td>{$ligne[5]}</td>\n";
		echo "</tr>\n";
		$i++;
		}
	echo "</table><br/>\n";
	echo "<input type='submit' value='Importer' />\n";
	echo "</form>\n";
	}

require_once "../footer.php";
?>