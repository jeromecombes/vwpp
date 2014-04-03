<?php
require_once "../header.php";
require_once "../inc/class.housing.inc";
require_once "menu.php";
access_ctrl(2);

?>
<h3>Housing - Liste des logements - <?php echo $_SESSION['vwpp']['semester']; ?></h3>
<a href='housing.php'>Housing Home</a>
<br/><br/>

<?php
$sort=isset($_GET['sort'])?$_GET['sort']:(isset($_SESSION['vwpp']['housing_sort'])?$_SESSION['vwpp']['housing_sort']:"lastname");
$_SESSION['vwpp']['housing_sort']=$sort;

$l=new housing();
$l->getLogements();
$l->sort("logements",$sort);
$logements=$l->logements;

echo <<<EOD
<form name='form' action='housing-email.php' method='post'>
<table id='myTab' cellspacing='0'>
<tr class='th'><td><input type='checkbox' onclick='checkall("form",this)' /></td>
<td>Nom
<a href='housing-list.php?sort=lastname'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='housing-list.php?sort=lastname_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td style='width:100px;'>Prénom
<a href='housing-list.php?sort=firstname'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='housing-list.php?sort=firstname_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td style='width:140px;'>Code Postal
<a href='housing-list.php?sort=zipcode'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='housing-list.php?sort=zipcode_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Email
<a href='housing-list.php?sort=email'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='housing-list.php?sort=email_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td style='width:120px;'>Téléphone
<a href='housing-list.php?sort=phonenumber'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='housing-list.php?sort=phonenumber_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td style='width:120px;'>Portable
<a href='housing-list.php?sort=cellphone'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='housing-list.php?sort=cellphone_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Etudiant
<a href='housing-list.php?sort=studentName'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='housing-list.php?sort=studentName_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
</tr>
EOD;
foreach($logements as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'>\n";
  echo "<td style='width:40px;'>";
  echo <<<EOD
  <input type='checkbox' name='housing[]' value='{$elem['id']}' onclick='setTimeout("select_action(\"form\")",5);'/>
EOD;
  echo "<a href='housing-edit.php?id={$elem['id']}'><img src='../img/edit.png' alt='Edit' /></a>";
  echo "<input type='hidden' id='mail_{$elem['id']}' value='{$elem['email']}' />\n";
  echo "<input type='hidden' id='mail2_{$elem['id']}' value='{$elem['email2']}' />\n";
  echo "</td>\n";
  echo "<td>{$elem['lastname']}</td><td>{$elem['firstname']}</td><td>{$elem['zipcode']}</td>";
  echo "<td><a href='mailto:{$elem['email']}'>{$elem['email']}</a>";
  echo "</td><td>{$elem['phonenumber']}</td><td>{$elem['cellphone']}</td><td>{$elem['studentName']}</td></tr>\n";
}
echo "</table>\n";
echo "</form>\n";


//			A CONTINUER



echo "<form name='form2'>\n";
echo "Pour la sélection : ";
echo "<select id='action' onchange='select_action(\"form\");' style='width:250px;'>\n";
echo "<option value=''>&nbsp;</option>\n";
echo "<option value='Email_Housing'>Envoyer un email (Logiciel)</option>\n";
echo "<option value='Email2_Housing'>Envoyer un email (Web Browser)</option>\n";
echo "<option value='Excel_Housing'>Exporter en Excel</option>\n";
echo "</select>\n";

echo "<input type='button' id='submit_button' value='Valider' disabled='disabled' onclick='submit_action(\"form2\",\"form\");'/>\n";
// echo "<input type='submit' value='Envoyer un email aux personnes sélectionnées' />\n";
echo "</form>\n";
if(in_array(7,$_SESSION['vwpp']['access']))
  echo "<br/><a href='housing-edit.php'>Ajouter un nouveau logement</a>\n";






require_once "../footer.php";
?>