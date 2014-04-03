<?php
require_once "../header.php";
require_once "menu.php";
if(isset($_GET['semestre']))
  $_SESSION['vwpp']['semestre']=$_GET['semestre'];
$semestre=isset($_SESSION['vwpp']['semestre'])?$_SESSION['vwpp']['semestre']:null;

echo <<<EOD

<h3>Home Page</h3>

<div style='font-size:12pt;margin:30px 10px 10px 0;'>
<p>Welcome to the Administrative Database for the Vassar-Wesleyan Program in Paris!</p>
<p>Please choose the semester to which you would like to add students. You can also consult or edit a previously created list.</p>
<p>By clicking on the appropriate tab at the top, you can add or edit information regarding students, courses, grades, housing, evaluations or users for the semester chosen. </p>
</div>

<form name='form' action='students-list.php' method='get'>
<table border='0' style='width:400px;'><tr style='vertical-align:top;'>
<td style='font-size:12pt; padding:30px 0 0 0;'>Select a semester</td>
<td style='font-size:12pt; padding:27px 0 0 30px; width:200px;''><select name='semestre' style='width:70%;'> 
<!--  onchange='document.form.submit();' -->
<option value=''>Semester</option>
EOD;

for($i=date('Y')-2;$i<date('Y')+3;$i++){
  $selected1=$semestre=="Spring_$i"?"selected='selected'":null;
  $selected2=$semestre=="Fall_$i"?"selected='selected'":null;
  echo "<option value='Spring_$i' $selected1 >Spring $i</option>\n";
  echo "<option value='Fall_$i' $selected2 >Fall $i</option>\n";
}
echo <<<EOD
</select>
<input type='submit' value='OK' />

</td></tr>
</table>
</form>
<br/>
EOD;

require_once "../footer.php";
?>