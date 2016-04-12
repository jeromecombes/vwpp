<?php
// Last update : 2016-04-12

require_once "../header.php";
require_once "menu.php";
require_once "../inc/class.dates.inc";

access_ctrl(24);

$d=new dates();
$d->fetch();
$dates=$d->elements;

echo <<<EOD
<h3>Dates, Deadlines</h3>
<br/>

<form name='form' action='dates_update.php' method='post'>

<table class='datatable'>
<thead>
<tr>
<th style='display:none';>&nbsp;</th>
<th style='display:none';>&nbsp;</th>
<th style='width:50%;' class='dataTableNoSort'>Home form</th>
<th class='dataTableNoSort'>Date</th></tr></thead>
<tbody>
<tr>
	<td style='display:none';>&nbsp;</td>
	<td style='display:none';>&nbsp;</td>
	<td>Personal details and contact information by </td>
  <td><input type='text' name='date1' value='{$dates['date1']}' class='myUI-datepicker-string'/></td></tr>
<tr>
	<td style='display:none';>&nbsp;</td>
	<td style='display:none';>&nbsp;</td>
	<td>Housing preferences by </td>
  <td><input type='text' name='date2' value='{$dates['date2']}' class='myUI-datepicker-string'/></td></tr>
<tr>
	<td style='display:none';>&nbsp;</td>
	<td style='display:none';>&nbsp;</td>
	<td>University preference by </td>
  <td><input type='text' name='date3' value='{$dates['date3']}' class='myUI-datepicker-string'/></td></tr>
<tr>
	<td style='display:none';>&nbsp;</td>
	<td style='display:none';>&nbsp;</td>
	<td>pre-registration for VWPP Courses by </td>
  <td><input type='text' name='date4' value='{$dates['date4']}' class='myUI-datepicker-string'/></td></tr>
</tbody>
</table>

<br/><br/>

<table class='datatable'>
<thead>
<tr>
<th style='display:none';>&nbsp;</th>
<th style='display:none';>&nbsp;</th>
<th style='width:50%;' class='dataTableNoSort'>Univ registration form</th>
<th class='dataTableNoSort'>Date</th></tr></thead>
<tbody>
<tr>
	<td style='display:none';>&nbsp;</td>
	<td style='display:none';>&nbsp;</td>
	<td>Paris  3, end of course </td>
  <td><input type='text' name='date5' value='{$dates['date5']}' class='myUI-datepicker-string'/></td></tr>
<tr>
	<td style='display:none';>&nbsp;</td>
	<td style='display:none';>&nbsp;</td>
	<td>Paris  4, end of course </td>
  <td><input type='text' name='date6' value='{$dates['date6']}' class='myUI-datepicker-string'/></td></tr>
<tr>
	<td style='display:none';>&nbsp;</td>
	<td style='display:none';>&nbsp;</td>
	<td>Paris  7, end of course </td>
  <td><input type='text' name='date7' value='{$dates['date7']}' class='myUI-datepicker-string'/></td></tr>
<tr>
	<td style='display:none';>&nbsp;</td>
	<td style='display:none';>&nbsp;</td>
	<td>Paris 12, end of course </td>
  <td><input type='text' name='date8' value='{$dates['date8']}' class='myUI-datepicker-string'/></td></tr>
</tbody>
</table>

<br/><br/>

<input type='submit' value='Valider' class='myUI-button'/>
</form>
EOD;

require_once "../footer.php";
?>