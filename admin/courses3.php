<?php
require_once "../header.php";
require_once "../inc/class.reidhall.inc";
require_once "../inc/class.univ3.inc";
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

//		Get Univ Courses
$u=new univ3();
$u->fetchAllCM();
$univ=$u->elements;
$nb['univ']=count($univ);




//		Sort Univ Courses
$_SESSION['vwpp']['univSort']=$_SESSION['vwpp']['univSort']?$_SESSION['vwpp']['univSort']:"univ_lastname";
$univSort=isset($_GET['univSort'])?$_GET['univSort']:$_SESSION['vwpp']['univSort'];
usort($univ,"cmp_".$univSort);

//		Get Discussion Courses
$td=new univ3();
$td->fetchAllTD();
$td=$td->elements;
$nb['td']=count($td);

//		Sort Discussion Courses
$_SESSION['vwpp']['TDSort']=$_SESSION['vwpp']['TDSort']?$_SESSION['vwpp']['TDSort']:"univ_lastname";
$TDSort=isset($_GET['TDSort'])?$_GET['TDSort']:$_SESSION['vwpp']['TDSort'];
usort($td,"cmp_".$TDSort);


//	VWPP Table	//
echo <<<EOD
<h3>VWPP Courses for $semester ({$nb['reidhall']})</h3>
<table id='myTab' cellspacing='0' style='width:1180px;'>
<tr class='th'><td style='width:50px;'></td>

<td>Type
<a href='courses3.php?vwppSort=type'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses3.php?vwppSort=type_desc'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

<td>Code
<a href='courses3.php?vwppSort=code'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses3.php?vwppSort=code_desc'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

<td>Title
<a href='courses3.php?vwppSort=title'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses3.php?vwppSort=title_desc'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

<td>Professor
<a href='courses3.php?vwppSort=professor'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses3.php?vwppSort=professor_desc'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

</tr>

EOD;

$class="tr2";
$i=1;
foreach($reidhall as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'><td style='width:30px;'>\n";
  echo "&nbsp;<a href='courses-edit.php?id={$elem['id']}'>";
  echo "<img src='../img/edit.png' alt='Edit' /></a>\n";
  echo "&nbsp;<a href='courses-students.php?id={$elem['id']}'>";
  echo "<img src='../img/people.png' alt='Students' /></a>\n";
  echo "</td>\n";
  echo "<td>{$elem['type']}</td><td>{$elem['code']}</td><td>{$elem['title']}</td><td>{$elem['professor']}</td></tr>\n";
}
echo "</table>\n";
echo "<div style='margin-top:10px;'><input type='button' onclick='location.href=\"courses_excel_vwpp.php\";' value='Export Final Reg. to Excel'/>\n";
echo "<input type='button' onclick='location.href=\"courses_excel_vwpp2.php\";' style='margin-left:40px;' value='Export Students choices to Excel'/></div>\n";

echo "<div style='width:1180px;text-align:right;margin-top:-25px;'>\n";
echo "<input type='button' onclick='location.href=\"courses-edit.php?univ=rh\";' value='Add a VWPP Course' />\n";
echo "</div>\n";



//	University Table	//
echo <<<EOD
<br/><a name='univ'><br/></a>
<h3>University Courses for $semester ({$nb['univ']})</h3>
<table id='myTab' cellspacing='0' style='width:1180px;'>
<tr class='th'><td style='width:50px;'>&nbsp;</td>

<td>University
<a href='courses3.php?univSort=univ_lastname#univ'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses3.php?univSort=univ_lastname_desc#univ'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

<td>UFR
<a href='courses3.php?univSort=ufr#univ'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses3.php?univSort=ufr_desc#univ'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

<!-- <td>Discipline</td><td>Department</td>	-->

<td>Course Code
<a href='courses3.php?univSort=code#univ'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses3.php?univSort=code_desc#univ'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

<td>Course Name
<a href='courses3.php?univSort=nom#univ'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses3.php?univSort=nom_desc#univ'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

<td>Professor
<a href='courses3.php?univSort=prof#univ'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses3.php?univSort=prof_desc#univ'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

</tr>

EOD;
$class="tr2";
$i=1;
foreach($univ as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'><td style='width:30px;'><a href='courses3-univ-edit.php?id={$elem['id']}'>\n";
  echo "<img src='../img/edit.png' alt='Edit' /></a>\n";
  echo "&nbsp;<a href='courses3-students-univ.php?id={$elem['id']}'>";
  echo "<img src='../img/people.png' alt='Students' /></a>\n";
  echo $elem['students'];
  echo "</td>\n";
  echo "<td>{$elem['university']}</td><td>{$elem['ufr']}</td>\n";
//   echo "<td>{$elem['discipline']}</td><td>{$elem['departement']}</td>\n";
  echo "<td>{$elem['code']}</td>\n";
  echo "<td>{$elem['nom']}</td><td>{$elem['prof']}</td>\n";
  echo "</tr>\n";
}
echo "</table>\n";
echo "<div style='margin-top:10px;'><input type='button' onclick='location.href=\"courses3_excel.php\"'; value='Export to excel' /></div>\n";


//	TD Table	//


//		Continuer les tris		<<<<<<<<<//////////////////////////////////////


echo <<<EOD
<br/><a name='TD'><br/></a>
<h3>University Discussion section for $semester ({$nb['td']})</h3>
<table id='myTab' cellspacing='0' style='width:1180px;'>
<tr class='th'>
  <td style='width:50px;'>&nbsp;</td>
  <td>University
  <a href='courses3.php?TDSort=univ_lastname#TD'>
  <img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
  <a href='courses3.php?TDSort=univ_lastname_desc#TD'>
  <img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>
  <td>Discussion code
  <a href='courses3.php?TDSort=code#TD'>
  <img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
  <a href='courses3.php?TDSort=code_desc#TD'>
  <img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>
  <td>Course name
  <a href='courses3.php?TDSort=nom#TD'>
  <img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
  <a href='courses3.php?TDSort=nom_desc#TD'>
  <img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>
  <td>Professor
  <a href='courses3.php?TDSort=prof#TD'>
  <img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
  <a href='courses3.php?TDSort=prof_desc#TD'>
  <img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>
  <td>Lecture code
  <a href='courses3.php?TDSort=cm_code#TD'>
  <img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
  <a href='courses3.php?TDSort=cm_code_desc#TD'>
  <img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>
  <td>Lecture name
  <a href='courses3.php?TDSort=cm_nom#TD'>
  <img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
  <a href='courses3.php?TDSort=cm_nom_desc#TD'>
  <img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td></tr>
EOD;
foreach($td as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo <<<EOD
  <tr class='$class'>
    <td style='width:30px;'><a href='courses3-univ-editTD.php?id={$elem['id']}'>
      <img src='../img/edit.png' alt='Edit' /></a>
      &nbsp;<a href='courses3-students-td.php?id={$elem['id']}'><img src='../img/people.png' alt='Students' /></a></td>
    <td>{$elem['university']}</td>
    <td>{$elem['code']}</td>
    <td>{$elem['nom']}</td>
    <td>{$elem['prof']}</td>
    <td>{$elem['cm_code']}</td>
    <td>{$elem['cm_nom']}</td></tr>
EOD;
}
echo "</table>\n";
echo "<div style='margin-top:10px;'><input type='button' onclick='location.href=\"courses3_excelTD.php\"'; value='Export to excel' /></div>\n";

require_once "../footer.php";
?>