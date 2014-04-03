<?php
$li=array("li0","li1","li2","li3","li4","li5","li6","li7","li8","li9","li10","li11");

$script=explode("/",$_SERVER['SCRIPT_NAME']);
$script=$script[count($script)-1];
switch(substr($script,0,5)){
  case "cours" 	: $li[1]="current";	break;
  case "users" 	: $li[2]="current";	break;
  case "forms" 	: $li[3]="current";	break;
  case "eval_" 	: $li[4]="current";	break;
  case "stude" 	: $li[5]="current";	break;
  case "myAcc" 	: $li[6]="current";	break;
  case "housi" 	: $li[7]="current";	break;
  case "docum" 	: $li[8]="current";	break;
  case "grade" 	: $li[9]="current";	break;
  case "univ_" 	: $li[10]="current";	break;
  case "dates" 	: $li[11]="current";	break;
  default 	: $li[0]="current";	break;
}

$semester=($_SESSION['vwpp']['semestre'] or $_REQUEST['semestre'])?true:false;

echo <<<EOD
<div id='onglets'>
<div id='titre'>VWPP Database</div>
<ul>
<li id='{$li[0]}'><a href='index.php'>Home</a></li>
EOD;
if($semester){
  if(in_array(24,$_SESSION['vwpp']['access']))
    echo "<li id='{$li[11]}'><a href='dates.php'>Dates</a></li>\n";

  echo "<li id='{$li[5]}'><a href='students-list.php'>Students</a></li>\n";

  if(in_array(2,$_SESSION['vwpp']['access']))
    echo "<li id='{$li[7]}'><a href='housing.php'>Housing</a></li>\n";

  echo "<li id='{$li[10]}'><a href='univ_reg.php'>Univ. reg.</a></li>\n";

  if(in_array(23,$_SESSION['vwpp']['access']))
    echo "<li id='{$li[1]}'><a href='courses4.php'>Courses</a></li>\n";
  
  if(in_array(18,$_SESSION['vwpp']['access']) or in_array(19,$_SESSION['vwpp']['access']) or in_array(20,$_SESSION['vwpp']['access']))
    echo "<li id='{$li[9]}'><a href='grades3-1.php'>Grades</a></li>\n";

  echo "<li id='{$li[4]}'><a href='eval_index.php'>Evaluations</a></li>\n";

  if(in_array(3,$_SESSION['vwpp']['access']))
    echo "<li id='{$li[8]}'><a href='documents.php'>Documents</a></li>\n";
}

if(in_array(9,$_SESSION['vwpp']['access']))
  echo "<li id='{$li[2]}'><a href='users.php'>Users</a></li>\n";

echo "<li id='{$li[6]}'><a href='myAccount.php'>My Account</a></li>\n";

?>
<li id='logout'><a href='logout.php'>Logout</a></li>
</ul>
<?php echo "<div id='loginName'>{$_SESSION['vwpp']['login_name']}</div>\n"; ?>
</div>	<!--	Onglets	-->
<?php
echo <<<EOD
<div id='information_{$_GET['error']}'>{$GLOBALS['lang'][$_GET['msg']]}</div>
<script type='text/JavaScript'>setTimeout("document.getElementById('information_{$_GET['error']}').style.display='none'",3000);</script>
<div id="content">
EOD;
?>