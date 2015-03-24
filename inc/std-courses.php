<?php
// Last update : 2015-03-24

require_once "class.reidhall.inc";
$semester=$_SESSION['vwpp']['semestre'];
$student=$_SESSION['vwpp']['std-id'];

//	Get student choices for RH courses
$db=new db();
$db->select("courses_choices","*","semester='$semester' AND student='$student'");
$choices=$db->result[0];

//	Get list of RH courses
$rh=new reidhall();
$rh->fetchAll();
$courses=$rh->elements;
usort($rh->seminars,"cmp_title");
usort($rh->writings,"cmp_title");
$lock1=$rh->isLock($student)?"Unlock":"Lock";
$lock2=$rh->isPublished($student)?"Hide":"Publish";

//	Get student RH courses attribution
$db=new db();
$db->select("courses_attrib_rh","*","semester='$semester' AND student='$student'");
$writing1=$db->result[0]['writing1'];
$writing2=$db->result[0]['writing2'];
$writing3=$db->result[0]['writing3'];
$seminar1=$db->result[0]['seminar1'];
$seminar2=$db->result[0]['seminar2'];
$seminar3=$db->result[0]['seminar3'];

//	Get all RH courses attribution
$tab=array();
$db=new db();
$db->select("courses_attrib_rh","*","semester='$semester'");
foreach($db->result as $elem){
  $tab[]=$elem['writing1'];
  $tab[]=$elem['writing2'];
  $tab[]=$elem['writing3'];
  $tab[]=$elem['seminar1'];
  $tab[]=$elem['seminar2'];
  $tab[]=$elem['seminar3'];
}

$newTab=array();		//	Delete All NULL values
foreach($tab as $elem){
  if(is_numeric($elem)){
    $newTab[]=$elem;
  }
}

$count=array_count_values($newTab);
$occurences=array();
foreach($courses as $elem){
  $occurences[]=array("count"=>intval($count[$elem['id']]), "code"=>$elem['code'], "title"=>$elem['title'], "professor"=>$elem['professor'], "type"=>$elem['type']);
}
usort($occurences,"cmp_countDesc");

//	Get choices for university courses
$univ=array();
$i=0;
$db=new db();
$db->select("courses_univ","*","semester='$semester' AND student='$student'");
if($db->result){
  $keys=array_keys($db->result[0]);
  foreach($db->result as $elem){
    foreach($keys as $key){
      if(!is_numeric($key) and !in_array($key,array("id","semester","student"))){
	if(in_array($key,array("university","cm_code")))
	  $univ[$i][$key]=decrypt($elem[$key]);
	else
	  $univ[$i][$key]=decrypt($elem[$key],$student);
      }
      $univ[$i]['id']=$elem['id'];
    }
    $i++;
  }
}



echo <<<EOD
<div id='div$id' style='display:$display;'>
<h3>VWPP Courses</h3>
<div>
<fieldset>
<form name='form' action='courses-attrib-update.php' method='post'>
<input type='hidden' name='univ' value='rh' />
<input type='hidden' name='student' value='$student' />
<input type='hidden' name='semester' value='$semester' />

<table class='myTab'>
<tr><td colspan='4' style='padding:0 0 10px 0;'><b><u>1.) Student's choices</u></b>
<div style='text-align:right;'><input type='button' value='$lock1' onclick='lockRH(this,$student);' class='myUI-button-right' /></div>
</td></tr>
<tr><td colspan='2'><b>Writing-Intensive Course</b></td></tr>
<tr><td style='padding-left:30px;'>1<sup>st</sup> choice</td>
<td>{$courses[$choices['a1']]['code']} 
{$courses[$choices['a1']]['title']}</td>
<td>{$courses[$choices['a1']]['professor']}</td></tr>
<tr><td style='padding-left:30px;'>2<sup>nd</sup> choice</td>
<td>{$courses[$choices['b1']]['code']} 
{$courses[$choices['b1']]['title']}</td>
<td>{$courses[$choices['b1']]['professor']}</td></tr>
<tr><td colspan='2'><b>Seminar</b></td></tr>
<tr><td style='padding-left:30px;'>1<sup>st</sup> choice</td>
<td>{$courses[$choices['a2']]['code']} 
{$courses[$choices['a2']]['title']}</td>
<td>{$courses[$choices['a2']]['professor']}</td></tr>
<tr><td style='padding-left:30px;'>2<sup>nd</sup> choice</td>
<td>{$courses[$choices['b2']]['code']} 
{$courses[$choices['b2']]['title']}</td>
<td>{$courses[$choices['b2']]['professor']}</td></tr>

