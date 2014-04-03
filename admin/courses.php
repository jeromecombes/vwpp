<?php
require_once "../header.php";
require_once "../inc/class.reidhall.inc";
require_once "../inc/class.univ.inc";
require_once "menu.php";

access_ctrl(23);

$semester=str_replace("_"," ",$_SESSION['vwpp']['semestre']);

//		Get VWPP Courses
$rh=new reidhall();
$rh->fetchAll();
$reidhall=$rh->elements;

//		Sort VWPP Courses
$_SESSION['vwpp']['vwppSort']=$_SESSION['vwpp']['vwppSort']?$_SESSION['vwpp']['vwppSort']:"type_desc";
$vwppSort=isset($_GET['vwppSort'])?$_GET['vwppSort']:$_SESSION['vwpp']['vwppSort'];
usort($reidhall,"cmp_".$vwppSort);


//		Get Univ Courses
$univ=new univ();
$univ->fetchAll($_SESSION['vwpp']['login_univ']);
$univ=$univ->elements;

//		Sort Univ Courses
$_SESSION['vwpp']['univSort']=$_SESSION['vwpp']['univSort']?$_SESSION['vwpp']['univSort']:"univ_lastname";
$univSort=isset($_GET['univSort'])?$_GET['univSort']:$_SESSION['vwpp']['univSort'];
usort($univ,"cmp_".$univSort);


//	VWPP Table	//
echo <<<EOD
<h3>VWPP Courses for $semester</h3>
<table id='myTab' cellspacing='0' style='width:1180px;'>
<tr class='th'><td style='width:50px;'></td>

<td>Type
<a href='courses.php?vwppSort=type'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses.php?vwppSort=type_desc'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

<td>Code
<a href='courses.php?vwppSort=code'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses.php?vwppSort=code_desc'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

<td>Title
<a href='courses.php?vwppSort=title'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses.php?vwppSort=title_desc'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

<td>Professor
<a href='courses.php?vwppSort=professor'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses.php?vwppSort=professor_desc'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

</tr>

EOD;

$class="tr2";
$i=1;
foreach($reidhall as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'><td style='width:70px;'>\n";
  printf("%02d",$i++);
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
<br/><br/>
<h3>University Courses for $semester</h3>
<table id='myTab' cellspacing='0' style='width:1180px;'>
<tr class='th'><td style='width:50px;'>&nbsp;</td>

<td>University
<a href='courses.php?univSort=univ_lastname'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses.php?univSort=univ_lastname_desc'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

<td>UFR
<a href='courses.php?univSort=ufr'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses.php?univSort=ufr_desc'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

<!-- <td>Discipline</td><td>Department</td>	-->

<td>Course Code
<a href='courses.php?univSort=cm_code'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses.php?univSort=cm_code_desc'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

<td>Course Name
<a href='courses.php?univSort=cm_name'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses.php?univSort=cm_name_desc'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

<td>Professor
<a href='courses.php?univSort=cm_prof'>
<img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
<a href='courses.php?univSort=cm_prof_desc'>
<img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>

<td>Réference</td>
</tr>

EOD;
$class="tr2";
$i=1;
foreach($univ as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'><td><a href='courses-univ-edit.php?id={$elem['id']}'>\n";
  echo "<img src='../img/edit.png' alt='Edit' /></a></td>\n";
  echo "<td>{$elem['university']}</td><td>{$elem['ufr']}</td>\n";
//   echo "<td>{$elem['discipline']}</td><td>{$elem['departement']}</td>\n";
  echo "<td>{$elem['cm_code']}</td>\n";
  echo "<td>{$elem['cm_name']}</td><td>{$elem['cm_prof']}</td>\n";
  $checked=$elem['ref']==1?"checked='checked'":null;
  echo "<td><input type='checkbox' name='ref{$elem['id']}' value='on' onclick='courses_ref({$elem['id']});' $checked/></td>\n";
  echo "</tr>\n";
}
echo "</table>\n";
echo "<div style='margin-top:10px;'><input type='button' onclick='location.href=\"courses_excel.php\"'; value='Export to excel'/></div>\n";
require_once "../footer.php";
?>