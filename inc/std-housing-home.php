<?php
// Last update : 2015-10-15

require_once "class.housing.inc";
require_once "class.student.inc";

$semester=$_SESSION['vwpp']['semester'];
$student=$_SESSION['vwpp']['std-id'];

//	Student information
$std=new student();
$std->id=$student;
$std->fetch();
$student=$std->elements;

//	Housing information
$h=new housing();
$h->getLogementsDispo();
$logements=$h->logements;

//	Student housing
$logement=isset($student['logement'])?$student['logement']:null;
$l=new housing();
$l->getLogement($logement);
$logement=$l->logement;


echo "<div id='div$id' style='display:$display;'>\n";
echo "<h3>Housing</h3>\n";

if(in_array(7,$_SESSION['vwpp']['access'])){
  echo "<p>Affectation d'un logement pour {$student['firstname']} {$student['lastname']} pour $semester.</p>";

  echo "<form method='post' action='housing-affect2.php'><table>\n";
  echo "<input type='hidden' name='student' value='{$student['id']}' />\n";
  echo "<input type='hidden' name='page' value='students-view2.php' />\n";
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
  echo "<td><input type='submit' value='OK' class='myUI-button' /></td></tr>\n";
  echo "</table></form>\n";
}


if(isset($student['logement'])){
  echo <<<EOD
  <div style='margin-top:40px;'>
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

// echo "<br/><br/><a href='javascript:showHousingForm();'>Student form</a>\n";
echo "<br/><br/><h3>Student form</h3>\n";
echo "</div>\n";
?>