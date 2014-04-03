<?php
require_once  "../header.php";
require_once  "menu.php";
access_ctrl(9);

		//	select users
$db=new db();
$db->select("users",null,null,"order by lastname,firstname");
		//	login-ctrl
/*
foreach($db->result as $elem)
  echo "<script type='text/JavaScript'>logins.push('{$elem['login']}');</script>\n";
*/
	      //	Print users table
echo "<h3>Users list</h3>\n";
echo "<table cellspacing='0' id='myTab' style='width:1180px;'>\n";
echo "<tr class='th'><td>&nbsp;</td><td>Lastname</td><td>Firstname</td><td>Email</td><td>University</td></tr>\n";
$class="tr2";
foreach($db->result as $elem){
  $class=$class=="tr1"?"tr2":"tr1";
  echo "<tr class='$class'><td>";
  if(in_array(10,$_SESSION['vwpp']['access']))
    echo "<a href='users-edit.php?id={$elem['id']}'><img src='../img/edit.png' alt='Edit' /></a>";
  echo "</td>\n";
  echo "<td>{$elem['lastname']}</td><td>{$elem['firstname']}</td>\n";
  echo "<td><a href='mailto:{$elem['email']}'>{$elem['email']}</a></td>\n";
  echo "<td>{$elem['university']}</td></tr>\n";
//   echo "<td>{$elem['login']}</td></tr>\n";
}
echo "</table>\n";

	  //		Button Add
get_button("Add",1,11,"left","10px 0 0 0");

	  //		Add users form
?>
<div id='div-edit1' style='display:none'>
<fieldset style='margin:20px 0 0 0'>
<legend>New user</legend>
<form name='form' action='users-add.php' method='post' onsubmit='return ctrl_form1();'>	<!-- ctrl_form1 a faire -->
<table id='myTab2'>
<tr><td>Lastname</td>
<td><input type='text' name='lastname' /></td>
<td style='width:180px;'>&nbsp;</td>
<td>Access</td>
<td rowspan='6'>
<input type='checkbox' name='access[]' value='1' id='access1' />Voir les infos générales<br/>
<input type='checkbox' name='access[]' value='2' id='access2' />Voir les Housings<br/>
<input type='checkbox' name='access[]' value='3' id='access3' />Voir les documents<br/>
<input type='checkbox' name='access[]' value='4' id='access4' />Ajouter des étudiants<br/>
<input type='checkbox' name='access[]' value='5' id='access5' />Supprimer les étudiants<br/>
<input type='checkbox' name='access[]' value='6' id='access6' />Modifier les infos générales<br/>
<input type='checkbox' name='access[]' value='7' id='access7' />Modifier les Housings<br/>
<input type='checkbox' name='access[]' value='8' id='access8' />Modifier les documents<br/>
<input type='checkbox' name='access[]' value='9' id='access9' />Voir les utilisateurs<br/>
<input type='checkbox' name='access[]' value='10' id='access10' />Modifier les utilisateurs<br/>
<input type='checkbox' name='access[]' value='11' id='access11' />Ajouter des utilisateurs<br/>
<input type='checkbox' name='access[]' value='12' id='access12' />Supprimer les utilisateurs<br/>
<input type='checkbox' name='access[]' value='13' id='access13' />Modifier les formulaires<br/>
<input type='checkbox' name='access[]' value='22' id='access22' />Voir qui a rempli les évaluations<br/>
<input type='checkbox' name='access[]' value='15' id='access15' />Voir les évaluations<br/>
<input type='checkbox' name='access[]' value='23' id='access23' />Voir les cours<br/>
<input type='checkbox' name='access[]' value='16' id='access16' />Modifier les cours<br/>
<input type='checkbox' name='access[]' value='17' id='access17' />Voir Univ. Reg.<br/>
<input type='checkbox' name='access[]' value='18' id='access18' />Voir et modifier les Notes FR<br/>
<input type='checkbox' name='access[]' value='20' id='access20' />Voir les Notes US<br/>
<input type='checkbox' name='access[]' value='19' id='access19' />Voir et modifier les Notes US<br/>
<input type='checkbox' name='access[]' value='21' id='access21' />Bloc-notes des cours<br/>
<input type='checkbox' name='access[]' value='24' id='access24' />Modifier les dates (1<sup>ère</sup> page)<br/>
</td>

</tr>
<tr><td>Fistname</td>
<td><input type='text' name='firstname' /></td></tr>
<tr><td>Email</td>
<td><input type='text' name='email' /></td></tr>

<tr><td>University</td>
<td><select name='university'>
<option value=''>&nbsp;</option>
<option value='Vassar'>Vassar</option>
<option value='Wesleyan'>Wesleyan</option>
<option value='VWPP'>VWPP</option>
</select></td></tr>

<!-- <tr><td>Login</td>
<td><input type='text' name='login' onkeyup='login_ctrl(this);' onblur='login_ctrl(this);' /></td>
<td style='color:red;' id='login_msg'></font></td></tr>  -->
<tr><td>Password</td>
<td><input type='password' name='password' id='password' onkeyup='password_ctrl(this);' onblur='password_ctrl(this);'/></td>
<td style='color:red;' id='passwd1'></font></td></tr>
<tr><td>Retype password</td>
<td><input type='password' name='password2' onkeyup='password_ctrl(this);' onblur='password_ctrl(this);'/></td>
<td style='color:red;' id='passwd2'></font></td></tr>
<tr><td colspan='2' style='text-align:center;'>
<input type='submit' value='Add' id='submit' disabled='disabled'/></td></tr>
</table></form>
</fieldset>
</div>

<?php
require_once  "../footer.php";
?>