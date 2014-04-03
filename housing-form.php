<?php
require_once "header.php";
require_once "menu.php";
require_once "inc/class.housing.inc";

$tmp=explode(" ",$_SESSION['vwpp']['semester']);
$tmp=$tmp[1].($tmp[0]=="Spring"?1:2);

$h=new housing;
$h->student=$_SESSION['vwpp']['student'];
$h->charte_accepted();

if(!$h->accepted){
  echo "<h3>Housing</h3>\n";
  echo $GLOBALS['lang']['accept_charte'];
  echo "<p><a href='housing.php'>Retour</a></p>\n";
}
elseif(intval($tmp)<20132)	// Before Fall 2013
  require_once "inc/form.housing.inc";
else
  require_once "inc/form.housing2013.inc";

require_once "footer.php";
?>
