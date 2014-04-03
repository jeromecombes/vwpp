<?php
require_once "../inc/config.php";
require_once "../inc/class.housing.inc";
require_once "../header.php";
require_once "menu.php";

if(!$_POST['housing']){
  echo "<p style=color:red;font-weight:bold;'>Nobody selected</p>\n";
  echo "<a href='housing-list.php'>Back to list</a>\n";
  require_once "../footer.php";
  exit;
}


$h=new housing();
$h->getLogements();
$housing=$_POST['housing'];
foreach($housing as $elem){
  $housing2[]="{$h->logements[$elem]['firstname']} {$h->logements[$elem]['lastname']}";
  if($h->logements[$elem]['email2']){
    $housing2[]="{$h->logements[$elem]['firstname2']} {$h->logements[$elem]['lastname2']}";
  }
}

usort($housing2,cmp_firstname);
$housing2=join(" ; ",$housing2);
$housing=serialize($housing);

echo <<<EOD
<h3>Email</h3>
<a href='housing-list.php'>Back to list</a><br/><br/>

<div class='fieldset'>
<form action='housing-email2.php' method='post'>
<input type='hidden' name='housing' value='$housing' />
<table style='margin-left:-30px;'>
<tr><td colspan='2'><b>This email will be sent to the following</b> : </td></tr>
<tr><td colspan='2'>$housing2</td></tr>

<tr><td style='padding-top:40px;width:100px;'><b>Subject : </b></td>
<td style='padding-top:40px;'><input type='text' name='subject' /></td></tr>

<tr><td colspan='2' style='padding-top:40px;'><b>Message</b></td></tr>
<tr><td colspan='2'><textarea name='message' cols='100' rows='5'></textarea></td></tr>

<tr><td colspan='2' style='text-align:center'>
<input type='button' value='Cancel' onclick='document.location.href="housing-list.php";' />
<input type='submit' value='Send' style='margin-left:40px;'/>
</table>
</form>
</div>
EOD;


require_once "../footer.php";
?>