<?php
// Update : 2015-10-20

$title="studentName";
require_once "../header.php";
require_once "../inc/class.student.inc";

$menu_id=filter_input(INPUT_GET,"menu_id",FILTER_SANITIZE_STRING);
$menu_id_session=isset($_SESSION['vwpp']['menu_id'])?$_SESSION['vwpp']['menu_id']:null;
$menu_id=$menu_id?$menu_id:$menu_id_session;
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
require_once "students-menu2.php";

//	Show content


switch($menu_id){
	//	page name, page id, required access
  case 1 : get_page("std-generals.php",1,1);			break;
  case 5 : get_page("univ_registration.php",5,17);		break;
  case 2 : get_page("std-housing-home.php",2,2);
	   get_page("form.housing.inc",6,2);			break;
  case 4 : get_page("std-courses.php",4,23);			break;
  case 7 : get_page("std-grades.php",7,array(18,19,20));	break;
  case 3 : get_page("form.docs.inc",3,3);			break;
  case 8 : get_page("form.schedule.inc",8,1);			break;
}

require_once "../footer.php";
?>