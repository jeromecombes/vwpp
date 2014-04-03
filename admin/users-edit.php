<?php
//		Enregistrement des infos dans la BDD
if(isset($_POST['id'])){
  require_once  "../inc/config.php";
  access_ctrl(10);
  $id=array('id'=>$_POST['id']);
  $_POST['access']=isset($_POST['access'])?serialize($_POST['access']):serialize(array());
  if($_POST['password'])
    $_POST['password']=md5($_POST['password']);
  unset($_POST['password2']);

  $_POST['token']=md5($_POST['email']);
  $_POST['alerts']=isset($_POST['alerts'])?1:0;

  $db=new db();
  $db->update2("users",$_POST,$id);
  
  header("Location:users.php");
}

		//	User form
require_once  "../header.php";
require_once  "menu.php";
access_ctrl(10);

		//	login ctrl
/*
$db=new db();
$db->select("users");
foreach($db->result as $elem)
  echo "<script type='text/JavaScript'>logins.push('{$elem['login']}');</script>\n";
*/
		//	Get user infos
$db=new db();
$db->select("users","*","id={$_GET['id']}");
$user=$db->result[0];
$access=unserialize($user['access']);
$checkedAlert=$user['alerts']==1?"checked='checked'":null;
$isVassar=$user['university']=="Vassar"?"selected='selected'":null;
$isWesleyan=$user['university']=="Wesleyan"?"selected='selected'":null;
$isVWPP=$user['university']=="VWPP"?"selected='selected'":null;
$langFR=$user['language']=="fr"?"selected='selected'":null;

		//	User form
echo <<<EOD
<h3>{$user['firstname']} {$user['lastname']}</h3>
<fieldset style='margin:20px 0 0 0;padding: 20px 20px 20px 20px;'>

<form name='form' action='users-edit.php' method='post' onsubmit='return ctrl_form2("{$user['email']}");'>	<!-- ctrl_form1 a faire -->
<input type='hidden' name='id' value='{$user['id']}' />
<table id='myTab2' border='0'>
<tr><td>Lastname</td>
<td><input type='text' name='lastname' value='{$user['lastname']}' /></td>
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
</td></tr>

<tr><td>Fistname</td>
<td><input type='text' name='firstname' value='{$user['firstname']}'/></td></tr>
<tr><td>Email</td>
<td><input type='text' name='email' value='{$user['email']}'/></td></tr>

<tr><td>University</td>
<td><select name='university'>
<option value=''>&nbsp;</option>
<option $isVassar value='Vassar'>Vassar</option>
<option $isWesleyan value='Wesleyan'>Wesleyan</option>
<option $isVWPP value='VWPP'>VWPP</option>
</select></td></tr>

<!-- <tr><td>Login</td>
<td><input type='text' name='login' onkeyup='login_ctrl2(this,"{$user['login']}");' onblur='login_ctrl2(this,"{$user['login']}");' value='{$user['login']}'/></td>
<td style='color:red;' id='login_msg'></font></td></tr> -->
<tr><td>Change password</td>
<td><input type='checkbox' onclick='change_password(this);'/></td></tr>
<tr style='display:none;' id='tr_password1'><td>Password</td>
<td><input type='password' name='password' id='password' value='' onkeyup='password_ctrl(this);' onblur='password_ctrl(this);' disabled='disabled'/></td>
<td style='color:red;' id='passwd1'></font></td></tr>
<tr style='display:none;' id='tr_password2'><td>Retype password</td>
<td><input type='password' name='password2' value='' onkeyup='password_ctrl(this);' onblur='password_ctrl(this);' disabled='disabled'/></td>
<td style='color:red;' id='passwd2'></font></td></tr>
<tr><td>Language</td>
<td><select name='language'>
<option value='en'>English</option>
<option value='fr' $langFR >Français</option>
</select>
</td></tr>

<tr><td>E-mail alerts ?</td>
  <td><input type='checkbox' value='1' name='alerts' $checkedAlert />

<tr><td colspan='2' style='text-align:center;padding-top:30px;'>
EOD;
if(in_array(12,$_SESSION['vwpp']['access']))
  echo "<input type='button' value='Delete' onclick='user_delete(\"{$user['id']}\")'/>\n";
echo <<<EOD

<input type='button' value='Cancel' onclick='location.href="users.php";'/>
<input type='submit' value='Update' id='submit'/>

</td></tr>
</table></form>
</fieldset>
EOD;

foreach($access as $elem)
  echo "<script type='text/JavaScript'>document.getElementById('access{$elem}').click();</script>\n";

require_once  "../footer.php";
?>
