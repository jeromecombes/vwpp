<?php
// Last update : 2015-03-20, Jérôme Combes

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
	if($_POST['id']){
		$db->update2("users",$_POST,$id);
	} else {
		unset($_POST['id']);
		$db->insert2("users",$_POST);
	}  
  header("Location:users.php?msg=update_success");
}

		//	User form
require_once  "../header.php";
require_once  "menu.php";
access_ctrl(10);


		//	Get user infos
if(isset($_GET['id'])){
	$db=new db();
	$db->select("users","*","id={$_GET['id']}");
	$user=$db->result[0];
	$access=unserialize($user['access']);
	$checkedAlert=$user['alerts']==1?"checked='checked'":null;
	$isVassar=$user['university']=="Vassar"?"selected='selected'":null;
	$isWesleyan=$user['university']=="Wesleyan"?"selected='selected'":null;
	$isVWPP=$user['university']=="VWPP"?"selected='selected'":null;
	$langFR=$user['language']=="fr"?"selected='selected'":null;
} else {
	$user=array("id"=>null,"firstname"=>null,"lastname"=>null,"email"=>null);
	$access=array();
	$checkedAlert=null;
	$isVassar=null;
	$isWesleyan=null;
	$isVWPP=null;
	$langFR=null;
}
		//	User form
echo <<<EOD
<h3>{$user['firstname']} {$user['lastname']}</h3>
<form name='form' action='users-edit.php' method='post' onsubmit='return ctrl_form2("{$user['email']}");'>	<!-- ctrl_form1 a faire -->
<input type='hidden' name='id' value='{$user['id']}' />
<fieldset style='margin:20px 0 0 0;padding: 20px 20px 20px 20px;'>

<div>
<strong><u>General information</u></strong>
<table id='myTab2' border='0' style='width:100%; margin-top:25px;'>
<tr><td style='width:30%;'><label for='lastname'>Lastname</label></td>
<td style='width:40%;'><input type='text' name='lastname' value='{$user['lastname']}' /></td>
<td>&nbsp;</td></tr>
<tr><td><label for='firstname'>Fistname</label></td>
<td><input type='text' name='firstname' value='{$user['firstname']}'/></td></tr>
<tr><td><label for='email'>Email</label></td>
<td><input type='text' name='email' value='{$user['email']}'/></td></tr>

<tr><td><label for='university'>University</label></td>
<td><select name='university'>
<option value=''>&nbsp;</option>
<option $isVassar value='Vassar'>Vassar</option>
<option $isWesleyan value='Wesleyan'>Wesleyan</option>
<option $isVWPP value='VWPP'>VWPP</option>
</select></td></tr>
EOD;

if(isset($_GET['id'])){
	echo <<<EOD
	<tr><td><label>Change password</label></td>
	<td><input type='checkbox' onclick='change_password(this);'/></td></tr>
	<tr style='display:none;' id='tr_password1'><td><label for='password'>Password</label></td>
	<td><input type='password' name='password' id='password' value='' onkeyup='password_ctrl(this);' onblur='password_ctrl(this);' disabled='disabled'/></td>
	<td style='color:red;' id='passwd1'></font></td></tr>
	<tr style='display:none;' id='tr_password2'><td><label for='password2'>Retype password</label></td>
	<td><input type='password' name='password2' value='' onkeyup='password_ctrl(this);' onblur='password_ctrl(this);' disabled='disabled'/></td>
	<td style='color:red;' id='passwd2'></font></td></tr>
EOD;
} else {
	echo <<<EOD
	<tr id='tr_password1'><td><label for='password'>Password</label></td>
	<td><input type='password' name='password' id='password' value='' onkeyup='password_ctrl(this);' onblur='password_ctrl(this);'/></td>
	<td style='color:red;' id='passwd1'></font></td></tr>
	<tr id='tr_password2'><td><label for='password2'>Retype password</label></td>
	<td><input type='password' name='password2' value='' onkeyup='password_ctrl(this);' onblur='password_ctrl(this);'/></td>
	<td style='color:red;' id='passwd2'></font></td></tr>
EOD;
}

