<?php
// Last update : 2015-03-22

require_once "class.courses.inc";

$c=new courses();
$c->getSchedule();
$tab=$c->schedule;

echo <<<EOD
<h3>My Schedule</h3>

EOD;

echo "<table id='myTab' cellspacing='0' cellpadding='5'>\n";
echo "<tr class='th'><th>Jour</th><th>Début</th><th>Fin</th><th>Type</th><th>Cours</th><th>Professeur</th></tr>\n";
foreach($tab as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'><td>{$elem['jour']}</td><td>{$elem['debut']}</td><td>{$elem['fin']}</td>
    <td>{$elem['type']}</td><td>{$elem['nom']}</td><td>{$elem['prof']}</td></tr>\n";
}
echo "</table>\n";


?>
