<?php
require_once "class.student.inc";

class tutorat{
  public $student=null;
  public $semester=null;
  public $elements=array();

  public function tutorat(){
    $this->semester=$_SESSION['vwpp']['semester'];
    $this->student=$_SESSION['vwpp']['std-id']?$_SESSION['vwpp']['std-id']:$_SESSION['vwpp']['student'];
  }

  public function fetch(){
    $student=$this->student;
    $semester=$this->semester;
  
    $db=new db();
    $db->select("tutorat","*","student='$student' AND semester='$semester'");
    $data=$db->result[0];
    $data=array("tuteur"=>decrypt($data['tuteur']),"day"=>decrypt($data['day']),
	"start"=>decrypt($data['start']),"end"=>decrypt($data['end']));
    $this->elements=$data;
  }

  public function fetchALL($univ=null){	//	A continuer
    $semester=$this->semester;
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
    $db->select("tutorat","*","semester='$semester'");
    foreach($db->result as $elem){	//	A continuer
      $lastname=$students[$elem['student']]['lastname'];
      $firstname=$students[$elem['student']]['firstname'];
      $tab[$elem['student']]=array("tuteur"=>decrypt($elem['tuteur']),"day"=>decrypt($elem['day']),
	  "start"=>decrypt($elem['start']),"end"=>decrypt($elem['end']),"lastname"=>$lastname,"firstname"=>$firstname);
    }
    $this->elements=$tab;
  }


  public function update($tutorat){
    $student=$this->student;
    $semester=$this->semester;

    $tutorat=array_map("entities",$tutorat);
    $tutorat=array_map("encrypt",$tutorat);

    $data=array(":semester"=>$semester,":student"=>$student,":tuteur"=>$tutorat['tuteur'],
      ":day"=>$tutorat['day'],":start"=>$tutorat['start'],":end"=>$tutorat['end']);

    $db=new db();
    $db->delete("tutorat","semester='$semester' AND student='$student'");

    $db=new dbh();
    $db->prepare("INSERT INTO {$GLOBALS['dbprefix']}tutorat (semester,student,tuteur,day,start,end)
      VALUES (:semester,:student,:tuteur,:day,:start,:end);");

    $db->execute($data);

  }
}

?>