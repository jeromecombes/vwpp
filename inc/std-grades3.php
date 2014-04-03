<?php
require_once "class.courses.inc";
require_once "class.grades.inc";

$student=$_SESSION['vwpp']['category']=="admin"?$_SESSION['vwpp']['std-id']:$_SESSION['vwpp']['student'];
$c=new courses();
$c->fetch($student);

$vwpp_courses=$c->vwpp_courses;
$univ_courses=$c->univ_courses;
$ciph_courses=$c->ciph_courses;

$g=new grades();
$g->fetch($student);
$grades=$g->grades;

$grades_tab=array("A+","A","A-","B+","B","B-","C+","C","C-","D+","D","D-","F","Pass","S","DS");

echo <<<EOD
<div id='div$id' style='display:$display;'>
<form action='grades_update.php' method='post' name='form'>
<input type='hidden' name='student' value='$student' />
<h3>VWPP Courses</h3>				<!--	VWPP Courses	-->
<fieldset>
<table>
<tr><td style='width:640px;'>&nbsp;</td>
EOD;
if(in_array(18,$_SESSION['vwpp']['access'])){
  echo "<td style='width:50px;'>Note</td><td style='width:130px;'>Date received</td>";
}
if(in_array(19,$_SESSION['vwpp']['access']) or in_array(20,$_SESSION['vwpp']['access']))
  echo "<td style='width:70px;'>Grade US</td><td style='width:130px;'>Date Recorded</td>";
echo "</tr>\n";

foreach($vwpp_courses as $course){
  echo "<tr><td>{$course['title']}, {$course['professor']}</td>\n";
  if(in_array(18,$_SESSION['vwpp']['access'])){
    echo "<td><input type='text' name='VWPP_FR_{$course['id']}' value='{$grades['VWPP'][$course['id']]['note']}' onkeyup='verifNote(\"form\",this);'></td>\n";
/*    echo "<td><select name='VWPP_FR_{$course['id']}'>\n";	//	Note FR
    echo "<option value='null_fr'>&nbsp;</option>\n";
    for($i=0;$i<21;$i++){
      $selected=null;
      if(is_numeric($grades['VWPP'][$course['id']]['note']) and $grades['VWPP'][$course['id']]['note']==$i)		// empeche la mise à zéro si null
	$selected="selected='selected'";
      echo "<option value='$i' $selected >$i</option>\n";
    }
    echo "</select></td>\n";*/
  
  echo "<td><input type='text' name='VWPP_FRDATE_{$course['id']}' value='{$grades['VWPP'][$course['id']]['date1']}' style='width:110px;'/>\n";
  echo "<a href='javascript:calendar(\"form\",\"VWPP_FRDATE_{$course['id']}\",true);' >\n";
  echo "<img src='../img/calendar.gif' alt='Calendar' /></a></td>\n";
  }

  if(in_array(19,$_SESSION['vwpp']['access'])){		//	Grade US
    echo "<td><select name='VWPP_US_{$course['id']}'>\n";
    echo "<option value='null_us'>&nbsp;</option>\n";
   foreach($grades_tab as $grade){
      $selected=$grades['VWPP'][$course['id']]['grade']==$grade?"selected='selected'":null;
      echo "<option value='$grade' $selected >$grade</option>\n";
    }
    echo "</select></td>\n";
  echo "<td><input type='text' name='VWPP_USDATE_{$course['id']}' value='{$grades['VWPP'][$course['id']]['date2']}' style='width:110px;'/>\n";
  echo "<a href='javascript:calendar(\"form\",\"VWPP_USDATE_{$course['id']}\",true);' >\n";
  echo "<img src='../img/calendar.gif' alt='Calendar' /></a></td>\n";
  }
  elseif(in_array(20,$_SESSION['vwpp']['access'])){
    echo "<td>{$grades['VWPP'][$course['id']]['grade']}</td>\n";
    echo "<td>{$grades['VWPP'][$course['id']]['date2']}</td>\n";
  }
  echo "</tr>\n";
}

echo <<<EOD
</table>
</fieldset>		<!-- END OF VWPP -->

<h3>University Courses</h3>			<!--	University	-->
<fieldset>
<table>
<tr><td style='width:640px;'>&nbsp;</td>
EOD;
if(in_array(18,$_SESSION['vwpp']['access'])){
  echo "<td style='width:50px;'>Note</td><td style='width:130px;'>Date received</td>";
}
if(in_array(19,$_SESSION['vwpp']['access']) or in_array(20,$_SESSION['vwpp']['access']))
  echo "<td style='width:70px;'>Grade US</td><td style='width:130px;'>Date Recorded</td>";
echo "</tr>\n";

