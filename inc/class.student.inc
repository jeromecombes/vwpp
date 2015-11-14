<?php
/*
VWPP Database V 3.0
Last update 2015-11-13, Jérôme Combes
*/

require_once "class.mails.inc";
require_once "class.users.inc";
require_once "class.univ_reg.inc";

class student{
  public $auth=false;
  public $byUnivList=null;
  public $byUnivTab=array();
  public $error=false;
  public $messages=array();
  public $list=null;
  public $elements=array();
  public $welcomeMessage=array();
  public $id=null;
  public $email=null;
  public $password=null;
  public $token=null;
  public $semester;
  public $tin;
  public $university=null;				// university filter

  public $cryptedFieldsNoID=array("lastname","firstname","email");
  public $cryptedFieldsMD5=array("token","password");
  public $cryptedFields=array("gender","dob","citizenship1","citizenship2","town","university",
      "university2","graduation","city","street","zip","state","country","contactlast","contactfirst","contactphone",
      "contactmobile","contactemail","cellphone","homeInstitution","placeOB","countryOB","frenchNumber","resultatTCF","tin");

  function student(){
    if(array_key_exists("vwpp",$_SESSION) and array_key_exists("semester",$_SESSION['vwpp'])){
      $this->semester=str_replace(array(" ","_"),"%",$_SESSION['vwpp']['semester']);
    }
  }
  
  public function createPassword($sendMail=false){
    $this->fetchAll();
    $data=array();
    if(is_array($this->list))
    foreach($this->list as $elem){
      $clearPassword=genTrivialPassword();
      $password=md5($clearPassword);
      $token=md5($this->elements[$elem]["email"]);
      $this->elements[$elem]['clearPassword']=$clearPassword;
      $this->elements[$elem]['password']=$password;
      $data[]=array(":id"=>$elem,":password"=>$password,":token"=>$token);
      if($sendMail){
	$this->createWelcomeMessage($elem);  
	$mail=new vwppMail();
	$mail->addAddress($this->elements[$elem]["email"]);
	$mail->subject=$GLOBALS['config']['Messages-Welcome-Title'];
	$mail->body = $this->welcomeMessage[$elem];
	$mail->send();
	if($mail->error){
	  $this->error=true;
	  $this->messages[]=$mail->error;
	}
      }
    }
    $sql="UPDATE {$GLOBALS['config']['dbprefix']}students SET password=:password, token=:token
	  WHERE id=:id;";
    $db=new dbh();
    $db->prepare($sql);
    foreach($data as $elem){
      $db->execute($elem);
    }
  }

  public function createWelcomeMessage($id){
    $email=$this->elements[$id]['email'];
    $firstname=$this->elements[$id]['firstname'];
    $lastname=$this->elements[$id]['lastname'];
    $password=$this->elements[$id]['clearPassword'];
    $message=$GLOBALS['config']['Messages-Welcome'];
    $message=str_replace(array("[FIRSTNAME]","[LASTNAME]","[EMAIL]","[PASSWORD]"),array($firstname,$lastname,$email,$password),$message);
    $this->welcomeMessage[$id]=$message;
  }
  
  public function deleteTIN(){
    if(!in_array(6,$_SESSION['vwpp']['access'])){
      $this->error=true;
      return;
    }
    
    $students=$this->list;

    if(!is_array($students)){
      $this->error=true;
      return;
    }

    $db=new dbh();
    $db->prepare("INSERT INTO {$GLOBALS['config']['dbprefix']}log (message) VALUES (:message);");
    $insert=array(":message"=>"User #{$_SESSION['vwpp']['login_id']}, {$_SESSION['vwpp']['semestre']} : delete TIN for students ".join("; ",$students));
    $db->execute($insert);
    
    $db=new dbh();
    $db->prepare("UPDATE {$GLOBALS['config']['dbprefix']}students SET tin=:tin WHERE id=:id;");

    foreach($students as $elem){
      $db->execute(array(":tin"=>encrypt("",$elem),":id"=>$elem));
    }
  }

