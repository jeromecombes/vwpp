<?php
// Last update : 2014-04-04, Jérôme Combes

require_once "../header.php";
require_once "../inc/class.ciph.inc";
require_once "../inc/class.eval.inc";
require_once "../inc/class.reidhall.inc";
require_once "../inc/class.univ4.inc";
require_once "menu.php";
access_ctrl(22);

$s=new student();
$s->fetchAll($_SESSION['vwpp']['login_univ']);
$students=$s->elements;

usort($students,cmp_lastname);

$e=new evaluation();
$e->fetchStudents();
$e=$e->students;
// print_r($e);

echo "<table cellspacing='0' border='1' style='text-align:center;'>\n";
echo "<tr class='th'><td>Lastname</td><td>Firstname</td><td>Program</td><td>VWPP Courses</td>
  <td>Univ. Courses</td><td>CIPh</td><td>Tutorats</td><td>Intership</td></tr>\n";
foreach($students as $s){
  $r=new reidhall();
  $r->count2($s['id']);
  $nbVWPP=$r->nb;

  $c=new ciph();
  $c->count2($s['id']);
  $nbCiph=$c->nb;

  $u=new univ4();
  $u->student=$s['id'];
  $u->fetchAll();
  $nbUniv=count($u->elements);

  $class=$class=="tr1"?"tr2":"tr1";
  $classProgram=$e[$s['id']]['program']>0?"green bold":"red bold";
  $classVWPP=$e[$s['id']]['ReidHall']==$nbVWPP?"green bold":null;
  $classUniv=$e[$s['id']]['univ']==$nbUniv?"green bold":null;
  $classCiph=$e[$s['id']]['CIPH']==$nbCiph?"green bold":null;
  $classTutorats=$e[$s['id']]['tutorats']>0?"green bold":"red bold";
  $classIntership=$e[$s['id']]['intership']>0?"green bold":null;

  echo "<tr class='$class'><td>{$s['lastname']}</td><td>{$s['firstname']}</td>
    <td class='$classProgram'>{$e[$s['id']]['program']}</td>
    <td class='$classVWPP'>{$e[$s['id']]['ReidHall']} / $nbVWPP</td>
    <td class='$classUniv'>{$e[$s['id']]['univ']} / $nbUniv</td>
    <td class='$classCiph'>{$e[$s['id']]['CIPH']} / $nbCiph</td>
    <td class='$classTutorats'>{$e[$s['id']]['tutorats']}</td>
    <td class='$classIntership'>{$e[$s['id']]['intership']}</td></tr>\n";
}

echo "</table>\n";

require_once "../footer.php";
?>