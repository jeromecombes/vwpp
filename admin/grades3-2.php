<?php
// Last update : 2016-03-12

require_once("../inc/config.php");
require_once("../inc/class.ciph.inc");
require_once("../inc/class.courses.inc");
require_once("../inc/class.univ4.inc");
require_once("../inc/class.grades.inc");
require_once("../header.php");
require_once("menu.php");

access_ctrl("18,19,20");

$_SESSION['vwpp']['course_id']=isset($_GET['id'])?$_GET['id']:$_SESSION['vwpp']['course_id'];
$course_id=$_SESSION['vwpp']['course_id'];

$_SESSION['vwpp']['univ']=isset($_GET['univ'])?$_GET['univ']:$_SESSION['vwpp']['univ'];
$univ=$_SESSION['vwpp']['univ'];

$_SESSION['vwpp']['course_code']=isset($_GET['code'])?$_GET['code']:$_SESSION['vwpp']['course_code'];
$code=$_SESSION['vwpp']['course_code'];
$_SESSION['vwpp']['course_univ2']=isset($_GET['univ2'])?$_GET['univ2']:$_SESSION['vwpp']['course_univ2'];
$univ2=$_SESSION['vwpp']['course_univ2'];


switch($univ){
  case "VWPP" :
    $c=new courses();
    $c->getStudents($course_id,$_SESSION['vwpp']['login_univ']);
    $students=$c->students_attrib;
    $c->courseName($course_id);
    $course=$c->course;
    break;

  case "univ" :
    $u=new univ4();
    $u->fetch($course_id);
    $title=$u->elements['nom'];
    $course=array("code"=>$u->elements['code'],"title"=>$title,"professor"=>$u->elements['prof']);
    $students[]=array("id"=>$u->elements['student'],"lastname"=>$u->elements['studentLastname'],"firstname"=>$u->elements['studentFirstname']);
// print_r($u->elements);
    break;

  case "ciph" :
    $c=new ciph();
    $c->fetch($course_id);
    $course=array("code"=>"&nbsp;","title"=>$c->element['titre'],"professor"=>$c->element['instructeur']);
    $students[]=array("id"=>$c->element['student'],"lastname"=>$c->element['studentLastname'],"firstname"=>$c->element['studentFirstname']);
    break;
}

$g=new grades();
$g->fetchCourse($univ,$course_id);
for($i=0;$i<count($students);$i++){
  $students[$i]['note']=$g->grades[$students[$i]['id']]['note'];
  $students[$i]['grade1']=$g->grades[$students[$i]['id']]['grade1'];
  $students[$i]['grade2']=$g->grades[$students[$i]['id']]['grade2'];
  $students[$i]['grade']=$g->grades[$students[$i]['id']]['grade'];
  $students[$i]['date1']=$g->grades[$students[$i]['id']]['date1'];
  $students[$i]['date2']=$g->grades[$students[$i]['id']]['date2'];
}
$grades_tab=array("A+","A","A-","B+","B","B-","C+","C","C-","D+","D","D-","F","Pass","S","DS");

