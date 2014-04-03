<?php
// Last change : 2013-04-25, Jérôme Combes

require_once "inc/config.php";

  //	ACL if admin
if($_SESSION['vwpp']['category']!="student")
  access_ctrl($_POST['acl']);

$multiple_evals=array("CIPH","ReidHall","tutorats","stages","univ");
$std_id=$_POST['std_id'];
$form=$_POST['form'];
$timestamp=$_POST['timestamp'];
$closed=$_POST['closed'];
$courseId=isset($_POST['courseId'])?$_POST['courseId']:0;

//	Original form
if(array_key_exists("data",$_POST)){
  $dataInsert=array();
  $keys=array_keys($_POST['data']);
  foreach($keys as $elem){
    if(is_array($_POST['data'][$elem])){		// Checkboxes
      $response=serialize($_POST['data'][$elem]);
    }
    else{
      $response=htmlentities($_POST['data'][$elem],ENT_QUOTES | ENT_IGNORE,"UTF-8");
    }
    $response=encrypt($response,$std_id);
    $dataInsert[]=array(":student"=>$std_id,":timestamp"=>$timestamp,":form"=>$form,":courseId"=>$courseId,":question"=>$elem,":response"=>$response,":closed"=>$closed,":semester"=>$_SESSION['vwpp']['semestre']);
  }

  $filter="student='$std_id' AND form='$form' AND semester='{$_SESSION['vwpp']['semestre']}'";
  if($courseId)
    $filter.=" AND courseId='$courseId'";		// AND CourseId If multiple evals
  elseif(in_array($form,$multiple_evals))
    $filter.=" AND timestamp='$timestamp'";		// AND TIMESTAMP If multiple evals

  $db=new db();
  $db->delete("evaluations",$filter);
  
  $sql="INSERT INTO {$dbprefix}evaluations (student,timestamp,form,courseId,question,response,closed,semester) VALUES 
    (:student, :timestamp, :form, :courseId, :question, :response, :closed, :semester);";
  $db=new dbh();
  $db->prepare($sql);
  foreach($dataInsert as $elem)
    $db->execute($elem);
}

header("Location: eval_index.php");

?>