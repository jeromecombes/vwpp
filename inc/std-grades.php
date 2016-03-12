<?php
// Last update 2016-03-12

require_once "class.courses.inc";
require_once "class.grades.inc";

$student=$_SESSION['vwpp']['category']=="admin"?$_SESSION['vwpp']['std-id']:$_SESSION['vwpp']['student'];
$c=new courses();
$c->fetch($student);

$vwpp_courses=$c->vwpp_courses;
$ciph_courses=$c->ciph_courses;

$tmp=$c->univ_courses;

$univ_courses=array();
$td_courses=array();
foreach($tmp as $elem){
    $univ_courses[]=$elem;
}

$g=new grades();
$g->fetch($student);
$grades=$g->grades;

$grades_tab=array("A+","A","A-","B+","B","B-","C+","C","C-","D+","D","D-","F","Pass","S","DS");

echo <<<EOD
<div id='div$id' style='display:$display;'>
<form action='grades_update.php' method='post' name='form_1'>
<input type='hidden' name='student' value='$student' />
<h3>VWPP Courses</h3>				<!--	VWPP Courses	-->
<fieldset>
<table>
<tr style='font-weight:bold;font-size:10pt;'><td style='width:595px;'>Course title</td>

EOD;
if(in_array(18,$_SESSION['vwpp']['access']) or in_array(19,$_SESSION['vwpp']['access']) or in_array(20,$_SESSION['vwpp']['access'])){
  echo "<td style='width:50px;'>Note</td><td style='width:150px;'>Date received</td>";
}
if(in_array(19,$_SESSION['vwpp']['access']) or in_array(20,$_SESSION['vwpp']['access'])){
  echo "<td style='width:75px;'>Pass/Fail NRO</td>";
  echo "<td style='width:75px;'>Actual Grade</td>";
  echo "<td style='width:75px;'>Reported Grade</td>";
  echo "<td style='width:150px;'>Date Recorded</td>";
}
echo "</tr>\n";

