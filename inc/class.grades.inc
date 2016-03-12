<?php
// Last update : 2016-03-12, Jérôme Combes

class grades{
  public $semester=null;
  public $grades=array();
  public $data=array();

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
      $this->grades[$elem['course']][$elem['course_id']]['grade1']=$elem['grade1']?decrypt($elem['grade1'],$student):null;
      $this->grades[$elem['course']][$elem['course_id']]['grade2']=$elem['grade2']?decrypt($elem['grade2'],$student):null;
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
	$this->grades[$elem['student']]['grade1']=$elem['grade1']?decrypt($elem['grade1'],$elem['student']):null;
	$this->grades[$elem['student']]['grade2']=$elem['grade2']?decrypt($elem['grade2'],$elem['student']):null;
	$this->grades[$elem['student']]['grade']=$elem['grade']?decrypt($elem['grade'],$elem['student']):null;
	$this->grades[$elem['student']]['date1']=$elem['date1']?decrypt($elem['date1'],$elem['student']):null;
	$this->grades[$elem['student']]['date2']=$elem['date2']?decrypt($elem['date2'],$elem['student']):null;
      }
    }
  }


  function update(){
    // Return if data isn't set
    if(empty($this->data)){
      return;
    }

    // For each line
    foreach($this->data as $key => $value){
      // Prepare data to insert or to update
      $student=$value['student'];
      
      $data=array(":semester"=>$this->semester, ":student"=>$student, ":course"=>$value['course'], ":course_id"=>$value['course_id'], 
	":note"=> encrypt($value['note'],$student), ":date1"=> encrypt($value['date1'],$student), 
	":grade1"=> encrypt($value['grade1'],$student), ":grade2"=> encrypt($value['grade2'],$student), ":grade"=> encrypt($value['grade'],$student), 
	":date2"=> encrypt($value['date2'],$student));
    
      // Check if grade exists in the database
      $db=new db();
      $db->select("grades","*","semester='{$this->semester}' AND student=$student AND course='{$value['course']}' AND course_id={$value['course_id']}");

      // If grade exists, then update
      if($db->result){
	$data[":id"]=$db->result[0]['id'];
	unset($data[':semester']);
	unset($data[':student']);
	unset($data[':course']);
	unset($data[':course_id']);

	$sql="UPDATE `{$GLOBALS['dbprefix']}grades` set note=:note, date1=:date1, grade1=:grade1, grade2=:grade2, grade=:grade, date2=:date2 WHERE id=:id;";
      }
      // If grade doesn't exist, then add
      else{
	$sql="INSERT INTO `{$GLOBALS['dbprefix']}grades` (semester,student,course,course_id,note,date1,grade1,grade2,grade,date2) 
	  VALUES (:semester,:student,:course,:course_id,:note,:date1,:grade1,:grade2,:grade,:date2)";
      }
      
      $db=new dbh();
      $db->prepare($sql);
      $db->execute($data);
    }
  }

}

?>