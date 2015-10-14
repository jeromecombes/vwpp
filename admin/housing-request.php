<?php
// Last update : 2015-10-14

require_once "../header.php";
require_once "../inc/class.housing.inc";
require_once "menu.php";
access_ctrl(2);

?>
<h3>Housing - Demandes des étudiants - <?php echo $_SESSION['vwpp']['semester']; ?></h3>
<a href='housing.php'>Housing Home</a>
<a href='housing_excel.php' style='margin-left:50px;'>Excel</a>
<br/><br/>

<?php

$h=new housing();
$h->fetchAll($_SESSION['vwpp']['login_univ']);
$elements=$h->shortElem;
$questions=$h->questions;
$questions_Ids=$h->questions_Ids;

echo "<table class='datatable'>\n";
echo "<thead>\n";
echo "<tr>\n";
echo "<th>&nbsp;</th>\n";
echo "<th>Lastname</th><th>Firstname</th>\n";
foreach($questions as $elem){
  echo "<th>$elem</th>\n";
}
echo "</tr>\n";
echo "</thead>\n";

echo "<tbody>\n";
foreach($elements as $elem){
  echo "<tr>\n";
  echo "<td>";
  if(in_array(7,$_SESSION['vwpp']['access']))
    echo "<a href='housing-affect.php?student={$elem['student']}'>Loger</a>";
  echo "</td>\n";
  echo "<td>{$elem['lastname']}</td><td>{$elem['firstname']}</td>\n";
  foreach($questions_Ids as $id){
    $div=null;
    if(array_key_exists($id,$elem)){
      $div="<div style='height:50px;max-height:50px;overflow:hidden' title='{$elem[$id]}'>{$elem[$id]}</div>\n";
    }
    echo "<td>$div</td>\n";
  }
  echo "</tr>\n";
}
echo "</tbody>\n";
echo "</table>\n";
require_once "../footer.php";
?>
