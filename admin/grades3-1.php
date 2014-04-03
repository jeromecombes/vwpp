<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ERROR | E_WARNING | E_PARSE);
ini_set('error_reporting',E_ALL);
require_once("../inc/config.php");
require_once("../inc/class.ciph.inc");
require_once("../inc/class.reidhall.inc");
require_once("../inc/class.univ4.inc");
require_once("../header.php");
require_once("menu.php");

access_ctrl("18,19,20");


//	Reid Hall Courses
$sortVWPP=isset($_GET['sortVWPP'])?$_GET['sortVWPP']:(isset($_SESSION['vwpp']['sortVWPP'])?$_SESSION['vwpp']['sortVWPP']:"title");
$_SESSION['vwpp']['sortVWPP']=$sortVWPP;
$r=new reidhall();
$r->fetchAll();
usort($r->elements,"cmp_".$sortVWPP);

//	Univ. Courses
$sortUniv=isset($_GET['sortUniv'])?$_GET['sortUniv']:(isset($_SESSION['vwpp']['sortUniv'])?$_SESSION['vwpp']['sortUniv']:"univ");
$_SESSION['vwpp']['sortUniv']=$sortUniv;
$u=new univ4();
$u->sort=$sortUniv;
$u->fetchAllStudents(true);
$u->elements=array_map(replace_name,$u->elements);
$nbUniv=count($u->elements);


//	CIPh. Courses
$sortCIPh=isset($_GET['sortCIPh'])?$_GET['sortCIPh']:(isset($_SESSION['vwpp']['sortCIPh'])?$_SESSION['vwpp']['sortCIPh']:"institution");
$_SESSION['vwpp']['sortCIPh']=$sortCIPh;
$c=new ciph();
$c->fetchAll($_SESSION['vwpp']['login_univ']);
usort($c->elements,"cmp_".$sortCIPh);


//	Reid Hall Courses
echo <<<EOD
<h3>Grades, {$_SESSION['vwpp']['semester']}</h3>
<b>VWPP Courses</b>
<table cellspacing='0'>
<tr class='th'><td>&nbsp;</td>
<td>Code
<a href='grades3-1.php?sortVWPP=code'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades3-1.php?sortVWPP=code_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>

<td>Course title
<a href='grades3-1.php?sortVWPP=title'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades3-1.php?sortVWPP=title_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>

<td>Professor
<a href='grades3-1.php?sortVWPP=professor'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades3-1.php?sortVWPP=professor_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td></tr>
EOD;
foreach($r->elements as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'>\n";
  echo "<td><a href='grades3-2.php?univ=VWPP&amp;id={$elem['id']}'><img src='../img/edit.png' alt='Edit' border='0'/></a></td>\n";
  echo "<td>{$elem['code']}</td><td>{$elem['title']}</td><td>{$elem['professor']}</td></tr>\n";
}

echo <<<EOD
</table>
EOD;


//	Univ. Courses
echo <<<EOD
<a name='univ'>&nbsp;</a>
<br/><br/>
<b>University Courses ($nbUniv)</b>
<table cellspacing='0'>
<tr class='th'><td>&nbsp;</td>
<td>Institution
<a href='grades3-1.php?sortUniv=institution2#univ'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades3-1.php?sortUniv=institution2_desc#univ_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Discipline
<a href='grades3-1.php?sortUniv=discipline2#univ'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades3-1.php?sortUniv=discipline2_desc#univ'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Code
<a href='grades3-1.php?sortUniv=code2#univ'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades3-1.php?sortUniv=code2_desc#univ'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Course title
<a href='grades3-1.php?sortUniv=nom#univ'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades3-1.php?sortUniv=nom_desc#univ'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Professor
<a href='grades3-1.php?sortUniv=prof#univ'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades3-1.php?sortUniv=prof_desc#univ'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Student
<a href='grades3-1.php?sortUniv=studentName2#univ'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades3-1.php?sortUniv=studentName2_desc#univ'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td></tr>

EOD;
foreach($u->elements as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'>\n";
  echo "<td><a href='grades3-2.php?univ=univ&amp;id={$elem['id']}'><img src='../img/edit.png' alt='Edit' border='0'/></a></td>\n";
  echo "<td>";
  if($elem['lien']){
    echo "&rdsh;&nbsp;";
  }
  echo "{$elem['institution2']}</td><td>{$elem['discipline']}</td>";
  echo "<td>{$elem['code']}</td>\n";
  echo "<td>{$elem['nom']}</td>\n";
  echo "<td>{$elem['prof']}</td><td>{$elem['studentName']}</td></tr>\n";
}

echo <<<EOD
</table>
EOD;



//	CIPh. Courses
/*echo <<<EOD
<a name='ciph'>&nbsp;</a>
<br/><br/>
<b>Independent studies and courses at other institutions</b>
<table cellspacing='0'>
<tr class='th'><td>&nbsp;</td>
<td>Institution
<a href='grades3-1.php?sortCIPh=institution#ciph'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades3-1.php?sortCIPh=institution_desc#ciph'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Domaine
<a href='grades3-1.php?sortCIPh=domaine#ciph'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades3-1.php?sortCIPh=domaine_desc#ciph'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Titre
<a href='grades3-1.php?sortCIPh=titre#ciph'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades3-1.php?sortCIPh=titre_desc#ciph'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Instructeur
<a href='grades3-1.php?sortCIPh=instructeur#ciph'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades3-1.php?sortCIPh=instructeur_desc#ciph'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td></tr>
EOD;
foreach($c->elements as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'>\n";
  echo "<td><a href='grades3-2.php?univ=ciph&amp;id={$elem['id']}'><img src='../img/edit.png' alt='Edit' border='0'/></a></td>\n";
  echo "<td>{$elem['institution']}</td><td>{$elem['domaine']}</td>";
  echo "<td>{$elem['titre']}</td><td>{$elem['instructeur']}</td></tr>\n";
}
echo "</table>\n";
*/

echo <<<EOD
<!-- <br/><br/><a href='grades_export.php' disabled='disabled'>Export to Excel</a> -->
<br/><br/><input type='button' value='Export to Excel' onclick='location.href="grades3_export.php";' />
EOD;

require_once("../footer.php");
?>