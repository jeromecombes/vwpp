<?php
require_once "../header.php";
require_once "menu.php";

$semestre=$_SESSION['vwpp']['semestre'];
$formId=$_SESSION['vwpp']['formId'];

access_ctrl($formId);

switch($formId){
  case 6 : $formName="Students"; break;
  case 7 : $formName="Housing"; break;
}


echo "<h3>$formName form for $semestre</h3>\n";

$db=new db();
$db->select("forms","*","semestre='$semestre' AND formId='$formId'","ORDER BY ordre");
$fields=$db->result?$db->result:array();

echo "<form name='form' action='forms-update.php' method='post'>\n";
echo "<table>\n";
echo "<tr><td>Question</td><td>Type</td><td>Values</td><td>Order</td></tr>\n";
$i=1;
foreach($db->result as $elem){
  echo <<<EOD
  <tr><td><input type='hidden' name='forms[$i][]' value='{$elem['id']}' />
  <input type='text' name='forms[$i][]' id='q$i' value='{$elem['question']}' /></td>
  <td><select name='forms[$i][]' id='t$i'>
  <option value='text'>Text</option>
  <option value='textarea'>Textarea</option>
  <option value='select'>Select</option>
  <option value='checkbox'>Checkbox</option>
  <option value='radio'>Radio</option>
  <option value='password'>Password</option>
  </select>
  <script type='text/JavaScript'>document.getElementById("t$i").value='{$elem['type']}';</script>
  </td>
  <td><input type='text' name='forms[$i][]' id='r$i' value='{$elem['responses']}' /></td>
  <td><select name='forms[$i][]'id='o$i' >
EOD;
  for($j=1;$j<$db->nb+30;$j++){
    $selected=$j==$i?"selected='selected'":null;
    echo "<option value='$j' $selected>$j</option>\n";
  }
  echo "</select></td>\n";
  echo "<td><a href='javascript:delete_line($i);'><img src='' alt='Delete' /></a></td>\n";
  echo "</tr>\n";
  $i++;
}

$nb=$i;
for($i=$nb;$i<$nb+30;$i++){
  $hidden=$i>$nb+2?"style='display:none;'":null;
  echo "<tr $hidden id='tr_$i'>\n";
  echo "<td><input type='hidden' name='forms[$i][]' value='' />\n";
  echo "<input type='text' name='forms[$i][]' id='q$i' onkeydown='add_fields($i);' /></td>\n";
  echo "<td><select name='forms[$i][]' id='t$i' >\n";
  echo "<option value='text'>Text</option>\n";
  echo "<option value='textarea'>Textarea</option>\n";
  echo "<option value='select'>Select</option>\n";
  echo "<option value='checkbox'>Checkbox</option>\n";
  echo "<option value='radio'>Radio</option>\n";
  echo "<option value='password'>Password</option>\n";
  echo "</select></td>\n";
  echo "<td><input type='text' name='forms[$i][]' id='r$i' /></td>\n";
  echo "<td><select name='forms[$i][]' id='o$i' >\n";
  for($j=1;$j<$db->nb+30;$j++){
    $selected=$j==$i?"selected='selected'":null;
    echo "<option value='$j' $selected>$j</option>\n";
  }
  echo "</select></td>\n";
  echo "<td><a href='javascript:delete_line($i);'><img src='' alt='Delete' /></a></td>\n";
  echo "</tr>\n";
}
echo "<tr><td colspan='4'><input type='button' value='Cancel' onclick='location.href=\"forms-view.php\";'/>&nbsp;&nbsp;<input type='submit' value='Submit' /></td></tr>\n";
echo "</table></form>\n";


require_once "../footer.php";
?>