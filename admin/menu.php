<?php
// Last update : 2015-03-19

$script=explode("/",$_SERVER['SCRIPT_NAME']);
$script=$script[count($script)-1];
$semester=($_SESSION['vwpp']['semestre'] or $_REQUEST['semestre'])?true:false;

echo <<<EOD
<div id='title'>VWPP Database - Admin</div>
<div id='loginName'>{$_SESSION['vwpp']['login_name']}
  <span class='ui-icon ui-icon-triangle-1-s' id='myMenuTriangle'></span><br/>
  <div id='myMenu'>
    <a href='myAccount.php'>My Account</a><br/>
    <a href='logout.php'>Logout</a>
  </div>
</div>

<div class='ui-tabs ui-widget ui-widget-content ui-corner-all'>
<nav>
<ul class='ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all'>
<li id='li0' class='ui-state-default ui-corner-top'><a href='index.php'>Home</a></li>
EOD;
if($semester){
  if(in_array(24,$_SESSION['vwpp']['access']))
    echo "<li id='li11' class='ui-state-default ui-corner-top'><a href='dates.php'>Dates</a></li>\n";

  echo "<li id='li5' class='ui-state-default ui-corner-top'><a href='students-list.php'>Students</a></li>\n";

  if(in_array(2,$_SESSION['vwpp']['access']))
    echo "<li id='li7' class='ui-state-default ui-corner-top'><a href='housing.php'>Housing</a></li>\n";

  echo "<li id='li10' class='ui-state-default ui-corner-top'><a href='univ_reg.php'>Univ. reg.</a></li>\n";

  if(in_array(23,$_SESSION['vwpp']['access']))
    echo "<li id='li1' class='ui-state-default ui-corner-top'><a href='courses4.php'>Courses</a></li>\n";
  
  if(in_array(18,$_SESSION['vwpp']['access']) or in_array(19,$_SESSION['vwpp']['access']) or in_array(20,$_SESSION['vwpp']['access']))
    echo "<li id='li9' class='ui-state-default ui-corner-top'><a href='grades3-1.php'>Grades</a></li>\n";

  echo "<li id='li4' class='ui-state-default ui-corner-top'><a href='eval_index.php'>Evaluations</a></li>\n";

  if(in_array(3,$_SESSION['vwpp']['access']))
    echo "<li id='li8' class='ui-state-default ui-corner-top'><a href='documents.php'>Documents</a></li>\n";
}

if(in_array(9,$_SESSION['vwpp']['access']))
  echo "<li id='li2' class='ui-state-default ui-corner-top'><a href='users.php'>Users</a></li>\n";

echo "<li id='li6' class='ui-state-default ui-corner-top'><a href='myAccount.php'>My Account</a></li>\n";

?>
</ul>
</nav>
<section id='content'>
