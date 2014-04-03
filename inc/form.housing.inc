<?php
require_once "class.student.inc";

$semestre=$_SESSION['vwpp']['semestre'];
$std_id=isset($_SESSION['vwpp']['student'])?$_SESSION['vwpp']['student']:$GLOBALS['std_id'];

//	Get data from table 'students'
$std=new student;
$std->id=$std_id;
$std->fetch();
$std=$std->elements;



//	Get data from table 'housing'
$housing=array();
$db=new db();
$db->select("housing","*","student='$std_id' AND semestre='$semestre'");
if($db->result){
  foreach($db->result as $elem){
    $housing[$elem['question']]=decrypt($elem['response'],$std_id);
    $housing[$elem['question']]=str_replace("\n","<br/>",$housing[$elem['question']]);
  }
}

//	Get custom form questions
$db=new db();
$db->select("forms","*","semestre='$semestre' AND formId='7'","ORDER BY ordre");
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

// For admins, $display is defined in get_page
$display=null;
$display=$_SESSION['vwpp']['category']=="admin"?$display:"none";
$display2=$_SESSION['vwpp']['category']=="admin"?"none":null;

$tmp=array();
if($std['street'])
  $tmp[]=$std['street'];
if($std['city'])
  $tmp[]=$std['city'];
if($std['state'])
  $tmp[]=$std['state'];
if($std['country'])
  $tmp[]=$std['country'];
$address=join(", ",$tmp);

$tmp=explode(" ",$_SESSION['vwpp']['semester']);
$tmp=$tmp[1].($tmp[0]=="Spring"?1:2);


if(intval($tmp)<20132){	// Before Fall 2013
  include "form.housing2.inc";
  include "form.housing3.inc";
}
else{
  include "form.housing20132.inc";
  include "form.housing20133.inc";
}

?>