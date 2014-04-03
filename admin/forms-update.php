<?php
require_once "../inc/config.php";

$semestre=$_SESSION['vwpp']['semestre'];
$formId=$_SESSION['vwpp']['formId'];

access_ctrl($formId);

$insert=array();
$update=array();
$delete=array();

foreach($_POST['forms'] as $elem){
  if(empty($elem[0]) and !empty($elem[1])){		//	insert
    $insert[]=array("question"=>$elem[1],"type"=>$elem[2],"responses"=>$elem[3],"ordre"=>$elem[4],"formId"=>$formId,"semestre"=>$semestre);
  }
  elseif(!empty($elem[0]) and empty($elem[1])){		//	delete
    $delete[]=$elem[0];
  }
  elseif(!empty($elem[0]) and !empty($elem[1])){	//	update
    $update[]=array("id"=>$elem[0],"question"=>$elem[1],"type"=>$elem[2],"responses"=>$elem[3],"ordre"=>$elem[4],"formId"=>$formId,"semestre"=>$semestre);
  }
}


if(!empty($insert)){
  $db=new db();
  $db->insert2("forms",$insert);
}

if(!empty($delete)){
  $db=new db();
  $db->delete2("forms","id",$delete);
}

foreach($update as $elem){
  $db=new db();
  $db->update2("forms",$elem,array("id"=>$elem["id"]));
}

header("Location: forms-view.php");
?>