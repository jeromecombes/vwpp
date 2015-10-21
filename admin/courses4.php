<?php
// Last update : 2015-10-21

require_once "../header.php";
require_once "../inc/class.reidhall.inc";
require_once "../inc/class.univ4.inc";
require_once "menu.php";

access_ctrl(23);

$semester=str_replace("_"," ",$_SESSION['vwpp']['semestre']);

//		Get VWPP Courses
$rh=new reidhall();
$rh->fetchAll();
$reidhall=$rh->elements;
$nb['reidhall']=count($reidhall);

//		Sort VWPP Courses
$_SESSION['vwpp']['vwppSort']=$_SESSION['vwpp']['vwppSort']?$_SESSION['vwpp']['vwppSort']:"code";
$vwppSort=isset($_GET['vwppSort'])?$_GET['vwppSort']:$_SESSION['vwpp']['vwppSort'];
usort($reidhall,"cmp_".$vwppSort);

//		Sort Univ Courses
$_SESSION['vwpp']['univSort']=$_SESSION['vwpp']['univSort']?$_SESSION['vwpp']['univSort']:"institution2";
$univSort=isset($_GET['univSort'])?$_GET['univSort']:$_SESSION['vwpp']['univSort'];
$_SESSION['vwpp']['univSort']=$univSort;

//		Get Univ Courses
$u=new univ4();
$u->sort=$univSort;
$u->fetchAllStudents();
$univ=$u->elements;
$nb['univ']=count($univ);





//	VWPP Table	//
echo <<<EOD
<h3>VWPP Courses for $semester ({$nb['reidhall']})</h3>
<table class='datatable'>
<thead>
  <tr>
    <th class='dataTableNoSort'>&nbsp;</th>
    <th>Type</th>
    <th>Code</th>
    <th>Title</th>
    <th>Professor</th>
  </tr>
</thead>

<tbody>
EOD;

$i=1;
foreach($reidhall as $elem){
  echo "<tr><td>\n";
  echo "&nbsp;<a href='courses-edit.php?id={$elem['id']}'>";
  echo "<img src='../img/edit.png' alt='Edit' /></a>\n";
  echo "&nbsp;<a href='courses-students.php?id={$elem['id']}'>";
  echo "<img src='../img/people.png' alt='Students' /></a>\n";
  echo "</td>\n";
  echo "<td>{$elem['type']}</td><td>{$elem['code']}</td><td>{$elem['title']}</td><td>{$elem['professor']}</td></tr>\n";
}
echo "</tbody>\n";
echo "</table>\n";
echo "<div style='margin-top:20px; text-align:right;'>\n";
if(in_array(16,$_SESSION['vwpp']['access'])){
  echo "<input type='button' onclick='location.href=\"courses-edit.php?univ=rh\";' value='Add a VWPP Course'  class='myUI-button-right'/>\n";
}
echo "<input type='button' onclick='location.href=\"courses_excel_vwpp.php\";' value='Export Final Reg. to Excel' class='myUI-button-right'/>\n";
echo "<input type='button' onclick='location.href=\"courses_excel_vwpp2.php\";' value='Export Students choices to Excel' class='myUI-button-right'/>\n";
echo "</div>\n";



//	University Table	//
echo <<<EOD
<br/><a name='univ'><br/></a>
<h3>University Courses for $semester ({$nb['univ']})</h3>
<table class='datatable'>
<thead>
  <tr>
    <th class='dataTableNoSort'>&nbsp;</th>
    <th>Institution</th>
    <th>Discipline</th>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Professor</th>
    <th>Type</th>
    <th>Student</th>
  </tr>
</thead>

<tbody>
EOD;

$i=1;
foreach($univ as $elem){
  echo "<tr><td><a href='courses4-univ-edit.php?id={$elem['id']}'>\n";
  echo "<img src='../img/edit.png' alt='Edit' /></a>\n";
  echo "</td>\n";
  echo "<td>";
  if($elem['lien']){
    echo "&rdsh;&nbsp;";
  }
  echo "{$elem['institution2']}</td><td>{$elem['discipline']}</td>\n";
  echo "<td>{$elem['code']}</td>\n";
  echo "<td>{$elem['nom']}</td><td>{$elem['prof']}</td><td>{$elem['nature']}</td>\n";
  echo "<td>{$elem['studentName']}</td>\n";
  echo "</tr>\n";
}
echo "</tbody>\n";
echo "</table>\n";
echo "<div style='margin-top:20px; text-align:right;' >\n";
echo "<input type='button' onclick='location.href=\"courses4_excel.php\"'; value='Export to excel' class='myUI-button-right'/>\n";
echo "</div>\n";

require_once "../footer.php";
?>