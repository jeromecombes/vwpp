<?php
// Last update : 2016-03-12

require_once "class.courses.inc";

$c=new courses();
$c->getSchedule();
$tab=$c->schedule;

echo <<<EOD
<h3>My Schedule</h3>

<table class='datatable' data-sort='[]'>
<thead>
<tr><th class='dataTableNoSort'>Jour</th class='dataTableNoSort'><th class='dataTableNoSort'>Début</th><th class='dataTableNoSort'>Fin</th><th class='dataTableNoSort'>Type</th><th class='dataTableNoSort'>Cours</th><th class='dataTableNoSort'>Professeur</th></tr>
</thead>
<tbody>
EOD;

foreach($tab as $elem){
  echo "<tr class='$class'><td>{$elem['jour']}</td><td>{$elem['debut']}</td><td>{$elem['fin']}</td>
    <td>{$elem['type']}</td><td>{$elem['nom']}</td><td>{$elem['prof']}</td></tr>\n";
}
echo "</tbody>\n";
echo "</table>\n";
?>
