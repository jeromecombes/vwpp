<?php
// Last update : 2015-03-23

require_once "../header.php";
require_once "menu.php";
access_ctrl(4);
?>

<h3>Adding students for <?php echo $_SESSION['vwpp']['semestre']; ?></h3>
<form name='form' action='students-add2.php' method='post'>
<table cellspacing='0' cellpadding='5' style='width:100%;'>
<tr class='th'><th>Lastname</th><th>Firstname</th><th>Email</th><th>Other</th></tr>
<?php
for($i=0;$i<60;$i++)
  {
  $hidden=$i>2?"style='display:none;'":null;
  echo "<tr $hidden id='tr_$i'>\n";
  echo "<td style='padding:8px 18px 0 0;'><input type='text' name='students[$i][]' onkeydown='add_fields($i);' /></td>\n";
  echo "<td style='padding:8px 18px 0 0;'><input type='text' name='students[$i][]' /></td>\n";
  echo "<td style='padding:8px 18px 0 0;'><input type='text' name='students[$i][]'/></td>\n";
  echo "<td style='padding:8px 18px 0 0;'><input type='checkbox' name='students[$i][]' value='1'/></td></tr>\n";
  }
?>
</table>

<div style='margin-top:30px;text-align:right;'>
<input type='button' value='Cancel' onclick='history.back();' class='myUI-button-right' />
<input type='submit' value='Add' style='margin-left:20px;' class='myUI-button-right' />
</div>
</form>


<?php
require_once "../footer.php";
?>