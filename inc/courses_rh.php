<?php
require_once "class.reidhall.inc";
//	Get RH courses attribution
$attrib=array();
$db=new db();
$db->select("courses_attrib_rh","*","student='{$_SESSION['vwpp']['student']}' AND semester='{$_SESSION['vwpp']['semestre']}'");
if($db->result){
  $attrib[]=$db->result[0]['writing1'];
  $attrib[]=$db->result[0]['writing2'];
  $attrib[]=$db->result[0]['writing3'];
  $attrib[]=$db->result[0]['seminar1'];
  $attrib[]=$db->result[0]['seminar2'];
  $attrib[]=$db->result[0]['seminar3'];
}

//	Get names of RH courses
$rh=new reidhall();
$rh->fetchAll();
$courses=$rh->elements;


if(!empty($attrib) and $rh->isPublished($_SESSION['vwpp']['student'])){
  echo "<fieldset style='width:1170px;'><ul>\n";
  echo "<h3 style='margin-left:-40px;'><u>Final Reg.</u></h3>\n";
  foreach($attrib as $elem){
    if($elem){
      if($courses[$elem]['type']=="Writing")
	$courses[$elem]['type']="Writing-Intensive";
      echo "<li>{$courses[$elem]['type']} : {$courses[$elem]['code']} {$courses[$elem]['title']}, {$courses[$elem]['professor']}</li>\n";
    }
  }
  echo "</ul></fieldset>\n";
}

?>