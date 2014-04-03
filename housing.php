<?php
require_once "header.php";
require_once "inc/class.housing.inc";
require_once "menu.php";
?>
<h3>Housing</h3>
<p style='text-align:justify;width:1170px;'>
Welcome to the VWPP Housing questionnaire pages.  Please take a few minutes to read through the Housing 
Process Residence commitment sections of the VWPP website by clicking on the link below, before 
proceeding to fill out the questionnaire.
</p>
<a href='http://en.vwpp.org/info-for-accepted-students/essential-housing-information/' target='_blank'>Housing Process Residence commitment</a>
<br/><br/>

<?php
$h=new housing;
$h->student=$_SESSION['vwpp']['student'];
$h->charte_accepted();
$h->closed();

$checked=$h->accepted?"checked='checked'":null;

if($h->accepted and !$h->closed2){
  $displayLink=null;
  $displayText="style='display:none;'";
}
else{
  $displayLink="style='display:none;'";
  $displayText=null;
}

echo "<input type='checkbox' $checked onclick='accept_housing_charte(this);'/> I accept the terms and conditions mentioned in the above link\n";
echo "<p $displayLink id='link'><a href='housing-form.php'>Housing form</a></p>\n";
echo "<p $displayText id='text'>Housing form</p>\n";

require_once "footer.php";
?>