foreach($univ_courses as $course){
  echo "<tr><td>{$course['cm_name_en']}, {$course['cm_prof']}</td>\n";
  if(in_array(18,$_SESSION['vwpp']['access'])){			//	Note FR
    echo "<td><input type='text' name='UNIV_FR_{$course['id']}' value='{$grades['UNIV'][$course['id']]['note']}' onkeyup='verifNote(\"form\",this);'></td>\n";
/*    echo "<td><select name='UNIV_FR_{$course['id']}'>\n";	//	Note FR
    echo "<option value='null_fr'>&nbsp;</option>\n";
    for($i=0;$i<21;$i++){
      $selected=null;
      if(is_numeric($grades['UNIV'][$course['id']]['note']) and $grades['UNIV'][$course['id']]['note']==$i)		// empeche la mise à zéro si null
	$selected="selected='selected'";
      echo "<option value='$i' $selected >$i</option>\n";
    }
    echo "</select></td>\n";*/
    echo "<td><input type='text' name='UNIV_FRDATE_{$course['id']}' value='{$grades['UNIV'][$course['id']]['date1']}' style='width:110px;'/>\n";
    echo "<a href='javascript:calendar(\"form\",\"UNIV_FRDATE_{$course['id']}\",true);' >\n";
    echo "<img src='../img/calendar.gif' alt='Calendar' /></a></td>\n";
  }
  if(in_array(19,$_SESSION['vwpp']['access'])){		//	Grade US
    echo "<td><select name='UNIV_US_{$course['id']}'>\n";
    echo "<option value='null_us'>&nbsp;</option>\n";
    foreach($grades_tab as $grade){
      $selected=$grades['UNIV'][$course['id']]['grade']==$grade?"selected='selected'":null;
      echo "<option value='$grade' $selected >$grade</option>\n";
    }
    echo "</select></td>\n";
    echo "<td><input type='text' name='UNIV_USDATE_{$course['id']}' value='{$grades['UNIV'][$course['id']]['date2']}' style='width:110px;'/>\n";
    echo "<a href='javascript:calendar(\"form\",\"UNIV_USDATE_{$course['id']}\",true);' >\n";
    echo "<img src='../img/calendar.gif' alt='Calendar' /></a></td>\n";
  }
  elseif(in_array(20,$_SESSION['vwpp']['access'])){
    echo "<td>{$grades['UNIV'][$course['id']]['grade']}</td>\n";
    echo "<td>{$grades['UNIV'][$course['id']]['date2']}</td>\n";
  }
  echo "</tr>\n";
}


echo <<<EOD
</table>
</fieldset>		<!--	END OF University 	-->

<h3>CIPh or other institutions Courses</h3>
<fieldset>
<table>
<tr><td style='width:660px;'>&nbsp;</td>
EOD;
if(in_array(18,$_SESSION['vwpp']['access'])){
  echo "<td style='width:50px;'>Note</td><td style='width:130px;'>Date de réception</td>";
}
if(in_array(19,$_SESSION['vwpp']['access']) or in_array(20,$_SESSION['vwpp']['access'])){
  echo "<td style='width:50px;'>Grade</td><td style='width:130px;'>Date Recorded</td>";
}
echo "</tr>\n";

foreach($ciph_courses as $course){
  echo "<tr><td>{$course['titre']}, {$course['instructeur']}</td>\n";
  if(in_array(18,$_SESSION['vwpp']['access'])){
    echo "<td><input type='text' name='CIPH_FR_{$course['id']}' value='{$grades['CIPH'][$course['id']]['note']}' onkeyup='verifNote(\"form\",this);'></td>\n";
/*    echo "<td><select name='CIPH_FR_{$course['id']}'>\n";
    echo "<option value='null_fr'>&nbsp;</option>\n";
    for($i=0;$i<21;$i++){
      $selected=null;
      if(is_numeric($grades['CIPH'][$course['id']]['note']) and $grades['CIPH'][$course['id']]['note']==$i)		// empeche la mise à zéro si null
	$selected="selected='selected'";
      echo "<option value='$i' $selected >$i</option>\n";
    }
    echo "</select></td>\n";*/
    echo "<td><input type='text' name='CIPH_FRDATE_{$course['id']}' value='{$grades['CIPH'][$course['id']]['date1']}' style='width:110px;'/>\n";
    echo "<a href='javascript:calendar(\"form\",\"CIPH_FRDATE_{$course['id']}\",true);' >\n";
    echo "<img src='../img/calendar.gif' alt='Calendar' /></a></td>\n";
  }

  if(in_array(19,$_SESSION['vwpp']['access'])){		//	Grade US
    echo "<td><select name='CIPH_US_{$course['id']}'>\n";
    echo "<option value='null_us'>&nbsp;</option>\n";
    foreach($grades_tab as $grade){
      $selected=$grades['CIPH'][$course['id']]['grade']==$grade?"selected='selected'":null;
      echo "<option value='$grade' $selected >$grade</option>\n";
    }
    echo "</select></td>\n";
    echo "<td><input type='text' name='CIPH_USDATE_{$course['id']}' value='{$grades['CIPH'][$course['id']]['date2']}' style='width:110px;'/>\n";
    echo "<a href='javascript:calendar(\"form\",\"CIPH_USDATE_{$course['id']}\",true);' >\n";
    echo "<img src='../img/calendar.gif' alt='Calendar' /></a></td>\n";
  }
  elseif(in_array(20,$_SESSION['vwpp']['access'])){
    echo "<td>{$grades['CIPH'][$course['id']]['grade']}</td>\n";
    echo "<td>{$grades['CIPH'][$course['id']]['date2']}</td>\n";
  }
  echo "</tr>\n";
}


echo <<<EOD
</table>
</fieldset>		<!--	END OF CIPh 	-->

					
<br/<br/>
EOD;

if(in_array(18,$_SESSION["vwpp"]["access"]) or in_array(19,$_SESSION["vwpp"]["access"])){
  echo "<div style='text-align:right;width:1200px;'>\n";
  echo "<input type='submit' value='Submit' id='submit'/>\n";
  echo "</div>\n";
}

echo "</form></div>\n";
?>