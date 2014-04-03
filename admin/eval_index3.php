<?php
require_once "../header.php";
require_once "../inc/class.ciph.inc";
require_once "../inc/class.eval.inc";
require_once "../inc/class.reidhall.inc";
require_once "../inc/class.univ.inc";
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

  $u=new univ();
  $u->count2($s['id']);
  $nbUniv=$u->nb;

  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'><td>{$s['lastname']}</td><td>{$s['firstname']}</td><td>{$e[$s['id']]['program']}</td>
    <td>{$e[$s['id']]['ReidHall']} / $nbVWPP</td><td>{$e[$s['id']]['univ']} / $nbUniv</td>
    <td>{$e[$s['id']]['CIPH']} / $nbCiph</td>
    <td>{$e[$s['id']]['tutorats']}</td><td>{$e[$s['id']]['intership']}</td></tr>\n";
}

echo "</table>\n";

require_once "../footer.php";
?>