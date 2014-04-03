<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ERROR | E_WARNING | E_PARSE);
ini_set('error_reporting',E_ALL);
require_once("../inc/config.php");
require_once("../inc/class.ciph.inc");
require_once("../inc/class.reidhall.inc");
require_once("../inc/class.univ.inc");
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
$u=new univ();
$u->fetchAll($_SESSION['vwpp']['login_univ'],$group=true);
usort($u->elements,"cmp_".$sortUniv);
$nbUniv=count($u->elements);
// print_r($u->elements);

//	CIPh. Courses
$sortCIPh=isset($_GET['sortCIPh'])?$_GET['sortCIPh']:(isset($_SESSION['vwpp']['sortCIPh'])?$_SESSION['vwpp']['sortCIPh']:"institution");
$_SESSION['vwpp']['sortCIPh']=$sortCIPh;
$c=new ciph();
$c->fetchAll($_SESSION['vwpp']['login_univ']);
usort($c->elements,"cmp_".$sortCIPh);


//	Reid Hall Courses
echo <<<EOD
<h3>A continuer Adapter à UNIV3</h3>
<h3>Grades, {$_SESSION['vwpp']['semester']}</h3>
<b>VWPP Courses</b>
<table cellspacing='0'>
<tr class='th'><td>&nbsp;</td>
<td>Code
<a href='grades.php?sortVWPP=code'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades.php?sortVWPP=code_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>

<td>Course title
<a href='grades.php?sortVWPP=title'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades.php?sortVWPP=title_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>

<td>Professor
<a href='grades.php?sortVWPP=professor'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades.php?sortVWPP=professor_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td></tr>
EOD;
foreach($r->elements as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'>\n";
  echo "<td><a href='grades2.php?univ=VWPP&amp;id={$elem['id']}'><img src='../img/edit.png' alt='Edit' border='0'/></a></td>\n";
  echo "<td>{$elem['code']}</td><td>{$elem['title']}</td><td>{$elem['professor']}</td></tr>\n";
}

echo <<<EOD
</table>
EOD;


//	Univ. Courses
echo <<<EOD
<br/><br/>
<b>Univ. Courses ($nbUniv)</b>
<table cellspacing='0'>
<tr class='th'><td>&nbsp;</td>
<td>Univ.
<a href='grades.php?sortUniv=univ'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades.php?sortUniv=univ_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>UFR
<a href='grades.php?sortUniv=ufr_en'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades.php?sortUniv=ufr_en_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Code
<a href='grades.php?sortUniv=cm_code'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades.php?sortUniv=cm_code_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Course title
<a href='grades.php?sortUniv=cm_name_en'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades.php?sortUniv=cm_name_en_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Professor
<a href='grades.php?sortUniv=cm_prof'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades.php?sortUniv=cm_prof_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td></tr>
EOD;
foreach($u->elements as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'>\n";
//   echo "<td><a href='grades2.php?univ=univ&amp;id={$elem['id']}'><img src='../img/edit.png' alt='Edit' border='0'/></a></td>\n";
  echo "<td><a href='grades2.php?univ=univ&amp;univ2={$elem['university']}&amp;code={$elem['cm_code']}'><img src='../img/edit.png' alt='Edit' border='0'/></a></td>\n";
  echo "<td>{$elem['university']}</td><td>{$elem['ufr_en']}</td>";
  echo "<td>{$elem['cm_code']}</td>\n";
  echo $elem['cm_name_en']?"<td>{$elem['cm_name_en']}</td>":"<td>{$elem['cm_name']}</td>";
  echo "<td>{$elem['cm_prof']}</td></tr>\n";
}

echo <<<EOD
</table>
EOD;

//	CIPh. Courses
echo <<<EOD
<br/><br/>
<b>Independent studies and courses at other institutions</b>
<table cellspacing='0'>
<tr class='th'><td>&nbsp;</td>
<td>Institution
<a href='grades.php?sortCIPh=institution'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades.php?sortCIPh=institution_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Domaine
<a href='grades.php?sortCIPh=domaine'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades.php?sortCIPh=domaine_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Titre
<a href='grades.php?sortCIPh=titre'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades.php?sortCIPh=titre_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td>
<td>Instructeur
<a href='grades.php?sortCIPh=instructeur'><img src='../img/up2.png' alt='up' style='width:12px;' border='0'/></a>
<a href='grades.php?sortCIPh=instructeur_desc'><img src='../img/down2.png' alt='down 'style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a>
</td></tr>
EOD;
foreach($c->elements as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'>\n";
  echo "<td><a href='grades2.php?univ=ciph&amp;id={$elem['id']}'><img src='../img/edit.png' alt='Edit' border='0'/></a></td>\n";
  echo "<td>{$elem['institution']}</td><td>{$elem['domaine']}</td>";
  echo "<td>{$elem['titre']}</td><td>{$elem['instructeur']}</td></tr>\n";
}

echo <<<EOD
</table>

<br/><br/><a href='grades_export.php'>Export to Excel</a>
EOD;

require_once("../footer.php");
?>