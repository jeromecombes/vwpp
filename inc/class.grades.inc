<?php
// Last update : 2014-04-04, Jérôme Combes

class grades{
  public $semester=null;
  public $grades=array();

  public function grades(){
    $this->semester=$_SESSION['vwpp']['semester'];
  }

  public function fetch($student){
    $db=new db();
    $db->select("grades","*","semester='{$this->semester}' AND student='$student'");
    if(!$db->result)
      return false;
    
    foreach($db->result as $elem){
      $this->grades[$elem['course']][$elem['course_id']]['course_id']=$elem['course_id'];
      $this->grades[$elem['course']][$elem['course_id']]['note']=$elem['note']?decrypt($elem['note'],$student):null;
      $this->grades[$elem['course']][$elem['course_id']]['grade']=$elem['grade']?decrypt($elem['grade'],$student):null;
      $this->grades[$elem['course']][$elem['course_id']]['date1']=$elem['date1']?decrypt($elem['date1'],$student):null;
      $this->grades[$elem['course']][$elem['course_id']]['date2']=$elem['date2']?decrypt($elem['date2'],$student):null;
      //	Example : 	$this->grades["VWPP"][1]=array(1,18,"A");
      //			$this->grades["VWPP"][2]=array(2,16,"A-");
      //			$this->grades["UNIV"][1]=array(1,18,"A");
    }
  }

  public function fetchCourse($course,$course_id){
    $db=new db();
    $db->select("grades","*","semester='{$this->semester}' AND course='$course' AND course_id='$course_id'");
    if(!$db->result)
      return false;
    
    foreach($db->result as $elem){
      $s=new student();
      $s->id=$elem['student'];
      $s->fetch();
      if($s->elements){
	$this->grades[$elem['student']]['lastname']=$s->elements['lastname'];
	$this->grades[$elem['student']]['firstname']=$s->elements['firstname'];
	$this->grades[$elem['student']]['university']=$s->elements['university'];
	$this->grades[$elem['student']]['lastExcel']=html_entity_decode($s->elements['lastname'],ENT_QUOTES|ENT_IGNORE,"utf-8");
	$this->grades[$elem['student']]['firstExcel']=html_entity_decode($s->elements['firstname'],ENT_QUOTES|ENT_IGNORE,"utf-8");
	$this->grades[$elem['student']]['student']=$elem['student'];
	$this->grades[$elem['student']]['note']=$elem['note']?decrypt($elem['note'],$elem['student']):null;
	$this->grades[$elem['student']]['grade']=$elem['grade']?decrypt($elem['grade'],$elem['student']):null;
	$this->grades[$elem['student']]['date1']=$elem['date1']?decrypt($elem['date1'],$elem['student']):null;
	$this->grades[$elem['student']]['date2']=$elem['date2']?decrypt($elem['date2'],$elem['student']):null;
      }
    }
  }

  function update($student,$course,$course_id,$grade,$field=null){
    if(!$student)
      return false;

    $db=new db();					//	Check if grade exists
    $db->select("grades","*","semester='{$this->semester}' AND student=$student AND course='$course' AND course_id=$course_id");
    $id=$db->result?$db->result[0]['id']:null;

    if($grade=="" and $id){				//	Set note=null
      $db=new db();
      $db->update("grades","note='', date1=''","id=$id");
      return;
    }
    elseif($grade=="null_us" and $id){				//	Set grade=null;
      $db=new db();
      $db->update("grades","grade='', date2=''","id=$id");
      return;
    }

    if(!$field){
      $field=is_numeric($grade)?"note":"grade";		//	Grade FR or US
    }							//	Or date1 or date2 if specified
					    
    $grade=encrypt($grade,$student);

    if($id){						//	Update note or grade
      $sql="UPDATE `{$GLOBALS['dbprefix']}grades` set $field=:grade WHERE id=:id";
      $data=array(":grade"=>$grade, ":id"=>$db->result[0]['id']);

    }
    else{						//	Or insert
      $sql="INSERT INTO `{$GLOBALS['dbprefix']}grades` (semester,student,course,course_id,$field) 
	VALUES (:semester,:student,:course,:course_id,:grade)";
      $data=array(":semester"=>$this->semester, ":student"=>$student, ":course"=>$course, 
	":course_id"=>$course_id, ":grade"=>$grade);
    }

    $db=new dbh();					//	Execute the request
    $db->prepare($sql);
    $db->execute($data);
  }

}

?>