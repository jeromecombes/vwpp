<?php
require_once "../header.php";
require_once "../inc/class.housing.inc";
require_once "menu.php";
?>
<h3>Housing</h3>
<a href='housing.php'>Housing Home</a>
<br/><br/>

<?php
$l=new housing();
$l->getLogements();

$logements=$l->logements;

print_r($logements);


echo "<br/><a href='housing-edit.php'>Ajouter un logements</a>\n";







require_once "../footer.php";
?>