$i=0;
foreach($vwpp_courses as $course){
  echo "<tr><td>{$course['title']}, {$course['professor']}</td>\n";
  // VWPP Courses Notes Française
  // Modification
  if(in_array(18,$_SESSION['vwpp']['access'])){
    echo "<td><font id='form_1_$i'>{$grades['VWPP'][$course['id']]['note']}</font>\n";
    echo "<input style='display:none;' type='text' name='VWPP_FR_{$course['id']}' value='{$grades['VWPP'][$course['id']]['note']}' onkeyup='verifNote(\"form_1\",this);'></td>\n";
    $i++;
    echo <<<EOD
    <td><font id='form_1_$i'>{$grades['VWPP'][$course['id']]['date1']}</font>
      <input style='display:none;width:130px;' type='text' name='VWPP_FRDATE_{$course['id']}' value='{$grades['VWPP'][$course['id']]['date1']}' class='myUI-datepicker-string' />
    </td>
EOD;
    $i++;
  }
  // Affichage si pas le droit de modifier
  elseif(in_array(20,$_SESSION['vwpp']['access']) or in_array(19,$_SESSION['vwpp']['access'])){
    echo "<td>{$grades['VWPP'][$course['id']]['note']}</td>\n";
    echo "<td>{$grades['VWPP'][$course['id']]['date1']}</td>\n";
  }

  // Grades US
  // Modification
  // reported grade : $grades['VWPP'][$course['id']]['grade']
  // pass / fail / NRO :$grades['VWPP'][$course['id']]['grade1']
  // actual grade :$grades['VWPP'][$course['id']]['grade2']
  
  if(in_array(19,$_SESSION['vwpp']['access'])){
    // Reported grade
    echo "<td><font id='form_1_$i'>{$grades['VWPP'][$course['id']]['grade1']}</font>\n";
    $i++;
    echo "<select style='display:none;' name='VWPP_US1_{$course['id']}'>\n";
    echo "<option value=''>&nbsp;</option>\n";
   foreach($grades_tab as $grade){
      $selected=$grades['VWPP'][$course['id']]['grade1']==$grade?"selected='selected'":null;
      echo "<option value='$grade' $selected >$grade</option>\n";
    }
    echo "</select></td>\n";
    // Reported grade
    echo "<td><font id='form_1_$i'>{$grades['VWPP'][$course['id']]['grade2']}</font>\n";
    $i++;
    echo "<select style='display:none;' name='VWPP_US2_{$course['id']}'>\n";
    echo "<option value=''>&nbsp;</option>\n";
   foreach($grades_tab as $grade){
      $selected=$grades['VWPP'][$course['id']]['grade2']==$grade?"selected='selected'":null;
      echo "<option value='$grade' $selected >$grade</option>\n";
    }
    echo "</select></td>\n";
    // Reported grade
    echo "<td><font id='form_1_$i'>{$grades['VWPP'][$course['id']]['grade']}</font>\n";
    $i++;
    echo "<select style='display:none;' name='VWPP_US_{$course['id']}'>\n";
    echo "<option value=''>&nbsp;</option>\n";
   foreach($grades_tab as $grade){
      $selected=$grades['VWPP'][$course['id']]['grade']==$grade?"selected='selected'":null;
      echo "<option value='$grade' $selected >$grade</option>\n";
    }
    echo "</select></td>\n";
  // Recorded Grade
  echo "<td><font id='form_1_$i'>{$grades['VWPP'][$course['id']]['date2']}</font>\n";
  $i++;
  echo "<input style='display:none;width:130px;' type='text' name='VWPP_USDATE_{$course['id']}' value='{$grades['VWPP'][$course['id']]['date2']}' class='myUI-datepicker-string' />\n";
  echo "</td>\n";
  }
  // Affichage si pas le droit de modifier
  elseif(in_array(20,$_SESSION['vwpp']['access'])){
    // Reported Grade
    echo "<td>{$grades['VWPP'][$course['id']]['grade1']}</td>\n";
    // Reported Grade
    echo "<td>{$grades['VWPP'][$course['id']]['grade2']}</td>\n";
    // Reported Grade
    echo "<td>{$grades['VWPP'][$course['id']]['grade']}</td>\n";
    // Recorded date
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
<tr style='font-weight:bold;font-size:10pt;'><td style='width:595px;'>Course title</td>
EOD;
if(in_array(18,$_SESSION['vwpp']['access']) or in_array(19,$_SESSION['vwpp']['access']) or in_array(20,$_SESSION['vwpp']['access'])){
  echo "<td style='width:50px;'>Note</td><td style='width:150px;'>Date received</td>";
}
if(in_array(19,$_SESSION['vwpp']['access']) or in_array(20,$_SESSION['vwpp']['access'])){
  echo "<td style='width:75px;'>Pass/Fail NRO</td>";
  echo "<td style='width:75px;'>Actual Grade</td>";
  echo "<td style='width:75px;'>Reported Grade</td>";
  echo "<td style='width:150px;'>Date Recorded</td>";
}
echo "</tr>\n";

foreach($univ_courses as $course){
  echo "<tr><td>{$course['nom_en']}, {$course['prof']} ({$course['type']})</td>\n";
  if(in_array(18,$_SESSION['vwpp']['access'])){			//	Note FR
    echo "<td><font id='form_1_$i'>{$grades['UNIV'][$course['id']]['note']}</font>\n";
    echo "<input style='display:none;' type='text' name='UNIV_FR_{$course['id']}' value='{$grades['UNIV'][$course['id']]['note']}' onkeyup='verifNote(\"form_1\",this);'></td>\n";
    $i++;
    echo <<<EOD
    <td><font id='form_1_$i'>{$grades['UNIV'][$course['id']]['date1']}</font>
      <input style='display:none;width:130px;' type='text' name='UNIV_FRDATE_{$course['id']}' value='{$grades['UNIV'][$course['id']]['date1']}' class='myUI-datepicker-string' />
      </td>
EOD;
    $i++;
  }
  elseif(in_array(20,$_SESSION['vwpp']['access']) or in_array(19,$_SESSION['vwpp']['access'])){
    echo "<td>{$grades['UNIV'][$course['id']]['note']}</td>\n";
    echo "<td>{$grades['UNIV'][$course['id']]['date1']}</td>\n";
  }

  // Grades US
  // Modification
  // reported grade : $grades['VWPP'][$course['id']]['grade']
  // pass / fail / NRO :$grades['VWPP'][$course['id']]['grade1']
  // actual grade :$grades['VWPP'][$course['id']]['grade2']
  if(in_array(19,$_SESSION['vwpp']['access'])){
    // Pass Fail NRO
    echo "<td><font id='form_1_$i'>{$grades['UNIV'][$course['id']]['grade1']}</font>\n";
    $i++;
    echo "<select style='display:none;' name='UNIV_US1_{$course['id']}'>\n";
    echo "<option value=''>&nbsp;</option>\n";
    foreach($grades_tab as $grade){
      $selected=$grades['UNIV'][$course['id']]['grade1']==$grade?"selected='selected'":null;
      echo "<option value='$grade' $selected >$grade</option>\n";
    }
    echo "</select></td>\n";
    // Actual grade
    echo "<td><font id='form_1_$i'>{$grades['UNIV'][$course['id']]['grade2']}</font>\n";
    $i++;
    echo "<select style='display:none;' name='UNIV_US2_{$course['id']}'>\n";
    echo "<option value=''>&nbsp;</option>\n";
    foreach($grades_tab as $grade){
      $selected=$grades['UNIV'][$course['id']]['grade2']==$grade?"selected='selected'":null;
      echo "<option value='$grade' $selected >$grade</option>\n";
    }
    echo "</select></td>\n";
    // Reported Grade
    echo "<td><font id='form_1_$i'>{$grades['UNIV'][$course['id']]['grade']}</font>\n";
    $i++;
    echo "<select style='display:none;' name='UNIV_US_{$course['id']}'>\n";
    echo "<option value=''>&nbsp;</option>\n";
    foreach($grades_tab as $grade){
      $selected=$grades['UNIV'][$course['id']]['grade']==$grade?"selected='selected'":null;
      echo "<option value='$grade' $selected >$grade</option>\n";
    }
    echo "</select></td>\n";
    echo "<td><font id='form_1_$i'>{$grades['UNIV'][$course['id']]['date2']}</font>\n";
    $i++;
    echo "<input style='display:none;width:130px;' type='text' name='UNIV_USDATE_{$course['id']}' value='{$grades['UNIV'][$course['id']]['date2']}' class='myUI-datepicker-string' />\n";
    echo "</td>\n";
  }
  elseif(in_array(20,$_SESSION['vwpp']['access'])){
    echo "<td>{$grades['UNIV'][$course['id']]['grade']}</td>\n";
    echo "<td>{$grades['UNIV'][$course['id']]['grade1']}</td>\n";
    echo "<td>{$grades['UNIV'][$course['id']]['grade2']}</td>\n";
    echo "<td>{$grades['UNIV'][$course['id']]['date2']}</td>\n";
  }
  echo "</tr>\n";
}


echo <<<EOD
</table>
</fieldset>		<!--	END OF University 	-->

<!--
<h3>Discussion courses</h3>			<!--	TD	
<fieldset>
<table>
<tr style='font-weight:bold;font-size:10pt;'><td style='width:595px;'>Course title</td>
EOD;
if(in_array(18,$_SESSION['vwpp']['access']) or in_array(19,$_SESSION['vwpp']['access']) or in_array(20,$_SESSION['vwpp']['access'])){
  echo "<td style='width:50px;'>Note</td><td style='width:150px;'>Date received</td>";
}
if(in_array(19,$_SESSION['vwpp']['access']) or in_array(20,$_SESSION['vwpp']['access']))
  echo "<td style='width:75px;'>US Grade</td><td style='width:150px;'>Date Recorded</td>";
echo "</tr>\n";

foreach($td_courses as $course){
  echo "<tr><td>{$course['nom_en']}, {$course['prof']} ({$course['type']})</td>\n";
  if(in_array(18,$_SESSION['vwpp']['access'])){			//	Note FR
    echo "<td><font id='form_1_$i'>{$grades['TD'][$course['id']]['note']}</font>\n";
    $i++;
    echo "<input style='display:none;' type='text' name='TD_FR_{$course['id']}' value='{$grades['TD'][$course['id']]['note']}' onkeyup='verifNote(\"form_1\",this);'></td>\n";
    echo "<td><font id='form_1_$i'>{$grades['TD'][$course['id']]['date1']}</font>\n";
    $i++;
    echo "<input style='display:none;width:130px;' type='text' name='TD_FRDATE_{$course['id']}' value='{$grades['TD'][$course['id']]['date1']}' class='myUI-datepicker-string' />\n";
    echo "</td>\n";
  }
  elseif(in_array(20,$_SESSION['vwpp']['access']) or in_array(19,$_SESSION['vwpp']['access'])){
    echo "<td>{$grades['TD'][$course['id']]['note']}</td>\n";
    echo "<td>{$grades['TD'][$course['id']]['date1']}</td>\n";
  }

  if(in_array(19,$_SESSION['vwpp']['access'])){		//	Grade US
    echo "<td><font id='form_1_$i'>{$grades['TD'][$course['id']]['grade']}</font>\n";
    $i++;
    echo "<select style='display:none;' name='TD_US_{$course['id']}'>\n";
    echo "<option value=''>&nbsp;</option>\n";
    foreach($grades_tab as $grade){
      $selected=$grades['TD'][$course['id']]['grade']==$grade?"selected='selected'":null;
      echo "<option value='$grade' $selected >$grade</option>\n";
    }
    echo "</select></td>\n";
    echo "<td><font id='form_1_$i'>{$grades['TD'][$course['id']]['date2']}</font>\n";
    $i++;
    echo "<input style='display:none;width:130px;' type='text' name='TD_USDATE_{$course['id']}' value='{$grades['TD'][$course['id']]['date2']}' class='myUI-datepicker-string' />\n";
    echo "</td>\n";
  }
  elseif(in_array(20,$_SESSION['vwpp']['access'])){
    echo "<td>{$grades['TD'][$course['id']]['grade']}</td>\n";
    echo "<td>{$grades['TD'][$course['id']]['date2']}</td>\n";
  }
  echo "</tr>\n";
}


echo <<<EOD
</table>
</fieldset>		<!--	END OF TD		
-->

<!--
<h3>CIPh or other institutions Courses</h3>
<fieldset>
<table>
<tr style='font-weight:bold;font-size:10pt;'><td style='width:595px;'>Course title</td>
EOD;
if(in_array(18,$_SESSION['vwpp']['access']) or in_array(19,$_SESSION['vwpp']['access']) or in_array(20,$_SESSION['vwpp']['access'])){
  echo "<td style='width:50px;'>Note</td><td style='width:150px;'>Date received</td>";
}
if(in_array(19,$_SESSION['vwpp']['access']) or in_array(20,$_SESSION['vwpp']['access'])){
  echo "<td style='width:75px;'>US Grade</td><td style='width:150px;'>Date Recorded</td>";
}
echo "</tr>\n";

foreach($ciph_courses as $course){
  echo "<tr><td>{$course['titre']}, {$course['instructeur']}</td>\n";
  if(in_array(18,$_SESSION['vwpp']['access'])){
    echo "<td><font id='form_1_$i'>{$grades['CIPH'][$course['id']]['note']}</font>\n";
    $i++;
    echo "<input style='display:none;' type='text' name='CIPH_FR_{$course['id']}' value='{$grades['CIPH'][$course['id']]['note']}' style='width:90px;'/>\n";
    echo "<td><font id='form_1_$i'>{$grades['CIPH'][$course['id']]['date1']}</font>\n";
    $i++;
    echo "<input style='display:none;width:130px;' type='text' name='CIPH_FRDATE_{$course['id']}' value='{$grades['CIPH'][$course['id']]['date1']}' class='myUI-datepicker-string' />\n";
    echo "</td>\n";
  }
  elseif(in_array(20,$_SESSION['vwpp']['access']) or in_array(19,$_SESSION['vwpp']['access'])){
    echo "<td>{$grades['CIPH'][$course['id']]['note']}</td>\n";
    echo "<td>{$grades['CIPH'][$course['id']]['date1']}</td>\n";
  }

  if(in_array(19,$_SESSION['vwpp']['access'])){		//	Grade US
    echo "<td><font id='form_1_$i'>{$grades['CIPH'][$course['id']]['grade']}</font>\n";
    $i++;
    echo "<select style='display:none;'name='CIPH_US_{$course['id']}'>\n";
    echo "<option style='display:none;' value=''>&nbsp;</option>\n";
    foreach($grades_tab as $grade){
      $selected=$grades['CIPH'][$course['id']]['grade']==$grade?"selected='selected'":null;
      echo "<option value='$grade' $selected >$grade</option>\n";
    }
    echo "</select></td>\n";
    echo "<td><font id='form_1_$i'>{$grades['CIPH'][$course['id']]['date2']}</font>\n";
    $i++;
    echo "<input style='display:none;width:130px;' type='text' name='CIPH_USDATE_{$course['id']}' value='{$grades['CIPH'][$course['id']]['date2']}' class='myUI-datepicker-string' />\n";
    echo "</td>\n";
  }
  elseif(in_array(20,$_SESSION['vwpp']['access'])){
    echo "<td>{$grades['CIPH'][$course['id']]['grade']}</td>\n";
    echo "<td>{$grades['CIPH'][$course['id']]['date2']}</td>\n";
  }
  echo "</tr>\n";
}


echo <<<EOD
</table>
</fieldset>	-->	<!--	END OF CIPh 	-->

					
<br/<br/>
EOD;

if(in_array(18,$_SESSION["vwpp"]["access"]) or in_array(19,$_SESSION["vwpp"]["access"])){
  echo "<div style='text-align:right; margin-bottom:20px;'>\n";
  echo "<input id='form_1_radio_0' style='display:none;' type='button' value='Cancel' onclick='location.href=\"students-view2.php\";' class='myUI-button-right' />\n";
  echo "<input id='form_1_done' style='display:none;' type='submit' value='Submit' class='myUI-button-right' />\n";
  echo "<input type='button' value='Change' id='form_1_$i' onclick='displayForm(\"form\",1);' class='myUI-button-right' />\n";
  echo "</div>\n";
}

echo "</form></div>\n";
?>