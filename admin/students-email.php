<?php
// Update : 2015-10-14
require_once "../inc/config.php";
require_once "../inc/class.student.inc";
require_once "../header.php";
require_once "menu.php";

if(!$_POST['students']){
  echo "<p style=color:red;font-weight:bold;'>No student selected</p>\n";
  echo "<a href='students-list.php'>Back to list</a>\n";
  require_once "../footer.php";
  exit;
}


$s=new student();
$s->fetchAll();
$students=$_POST['students'];
foreach($students as $student){
  $students2[]="{$s->elements[$student]['firstname']} {$s->elements[$student]['lastname']}";
}

usort($students2,"cmp_firstname");
$students2=join(" ; ",$students2);
$students=serialize($students);

echo <<<EOD
<h3>Email</h3>
<a href='students-list.php'>Back to list</a><br/><br/>

<div class='fieldset'>
<form action='students-email2.php' method='post'>
<input type='hidden' name='students' value='$students' />
<table style='margin-left:-30px;'>
<tr><td colspan='2'><b>This email will be sent to the following students</b> : </td></tr>
<tr><td colspan='2'>$students2</td></tr>

<tr><td style='padding-top:40px;width:100px;'><b>Subject : </b></td>
<td style='padding-top:40px;'><input type='text' name='subject' /></td></tr>

<tr><td colspan='2' style='padding-top:40px;'><b>Message</b></td></tr>
<tr><td colspan='2'><textarea name='message' cols='100' rows='5'></textarea></td></tr>

<tr><td colspan='2' style='text-align:center'>
<input type='button' value='Cancel' onclick='document.location.href="students-list.php";' />
<input type='submit' value='Send' style='margin-left:40px;'/>
</table>
</form>
</div>
EOD;


require_once "../footer.php";
?>