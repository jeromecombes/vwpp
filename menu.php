<?php
$li=array("li0","li1","li2","li3","li4","li5","li6","li7","li8","li9");

$script=explode("/",$_SERVER['SCRIPT_NAME']);
$script=$script[count($script)-1];
switch(substr($script,0,3)){
  case "uni" 	: $li[1]="current";	break;
  case "hou" 	: $li[2]="current";	break;
  case "cou" 	: $li[3]="current";	break;
  case "eva" 	: $li[4]="current";	break;
  case "tri" 	: $li[5]="current";	break;
  case "myA" 	: $li[6]="current";	break;
  case "gen" 	: $li[7]="current";	break;
  case "doc" 	: $li[8]="current";	break;
  case "sch" 	: $li[9]="current";	break;
  default 	: $li[0]="current";	break;
}

if(count($_SESSION['vwpp']['semesters'])==1)
  $semester=str_replace(" ","_",$_SESSION['vwpp']['semesters'][0]);
else
  $semester=isset($_REQUEST['semester'])?str_replace(" ","_",$_REQUEST['semester']):$_SESSION['vwpp']['semestre'];

$db=new db();
$db->select("eval_enabled","*","semester='$semester' AND semester<>''");
$displayEval=$db->result?null:"style='display:none;'";

echo <<<EOD
<div id='onglets'>
<div id='titre'>{$_SESSION['vwpp']['login_name']}</div>
<ul>
<li id='{$li[0]}'><a href='index.php'>Home</a></li>
EOD;
if(array_key_exists("semester",$_SESSION['vwpp']) or $_POST['semester'] or count($_SESSION['vwpp']['semesters'])==1){
  echo <<<EOD
  <li id='{$li[7]}'><a href='general.php'>General Info.</a></li>
  <li id='{$li[2]}'><a href='housing.php'>Housing</a></li>
  <li id='{$li[1]}'><a href='univ_registration.php'>Univ. Reg.</a></li>
  <li id='{$li[3]}'><a href='courses.php'>Course Reg.</a></li>
  <!-- <li id='{$li[5]}'><a href='trip_index.php'>Trips</a></li> -->
  <li id='{$li[4]}' $displayEval ><a href='eval_index.php'>Evaluations</a></li>
  <li id='{$li[8]}'><a href='documents.php'>Upload Docs</a></li>
  <li id='{$li[9]}'><a href='schedule.php'>Schedule</a></li>
  <li id='{$li[6]}'><a href='myAccount.php'>My Account</a></li>
EOD;
  }

?>
<li style='position:absolute;right:0px;'><a href='logout.php'>Logout</a></li>
</ul>
</div>	<!--	Onglets	-->
<?php
echo <<<EOD
<div id='information_{$_GET['error']}'>{$GLOBALS['lang'][$_GET['msg']]}</div>
<script type='text/JavaScript'>setTimeout("document.getElementById('information_{$_GET['error']}').style.display='none'",3000);</script>
<div id="content">
EOD;
?>