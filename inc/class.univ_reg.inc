<?php
// Update : 2016-04-12
require_once "class.student.inc";

class univ_reg{
  public $semester;
  public $student;
  public $elements=array();
  public $published=false;
  public $university;

  public function univ_reg(){
    $student=isset($_SESSION['vwpp']['student'])?$_SESSION['vwpp']['student']:null;
    $std_id=isset($_SESSION['vwpp']['std-id'])?$_SESSION['vwpp']['std-id']:null;
    $this->student=$student?$student:$std_id;
    $semester=isset($_SESSION['vwpp']['semester'])?$_SESSION['vwpp']['semester']:null;
    $this->semester=$semester;
  }


  public function attrib($univ){
    $db=new db();
    $db->delete("univ_reg3","semester='{$this->semester}' AND student='{$this->student}'");
    $db=new dbh();
    $db->prepare("INSERT INTO `{$GLOBALS['dbprefix']}univ_reg3` (university,student,semester)
      VALUES (:university,:student,:semester);");
    $db->execute(array(":university"=>encrypt($univ,$this->student),":student"=>$this->student,":semester"=>$this->semester));

    $db=new db();
    $db->delete("univ_reg_lock1","semester='{$this->semester}' AND student='{$this->student}'");
    if($univ){
      $db=new db();
      $db->insert2("univ_reg_lock1",array("student"=>$this->student, "semester"=>$this->semester));
    }
  }
  
  public function getAttrib(){
    $db=new db();
    $db->select("univ_reg3","*","semester='{$this->semester}' AND student='{$this->student}'");
    if($db->result){
      $this->university=decrypt($db->result[0]['university'],$this->student);
    }
    
    $db=new db();
    $db->select("univ_reg_show","*","semester='{$this->semester}' AND student='{$this->student}'");
    if($db->result){
      $this->published=true;
    }
    
  }

  public function fetch(){
    $db=new db();
    $db->select("univ_reg2","*","semester='{$this->semester}' AND student='{$this->student}'");
    if(!$db->result){
      $data=array(null,null,null,null,null,null,null,null,null,null,null,null);
      $this->elements=$data;
      return;
    }

    foreach($db->result as $elem){
      $this->elements[$elem['question']]=decrypt($elem['response'],$this->student);
    }
  }

  public function fetchAll($univ=null){
    $s=new student();
    $s->fetchAll($univ);
    $students=$s->elements;
    foreach($students as $elem){
      $tab[$elem['id']]['student']=$elem['id'];
      $tab[$elem['id']]['lastname']=$elem['lastname'];
      $tab[$elem['id']]['firstname']=$elem['firstname'];
      $tab[$elem['id']][0]=array("1"=>null,"2"=>null,"3"=>null,"4"=>null,"5"=>null,"6"=>null,"7"=>null,"8"=>null,"9"=>null, "10"=>null,"11"=>null,"12"=>null);	
     		// 9 = justification, 10 = IEP, 11 = Motivation by calendar, 12 = Paris 12
      $tab[$elem['id']][1]=array(null,null,null,null,null,null,null,null,null,null,null,null);
      $tab[$elem['id']][2]=null;

    }

    $semestre=str_replace(" ","_",$this->semester);
    $db=new db();
    $db->select("univ_reg","*","semestre='$semestre'");
    if($db->result){
      foreach($db->result as $elem){
	if($students[$elem['student']]['lastname']){	// Permet de vérifier si l'étudiant existe toujours
	  $tab[$elem['student']][0][$elem['question']]=decrypt($elem['response'],$elem['student']);
	}
      }
    }

    $db=new db();
    $db->select("univ_reg2","*","semester='{$this->semester}'");
    if($db->result){
      foreach($db->result as $elem){
	if(array_key_exists($elem['student'],$students) and array_key_exists("lastname",$students[$elem['student']])){
	  $tab[$elem['student']][1][$elem['question']]=decrypt($elem['response'],$elem['student']);
	}
      }
    }

    $db=new db();
    $db->select("univ_reg3","*","semester='{$this->semester}'");
    if($db->result){
      foreach($db->result as $elem){
	if(array_key_exists($elem['student'],$students) and array_key_exists("lastname",$students[$elem['student']])){
	  $tab[$elem['student']][2]=decrypt($elem['university'],$elem['student']);
	}
      }
    }

    $this->elements=$tab;
  }


  public function update($data){
    $db=new db();
    $db->delete("univ_reg2","semester='{$this->semester}' AND student='{$this->student}'");
    
    $db=new dbh();
    $db->prepare("INSERT INTO `{$GLOBALS['dbprefix']}univ_reg2` (question,response,semester,student) 
      VALUES (:question,:response,:semester,:student);");

    $keys=array_keys($data);
    foreach($keys as $key){
      $db->execute(array(":question"=>$key, ":response"=>encrypt(htmlentities($data[$key],ENT_QUOTES|ENT_IGNORE,"utf-8"),$this->student), ":semester"=>$this->semester, ":student"=>$this->student));
    }
  }












}
?>