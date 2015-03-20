<?php
// Last update : 2015-03-20, Jérôme Combes

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
?>
<h3>Users list</h3>
<table class='datatable'>
<thead>
<tr><th>&nbsp;</th><th>Lastname</th><th>Firstname</th><th>Email</th><th>University</th></tr>
</thead>
<tbody>

<?php
foreach($db->result as $elem){
  echo "<tr><td>";
  if(in_array(10,$_SESSION['vwpp']['access']))
    echo "<a href='users-edit.php?id={$elem['id']}'><img src='../img/edit.png' alt='Edit' /></a>";
  echo "</td>\n";
  echo "<td>{$elem['lastname']}</td><td>{$elem['firstname']}</td>\n";
  echo "<td><a href='mailto:{$elem['email']}'>{$elem['email']}</a></td>\n";
  echo "<td>{$elem['university']}</td></tr>\n";
}
echo "</tbody>\n";
echo "</table>\n";

	  //		Button Add
echo "<br/><a class='myUI-button' href='users-edit.php'/>Add</a>\n";

require_once  "../footer.php";
?>