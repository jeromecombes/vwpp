<?php
require_once "../header.php";
require_once "../inc/class.housing.inc";
require_once "../inc/class.student.inc";
require_once "menu.php";
access_ctrl(7);

$semester=$_SESSION['vwpp']['semester'];
$student=$_GET['student'];

//	Student information
$std=new student();
$std->id=$student;
$std->fetch();
$student=$std->elements;

//	Housing information
$h=new housing();
$h->getLogementsDispo();
$logements=$h->logements;
// print_r($logements);

//	Student housing
$l=new housing();
$l->getLogement($student['logement']);
$logement=$l->logement;


echo "<h3>Housing - Affectation</h3>\n";
echo "<a href='housing.php'>Housing</a> > \n";
echo "<a href='housing-request.php'>Demandes</a>\n";

echo "<p>Affectation d'un logement pour {$student['firstname']} {$student['lastname']} pour $semester.</p>";

echo "<table><form method='post' action='housing-affect2.php'>\n";
echo "<input type='hidden' name='student' value='{$student['id']}' />\n";
echo "<input type='hidden' name='page' value='housing-affect.php' />\n";
echo "<tr><td style='width:500px;'>\n";
echo "<select name='logement'>\n";
echo "<option value=''>&nbsp;</option>\n";
if($student['logement']){
  echo "<option value='{$logement['id']}' selected='selected'>{$logement['firstname']} {$logement['lastname']}, {$logement['zipcode']}</option>\n";
}
foreach($logements as $elem){
  echo "<option value='{$elem['id']}'>{$elem['firstname']} {$elem['lastname']}, {$elem['zipcode']}</option>\n";
}
echo "</select></td>\n";
echo "<td><input type='submit' value='OK' /></td></tr>\n";
echo "</table></form>\n";

if($student['logement']){
  echo <<<EOD
  <div style='margin-top:50px;'>
  <b>Logement actuellement affecté</b>
  <table>
  <tr><td>Nom</td><td>{$logement['lastname']}</td></tr>
  <tr><td>Prénom</td><td>{$logement['firstname']}</td></tr>
  <tr><td>Adresse</td><td>{$logement['address']}</td></tr>
  <tr><td>Code Postal</td><td>{$logement['zipcode']}</td></tr>
  <tr><td>Ville</td><td>{$logement['city']}</td></tr>
  <tr><td>Téléphone</td><td>{$logement['phonenumber']}</td></tr>
  <tr><td>Portable</td><td>{$logement['cellphone']}</td></tr>
  <tr><td>Email</td><td>{$logement['email']}</td></tr>
  </table>
  </div>
EOD;
}

?>