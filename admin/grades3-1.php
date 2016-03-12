<?php
// Last update : 2016-03-12

ini_set('display_errors',0);
ini_set('error_reporting',E_ERROR | E_WARNING | E_PARSE);

require_once("../inc/config.php");
require_once("../inc/class.ciph.inc");
require_once("../inc/class.reidhall.inc");
require_once("../inc/class.univ4.inc");
require_once("../header.php");
require_once("menu.php");

access_ctrl("18,19,20");


//	Reid Hall Courses
$r=new reidhall();
$r->fetchAll();

//	Univ. Courses
$u=new univ4();
$u->fetchAllStudents(true);
$u->elements=array_map("replace_name",$u->elements);
$nbUniv=count($u->elements);


//	Reid Hall Courses
echo <<<EOD
<h3>Grades, {$_SESSION['vwpp']['semester']}</h3>
<span style='position: absolute; top: 60px; right: 12px; ;text-align:right;'>
<input type='button' value='Export to Excel' onclick='location.href="grades3_export.php";' class='myUI-button-right' />
</span>

<b>VWPP Courses</b>
<table class='datatable'>
<thead>
  <tr>
    <th class='dataTableNoSort'>&nbsp;</th>
    <th>Code</th>
    <th>Course title</th>
    <th>Professor</th>
  </tr>
</thead>

<tbody>
EOD;
foreach($r->elements as $elem){
  echo "<tr>\n";
  echo "<td><a href='grades3-2.php?univ=VWPP&amp;id={$elem['id']}'><img src='../img/edit.png' alt='Edit' border='0'/></a></td>\n";
  echo "<td>{$elem['code']}</td><td>{$elem['title']}</td><td>{$elem['professor']}</td>\n";
  echo "</tr>\n";
}

echo <<<EOD
</tbody>
</table>
EOD;


//	Univ. Courses
echo <<<EOD
<a name='univ'>&nbsp;</a>
<br/><br/>
<b>University Courses ($nbUniv)</b>
<table class='datatable'>
<thead>
  <tr>
    <th class='dataTableNoSort'>&nbsp;</th>
    <th>Institution</th>
    <th>Discipline</th>
    <th>Code</th>
    <th>Course title</th>
    <th>Professor</th>
    <th>Student</th>
  </tr>
</thead>

<tbody>
EOD;
foreach($u->elements as $elem){
  echo "<tr>\n";
  echo "<td><a href='grades3-2.php?univ=univ&amp;id={$elem['id']}'><img src='../img/edit.png' alt='Edit' border='0'/></a></td>\n";
  echo "<td>";
  if($elem['lien']){
    echo "&rdsh;&nbsp;";
  }
  echo "{$elem['institution2']}</td><td>{$elem['discipline']}</td>";
  echo "<td>{$elem['code']}</td>\n";
  echo "<td>{$elem['nom']}</td>\n";
  echo "<td>{$elem['prof']}</td><td>{$elem['studentName']}</td>\n";
  echo "</tr>\n";
}


echo <<<EOD
</tbody>
</table>
EOD;

require_once("../footer.php");
?>