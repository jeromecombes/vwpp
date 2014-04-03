<?php
require_once "class.student.inc";

class ciph{
  public $element=array();
  public $elements=array();
  public $elemExcel=array();


  public function ciph(){
    $this->semester=str_replace(" ","_",$_SESSION['vwpp']['semester']);
  }

  public function count2($student){
    $db=new db();
    $db->select("courses_ciph","COUNT(*) as nb","semester='{$this->semester}' AND student='$student'");
    $this->nb=$db->result[0]['nb'];
  }

  public function fetch($id){
    $db=new db();
    $db->select("courses_ciph","*","id='$id'");
    if($db->result){
      $keys=array_keys($db->result[0]);
      $student=$db->result[0]['student'];
      foreach($keys as $key){
	if(in_array($key,array("id","student","semester","lock"))){
	  $this->element[$key]=$db->result[0][$key];
	}
	elseif(!is_numeric($key)){
	  $this->element[$key]=$db->result[0][$key]?decrypt($db->result[0][$key],$student):null;
	}
      }
      $s=new student();
      $s->id=$student;
      $s->fetch();
      $this->element['studentLastname']=$s->elements['lastname'];
      $this->element['studentFirstname']=$s->elements['firstname'];
    }
  }

  public function fetchAll($university){				// university filter
    $db=new db();
    $db->select("courses_ciph","*","semester='{$this->semester}'");
    if(!$db->result){
      return false;
    }
    $keys=array_keys($db->result[0]);
    $i=0;
    foreach($db->result as $elem){
      $s=new student();
      $s->id=$elem['student'];
      $s->university=$university;				// university filter	
      $s->fetch();
      if(!$s->elements['lastname']){
	unset($this->elements[$i]);
      }
      else{
	$this->elements[$i]['studentLastname']=$s->elements['lastname'];
	$this->elements[$i]['studentFirstname']=$s->elements['firstname'];
	$this->elemExcel[$i]['studentLastname']=html_entity_decode($s->elements['lastname'],ENT_QUOTES|ENT_IGNORE,"utf-8");
	$this->elemExcel[$i]['studentFirstname']=html_entity_decode($s->elements['firstname'],ENT_QUOTES|ENT_IGNORE,"utf-8");
	
	foreach($keys as $key){
	  if(in_array($key,array("id","student","semester","lock"))){
	    $this->elements[$i][$key]=$elem[$key];
	    $this->elemExcel[$i][$key]=html_entity_decode($elem[$key],ENT_QUOTES|ENT_IGNORE,"utf-8");
	  }
	  elseif(!is_numeric($key)){
	    $this->elements[$i][$key]=($elem[$key] and !is_numeric($key))?decrypt($elem[$key],$elem['student']):null;
	    $this->elemExcel[$i][$key]=html_entity_decode($this->elements[$i][$key],ENT_QUOTES|ENT_IGNORE,"utf-8");
	  }
	}
      }
    $i++;
    }
  }



}

?>
