<?php
// Last update : 2015-10-19

// menu id
$current_id=array_key_exists("menu_id",$_SESSION['vwpp'])?$_SESSION['vwpp']['menu_id']:1;
$student=$_SESSION['vwpp']['std-id'];

$db=new db();
$db->select("students","*","id='{$_SESSION['vwpp']['std-id']}'");
$titleMenu=decrypt($db->result[0]['lastname']);
$titleMenu.=", ".decrypt($db->result[0]['firstname']);


echo <<<EOD
<div id='title'>VWPP Database - {$titleMenu}</div>
<div id='loginName'><span>{$_SESSION['vwpp']['login_name']}</span>
  <span class='ui-icon ui-icon-triangle-1-s' id='myMenuTriangle'></span><br/>
  <div id='myMenu'>
    <a href='myAccount.php'>My Account</a><br/>
    <a href='logout.php'>Logout</a>
  </div>
</div>

<div class='ui-tabs ui-widget ui-widget-content ui-corner-all'>
<nav>
<ul class='ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all'>
EOD;
get_menu2("General info",1,1);		//	menu name, page, menu id, required access
get_menu2("Housing",2,2);
get_menu2("Univ. Reg.",5,17);
get_menu2("Courses",4,16);
get_menu2("Grades",7,array(18,19,20));
get_menu2("Documents",3,3);
get_menu2("Schedule",8,1);

echo "<li  class='ui-state-default ui-corner-top back-to-list'><a href='students-list.php'>Back to list</a></li>\n";

$studentsList=$_SESSION["vwpp"]["studentsList"];
$key=array_search($student,$studentsList);
if(array_key_exists($key-1,$studentsList)){
  $previousId=$studentsList[$key-1];
  echo "<li class='ui-state-default ui-corner-top li-previous'><a href='students-view2.php?id=$previousId'>Previous</a></li>\n";
}
if(array_key_exists($key+1,$studentsList)){
  $nextId=$studentsList[$key+1];
  echo "<li class='ui-state-default ui-corner-top li-next'><a href='students-view2.php?id=$nextId'>Next</a></li>\n";
}

echo "</ul>\n";


?>