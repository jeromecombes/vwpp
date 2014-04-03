<?php
require_once "header.php";
require_once "menu.php";

echo "<p>Before departing from the USA :<br/>\n";
echo "Choose your VWPP Courses</p>\n";
echo "<h3><u>VWPP Courses</u></h3>\n";

include "courses-rh.php";	//	Student's choices
include "inc/courses_rh.php";	//	Final. Reg


echo <<<EOD
<div id='map'><img src='img/map.png' alt='' /></div>

<p style='margin:30px 0 0 0;'>A Paris, saisissez l&apos;information concernant&eacute; :
<ul style='margin:5px 0 0 0'><li>Vos cours universitaires</li>
<li>Vos cours au CIPh or autre institution</li></ul></p>

<h3><u>Cours &agrave; l'universit&eacute;</u></h3>

<div>
EOD;
$univ="univ";
// include("courses-univ.php");
include("inc/courses_univ4.php");

echo <<<EOD
</div>
<!-- <h3 style='margin-top:50px;'><u>Cours au CIPh ou autres institutions</u></h3>
<div> -->
EOD;

// $isForm=false;
// $univ="ciph";
// // include("courses-univ.php");
// include("inc/courses_ciph2.php");

include("inc/form.tutorat.inc");

include("inc/form.stage.inc");


require_once "footer.php";
?>