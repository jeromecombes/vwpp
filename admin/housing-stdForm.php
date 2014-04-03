<?php
$title="studentName";
require_once "../header.php";
require_once "../inc/class.student.inc";
access_ctrl(2);

$menu_id=isset($_GET['menu_id'])?$_GET['menu_id']:$_SESSION['vwpp']['menu_id'];
$menu_id=$menu_id?$menu_id:1;
$_SESSION['vwpp']['menu_id']=$menu_id;

if(!$_SESSION['vwpp']['menu_id'])
  $_SESSION['vwpp']['menu_id']=1;
//	Get data
if(isset($_GET['id']))
  $_SESSION['vwpp']['std-id']=$_GET['id'];


//	Get generals infos
$std_id=$_SESSION['vwpp']['std-id'];
$std=new student;
$std->id=$std_id;
$std->fetch();
$std=$std->elements;

//	Show student menu
require_once "students-menu.php";

//	Show content
get_page("std-generals.php",1,1);	//	page name, page id, required access
get_page("univ_registration.php",5,17);
get_page("form.housing.inc",2,2);
get_page("std-courses.php",4,16);
get_page("form.docs.inc",3,3);

require_once "../footer.php";
?>