echo <<<EOD
<tr><td><label for='language'>Language</label></td>
<td><select name='language'>
<option value='en'>English</option>
<option value='fr' $langFR >Français</option>
</select>
</td></tr>

<tr><td><label for='alerts'>E-mail alerts ?</label></td>
  <td><input type='checkbox' value='1' name='alerts' $checkedAlert /></tr>

</table>
</div>

<div style='margin-top:50px;height: 300px;'>
<label for='access[]'><u>Access</u></label><br/>
<div style='margin:20px 0 0 0;display:inline-block; width:30%;vertical-align:top;'>
<input type='checkbox' name='access[]' value='1' id='access1' />Voir les infos générales<br/>
<input type='checkbox' name='access[]' value='2' id='access2' />Voir les Housings<br/>
<input type='checkbox' name='access[]' value='3' id='access3' />Voir les documents<br/>
<input type='checkbox' name='access[]' value='4' id='access4' />Ajouter des étudiants<br/>
<input type='checkbox' name='access[]' value='5' id='access5' />Supprimer les étudiants<br/>
<input type='checkbox' name='access[]' value='6' id='access6' />Modifier les infos générales<br/>
<input type='checkbox' name='access[]' value='7' id='access7' />Modifier les Housings<br/>
<input type='checkbox' name='access[]' value='8' id='access8' />Modifier les documents<br/>
</div><div style='margin:20px 0 0 0;display:inline-block; width:30%;vertical-align:top;'>
<input type='checkbox' name='access[]' value='9' id='access9' />Voir les utilisateurs<br/>
<input type='checkbox' name='access[]' value='10' id='access10' />Modifier les utilisateurs<br/>
<input type='checkbox' name='access[]' value='11' id='access11' />Ajouter des utilisateurs<br/>
<input type='checkbox' name='access[]' value='12' id='access12' />Supprimer les utilisateurs<br/>
<input type='checkbox' name='access[]' value='13' id='access13' />Modifier les formulaires<br/>
<input type='checkbox' name='access[]' value='22' id='access22' />Voir qui a rempli les évaluations<br/>
<input type='checkbox' name='access[]' value='15' id='access15' />Voir les évaluations<br/>
<input type='checkbox' name='access[]' value='23' id='access23' />Voir les cours<br/>
</div><div style='margin:20px 0 0 0;display:inline-block; width:30%;vertical-align:top;'>
<input type='checkbox' name='access[]' value='16' id='access16' />Modifier les cours<br/>
<input type='checkbox' name='access[]' value='17' id='access17' />Voir Univ. Reg.<br/>
<input type='checkbox' name='access[]' value='18' id='access18' />Voir et modifier les Notes FR<br/>
<input type='checkbox' name='access[]' value='20' id='access20' />Voir les Notes FR et US<br/>
<input type='checkbox' name='access[]' value='19' id='access19' />Voir et modifier les Notes US<br/>
<input type='checkbox' name='access[]' value='21' id='access21' />Bloc-notes des cours<br/>
<input type='checkbox' name='access[]' value='24' id='access24' />Modifier les dates (1<sup>ère</sup> page)
</div>
</div>

<div style='display:inline-block; width:100%;'>
EOD;

if(in_array(12,$_SESSION['vwpp']['access']) and isset($_GET['id'])){
  echo "<input type='button' value='Delete' onclick='user_delete(\"{$user['id']}\")' class='myUI-button'/>\n";
}
echo "<input type='button' value='Cancel' onclick='location.href=\"users.php\";' class='myUI-button'/>\n";
$button=isset($_GET['id'])?"Update":"Add";
echo "<input type='submit' value='$button' id='submit' class='myUI-button'/>\n";
?>

</div>
</fieldset>
</form>

<?php

foreach($access as $elem)
  echo "<script type='text/JavaScript'>document.getElementById('access{$elem}').click();</script>\n";

require_once  "../footer.php";
?>
