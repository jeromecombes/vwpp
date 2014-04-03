<?php
require_once "../header.php";
require_once "menu.php";
require_once "../inc/class.dates.inc";

access_ctrl(24);

$d=new dates();
$d->fetch();
$dates=$d->elements;

echo <<<EOD
<h3>Dates</h3>
<form name='form' action='dates_update.php' method='post'>
<table id='myTab' cellspacing='0' style='width:650px;'>
<tr class='th'><td>Home form</td><td colspan='2'>Date</td></tr>
<tr><td style='width:400px;'>Personal details and contact information by </td>
  <td style='width:200px;'><input type='text' name='date1' value='{$dates['date1']}'</td>
  <td><a href='javascript:calendar("form","date1",1);'><img src='../img/calendar.gif' border='0' alt='calendar'/></a></td></tr>
<tr class='tr2'><td>Housing preferences by </td>
  <td><input type='text' name='date2' value='{$dates['date2']}'</td>
  <td><a href='javascript:calendar("form","date2",1);'><img src='../img/calendar.gif' border='0' alt='calendar'/></a></td></tr>
<tr><td>University preference by </td>
  <td><input type='text' name='date3' value='{$dates['date3']}'</td>
  <td><a href='javascript:calendar("form","date3",1);'><img src='../img/calendar.gif' border='0' alt='calendar'/></a></td></tr>
<tr class='tr2'><td>pre-registration for VWPP Courses by </td>
  <td><input type='text' name='date4' value='{$dates['date4']}'</td>
  <td><a href='javascript:calendar("form","date4",1);'><img src='../img/calendar.gif' border='0' alt='calendar'/></a></td></tr>
<tr class='th'><td>Univ registration form</td><td colspan='2'>Date</td></tr>
<tr class='tr2'><td>Paris 3, end of course </td>
  <td><input type='text' name='date5' value='{$dates['date5']}'</td>
  <td><a href='javascript:calendar("form","date5",1);'><img src='../img/calendar.gif' border='0' alt='calendar'/></a></td></tr>
<tr class='tr2'><td>Paris 4, end of course </td>
  <td><input type='text' name='date6' value='{$dates['date6']}'</td>
  <td><a href='javascript:calendar("form","date6",1);'><img src='../img/calendar.gif' border='0' alt='calendar'/></a></td></tr>
<tr class='tr2'><td>Paris 7, end of course </td>
  <td><input type='text' name='date7' value='{$dates['date7']}'</td>
  <td><a href='javascript:calendar("form","date7",1);'><img src='../img/calendar.gif' border='0' alt='calendar'/></a></td></tr>
<tr><td colspan='3' style='text-align:right;'><input type='submit' value='Valider' /></td></tr>
</table>
</form>
EOD;

require_once "../footer.php";
?>