  public function fetch(){
    $univReq=null;
    if($this->university and $this->university!="VWPP"){		// university filter
      $univReq=" AND university like '%{$this->university}%'";
    }
    if($this->id)
      $req="id='{$this->id}' $univReq";
    elseif($this->email)
      $req="token=MD5('{$this->email}') $univReq";

    $db=new db();
    $db->select("students","*",$req);

    if($db->result){
      $elem=$db->result[0];
      $keys=array_keys($db->result[0]);
      $this->elements["semesters"]=unserialize($elem["semesters"]);
      if($this->elements["semesters"]){
	for($i=0;$i<count($this->elements["semesters"]);$i++)
	  $this->elements["semesters"][$i]=str_replace("_"," ",$this->elements["semesters"][$i]);
      }
      if(!$this->elements["semesters"])
	$this->elements["semesters"]=array(str_replace("_"," ",$elem["semestre"]));
      sort($this->elements["semesters"]);
      $this->elements["semestersJoin"]=join(", ",$this->elements["semesters"]);
      $year=intval(substr($this->elements['semesters'][0],-4));
      $this->elements["newSemester"]=preg_match('/Fall/',$this->elements['semesters'][0])?"Spring ".($year+1):"Fall $year";
      $this->elements['checkedSemester']=in_array($this->elements['newSemester'],$this->elements['semesters'])?"checked='checked'":null;

      foreach($keys as $key){
	if(in_array($key,array("id","token","password","semestre","semester","guest")))
	  $this->elements[$key]=$elem[$key];
	elseif(in_array($key,array("lastname","firstname","email")))
	  $this->elements[$key]=$elem[$key]?decrypt($elem[$key]):null;
	elseif($key=="university")
	  $this->elements[$key]=$elem[$key];
	elseif(!is_numeric($key) and $key!="semesters")
 	  $this->elements[$key]=$elem[$key]?decrypt($elem[$key],$elem['id']):null;
      }

      //	Add HomeInstitution if Vassar or Wesleyan
      if(!$this->elements["homeInstitution"]){
	$this->elements["homeInstitution"]=$this->elements["university"];
      }

      //	Add DOB
      if(isset($this->elements['dob']) and $this->elements['dob']!=null){
	$tmp=explode("-",$this->elements['dob']);
	$dob=strToTime($this->elements['dob']);
	$dob=date("M d, Y",$dob);
	$this->elements['dob_text']=$dob;
	$this->elements['dob']=$tmp[2];
	$this->elements['mob']=$tmp[1];
	$this->elements['yob']=$tmp[0];
      }else{
	$this->elements['dob_text']=null;
	$this->elements['dob']=null;
	$this->elements['mob']=null;
	$this->elements['yob']=null;
      }

      //	Add login_name
      $this->elements['login_name']=$this->elements['lastname'].", ".$this->elements['firstname'];

      //	Add logement
      $db=new db();
      $db->select("housing_affect","*","student='{$this->id}' AND semester LIKE '{$this->semester}'");
      if($db->result){
	$this->elements['logement']=$db->result[0]['logement'];
      }

      //	Add French University
      $u=new univ_reg();
      $u->student=$this->id;
      $u->getAttrib();
      $this->elements['frenchUniv']=$u->university;
    }
  }

  public function fetchAll($university=null){
    $university=$university=="VWPP"?null:$university;
    $univReq=" AND university like '%$university%'";
    $db=new db();
    $db->select("students","*","semesters like '%\"{$this->semester}\"%' $univReq");
    if($db->result){
      $students=array();
//       $stdExcel=array();
      $keys=array_keys($db->result[0]);
      foreach($db->result as $elem){
	$students[$elem['id']]["semesters"]=unserialize($elem["semesters"]);
	if(!$students[$elem['id']]["semesters"])
	  $students[$elem['id']]["semesters"]=array($elem["semestre"]);
	sort($students[$elem['id']]["semesters"]);
	$students[$elem['id']]["semestersJoin"]=join(", ",$students[$elem['id']]["semesters"]);
// 	$stdExcel[$elem['id']]["semestersJoin"]=html_entity_decode($students[$elem['id']]["semestersJoin"],ENT_QUOTES,"utf-8");
	$students[$elem['id']]["homeInstitution"]="toto".decrypt($elem['homeInstitution'],$elem['id']);
	foreach($keys as $key){
	  if(in_array($key,array("id","token","password","semestre","semester")))
	    $students[$elem['id']][$key]=$elem[$key];
	  elseif(in_array($key,array("lastname","firstname","email")))
	    $students[$elem['id']][$key]=$elem[$key]?decrypt($elem[$key]):null;
	  elseif(!is_numeric($key) and $key!="semesters")
	    $students[$elem['id']][$key]=$elem[$key]?decrypt($elem[$key],$elem['id']):null;
// 	 if(!is_array($students[$elem['id']][$key]))
// 	  $stdExcel[$elem['id']][$key]=html_entity_decode($students[$elem['id']][$key],ENT_QUOTES,"utf-8");
	}
	if(empty($students[$elem['id']]["homeInstitution"]))
	  $students[$elem['id']]["homeInstitution"]=$elem['university'];
// 	$stdExcel[$elem['id']]["homeInstitution"]=html_entity_decode($students[$elem['id']]["homeInstitution"],ENT_QUOTES,"utf-8");

	//	Add French University
	$u=new univ_reg();
	$u->student=$elem['id'];
	$u->getAttrib();
	$students[$elem['id']]['frenchUniv']=$u->university;


      }
    $this->elements=$students;
//     $this->elemExcel=$stdExcel;
    }
  }