echo <<<EOD
<h3>Grades, {$_SESSION['vwpp']['semester']}</h3>
<p>
{$course['code']} {$course['title']}, {$course['professor']}
</p>
EOD;
if(empty($students)){
  echo "No student";
}
else{
  echo <<<EOD
  <form name='form_1' action='grades_update2.php' method='post'>
  <table class='datatable' data-sort='[["0","asc"],["1","asc"]]' >
  <thead>
    <tr>
      <th>Lastname</th>
      <th>Firstname</th>
      <th>Note</th>
      <th>Date received</th>
EOD;

  if(in_array(19, $_SESSION['vwpp']['access']) or in_array(20, $_SESSION['vwpp']['access'])){
    echo "<th>Pass/Fail NRO</th>\n";
    echo "<th>Actual Grade</th>\n";
    echo "<th>Reported Grade</th>\n";
    echo "<th>Date Recorded</th>\n";
  }

  echo "</tr>\n";
  echo "</thead>\n";

  echo "<tbody>\n";

  $j=$k=0;
  foreach($students as $elem){
    echo "<tr>\n";
    echo "<td>{$elem['lastname']}</td><td>{$elem['firstname']}</td>\n";
								  // Voir et modifier les notes FR
    if(in_array(18, $_SESSION['vwpp']['access'])){
      echo "<td><font id='form_1_$j'>{$elem['note']}</font>\n";	// Note
      $j++;
      echo "<input type='text' name='note_{$elem['id']}' value='{$elem['note']}' style='display:none;' onkeyup='verifNote(\"form_1\",this);'>\n";
      echo "<td><font id='form_1_$j'>{$elem['date1']}</font>\n";	// Date
      $j++;
      echo "<input type='text' name='date1_{$elem['id']}' style='display:none;width:80%;' value='{$elem['date1']}' class='myUI-datepicker-string' />\n";
      $k++;
      echo "</td>\n";
    }
								  // Voir les notes FR
    else{
      echo "<td><font>{$elem['note']}</font></td>\n";
      echo "<td><font>{$elem['date1']}</font></td>\n";
    }

    if(in_array(19, $_SESSION['vwpp']['access'])){		// Voir et modifier les notes US
      // Pass/Fail NRO
      echo "<td><font id='form_1_$j'>{$elem['grade1']}</font>\n";
      $j++;
      echo "<select name='grade1_{$elem['id']}' style='display:none;'>\n";
      echo "<option value=''>&nbsp;</option>\n";
      foreach($grades_tab as $grade){
	$selected=$grade==$elem['grade1']?"selected='selected'":null;
	echo "<option value='$grade' $selected >$grade</option>\n";
      }
      echo "</select></td>\n";

      // Actual grade
      echo "<td><font id='form_1_$j'>{$elem['grade2']}</font>\n";
      $j++;
      echo "<select name='grade2_{$elem['id']}' style='display:none;'>\n";
      echo "<option value=''>&nbsp;</option>\n";
      foreach($grades_tab as $grade){
	$selected=$grade==$elem['grade2']?"selected='selected'":null;
	echo "<option value='$grade' $selected >$grade</option>\n";
      }
      echo "</select></td>\n";

      // Reported Grade
      echo "<td><font id='form_1_$j'>{$elem['grade']}</font>\n";
      $j++;
      echo "<select name='grade_{$elem['id']}' style='display:none;'>\n";
      echo "<option value=''>&nbsp;</option>\n";
      foreach($grades_tab as $grade){
	$selected=$grade==$elem['grade']?"selected='selected'":null;
	echo "<option value='$grade' $selected >$grade</option>\n";
      }
      echo "</select></td>\n";

      echo "<td><font id='form_1_$j'>{$elem['date2']}</font>\n";	// Date
      $j++;
      echo "<input type='text' name='date2_{$elem['id']}' style='display:none;width:80%;' value='{$elem['date2']}' class='myUI-datepicker-string' />\n";
      $k++;
      echo "</td>\n";
    }
								  // Voir les notes US
    if(!in_array(19, $_SESSION['vwpp']['access']) and in_array(20, $_SESSION['vwpp']['access'])){
      echo "<td><font>{$elem['grade1']}</font></td>\n";
      echo "<td><font>{$elem['grade2']}</font></td>\n";
      echo "<td><font>{$elem['grade']}</font></td>\n";
      echo "<td><font>{$elem['date2']}</font></td>\n";
    }

    echo "</tr>\n";
  }

  echo "</tbody>\n";
  echo "</table>\n";

  if(in_array(18,$_SESSION['vwpp']['access']) or in_array(19,$_SESSION['vwpp']['access'])){
    echo <<<EOD
    <div style='text-align:right;margin:20px 0 0 0;'>
    <div id='form_1_$j' >
    <a href='grades3-1.php' class='myUI-button-right' >Back to list</a>
    <input type='button' onclick='displayForm("form",1);' value='Edit' class='myUI-button-right' />
    </div>
    <div id='form_1_done' style='display:none'>
    <a href='grades3-1.php' class='myUI-button-right' >Back to list</a>
    <input type='button' onclick='location.href="grades3-2.php"'; value='Cancel' class='myUI-button-right' />
    <input type='submit' value='Submit' id='submit' class='myUI-button-right' />
    </div>
    </div>
    </form>
EOD;
  }
  else{
    echo "<div style='text-align:right;margin:20px 0 0 0;'>\n";
    echo "<a href='grades3-1.php' class='myUI-button-right' >Back to list</a>\n";
    echo "</div>\n";
  }
}

require_once("../footer.php");
?>