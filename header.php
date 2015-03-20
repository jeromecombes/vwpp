<?php
// Last update : 2015-03-19

ini_set('display_errors',0);
ini_set('error_reporting',E_ERROR | E_WARNING | E_PARSE);
// ini_set('error_reporting',E_ALL);

require_once "inc/config.php";
require_once "inc/lang.main.inc";

switch($title){
  case "studentName" :
    $student=isset($_GET['id'])?$_GET['id']:$_SESSION['vwpp']['std-id'];
    $db=new db();
    $db->select("students","lastname,firstname","id='$student'");
    if($db->result){
      $title=decrypt($db->result[0]['firstname'])." ".decrypt($db->result[0]['lastname']);
    }
    else { $title="VWPP Database"; }
    break;
  default : $title="VWPP Database";	break;
}

//	Login control
login_ctrl();

if(!array_key_exists('vwpp',$_SESSION) and stripos($_SERVER['PHP_SELF'],"admin")){
  header("Location: ..");	// Redirect to home if try to get admin pages without session
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?php echo "<title>$title</title>\n"; ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
echo "<link rel='shortcut icon' href='{$config['folder']}/favicon.ico' type='image/x-icon' />\n";
echo "<link rel='StyleSheet' href='{$config['folder']}/css/jquery-ui.min.css' type='text/css' media='all'/>\n";
echo "<link rel='StyleSheet' href='{$config['folder']}/css/dataTables/jquery.dataTables_themeroller.css' type='text/css' media='all'/>\n";
echo "<link rel='StyleSheet' href='{$config['folder']}/css/style.css' type='text/css' media='screen'/>\n";
echo "<link rel='StyleSheet' href='{$config['folder']}/css/print.css' type='text/css' media='print'/>\n";

echo "<script type='text/JavaScript' src='{$config['folder']}/js/jquery-ui-1.10.4/jquery-1.10.2.js'></script>\n";
echo "<script type='text/JavaScript' src='{$config['folder']}/js/jquery-ui-1.10.4/ui/jquery-ui.js'></script>\n";
echo "<script type='text/JavaScript' src='{$config['folder']}/js/dataTables/jquery.dataTables.min.js'></script>\n";
echo "<script type='text/JavaScript' src='{$config['folder']}/js/dataTables/sort.js'></script>\n";
echo "<script type='text/JavaScript' src='{$config['folder']}/vendor/CJScript.js'></script>\n";
echo "<script type='text/JavaScript' src='{$config['folder']}/js/script.js'></script>\n";

?>
<noscript><center><h1>ATTENTION : JavaScript is needed</h1></center></noscript>
</head>
<body>
<?php
//	No session	=>	Login form
if(!array_key_exists('vwpp',$_SESSION)){
  include "login.php";		// Prompt the login form if no session 
  include "footer.php";
  exit;
}				// Else, show the requested page
?>
<form name='position' action='#'>
<input type='hidden' name='x' />
<input type='hidden' name='y' />
</form>
<div style='position:relative;top:30px;'>
<iframe id='calendrier' style='display:none' scrolling='no'></iframe>
</div>

<?php
if(isset($_GET['msg'])){
	$infoType=$_GET['error']?"error":"highlight";
	echo "<script type='text/JavaScript'>CJInfo(\"{$GLOBALS['lang'][$_GET['msg']]}\",\"$infoType\");</script>\n";
}
?>
