<?php
/*
require_once "header.php";
require_once "menu.php";
access_ctrl(2);

$db=new db();
$db->select("students","*","id='{$_GET['id']}'");
$std=$db->result[0];

echo <<<EOD
<h3>{$std['firstname']} {$std['lastname']}</h3>
<form name='student' action='students-edit2.php' method='post'>
<input type='hidden' name='id' value='{$_GET['id']}' />
<table>
<tr><td>Lastname</td>
<td><input type='text' name='lastname' value='{$std['lastname']}' /></td></tr>
<tr><td>Firstname</td>
<td><input type='text' name='firstname' value='{$std['firstname']}' /></td></tr>
<tr><td>Email</td>
<td><input type='text' name='email' value='{$std['email']}' /></td></tr>
<tr><td colspan='2' style='text-align:center;padding-top:20px;'>
<input type='button' value='cancel' onclick='history.back();' />
<input type='submit' value='Submit' style='margin-left:50px;' />
</table>
</form>
EOD;

require_once "footer.php";
*/
?>