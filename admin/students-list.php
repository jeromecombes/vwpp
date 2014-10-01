<?php
// Last update : 2014-10-01

require_once "../inc/class.univ_reg.inc";
require_once "../inc/class.dates.inc";
require_once "../header.php";
require_once "menu.php";

if(isset($_GET['semestre'])){
  $_SESSION['vwpp']['semestre']=$_GET['semestre'];
  $_SESSION['vwpp']['semester']=str_replace("_"," ",$_GET['semestre']);

}
$semestre=isset($_SESSION['vwpp']['semestre'])?$_SESSION['vwpp']['semestre']:null;
$semester=str_replace("_"," ",$semestre);
$sort=$_GET['sort']?"cmp_".$_GET['sort']:"cmp_lastname";


if($semestre and in_array(4,$_SESSION['vwpp']['access'])){
  $addStudents="<a href='students-add.php'>Add students</a>\n";
}

//		Check If dates (dead lines) are registered
$d=new dates();
$d->fetch();
if(empty($d->elements)){
  echo "<center>";
  echo "<b style='color:red;'>Attention, les dates (dead-lines) ne sont pas renseignées</b><br/>\n";
  echo "Veuillez les renseigner dans l'onglet \"Dates\".<br/><br/>\n";
  echo "</center>\n";
}


if($semestre){
  //		Add French University
  $u=new univ_reg();
  $u->fetchAll();
  $univ_reg=$u->elements;

  $db=new db();
  $db->select("students","*","semesters LIKE '%\"$semestre\"%'");
  $students=$db->result;
  for($i=0;$i<count($students);$i++){
      $students[$i]['lastname']=decrypt($students[$i]['lastname']);
      $students[$i]['firstname']=decrypt($students[$i]['firstname']);
      $students[$i]['gender']=decrypt($students[$i]['gender'],$students[$i]['id']);
      $students[$i]['email']=decrypt($students[$i]['email']);
      $students[$i]['univ']=$students[$i]['university'];
      $students[$i]['homeInstitution']=decrypt($students[$i]['homeInstitution'],$students[$i]['id']);
      $students[$i]['university']=$students[$i]['guest']?$students[$i]['homeInstitution']:$students[$i]['university'];
      $dob=strToTime(decrypt($students[$i]['dob'],$students[$i]['id']));
      $students[$i]['dob']=$dob;
      $dob=$dob?date("M d, Y",$dob):null;
      $students[$i]['dob_text']=$dob;
      //		Add French University
      $students[$i]['frenchUniv']=$univ_reg[$students[$i]['id']][2];
  }
  
  if(!$students){
    echo $addStudents;
  }
  
  if($students){			//		Count all students
    $nb=array("Vassar"=>0,"Wesleyan"=>0,"guest"=>0,"host"=> null);
    foreach($db->result as $elem){
      if($elem['university']=="Vassar" and !$elem['guest'])
	$nb['Vassar']++;
      if($elem['university']=="Wesleyan" and !$elem['guest'])
	$nb['Wesleyan']++;
      if($elem['guest']){
	$nb['guest']++;
	$nb['host']=$elem['university'];
      }
    }

  $tmp=array();				//		Remove Vassar or Wesleyan students
  if($_SESSION['vwpp']['login_univ']=="VWPP"){
    $tmp=$students;
  }
  else{
    for($i=0;$i<count($students);$i++){
      if($students[$i]['univ']==$_SESSION['vwpp']['login_univ']){
	$tmp[]=$students[$i];
      }
    }
  }
  $students=$tmp;
  usort($students,$sort);

    echo <<<EOD
    <h3>Student list for {$semester}</h3>

    <div class='marginBottom10'>
      <span class='marginRight'>Number of students : <b>{$db->nb}</b></span>
      <span class='marginRight'>Vassar : <b>{$nb['Vassar']}</b></span>
      <span class='marginRight'>Wesleyan : <b>{$nb['Wesleyan']}</b></span>
      <span class='marginRight'>Other : <b>{$nb['guest']}</b></span>
      <span class='myUI-button'>$addStudents</span>
    </div>

    <form name='form2' method='post' action='students-delete.php'>
    <table class='datatable'>
    <thead>
      <tr><th class='dataTableNoSort'><input type='checkbox' name='all' onclick='checkall("form2",this);' /></th>
      <th>Lastname</th>
      <th>Firstname</th>
      <th>Gender</th>
      <th>French Univ.</th>
      <th>Email</th>
      <th>Home Institution</th>
      </tr>
    </thead>
    <tbody>
EOD;
    foreach($students as $elem){
      echo <<<EOD
      <tr><td class='nowrap'>
      <input type='checkbox' name='students[]' value='{$elem['id']}' onclick='setTimeout("select_action(\"form2\")",5);'/>
      <input type='hidden' id='mail_{$elem['id']}' value='{$elem['email']}' />
      <a href='students-view2.php?id={$elem['id']}'><img src='../img/edit.png' alt='view' border='0'/></a>
      <!-- <a href='students-edit.php?id={$elem['id']}'><img src='../img/edit.png' alt='edit' /></a> -->
      </td>
      <td>{$elem['lastname']}</td><td>{$elem['firstname']}</td><td>{$elem['gender']}</td><td>{$elem['frenchUniv']}</td>
      <td><a href='mailto:{$elem['email']}'>{$elem['email']}</a></td>
      <td>{$elem['university']}</td></tr>
EOD;
    }
    echo "</tbody>\n";
    echo "</table></form>\n";
    echo "<br/><form name='form3' action='students-list.php' method='get'>\n";
    echo "<div class='marginBottom'>\n";
    echo "For selected students : ";
    echo "<select name='action' id='action' onchange='select_action(\"form2\");' style='width:250px;' class='ui-widget-content ui-corner-all'>\n";
    echo "<option value=''>&nbsp;</option>\n";
    echo "<option value='Excel'>Export General Info to Excel</option>\n";
    if(in_array(17,$_SESSION['vwpp']['access']))
      echo "<option value='Univ_reg'>Export Univ. Reg. to Excel</option>\n";
    if(in_array(23,$_SESSION['vwpp']['access'])){
      echo "<option value='intership'>Export Intership to Excel</option>\n";
      echo "<option value='tutorial'>Export Tutorial to Excel</option>\n";
    }
    echo "<option value='Email'>Send email (with Email Program)</option>\n";
    echo "<option value='Email2'>Send email (with Web Browser)</option>\n";
    if(in_array(4,$_SESSION['vwpp']['access']))
      echo "<option value='CreatePassword'>Send emails with passwords</option>\n";
    if(in_array(5,$_SESSION['vwpp']['access']))
      echo "<option value='Delete'>Delete</option>\n";
    if(in_array(7,$_SESSION['vwpp']['access'])){
      echo "<option value='closeHousing'>Close housing</option>\n";
      echo "<option value='openHousing'>Open housing</option>\n";
    }
    if(in_array(16,$_SESSION['vwpp']['access'])){
      echo "<option value='lockVWPP'>Lock VWPP Courses reg.</option>\n";
      echo "<option value='unlockVWPP'>Unlock VWPP Courses reg.</option>\n";
      echo "<option value='publishVWPP'>Publish VWPP Courses Final reg.</option>\n";
      echo "<option value='hideVWPP'>Hide VWPP Courses Finale reg.</option>\n";
    }
    echo "<input type='button' id='submit_button' value='Go' disabled='disabled' onclick='submit_action(\"form3\",\"form2\");' class='myUI-button marginLeft' />\n";
    echo "</div>\n";
    echo "</form>\n";
  }

}

require_once "../footer.php";
?>