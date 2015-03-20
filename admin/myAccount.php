<?php
// Last update : 2015-03-20

if(!isset($_POST['password'])){
  require_once "../header.php";
  require_once "../inc/class.users.inc";
  require_once "menu.php";

  $u=new user();
  $u->fetch($_SESSION['vwpp']['login_id']);
  $checkedAlert=$u->elements['alerts']==1?"checked='checked'":null;

  echo <<<EOD
  <form method='post' action='myAccount.php'>
  <h3>Change password</h3>
  <table style='width:500px;'>
  <tr><td style='width:230px;'>Current password :</td>
  <td><input type='password' name='current' /></td></tr>
  <tr><td>New password :</td>
  <td><input type='password' name='password' /></td></tr>
  <tr><td>Confirm new password :</td>
  <td><input type='password' name='confirm' /></td></tr>
  </table>
  <input type='button' value='Cancel' onclick='location.href="index.php";'  class='myUI-button' />
  <input type='submit' value='Change password'  class='myUI-button' />
  </form>

  <br/><br/>
  <form method='post' action=''>
  <h3>Notifications</h3>
  <table style='width:500px;'>
  <tr><td style='width:230px;'>Enable notifications ?</td>
  <td><input type='checkbox' name='alerts' $checkedAlert onclick='changeNotifications(this);' /></td></tr>
  </table></form>
  
EOD;
  require_once "../footer.php";
}
else{
  require_once "../inc/config.php";
  require_once "../inc/class.password.inc";

  $pass=new password();
  $pass->email=$_SESSION['vwpp']['email'];
  $pass->changePassword($_POST['current'],$_POST['password'],$_POST['confirm']);
  $error=$pass->error;
  $msg=$pass->messages;

  header("Location: myAccount.php?error=$error&msg=$msg");
}
?>