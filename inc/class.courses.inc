<?php
// Last update : 2014-04-04, Jérôme Combes

require_once "class.student.inc";
require_once "class.tutorat.inc";
require_once "class.univ4.inc";

class courses{
  public $semester=null;
  public $vwpp_courses=array();
  public $univ_courses=array();
  public $ciph_courses=array();
  public $tutorat=array();
  public $students_attrib=array();
  public $students_choices=array();
  public $course=array();
  public $defaultStudent=null;

  public function courses(){
    $this->semester=str_replace(array(" ","_"),"%",$_SESSION['vwpp']['semester']);
    $this->defaultStudent=$_SESSION['vwpp']['std-id']?$_SESSION['vwpp']['std-id']:$_SESSION['vwpp']['student'];
  }

  public function fetch($student){
    //			VWPP Courses
    $db=new db();
    $db->select("courses_attrib_rh","*","semester LIKE '{$this->semester}' AND student=$student");
    $this->writing1=$db->result[0]['writing1']?$db->result[0]['writing1']:null;
    $this->writing2=$db->result[0]['writing2']?$db->result[0]['writing2']:null;
    $this->writing3=$db->result[0]['writing3']?$db->result[0]['writing3']:null;
    $this->seminar1=$db->result[0]['seminar1']?$db->result[0]['seminar1']:null;
    $this->seminar2=$db->result[0]['seminar2']?$db->result[0]['seminar2']:null;
    $this->seminar3=$db->result[0]['seminar3']?$db->result[0]['seminar3']:null;

    $this->coursesName();

    if($this->writing1)
      $this->vwpp_courses[]=$this->writing1;
	if($this->writing2)
      $this->vwpp_courses[]=$this->writing2;
	if($this->writing3)
      $this->vwpp_courses[]=$this->writing3;
    if($this->seminar1)
      $this->vwpp_courses[]=$this->seminar1;
    if($this->seminar2)
      $this->vwpp_courses[]=$this->seminar2;
    if($this->seminar3)
      $this->vwpp_courses[]=$this->seminar3;

    //			University Courses
    $u=new univ4();
    $u->student=$student;
    $u->fetchAll();
    foreach($u->elements as $elem){
      $tmp=$elem;
      $tmp['nom_en']=$elem['nom'];
      $tmp['type']=$elem['nature'];
      $this->univ_courses[]=$tmp;
    }
    usort($this->univ_courses,cmp_type);
/*
    $db=new db();
    $db->select("courses_univ3","*","semester LIKE '{$this->semester}' AND student=$student");
    
    $fields=array("cm_code","cm_name","cm_name_en","cm_prof","cm_day1","cm_day2","cm_start1","cm_start2","cm_end1","cm_end2","td_day1","td_day2","td_start1","td_start2","td_end1","td_end2","td_name","td_prof");
    if($db->result)
    foreach($db->result as $elem){
      $tmp=array("id"=>$elem['id']);
      foreach($fields as $field){
	$tmp[$field]=decrypt($elem[$field],$student);
      }
      $this->univ_courses[]=$tmp;
*/

/*      $this->univ_courses[]=array("id"=>$elem['id'],"cm_code"=>decrypt($elem['cm_code'],$student),
      "cm_name"=>decrypt($elem['cm_name'],$student),"cm_name_en"=>decrypt($elem['cm_name_en'],$student),
      "cm_prof"=>decrypt($elem['cm_prof'],$student));*/
//     }

    //			CIPH Courses
    $db=new db();
    $db->select("courses_ciph","*","semester LIKE '{$this->semester}' AND student=$student");
    $fields=array("titre","instructeur","day1","day2","day3","day4","day5","day6","start1","start2","start3","start4","start5","start6","end1","end2","end3","end4","end5","end6");
    if($db->result)
    foreach($db->result as $elem){
      $tmp=array("id"=>$elem['id']);
      foreach($fields as $field){
	$tmp[$field]=decrypt($elem[$field],$student);
      }
      $this->ciph_courses[]=$tmp;

/*      $this->ciph_courses[]=array("id"=>$elem['id'],"titre"=>decrypt($elem['titre'],$student),
      "instructeur"=>decrypt($elem['instructeur'],$student));*/
    }



    //	Tutorats

    $t=new tutorat();
    $t->fetch();
    $this->tutorat=$t->elements;
  }

  public function courseName($id){
    $db=new db();
    $db->select("courses","*","id=$id");
    if(!$db->result)
      return false;

    $cryptFields=array("professor","title","nom","code");
    $course["id"]=$id;
    $course["type"]=$db->result[0]['type'];
    foreach($cryptFields as $field){
      $course[$field]=decrypt($db->result[0][$field]);
    }
  $this->course=$course;
  }

  public function coursesName(){	// for VWPP Courses	: Add title, prof, schedule
    $db=new db();
    $db->select("courses","*","semester like '{$this->semester}'");
    if(!$db->result)
      return false;

    foreach($db->result as $elem){
      $cryptFields=array("professor","title","nom","code","jour","debut","fin");
      $courses[$elem['id']]["id"]=$elem['id'];
      $courses[$elem['id']]["type"]=$elem['type'];
      foreach($cryptFields as $field){
	$courses[$elem['id']][$field]=decrypt($elem[$field]);
      }
    }
    
    $this->writing1=$courses[$this->writing1];
    $this->writing2=$courses[$this->writing2];
    $this->writing3=$courses[$this->writing3];
    $this->seminar1=$courses[$this->seminar1];
    $this->seminar2=$courses[$this->seminar2];
    $this->seminar3=$courses[$this->seminar3];
  }


