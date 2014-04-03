<?php
require_once "../header.php";
require_once "../inc/class.housing.inc";
require_once "menu.php";
access_ctrl(2);

?>
<h3>Housing - Demandes des étudiants - <?php echo $_SESSION['vwpp']['semester']; ?></h3>
<a href='housing.php'>Housing Home</a>
<a href='housing_excel.php' style='margin-left:50px;'>Excel</a>

<?php

$h=new housing();
$h->fetchAll($_SESSION['vwpp']['login_univ']);
$elements=$h->shortElem;
$questions=$h->questions;
$questions_Ids=$h->questions_Ids;

echo "<table cellspacing='0' style='margin-top:30px;'>\n";
echo "<tr class='th'>\n";
echo "<td>&nbsp;</td>\n";
echo "<td>Lastname</td><td>Firstname</td>\n";
foreach($questions as $elem){
  echo "<td>$elem</td>\n";
}
echo "</tr>\n";

foreach($elements as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'>\n";
  echo "<td>";
  if(in_array(7,$_SESSION['vwpp']['access']))
    echo "<a href='housing-affect.php?student={$elem['student']}'>Loger</a>";
  echo "</td>\n";
  echo "<td>{$elem['lastname']}</td><td>{$elem['firstname']}</td>\n";
  foreach($questions_Ids as $id){
    echo "<td>{$elem[$id]}</td>\n";
  }
  echo "</tr>\n";
}
echo "</table>\n";
require_once "../footer.php";
?>