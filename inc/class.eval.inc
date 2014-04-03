<?php
// Last update : 2014-04-04, Jérôme Combes

class evaluation{
    var $semester;
    var $form;
    var $elements;
    var $elemExcel;
    var $closed;
    var $courseId;
    var $student;
    var $students;

  function evaluation(){
    $this->semester=str_replace(" ","_",$_SESSION['vwpp']['semester']);
    $this->form=null;
    $this->closed=null;
    $this->courseId=null;
    $this->student=null;
    $this->elements=array();
    $this->elemExcel=array();
  }

  function fetch($id){
    $db=new db();
    $db->select("evaluations","*","id='$id'");
    if($db->result){
      $timestamp=$db->result[0]['timestamp'];
      $student=$db->result[0]['student'];
      $this->form=$db->result[0]['form'];
      $this->closed=$db->result[0]['closed'];
      $this->courseId=$db->result[0]['courseId'];
      $this->student=$db->result[0]['student'];
      $db=new db();
      $db->select("evaluations","*","timestamp='$timestamp' AND student='$student'");
      foreach($db->result as $elem){
	$this->elements[$elem['question']]=$elem["response"]?decrypt($elem["response"],$student):null;
      }
    }
  }


  function fetchAll($form,$closed=null,$university=null){
    require_once "class.ciph.inc";
    require_once "class.reidhall.inc";
    require_once "class.student.inc";
    require_once "class.univ4.inc";

    $s=new student();
    $s->getByUniv($university);

    $tab=array();
    $tabExcel=array();
    $closed=$closed===null?"'0','1'":"'$closed'";		//	enum donc "'0'" et "'1'" obligatoire
								//	Possibilité de transformé closed en "closed int(1) default 0"

    $db=new db();						//	Recherche des reponses
    $db->select("evaluations","*","semester='{$this->semester}' AND form='$form' AND closed IN ($closed) AND student IN ({$s->byUnivList})");
    if($db->result){
      foreach($db->result as $elem){
	$offset=0;
	if($form=="univ"){
	  $offset=$elem['question']<11?2:3;
	}

	$response=$elem["response"]?decrypt($elem["response"],$elem['student']):null;
	$tab["{$elem['timestamp']}_{$elem['student']}"][$elem['question']-$offset]=$response;

	$response=str_replace(array("\n","\r","\t")," ",$response);
	$response=html_entity_decode($response,ENT_QUOTES|ENT_IGNORE,"utf-8");
	$tabExcel["{$elem['timestamp']}_{$elem['student']}"][$elem['question']-$offset]=$response;
      }
    }

    $db=new db();						//	Recherche des informations sur les cours
    $db->select("evaluations","*","semester='{$this->semester}' AND form='$form' AND closed IN ($closed) AND student IN ({$s->byUnivList}) GROUP BY timestamp,student");
    if($db->result){
      foreach($db->result as $elem){				//	Set static info
	$tab["{$elem['timestamp']}_{$elem['student']}"]["courseId"]=$elem["courseId"];
	$tab["{$elem['timestamp']}_{$elem['student']}"]["student"]=$elem["student"];
	$tabExcel["{$elem['timestamp']}_{$elem['student']}"]["courseId"]=$elem["courseId"];
	$tabExcel["{$elem['timestamp']}_{$elem['student']}"]["student"]=$elem["student"];

	$data=array();
	switch($form){
	  case "CIPH" :
	    $c=new ciph();
	    $c->fetch($elem['courseId']);
	    $data=array($c->element['instructeur'],$c->element['titre']);
	    for($i=0;$i<count($data);$i++){
	      $tab["{$elem['timestamp']}_{$elem['student']}"][$i+1]=$data[$i];
	      $data[$i]=str_replace(array("\n","\r","\t")," ",$data[$i]);
	      $data[$i]=html_entity_decode($data[$i],ENT_QUOTES|ENT_IGNORE,"utf-8");
	      $tabExcel["{$elem['timestamp']}_{$elem['student']}"][$i+1]=$data[$i];
	    }
	    break;

	  case "ReidHall" :
	    $r=new reidhall();
	    $r->fetch($elem['courseId']);
	    $data=array($r->element['title'],$r->element['professor']);
	    for($i=0;$i<count($data);$i++){
	      $tab["{$elem['timestamp']}_{$elem['student']}"][$i+1]=$data[$i];
	      $data[$i]=str_replace(array("\n","\r","\t")," ",$data[$i]);
	      $data[$i]=html_entity_decode($data[$i],ENT_QUOTES|ENT_IGNORE,"utf-8");
	      $tabExcel["{$elem['timestamp']}_{$elem['student']}"][$i+1]=$data[$i];
	    }
	    break;

	  case "univ" :
	    $u=new univ4();
	    $u->fetch($elem['courseId']);
	    $data=array($u->elements['nom'],$u->elements['code'],$u->elements['institution']);
	    for($i=0;$i<count($data);$i++){
	      $tab["{$elem['timestamp']}_{$elem['student']}"][$i+1]=$data[$i];
	      $data[$i]=str_replace(array("\n","\r","\t")," ",$data[$i]);
	      $data[$i]=html_entity_decode($data[$i],ENT_QUOTES|ENT_IGNORE,"utf-8");
	      $tabExcel["{$elem['timestamp']}_{$elem['student']}"][$i+1]=$data[$i];
	    }
	    break;
	}
      }
    }
  
    $this->elements=$tab;
    $this->elemExcel=$tabExcel;

  }

  function fetchStudents(){
    require_once("class.student.inc");
    $s=new student();
    $s->fetchAll();
    foreach($s->elements as $elem){
      $this->students[$elem['id']]["program"]=0;
      $this->students[$elem['id']]["ReidHall"]=0;
      $this->students[$elem['id']]["univ"]=0;
      $this->students[$elem['id']]["CIPH"]=0;
      $this->students[$elem['id']]["intership"]=0;
      $this->students[$elem['id']]["tutorats"]=0;
    }

    $db=new db();
    $db->select("evaluations","*","semester='{$this->semester}'","GROUP BY student,form,timestamp");

    foreach($db->result as $elem){
      $this->students[$elem['student']][$elem['form']]++;
    }
  }
}

?>