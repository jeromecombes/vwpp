<?php
require_once "class.courses.inc";

$c=new courses();
$c->getSchedule();
$tab=$c->schedule;

echo <<<EOD
<h3>My Schedule</h3>

EOD;

echo "<table id='myTab' cellspacing='0'>\n";
echo "<tr class='th'><td>Jour</td><td>Début</td><td>Fin</td><td>Type</td><td>Cours</td><td>Professeur</td></tr>\n";
foreach($tab as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'><td>{$elem['jour']}</td><td>{$elem['debut']}</td><td>{$elem['fin']}</td>
    <td>{$elem['type']}</td><td>{$elem['nom']}</td><td>{$elem['prof']}</td></tr>\n";
}
echo "</table>\n";


?>