<?php
// Last Update : 2015-10-14

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
<table class='datatable'>
<thead>
<tr><th class='dataTableNoSort'><input type='checkbox' onclick='checkall("form",this)' /></th>
<th>Nom</th>
<th>Prénom</th>
<th>Code Postal</th>
<th>Email</th>
<th>Téléphone</th>
<th>Portable</th>
<th>Etudiant</th>
</tr>
</thead>
<tbody>
EOD;
foreach($logements as $elem){
  echo "<tr>\n";
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
echo "</tbody>\n";
echo "</table>\n";
echo "</form>\n";


//			A CONTINUER



echo "<form name='form2'>\n";
echo "<br/>Pour la sélection : ";
echo "<select id='action' onchange='select_action(\"form\");' style='width:250px;' class='ui-widget-content ui-corner-all'>\n";
echo "<option value=''>&nbsp;</option>\n";
echo "<option value='Email_Housing'>Envoyer un email (Logiciel)</option>\n";
echo "<option value='Email2_Housing'>Envoyer un email (Web Browser)</option>\n";
echo "<option value='Excel_Housing'>Exporter en Excel</option>\n";
echo "</select>\n";

echo "<input type='button' id='submit_button' value='Valider' disabled='disabled' onclick='submit_action(\"form2\",\"form\");' class='myUI-button'/>\n";
// echo "<input type='submit' value='Envoyer un email aux personnes sélectionnées' />\n";
echo "</form>\n";
if(in_array(7,$_SESSION['vwpp']['access'])){
  echo "<p style='margin:20px 0 30px 0;'>\n";
  echo "<a href='housing-edit.php'>Ajouter un nouveau logement</a>\n";
  echo "</p>\n";
}






require_once "../footer.php";
?>