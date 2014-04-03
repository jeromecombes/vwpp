<?php
$semester=$_SESSION['vwpp']['semestre'];
$student=$_SESSION['vwpp']['std-id'];

//	Get student choices
$db=new db();
$db->select("courses_choices","*","semester='$semester' AND student='$student'");
$choices=$db->result[0];

//	Get list of courses
$db=new db();
$db->select("courses","*","semester='$semester'");
for($i=0;$i<$db->nb;$i++){
  $courses[$db->result[$i]['id']]['id']=$db->result[$i]['id'];
  $courses[$db->result[$i]['id']]['professor']=decrypt($db->result[$i]['professor']);
  $courses[$db->result[$i]['id']]['title']=decrypt($db->result[$i]['title']);
}

//	Get courses attribution
$db=new db();
$db->select("courses_attrib_rh","*","semester='$semester' AND student='$student'");
$course1=$db->result[0]['course1'];
$course2=$db->result[0]['course2'];

echo <<<EOD
<div id='div$id' style='display:$display;'>
<h3>VWPP Courses</h3>
<div style='margin-left:30px;'>
<p style='font-weight:bold;'>Student's choice</p>
<form name='form' action='courses-attrib-update.php' method='post'>
<input type='hidden' name='univ' value='rh' />
<input type='hidden' name='student' value='$student' />
<input type='hidden' name='semester' value='$semester' />

<table>
<tr><td colspan='2'><b>1<sup>st</sup> choice</b></td></tr>
<tr><td style='padding-left:30px;'>Course N°1</td>
<td>{$courses[$choices['a1']]['title']}</td>
<td>{$courses[$choices['a1']]['professor']}</td></tr>
<tr><td style='padding-left:30px;'>Course N°2</td>
<td>{$courses[$choices['b1']]['title']}</td>
<td>{$courses[$choices['b1']]['professor']}</td></tr>
<tr><td colspan='2'><b>2<sup>nd</sup> choice</b></td></tr>
<tr><td style='padding-left:30px;'>Course N°1</td>
<td>{$courses[$choices['a2']]['title']}</td>
<td>{$courses[$choices['a2']]['professor']}</td></tr>
<tr><td style='padding-left:30px;'>Course N°2</td>
<td>{$courses[$choices['b2']]['title']}</td>
<td>{$courses[$choices['b2']]['professor']}</td></tr>

<tr><td colspan='3' style='font-weight:bold;padding-top:50px;'>Attribution</td></tr>
<tr><td style='padding-left:30px;'>Course N°1</td>
<td colspan='2'>
<select name='course1'>
<option value=''>&nbsp;</option>
EOD;
usort($courses,"cmp_title");
foreach($courses as $elem){
  $selected=$course1==$elem['id']?"selected='selected'":null;
  echo "<option value='{$elem['id']}' $selected>{$elem['title']}, {$elem['professor']}</option>\n";
}
echo <<<EOD
</select></td>
<td><input type='submit' value='Submit' /></td></tr>
<tr><td style='padding-left:30px;'>Course N°2</td>
<td colspan='2'>
<select name='course2'>
<option value=''>&nbsp;</option>
EOD;
foreach($courses as $elem){
  $selected=$course2==$elem['id']?"selected='selected'":null;
  echo "<option value='{$elem['id']}' $selected>{$elem['title']}, {$elem['professor']}</option>\n";
}
echo <<<EOD
</select>
</td></tr>
</table>
</form>
</div>
</div>
EOD;


?>