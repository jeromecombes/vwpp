<?php
require_once "../header.php";
require_once "menu.php";
access_ctrl(4);
?>

<b>Adding students for <?php echo $_SESSION['vwpp']['semestre']; ?></b><br/>
<form name='form' action='students-add2.php' method='post'>
<table cellspacing='0' cellpadding='5'>
<tr class='th'><td>Lastname</td><td>Firstname</td><td>Email</td><td>Other</td></tr>
<?php
for($i=0;$i<60;$i++)
  {
  $hidden=$i>2?"style='display:none;'":null;
  echo "<tr $hidden id='tr_$i'>\n";
  echo "<td><input type='text' name='students[$i][]' onkeydown='add_fields($i);' /></td>\n";
  echo "<td><input type='text' name='students[$i][]' /></td>\n";
  echo "<td><input type='text' name='students[$i][]'/></td>\n";
  echo "<td><input type='checkbox' name='students[$i][]' value='1'/></td></tr>\n";
  }
?>
<tr><td colspan='3' style='text-align:center;'>
<input type='button' value='Cancel' onclick='history.back();'/>
<input type='submit' value='Add' style='margin-left:20px;'/></td></tr>
</table>
</form>


<?php
require_once "../footer.php";
?>