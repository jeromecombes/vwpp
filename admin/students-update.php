<?php
require_once "../inc/config.php";

  //	ACL
access_ctrl($_POST['acl']);
  
//	Custom form
if(array_key_exists("input",$_POST)){
  $customInsert=array();
  $keys=array_keys($_POST['input']);
  foreach($keys as $elem){
    $customInsert[]=array("question"=>$elem,"student"=>$_POST['std_id'],"responses"=>$_POST['input'][$elem]);
  }
  unset($_POST['input']);

  if(!empty($keys)){
    $customDelete=join(",",$keys);
    $db=new db();
    $db->query("DELETE FROM {$dbprefix}responses WHERE student='{$_POST['std_id']}' AND question IN ($customDelete);");
  }
  
  $db=new db();
  $db->insert2("responses",$customInsert);
}

//unset($_POST['acl']);
$table=$_POST['table'];
//unset($_POST['table']);
$page=$_POST['page'];
//unset($_POST['page']);


//	Original form
if(array_key_exists("data",$_POST)){
  $dataInsert=array();
  $keys=array_keys($_POST['data']);

  foreach($keys as $elem){
    $response=htmlentities(trim($_POST['data'][$elem]),ENT_QUOTES | ENT_IGNORE,"UTF-8");
    $crypt_key=in_array($elem,array("lastname","firstname","email"))?null:$_POST['std_id'];
    $response=encrypt($response,$crypt_key);
    $dataInsert[]=array(":student"=>$_POST['std_id'],":semestre"=>$_POST['semestre'],":question"=>$elem,":response"=>$response);
  }
//  unset($_POST['data']);

  $db=new db();
  $db->delete($table,"student='{$_POST['std_id']}' AND semestre='{$_POST['semestre']}'");
  
//  $db=new db();
//  $db->insert2($table,$dataInsert);

//	PDO requetes preparées
  $sql="INSERT INTO {$dbprefix}$table (student,semestre,question,response) VALUES 
    (:student, :semestre, :question, :response);"
  $dbh=new PDO("mysql:host={$config['dbhost']}:dbname=:{$config['dbname']}",$config['dbuser'],$config['dbpass']);
  $stmt=$dbh->prepare($sql);
  foreach($dataInsert as $elem)
    $stmt->execute($elem);

}
//echo "toto";

  //	Update
/*if(!empty($_POST['id'])){
  $id=array("id" => $_POST['id']);
  $db=new db();
  $db->update2($table,$_POST,$id);
}
*/
/*
$db=new db();
$db->delete($table,"std_id='{$_POST['std_id']}' AND semestre='{$_POST['semestre']}'");


$keys=array_keys($_POST['data']);

  	Insert
else{
  unset($_POST['id']);
  $db=new db();
  $db->insert2($table,$_POST);
}
*/
//header("Location: $page");

?>