<?php
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
    <table style='padding:20px 0 0 0;width:1180px;' border='0'>
    <tr style='vertical-align:top;'>
    <td style='width:200px;'>

    Number of students : {$db->nb}<br/>
    Vassar : {$nb['Vassar']}<br/>
    Wesleyan : {$nb['Wesleyan']}<br/>
    Other : {$nb['guest']}<br/><br/>
    $addStudents<br/>
    </td><td>

    <form name='form2' method='post' action='students-delete.php'>
    <table id='myTab' cellspacing='0' style='width:100%;'><tr class='th'><td>
    <input type='checkbox' name='all' onclick='checkall("form2",this);' /></td>
    <td>Lastname
    <a href='students-list.php?sort=lastname'>
    <img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
    <a href='students-list.php?sort=lastname_desc'>
    <img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>
    <td>Firstname
    <a href='students-list.php?sort=firstname'>
    <img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
    <a href='students-list.php?sort=firstname_desc'>
    <img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>
    <td>Gender
    <a href='students-list.php?sort=gender'>
    <img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
    <a href='students-list.php?sort=gender_desc'>
    <img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>
    <td>French Univ.
    <a href='students-list.php?sort=frenchUniv'>
    <img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
    <a href='students-list.php?sort=frenchUniv_desc'>
    <img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>
    <td>Email
    <a href='students-list.php?sort=email'>
    <img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
    <a href='students-list.php?sort=email_desc'>
    <img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td>
    <td>Home Institution
    <a href='students-list.php?sort=univ_lastname'>
    <img src='../img/up2.png' alt='Up' style='width:12px;' border='0'/></a>
    <a href='students-list.php?sort=univ_lastname_desc'>
    <img src='../img/down2.png' alt='Down' style='width:12px;margin: 2px 0 0 -5px;' border='0'/></a></td></tr>
EOD;
    $class="tr2";
    foreach($students as $elem){
      $class=$class=="tr1"?"tr2":"tr1";
//       $university=$elem['guest']?$elem['univ']:$elem['university'];
      echo <<<EOD
      <tr class='$class'><td style='width:50px;'>
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
    echo "</table></form>\n";
    echo "<br/><form name='form3' action='students-list.php' method='get'>\n";
    echo "For selected students : ";
    echo "<select name='action' id='action' onchange='select_action(\"form2\");' style='width:250px;'>\n";
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
    echo "<input type='button' id='submit_button' value='Go' disabled='disabled' onclick='submit_action(\"form3\",\"form2\");'/>\n";
    echo "</form>\n";
  }

}

echo "</td></tr></table>\n";

require_once "../footer.php";
?>