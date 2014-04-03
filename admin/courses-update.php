<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);

require_once "../inc/config.php";
require_once "../inc/class.reidhall.inc";

access_ctrl(16);


//	Deleting RH course
if(isset($_GET['delete'])){
  $rh=new reidhall();
  $rh->delete($_GET['id']);
  header("Location: courses.php?error=0&msg=delete_success");
  exit;
}

$id=array_key_exists("id",$_POST)?$_POST['id']:null;
$semester=$_SESSION['vwpp']['semestre'];

//	Variables for Reid Hall
/*if($_POST['univ']=="rh"){
  $professor=encrypt(htmlentities($_POST['professor'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $title=encrypt(htmlentities($_POST['title'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $nom=encrypt(htmlentities($_POST['nom'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $code=encrypt(htmlentities($_POST['code'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $jour=encrypt(htmlentities($_POST['jour'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $debut=encrypt(htmlentities($_POST['debut'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $fin=encrypt(htmlentities($_POST['fin'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $type=$_POST['type'];
}*/
		//	Update RH
if($_POST['univ']=="rh"){
  $r=new reidhall();
  $r->update($_POST);
}

// if($id and $_POST['univ']=="rh"){
//   $r=new reidhall();
//   $r->update($_POST);
// }
// 		//	Add RH
// elseif(!$id and $_POST['univ']=="rh"){
//   $sql="INSERT INTO {$dbprefix}courses (title,nom,professor,type,semester,code) VALUES (:title,:nom,:professor,:type,:semester,:code);";
//   $data=array(":title"=>$title, ":nom"=>$nom, ":professor"=>$professor, ":type"=>$type, ":semester"=>$semester, ":code"=>$code);
//   $db=new dbh();
//   $db->prepare($sql);
//   $db->execute($data);
// }

//	Variables for University
if($_POST['univ']=="univ"){
  $university=encrypt(htmlentities($_POST['university'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $ufr=encrypt(htmlentities($_POST['ufr'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $ufr_name=encrypt(htmlentities($_POST['ufr_name'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $parcours=encrypt(htmlentities($_POST['parcours'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $stream=encrypt(htmlentities($_POST['stream'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $course_year=encrypt(htmlentities($_POST['course_year'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $course_code=encrypt(htmlentities($_POST['course_code'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $cm_td=encrypt(htmlentities($_POST['cm_td'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $groupe=encrypt(htmlentities($_POST['groupe'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $credits=encrypt(htmlentities($_POST['credits'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $nom=encrypt(htmlentities($_POST['nom'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $title=encrypt(htmlentities($_POST['title'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
  $prof_group=encrypt(htmlentities($_POST['prof_group'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));  
  $prof_lecture=encrypt(htmlentities($_POST['prof_lecture'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));  
  $email=encrypt(htmlentities($_POST['email'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));  
  $telephone=encrypt(htmlentities($_POST['telephone'],ENT_QUOTES | ENT_IGNORE,"UTF-8"));  
}
  
		//	Update Univ
if($id and $_POST['univ']=="univ"){
  $sql="UPDATE {$dbprefix}courses SET university=:university, ufr=:ufr, ufr_name=:ufr_name, 
    parcours=:parcours, stream=:stream, course_year=:course_year, course_code=:course_code, 
    cm_td=:cm_td, groupe=:groupe, credits=:credits, nom=:nom, title=:title, 
    prof_group=:prof_group, prof_lecture=:prof_lecture, email=:email, telephone=:telephone 
    WHERE id=:id;";
  $data=array(":university"=>$university, ":ufr"=>$ufr, ":ufr_name"=>$ufr_name, ":parcours"=>$parcours, 
  ":stream"=>$stream, ":course_year"=>$course_year, ":course_code"=>$course_code, ":cm_td"=>$cm_td, 
  ":groupe"=>$groupe, ":credits"=>$credits, ":nom"=>$nom, ":title"=>$title, ":prof_group"=>$prof_group, 
  ":prof_lecture"=>$prof_lecture, ":email"=>$email, ":telephone"=>$telephone, ":id"=>$id);
  $db=new dbh();
  $db->prepare($sql);
  $db->execute($data);
}
		//	Add Univ
elseif(!$id and $_POST['univ']=="univ"){		// a faire
  $sql="INSERT INTO {$dbprefix}courses (univ,semester,university,ufr,ufr_name,parcours,stream,
    course_year,course_code,cm_td,groupe,credits,nom,title,prof_group,prof_lecture,email,telephone) 
    VALUES (:univ,:semester,:university,:ufr,:ufr_name,:parcours,:stream,:course_year,:course_code,
    :cm_td,:groupe,:credits,:nom,:title,:prof_group,:prof_lecture,:email,:telephone);";
  $data=array(":univ"=>"univ",":semester"=>$semester,":university"=>$university, ":ufr"=>$ufr, 
  ":ufr_name"=>$ufr_name, ":parcours"=>$parcours, ":stream"=>$stream, ":course_year"=>$course_year, 
  ":course_code"=>$course_code, ":cm_td"=>$cm_td, ":groupe"=>$groupe, ":credits"=>$credits, 
  ":nom"=>$nom, ":title"=>$title, ":prof_group"=>$prof_group, ":prof_lecture"=>$prof_lecture, 
  ":email"=>$email, ":telephone"=>$telephone);
  $db=new dbh();
  $db->prepare($sql);
  $db->execute($data);
}

$msg="update_success";
$error=0;
header("Location: courses.php?error=$error&msg=$msg");
?>