  public function getStudents($id,$university=null){
    $s=new student();		//	Students list
    $s->fetchAll($university);
    $students=$s->elements;

    $students_attrib=array();
    $where="(writing1=$id or writing2=$id or writing3=$id or seminar1=$id or seminar2=$id or seminar3=$id)";
    $db=new db();
    $db->select("courses_attrib_rh","student",$where);
    if($db->result){
      foreach($db->result as $elem){
	if(!in_array($elem["student"],$students_attrib) and $students[$elem["student"]]){
	  $students_attrib[]=$students[$elem["student"]];
	}
      }
    }
    usort($students_attrib,cmp_lastname);
    $this->students_attrib=$students_attrib;

    $students_choices=array();
    $where="(a1=$id or a2=$id)";
    $db=new db();
    $db->select("courses_choices","student",$where);
    if($db->result){
      foreach($db->result as $elem){			// verif array_key_exists : if student deleted
	if(!in_array($elem["student"],$students_choices) and array_key_exists($elem["student"],$students)){
	  $students_choices[]=array_merge($students[$elem["student"]],array("choice"=>"1<sup>st</sup>"));
	}
      }
    }
    $where="(b1=$id or b2=$id)";
    $db=new db();
    $db->select("courses_choices","student",$where);
    if($db->result){
      foreach($db->result as $elem){
	if(!in_array($elem["student"],$students_choices) and array_key_exists($elem["student"],$students)){
	  $students_choices[]=array_merge($students[$elem["student"]],array("choice"=>"2<sup>nd</sup>"));
	}
      }
    }

    usort($students_choices,cmp_lastname);
    $this->students_choices=$students_choices;
  }


  public function getSchedule(){
    $tab=array();
    $this->fetch($this->defaultStudent);
    if($this->vwpp_courses){
      foreach($this->vwpp_courses as $elem){
	if($elem["jour"] and $elem["debut"] and $elem["fin"]){
	  $day=str_replace(array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),array(1,2,3,4,5,6,7),$elem['jour']);
	  $tab[]=array("type"=>$elem["type"], "prof"=>$elem['professor'], "nom"=>$elem["nom"], 
	    "jour"=>$elem["jour"], "debut"=>$elem["debut"], "fin"=>$elem["fin"], "day"=>$day);
	}
      }
    }

    if($this->univ_courses){
      foreach($this->univ_courses as $elem){
	for($i=1;$i<3;$i++){
	  if($elem["jour$i"] and $elem["debut$i"] and $elem["fin$i"]){
	    $jour=str_replace(array(1,2,3,4,5,6,7),array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),$elem["jour$i"]);
	    $tab[]=array("type"=>$elem['type'], "prof"=>$elem['prof'], "nom"=>$elem["nom"], 
	      "jour"=>$jour, "debut"=>$elem["debut$i"], "fin"=>$elem["fin$i"], "day"=>$elem["jour$i"]);
	  }
	}
      }
    }

//     if($this->univ_courses){
//       foreach($this->univ_courses as $elem){
// 	for($i=1;$i<3;$i++){
// 	  if($elem["cm_day$i"] and $elem["cm_start$i"] and $elem["cm_end$i"]){
// 	    $day=str_replace(array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),array(1,2,3,4,5,6,7),$elem["cm_day$i"]);
// 	    $tab[]=array("type"=>"CM", "prof"=>$elem['cm_prof'], "nom"=>$elem["cm_name"], 
// 	      "jour"=>$elem["cm_day$i"], "debut"=>$elem["cm_start$i"], "fin"=>$elem["cm_end$i"], "day"=>$day);
// 	  }
// 	  if($elem["td_day$i"] and $elem["td_start$i"] and $elem["td_end$i"]){
// 	    $day=str_replace(array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),array(1,2,3,4,5,6,7),$elem["td_day$i"]);
// 	    $tab[]=array("type"=>"TD", "prof"=>$elem['td_prof'], "nom"=>$elem["td_name"], 
// 	      "jour"=>$elem["td_day$i"], "debut"=>$elem["td_start$i"], "fin"=>$elem["td_end$i"], "day"=>$day);
// 	  }
// 	}
//       }
//     }


    if($this->ciph_courses){
      foreach($this->ciph_courses as $elem){
	for($i=1;$i<7;$i++){
	  if($elem["day$i"] and $elem["start$i"] and $elem["end$i"]){
	    $day=str_replace(array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),array(1,2,3,4,5,6,7),$elem["day$i"]);
	    $tab[]=array("type"=>"CIPh", "prof"=>$elem['instructeur'], "nom"=>$elem["titre"], 
	      "jour"=>$elem["day$i"], "debut"=>$elem["start$i"], "fin"=>$elem["end$i"], "day"=>$day);
	  }
	}
      }
    }

    if($this->tutorat){
      $elem=$this->tutorat;
      if($elem["day"] and $elem["start"] and $elem["end"]){
	$day=str_replace(array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),array(1,2,3,4,5,6,7),$elem["day"]);
	$tab[]=array("type"=>"Tutorat", "prof"=>$elem['tuteur'], "nom"=>"Tutorat", 
	  "jour"=>$elem["day"], "debut"=>$elem["start"], "fin"=>$elem["end"], "day"=>$day);
      }
    }

    usort($tab,cmp_schedule);
    $this->schedule=$tab;
  }



}
?>