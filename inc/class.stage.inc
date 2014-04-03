<?php
class stage{
  public $semester;
  public $student=null;
  public $elements=array();
  
  public function stage(){
    $this->semester=$_SESSION['vwpp']['semester'];
    $this->student=$_SESSION['vwpp']['std-id']?$_SESSION['vwpp']['std-id']:$_SESSION['vwpp']['student'];
  }

  public function fetch(){
    $db=new db();
    $db->select("stages","*","student='{$this->student}' AND semester='{$this->semester}'");
    if($db->result){
      $stage=decrypt($db->result[0]['stage'],$this->student);
      $notes=$db->result[0]['notes']?decrypt($db->result[0]['notes'],$this->student):null;
      $notes2=str_replace("\n","<br/>",$notes);
      $this->elements=array("Oui",$stage,"id"=>$db->result[0]['id'],"lock"=>$db->result[0]['lock'],
      "notes"=>$notes,"notes2"=>$notes2);
    }
    else
      $this->elements=array("Non");
  }

  public function fetchAll($univ=null){
    $s=new student();
    $s->fetchAll($univ);
    $students=$s->elements;
    $studentsTab=array();
    if(is_array($students))
    foreach($students as $elem){
      $studentsTab[]=$elem['id'];
    }

    $tab=array();
    $db=new db();
    $db->select("stages","*","semester='{$this->semester}'");
    if($db->result){
      foreach($db->result as $elem){
	if(in_array($elem['student'],$studentsTab)){
	  $stage=decrypt($elem['stage'],$elem['student']);
	  $notes=$elem['notes']?decrypt($elem['notes'],$elem['student']):null;
	  $notes2=str_replace("\n","<br/>",$notes);
	  $lastname=$students[$elem['student']]['lastname'];
	  $firstname=$students[$elem['student']]['firstname'];
	  $tab[$elem['student']]=array("stage"=>$stage,"id"=>$elem['id'],"lock"=>$elem['lock'],
	  "notes"=>$notes,"notes2"=>$notes2,"lastname"=>$lastname,"firstname"=>$firstname);
	}
      }
    }
    $this->elements=$tab;
  }

  public function update($data){
    $stage=encrypt(htmlentities($data[1],ENT_QUOTES|ENT_IGNORE,"utf-8"),$this->student);
    $notes=encrypt(htmlentities($data["notes"],ENT_QUOTES|ENT_IGNORE,"utf-8"),$this->student);
    $this->fetch();
    if($this->elements[0]=="Oui" and $data[0]=="Non"){
      $db=new db();
      $db->delete("stages","student='{$this->student}' AND semester='{$this->semester}'");
      return;
    }
    elseif($this->elements[0]=="Oui" and $data[0]=="Oui"){
      $sql="UPDATE {$GLOBALS['config']['dbprefix']}stages SET stage=:stage,notes=:notes WHERE id=:id;";
      $data=array(":stage"=>$stage,":id"=>$this->elements['id'],":notes"=>$notes);
    }
    elseif($this->elements[0]=="Non" and $data[0]=="Oui"){
      $sql="INSERT INTO {$GLOBALS['config']['dbprefix']}stages (student,semester,stage,notes) 
	VALUES ('{$this->student}','{$this->semester}',:stage,:notes);";
      $data=array(":stage"=>$stage,":notes"=>$notes);
    }
    
    $db=new dbh();
    $db->prepare($sql);
    $db->execute($data);
  }
}
?>