  public function getByUniv($univ=null){
    $univ=$univ=="VWPP"?null:$univ;
    $db=new db();
    $db->select("students","*","university LIKE '%$univ%'");
    if($db->result){
      foreach($db->result as $elem){
	$this->byUnivTab[]=$elem['id'];
      }
      $this->byUnivList=join(",",$this->byUnivTab);
    }
  }

  public function login(){
    $db=new db();
    $db->select("students","*","token='{$this->token}' AND password='{$this->password}'");
    if($db->result){
      $this->id=$db->result[0]['id'];
      $this->fetch();
      $_SESSION['vwpp']['login']=$this->elements['email'];
      $_SESSION['vwpp']['access']=array();
      $_SESSION['vwpp']['category']="student";
      $_SESSION['vwpp']['login_univ']=$this->elements['university'];
      $_SESSION['vwpp']['student']=$this->elements['id'];
      $_SESSION['vwpp']['semesters']=$this->elements['semesters'];
      $_SESSION['vwpp']['login_name']=$this->elements['login_name'];
      $this->auth=true;
    }
  }

  public function setPassword($clearPassword){
    $this->password=md5($clearPassword);
  }

  public function setToken($email){
    $this->token=md5($email);
  }

/*  public function updatePassword($clearPassword){
    $db=new db();
    $db->update("students","password=MD5('$clearPassword')","id='{$this->id}'");
  }
*/
  public function update($data){
    if(!is_numeric($data['id'])){
      echo "Error, ID must be numeric (class student, function update)";
      $this->error=true;
      return;
    }
    else{
      $values=array();
      $set=array();
      $student=$data['id'];
      $values[":id"]=$data['id'];
      $keys=array_keys($data);
      foreach($keys as $key){
	if(in_array($key,$this->cryptedFieldsNoID)){
	  $set[]="$key=:$key";
	  $values[":$key"]=encrypt(htmlentities($data[$key],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
	}
	elseif(in_array($key,$this->cryptedFields)){
	  $set[]="$key=:$key";
	  $values[":$key"]=encrypt(htmlentities($data[$key],ENT_QUOTES | ENT_IGNORE,"UTF-8"),$student);
	}
	elseif($key=="semesters"){
	  sort($data[$key]);
	  $set[]="$key=:$key";
	  $values[":$key"]=serialize($data[$key]);
	}
      }

      if(in_array("email",$keys)){
	$set[]="token=:token";
	$values[":token"]=md5(trim($data['email']));
      }

      $set=join(", ",$set);
      $sql="UPDATE {$GLOBALS['config']['dbprefix']}students SET $set WHERE id=:id;";

      $db=new dbh();
      $db->prepare($sql);
      $db->execute($values);

      if($db->error){
	$this->error=1;
	$this->msg="update_error";
      }
      else{
	$this->msg="update_success";
      }
    }
  }

  public function delete($id){		// $id = int
    $tables=array("courses_attrib_rh","courses_choices","courses_ciph","courses_univ","housing","housing_accept","stages","univ_reg");
    foreach($tables as $table){
      $db=new db();
      $db->delete($table,"student=$id");
    }
    $db=new db();
    $db->delete("students","id=$id");

  }


  public function delete2($ids){	// $ids = array
    //	Send notification by e-mail
    $error=0;
    $msg="delete_success";

    $this->fetchAll();
    foreach($ids as $id){
      $std=$this->elements[$id];
      $studentsList[]="<li>{$std['lastname']} {$std['firstname']}, {$std['university2']} {$std['semestersJoin']}</li>\n";
    }

    $u=new user();
    $u->fetchUsersAlerts();
    $users=$u->elements;

    if(!empty($users)){
      $message="Les &eacute;tudiants suivants ont &eacute;t&eacute; supprim&eacute;s de la base de donn&eacute;es VWPP : <br/><ul>\n";
      $message.=join("\n",$studentsList);
      $message.="</ul><br/>Universit&eacute; : {$_SESSION['vwpp']['login_univ']}";
      $message.="<br/>Auteur : {$_SESSION['vwpp']['login_name']}";
      $message.="<br/><br/>The VWPP Database";

      $mail=new vwppMail();
      foreach($users as $elem){
	$mail->addAddress($elem);
      }
      $mail->subject="VWPP Database, étudiants supprimés";
      $mail->body = $message;
      $mail->send();
      if($mail->error){
	$error=1;
	$msg="send_emails_error";
      }
    }

    //	Delete students
    foreach($ids as $id){
      $this->delete($id);
    }
  }

}

?>