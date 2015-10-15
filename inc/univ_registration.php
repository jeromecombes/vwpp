<?php
// Update : 2015-10-15

$semestre=$_SESSION['vwpp']['semestre'];
$std_id=isset($_SESSION['vwpp']['student'])?$_SESSION['vwpp']['student']:$GLOBALS['std_id'];

//	Get data from table 'students'
$db=new db();
$db->select("students","*","id='$std_id'");
if($db->result){
  $std['lastname']=decrypt($db->result[0]['lastname']);
  $std['firstname']=decrypt($db->result[0]['firstname']);
  $std['email']=decrypt($db->result[0]['email']);
}

//	Get data from table 'univ_reg'
$data=array();
// On peuple pour éviter les "undefined index"
for($i=1;$i<25;$i++){
  $data[$i]=null;
}

$db=new db();
$db->select("univ_reg","*","student='$std_id' AND semestre='$semestre'");
if($db->result){
  foreach($db->result as $elem){
    $data[$elem['question']]=decrypt($elem['response'],$std_id);
//     $data[$elem['question']]=str_replace("\n","<br/>",$data[$elem['question']]);
  }
}

//	Get custom form questions
$db=new db();
$db->select("forms","*","semestre='$semestre' AND formId='1'","ORDER BY ordre");
$customForm=$db->result;

//	Get custom form responses
$db=new db();
$db->select("responses","*","student='$std_id'");
$customResp=$db->result;

for($i=0;$i<count($customForm);$i++){
  $customForm[$i]['response']=null;
  foreach($customResp as $response){
    if($response['question']==$customForm[$i]['id']){
      $customForm[$i]['response']=$response['responses'];
      break;
    }
  }
}

$display1="none";
$display2=null;

$db=new db();
$db->select("univ_reg_lock1","*","semester='{$_SESSION['vwpp']['semester']}' AND student='$std_id'");
/*echo "semester='{$_SESSION['vwpp']['semester']}' AND student='$std_id'";
print_r($db->result);*/
$lock=$db->result?true:false;
$lock_value=$db->result?"Unlock":"Lock";

include "univ_registration2.php";

if($lock or $_SESSION['vwpp']['category']=="admin"){
  include "univ_registration3.php";
}


?>
</div>	<!-- div open in univ_registration2.php -->
