<?php
// Last update : 2015-10-16

require_once "../inc/config.php";
require_once "../inc/class.student.inc";
require_once "../inc/class.doc.inc";
require_once "../header.php";
require_once "menu.php";

access_ctrl(3);

$d=new doc();
$d->fetchAllStudents($_SESSION['vwpp']['login_univ']);
$docs=$d->docs;

$_SESSION['vwpp']['type']=isset($_POST['type'])?htmlentities($_POST['type'],ENT_QUOTES|ENT_IGNORE,"utf-8"):$_SESSION['vwpp']['type'];
$_SESSION['vwpp']['sort']=isset($_GET['sort'])?$_GET['sort']:$_SESSION['vwpp']['sort'];
$sort=$_SESSION['vwpp']['sort']?$_SESSION['vwpp']['sort']:"lastname";

if(is_array($docs)){
  usort($docs,"cmp_".$sort);
}

echo <<<EOD
<h3>Documents</h3>
<!--
<p>
In this space you can upload required documents by clicking the edit button below.<br/>
Note that only pdf, jpg and word documents (with extensions .pdf, jpg our .jpeg and .doc or .docx) are permitted.<br/>
Please name each document as follows:<br/>
Lastname-type-of-document<br/>
Make sure not to append the extension (pdf, doc, jpg etc.) to the name of your file.<br/>
<br/>
</p>
-->
<div>
<form name='form' action='documents.php' method='post'>
Type of document : 
<select name='type' style='width:200px;' onchange='document.form.submit();'>
<option value=''>All</option>
EOD;
foreach($GLOBALS['config']['documentType'] as $type){
  $type=htmlentities($type,ENT_QUOTES|ENT_IGNORE,"utf-8");
  $selected=$type==$_SESSION['vwpp']['type']?"selected='selected'":null;
  echo "<option value='$type' $selected >$type</option>\n";
}
echo <<<EOD
</select>
</form>
</div>
<br/><br/>
EOD;

if($docs){
  echo <<<EOD
  <table class='datatable'>
  <thead>
  <tr>
  <th style='width:0px;padding:0;'>&nbsp;</th>
  <th>Lastname</th>
  <th>Firstname</th>
  <th>Doc. name</th>
  <th>Type</th>
  <th style='text-align:right;'>Size</th>
  <th class='dataTableDate'>Date</th>
EOD;
  if($_SESSION['vwpp']['category']=="admin"){
    echo "<th>Visibility</th>";
  }
  echo "</tr>\n";
  echo "</thead>\n";
  echo "<tbody>\n";
  foreach($docs as $doc){
    if($doc['rel']==$_SESSION['vwpp']['type'] or !$_SESSION['vwpp']['type']){
      $doc['size']=$doc['size']?$doc['size']:null;
      $visibility=$doc['adminOnly']?"Admin only":null;
      echo "<tr>\n";
      echo "<td>&nbsp;</td>\n";
      echo "<td>{$doc['lastname']}</td>\n";
      echo "<td>{$doc['firstname']}</td>\n";
      echo "<td><a href='../preview.php?id={$doc['id']}' target='_blank'>{$doc['name2']}</a></td>\n";
      echo "<td>{$doc['rel']}</td>\n";
      echo "<td style='text-align:right;'>{$doc['size']}</td>\n";
      echo "<td>".date($GLOBALS['config']['dateFormat'],$doc['timestamp'])."</td>\n";
      if($_SESSION['vwpp']['category']=="admin"){
	echo "<td>$visibility</td></tr>\n";
      }
    }
  }
  echo "</tbody>\n";
  echo "</table>\n";
}
//	Copy-paste from form.docs.inc
// get_button("Edit",$id,8,"right");	// text, div id, acl, align
/*
echo <<<EOD
</fieldset></div>
<div id='div-edit$id' style='display:none;'>
<form name='stdform$id' method='post' enctype='multipart/form-data' action='upload.php'>
<input type='hidden' name='std_id' value='$std_id' />
<!--
<input type='hidden' name='page' value='students-view2.php' />
<input type='hidden' name='std-page' value='documents.php' />
<input type='hidden' name='table' value='documents' />
<input type='hidden' name='acl' value='9' />
-->
<fieldset>
<legend>Documents</legend>
EOD;

echo "<table cellspacing='0'>\n";
echo "<tr class='th'><td>&nbsp;</td><td>Name</td><td>Type</td>";
if($_SESSION['vwpp']['category']=="admin"){
  echo "<td>Visibility</td>";
}
echo "<td>File</td><td>&nbsp;</td></tr>\n";
$i=0;
if($docs){
  foreach($docs as $doc){
    if($_SESSION['vwpp']['category']=="admin" or !$doc['adminOnly']){
      echo <<<EOD
      <tr>
      <td><input type='hidden' name='docs[$i][]' value='{$doc['id']}' /></td>
      <td><input type='text' name='docs[$i][]' value='{$doc['name']}' /></td>
      <td><select name='docs[$i][]'>
	<option value=''>&nbsp;</option>
EOD;
      foreach($GLOBALS['config']['documentType'] as $elem){
	$selected=$doc['rel']==htmlentities($elem,ENT_QUOTES|ENT_IGNORE,"utf8")?"selected='selected'":null;
	echo "<option $selected value='$elem'>$elem</option>\n";
      }
      echo "</select></td>\n";

      if($_SESSION['vwpp']['category']=="admin"){
	$checked=$doc['adminOnly']?"checked='checked'":null;
	echo "<td><input type='checkbox' name='docs[$i][]' value='1' $checked /> Admin Only</td>\n";
      }
      echo "<td><input type='file' name='files[$i]' />\n";
      echo "<a href='javascript:delete_doc({$doc['id']})'><img src='{$GLOBALS['config']['folder']}/img/delete.png' alt='delete' border='0' /></a></td>\n";
      echo "</tr>\n";
      }
    $i++;
  }
}
    
for($j=0;$j<3;$j++){
  echo <<<EOD
  <tr>
  <td><input type='hidden' name='docs[$i][]' /></td>
  <td><input type='text' name='docs[$i][]' /></td>
    <td>
    <select name='docs[$i][]'>
    <option value=''>&nbsp;</option>
    <option value='Passport'>Passport</option>
    <option value='Id Card'>Id Card</option>
    </td>
EOD;
  if($_SESSION['vwpp']['category']=="admin"){
    echo "<td><input type='checkbox' name='docs[$i][]' value='1' /> Admin Only</td>\n";
  }
  echo "<td><input type='file' name='files[$i]' /></td></tr>\n";
  $i++;
}

echo <<<EOD
</table>
<p style='text-align:right'>
<input type='button' value='Cancel' onclick='document.getElementById("div-edit$id").style.display="none";document.getElementById("div$id").style.display="";' />
<input type='submit' value='Submit' /></p>

</fieldset></form></div>
EOD;
*/


require_once "../footer.php";

?>