<tr><td colspan='3' style='font-weight:bold;padding:50px 0 10px 0;'><u>2.) Total registered</u></td></tr>
<tr><td colspan='2'><b>Writing-Intensive Course</b></td></tr>
<tr><td colspan='3'><ul style='margin-top:0px;'>
EOD;
$first=true;
foreach($occurences as $elem){
  if($elem['type']=="Seminar" and $first){
    echo "</ul></tr>\n";
    echo "<tr><td colspan='2'><b>Seminars</b></td></tr>\n";
    echo "<tr><td colspan='3'><ul style='margin-top:0px;'>\n";
    $first=false;
  }
  echo "<li>{$elem['code']} {$elem['title']}, {$elem['professor']} : {$elem['count']}</li>\n";
}
echo <<<EOD
</ul></td></tr>

<tr><td colspan='3' style='font-weight:bold;padding-top:30px;'><u>3.) Final registration</u></td></tr>
<tr><td style='padding-left:15px;font-weight:bold;' colspan='3'>Writing-Intensive Courses</td></tr>
<tr><td style='text-align:right;'>N°1</td>
<td colspan='2'>
<select name='writing1'>
<option value=''>&nbsp;</option>
EOD;
foreach($rh->writings as $elem){
    $selected=$writing1==$elem['id']?"selected='selected'":null;
    echo "<option value='{$elem['id']}' $selected>{$elem['code']} {$elem['title']}, {$elem['professor']}</option>\n";
}
echo <<<EOD
</select></td>
<td style='text-align:right;padding-right:0px;'><input type='submit' value='Submit' class='myUI-button-right' /></td></tr>

<tr><td style='text-align:right;'>N°2</td>
<td colspan='2'>
<select name='writing2'>
<option value=''>&nbsp;</option>
EOD;
foreach($rh->writings as $elem){
    $selected=$writing2==$elem['id']?"selected='selected'":null;
    echo "<option value='{$elem['id']}' $selected>{$elem['code']} {$elem['title']}, {$elem['professor']}</option>\n";
}
echo <<<EOD
</select>
</td>
<td style='text-align:right;padding-right:0px;'><input type='button' value='$lock2' onclick='lockRH2(this,$student);' class='myUI-button-right' /></td>
</tr>
<!--
<tr><td style='text-align:right;'>N°3</td>
<td colspan='2'>
<select name='writing3'>
<option value=''>&nbsp;</option>
EOD;
foreach($rh->writings as $elem){
    $selected=$writing3==$elem['id']?"selected='selected'":null;
    echo "<option value='{$elem['id']}' $selected>{$elem['code']} {$elem['title']}, {$elem['professor']}</option>\n";
}
echo <<<EOD
</select>
</td></tr>
-->
<tr><td style='padding-left:15px;font-weight:bold;' colspan='3'>Seminars</td>
</tr>

<tr><td style='text-align:right;'>N°1</td>
<td colspan='2'>
<select name='seminar1'>
<option value=''>&nbsp;</option>
EOD;
foreach($rh->seminars as $elem){
    $selected=$seminar1==$elem['id']?"selected='selected'":null;
    echo "<option value='{$elem['id']}' $selected>{$elem['code']} {$elem['title']}, {$elem['professor']}</option>\n";
}
echo <<<EOD
</select>
</td></tr>
<tr><td style='text-align:right;'>N°2</td>
<td colspan='2'>
<select name='seminar2'>
<option value=''>&nbsp;</option>
EOD;
foreach($rh->seminars as $elem){
    $selected=$seminar2==$elem['id']?"selected='selected'":null;
    echo "<option value='{$elem['id']}' $selected>{$elem['code']} {$elem['title']}, {$elem['professor']}</option>\n";
}
echo <<<EOD
</select>
</td></tr>
<tr><td style='text-align:right;'>N°3</td>
<td colspan='2'>
<select name='seminar3'>
<option value=''>&nbsp;</option>
EOD;
foreach($rh->seminars as $elem){
    $selected=$seminar3==$elem['id']?"selected='selected'":null;
    echo "<option value='{$elem['id']}' $selected>{$elem['code']} {$elem['title']}, {$elem['professor']}</option>\n";
}
echo <<<EOD
</select>
</td></tr>
</table>
</form>
</fieldset>
</div>
<br/><br/>


<h3 style='margin-top:50px;'>University Courses</h3>
<div>
EOD;
// include("courses_univ.php");


include("courses_univ4.php");	//	Nouvelles tables (courses_cm, courses_td courses_univ3)

echo "</div>\n";
// echo <<<EOD
// 
// <h3 style='margin-top:50px;'>Independent study, or courses at CIPh or other institutions</h3>
// <div>
// EOD;

$isForm=false;
// include("courses_ciph.php");

include("form.tutorat.inc");

include("form.stage.inc");
?>
</div>
</div>