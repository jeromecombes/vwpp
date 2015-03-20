<?php
// Last update : 2015-03-20

if(!isset($_POST['password'])){
  require_once "header.php";
  require_once "menu.php";

  echo <<<EOD
  <form method='post' action='myAccount.php'>
  <h3>Change password</h3>
  <table style='width:600px;'>
  <tr><td>Current password :</td>
  <td><input type='password' name='current' /></td></tr>
  <tr><td>New password :</td>
  <td><input type='password' name='password' /></td></tr>
  <tr><td>Confirm new password :</td>
  <td><input type='password' name='confirm' /></td></tr>
  </table>
  <input type='button' value='Cancel' onclick='location.href="index.php";'  class='myUI-button' />
  <input type='submit' value='Change password'  class='myUI-button' />
  </form>
EOD;
  require_once "footer.php";
}
else{
  require_once "inc/config.php";
  require_once "inc/class.password.inc";

  $pass=new password();
  $pass->id=$_SESSION['vwpp']['student'];
  $pass->changePassword($_POST['current'],$_POST['password'],$_POST['confirm']);
  $error=$pass->error;
  $msg=$pass->messages;

  header("Location: myAccount.php?error=$error&msg=$msg");
}
?>