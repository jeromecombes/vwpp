<?php
		// menu id
$current_id=array_key_exists("menu_id",$_SESSION['vwpp'])?$_SESSION['vwpp']['menu_id']:1;

$db=new db();
$db->select("students","*","id='{$_SESSION['vwpp']['std-id']}'");
$titleMenu=decrypt($db->result[0]['lastname']);
$titleMenu.=" ".decrypt($db->result[0]['firstname']);

echo <<<EOD
<div id='onglets'>
<div id='titre'>{$titleMenu}</div>
<ul>\n
EOD;
get_menu("General info",1,1);		//	menu name, page, menu id, required access
get_menu("Housing",2,2);
get_menu("Univ. Reg.",5,17);
get_menu("Courses",4,16);
get_menu("Grades",7,array(18,19,20));
get_menu("Upload Docs",3,3);

echo <<<EOD
<li style='position:absolute;right:0px;'><a href='students-list.php'>Back to list</a></li>
</ul></div>
<div id='information_{$_GET['error']}'>{$GLOBALS['lang'][$_GET['msg']]}</div>
<script type='text/JavaScript'>setTimeout("document.getElementById('information_{$_GET['error']}').style.display='none'",3000);</script>
<div id="content">
EOD;
?>