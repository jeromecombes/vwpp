<?php
// Last update : 2015-03-19

require_once "../header.php";
require_once "menu.php";
if(isset($_GET['semestre'])){
  $semestre=$_GET['semestre'];
}elseif(array_key_exists("semestre",$_SESSION["vwpp"])){
	$semestre=$_SESSION['vwpp']['semestre'];
}else{
	$semestre=date("n")>7?"Fall_".date("Y"):"Spring_".date("Y");
}
$_SESSION['vwpp']['semestre']=$semestre;

$db=new db();
$db->select("students","semestre",null,"group by semestre");
$oldestYear=substr($db->result[0]['semestre'],-4);

echo <<<EOD

<h3>Home Page</h3>

<div style='font-size:12pt;margin:30px 10px 10px 0;'>
<p>Welcome to the Administrative Database for the Vassar-Wesleyan Program in Paris!</p>
<p>Please choose the semester to which you would like to add students. You can also consult or edit a previously created list.</p>
<p>By clicking on the appropriate tab at the top, you can add or edit information regarding students, courses, grades, housing, evaluations or users for the semester chosen. </p>
</div>

<form name='form' action='students-list.php' method='get'>
<table border='0' style='width:500px;'><tr style='vertical-align:top;'>
<td style='font-size:12pt; padding:30px 0 0 0;'>Select a semester</td>
<td style='font-size:12pt; padding:27px 0 0 30px; width:300px;''>
<select name='semestre' style='width:50%;' class='ui-widget-content ui-corner-all'> 
<option value=''>Semester</option>
EOD;

for($i=date('Y')+1;$i>=$oldestYear;$i--){
  $selected2=$semestre=="Fall_$i"?"selected='selected'":null;
  $selected1=$semestre=="Spring_$i"?"selected='selected'":null;
  echo "<option value='Fall_$i' $selected2 >Fall $i</option>\n";
  echo "<option value='Spring_$i' $selected1 >Spring $i</option>\n";
}
echo <<<EOD
</select>
<input type='submit' value='OK' class='myUI-button' style='margin-left:20px;'/>

</td></tr>
</table>
</form>
<br/>
EOD;

require_once "../footer.php";
?>