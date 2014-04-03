<?php
require_once "../header.php";
require_once "menu.php";
//access_ctrl(13);

if(isset($_GET['semestre']))
  $_SESSION['vwpp']['semestre']=$_GET['semestre'];
$semestre=isset($_SESSION['vwpp']['semestre'])?$_SESSION['vwpp']['semestre']:null;
?>

<ul>
<!--
<li><a href='forms-view.php?formId=6'>Students Generals Information</a></li>
-->
<li><a href='forms-view.php?formId=7'>Housing</a></li>
</ul>
<?php
require_once "../footer.php";
?>