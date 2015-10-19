<?php
// Last update : 2015-10-19

require_once "class.doc.inc";
//	Get data
$std_id=isset($GLOBALS['std_id'])?$GLOBALS['std_id']:null;

$d=new doc();
$d->fetchAll();
$docs=$d->docs;

if(is_array($docs)){
  usort($docs,"cmp_name");
}

echo <<<EOD
<h3>Documents</h3>
<p>
In this space you can upload required documents by clicking the edit button below.<br/>
Note that only pdf, jpg and word documents (with extensions .pdf, jpg our .jpeg and .doc or .docx) are permitted.<br/>
<br/>
</p>

<div id='div$id'>
<fieldset>
EOD;

$class="tr2";
if($docs){
  echo "<table cellspacing='0' cellpadding='5'>\n";
  echo "<tr class='th'><th>Name</th><th>Type</th><th style='text-align:right;'>Size</th><th>Date</th>";
  if($_SESSION['vwpp']['category']=="admin"){
    echo "<th>Visibility</th>";
  }
  echo "</tr>\n";
  foreach($docs as $doc){
    if($_SESSION['vwpp']['category']=="admin" or !$doc['adminOnly']){
      $doc['size']=$doc['size']?$doc['size']:null;
      $class=$class=="tr1"?"tr2":"tr1";
      $visibility=$doc['adminOnly']?"Admin only":null;
      echo "<tr class='$class'>\n";
      echo "<td><a href='{$GLOBALS['config']['url']}/preview.php?id={$doc['id']}' target='_blank'>{$doc['name2']}</a></td>\n";
      echo "<td>{$doc['rel']}</td>\n";
      echo "<td style='text-align:right;'>{$doc['size']}</td>\n";
      echo "<td>".date($GLOBALS['config']['dateFormat'],$doc['timestamp'])."</td>\n";
      if($_SESSION['vwpp']['category']=="admin"){
	echo "<td>$visibility</td></tr>\n";
      }
    }
  }
  echo "</table>\n";
}

get_button("Edit",$id,8,"right");	// text, div id, acl, align

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
EOD;

echo "<table cellspacing='0' cellpadding='5'>\n";
echo "<tr class='th'><th>Name</th><th>Type</th>";
if($_SESSION['vwpp']['category']=="admin"){
  echo "<th>Visibility</th>";
}
echo "<th>File</th></tr>\n";
$i=0;
if($docs){
  foreach($docs as $doc){
    if($_SESSION['vwpp']['category']=="admin" or !$doc['adminOnly']){
      echo <<<EOD
      <tr>
      <td><input type='hidden' name='docs[$i][]' value='{$doc['id']}' />
      <a href='{$GLOBALS['config']['url']}/preview.php?id={$doc['id']}' target='_blank'>{$doc['name2']}</a></td>
      <td><select name='docs[$i][]'>
	<option value='Other'>&nbsp;</option>
EOD;
      foreach($GLOBALS['config']['documentType'] as $elem){
	$elem=htmlentities($elem,ENT_QUOTES|ENT_IGNORE,"utf-8");
	$selected=$doc['rel']==$elem?"selected='selected'":null;
	echo "<option $selected value='$elem'>$elem</option>\n";
      }
      echo "</select></td>\n";

      if($_SESSION['vwpp']['category']=="admin"){
	$checked=$doc['adminOnly']?"checked='checked'":null;
	echo "<td><input type='checkbox' name='docs[$i][]' value='1' $checked /> Admin Only</td>\n";
      }
      echo "<td><input type='file' name='files[$i]' />\n";
      echo "<a href='javascript:delete_doc({$doc['id']})'>";
      echo "Delete File";
      echo "</a></td>\n";
      echo "</tr>\n";
      }
    $i++;
  }
}
    
for($j=0;$j<3;$j++){
  echo <<<EOD
  <tr>
  <td><input type='hidden' name='docs[$i][]' /></td>
    <td>
    <select name='docs[$i][]'>
    <option value=''>&nbsp;</option>
EOD;
    foreach($GLOBALS['config']['documentType'] as $elem){
      echo "<option value='$elem'>$elem</option>\n";
    }
    echo "</select></td>\n";

  if($_SESSION['vwpp']['category']=="admin"){
    echo "<td><input type='checkbox' name='docs[$i][]' value='1' /> Admin Only</td>\n";
  }
  echo "<td><input type='file' name='files[$i]' /></td></tr>\n";
  $i++;
}

echo <<<EOD
</table>
<p style='text-align:right'>
<br/>
<input type='button' value='Cancel' onclick='document.getElementById("div-edit$id").style.display="none";document.getElementById("div$id").style.display="";' class='myUI-button-right' />
<input type='submit' value='Submit' class='myUI-button-right' /></p>

</fieldset></form></div>
EOD;

?>
