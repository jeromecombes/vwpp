<?php
// Update : 2015-10-15
require_once "class.student.inc";

class housing{
  public $student=null;
  public $studentLastname=null;
  public $studentFirstname=null;
  public $accepted=null;
  public $semester=null;
  public $maxID=null;
  public $logement=array();
  public $logements=array();
  public $elements=array();
  public $excelElem=array();
  public $shortElem=array();
  public $questions=array();
  public $questionsIds=null;
  public $sort=null;
  public $closed2=false;

  function housing(){
    $this->semester=str_replace(array(" ","_")," ",$_SESSION['vwpp']['semester']);
  }

  public function accept_charte(){
    $this->charte_accepted();
    if(!$this->accepted){
      $db=new db();
      $db->insert2("housing_accept",array("student"=>$this->student,"semester"=>$this->semester));
    }
//     elseif($this->accepted){
//       $db=new db();
//       $db->delete("housing_accept","student='{$this->student}' AND semester='{$this->semester}'");
//     }

  }

  public function affect($student,$logement){
    $db=new db();
    $db->delete("housing_affect","student=$student AND semester='{$this->semester}'");
    $values=array("student"=>$student,"semester"=>$this->semester,"logement"=>$logement);
    $db=new db();
    $db->insert2("housing_affect",$values);
  }

  public function charte_accepted(){
    $db=new db();
    $db->select("housing_accept","*","semester='{$this->semester}' AND student='{$this->student}'");
    if($db->result)
      $this->accepted=true;

  }


  public function fetchAll($university=null){
	  //	Get housing information form housing table
    $semester=str_replace(" ","_",$this->semester);
    $db=new db();
    $db->select("housing","*","semestre='$semester'","order by student,question");
    if(!$db->result)
      return;
  
    $elements=array();
    foreach($db->result as $elem){
      $elements[$elem['student']][$elem['question']]=decrypt($elem['response'],$elem['student']);
      $excelElem[$elem['student']][$elem['question']]=str_replace("\r\n"," - ",html_entity_decode(decrypt($elem['response'],$elem['student']),ENT_QUOTES,"utf-8"));
      $shortElem[$elem['student']][$elem['question']]=substr(decrypt($elem['response'],$elem['student']),0,100);
    }

	  //	Add student's information (student ID, lastname and firstname
    $std=new student();
    $std->fetchAll($university);		// university filter
    $students=$std->elements;

    $keys=array_keys($elements);
    foreach($keys as $key){
      $elements[$key]['student']=$key;
      $elements[$key]['lastname']=$students[$key]['lastname'];
      $elements[$key]['firstname']=$students[$key]['firstname'];
      $excelElem[$key]['student']=$key;
      $excelElem[$key]['lastname']=$students[$key]['lastname'];
      $excelElem[$key]['firstname']=$students[$key]['firstname'];
      $shortElem[$key]['student']=$key;
      $shortElem[$key]['lastname']=$students[$key]['lastname'];
      $shortElem[$key]['firstname']=$students[$key]['firstname'];

	  //	Unset data for deleted students
      if(!$students[$key]['lastname'] and !$students[$key]['firstname']){
	unset($elements[$key]);
	unset($excelElem[$key]);
	unset($shortElem[$key]);
      }
    }

	//	Sort by lastname
    usort($elements,"cmp_lastname");
    usort($excelElem,"cmp_lastname");
    usort($shortElem,"cmp_lastname");
      
    $this->elements=$elements;
    $this->excelElem=$excelElem;
    $this->shortElem=$shortElem;
    $this->getQuestions();
  }

  public function getQuestions(){
    $questions=array();
    $questions[1]="Group flight";
    $questions[3]="Housing Arranged by VWPP";
    $questions[4]="With whom and where you will be living";
    $questions[5]="1. Have you ever travel or lived in France";
    $questions[6]="2. Home stay experience";
    $questions[7]="3. Your own family like";
    $questions[8]="4. Independent living situation before";
    $questions[9]="5. With roommates";
    $questions[10]="6. Did you cook";
    $questions[11]="7. influence";
    $questions[12]="8. Reasons for coming to Paris";
    $questions[13]="9. Academic interests";
    $questions[14]="10. Extra-curricular";
    $questions[15]="11. Smoke";
    $questions[16]="11. Can you live with smookers";
    $questions[17]="1. Vegetarian";
    $questions[18]="2a. eat fish";
    $questions[19]="2b. eat chicken";
    $questions[20]="2c. eat eggs";
    $questions[21]="2d. dairy products";
    $questions[22]="2e. pork";
    $questions[23]="3. eat red meat";
    $questions[24]="4a. Dietary allergies";
    $questions[25]="4b customs";
    $questions[26]="5 adhere to these dietary";
    $questions[27]="6 allergies";
    $questions[28]="1. principal concern";
    $questions[30]="2. Appartement";
    $questions[31]="2. Collocation";
    $questions[32]="Other information";
    
    $this->questions=$questions;
    $this->questions_Ids=array_keys($questions);
  }



  public function getLogement($id){
    $logement=array("lastname"=>null, "firstname"=>null, "address"=>null, "zipcode"=>null, "city"=>null,
      "email"=>null, "phonenumber"=>null, "cellphone"=>null, "lastname2"=>null, "firstname2"=>null, 
      "email2"=>null, "cellphone2"=>null);

    if(!$id){
      $this->logement=$logement;
      return;
    }
    $db=new db();		// Select housing's info
    $db->select("logements","*","id=$id");
    if(!$db->result){
      $this->logement=$logement;
      return;
    }

    $logement=array();
    $this->getStudent($db->result[0]['id']);
    $logement=array("id"=>$db->result[0]['id'],"studentName"=>$this->studentLastname." ".$this->studentFirstname);

    $keys=array_keys($db->result[0]);
    foreach($keys as $key){
      if($key!="id"){
	$logement[$key]=decrypt($db->result[0][$key]);
      }
    }
    $this->logement=$logement;
  }

  public function getLogements($university=null){
				// Select housing available for the semester
    $semester=substr($this->semester,-4);
    $semester.=substr($this->semester,0,6)=="Spring"?1:2;
    $db=new db();
    $db->select("logements_dispo","*","start<='$semester' AND (end >='$semester' OR end=0)");
    if(!$db->result)
      return;
    $ids=array();	
    foreach($db->result as $elem){
      $ids[]=$elem['logement_id'];
    }
    $ids=join(",",$ids);	// List of housing available

    $db=new db();		// Select housing's info
    $db->select("logements","*","id IN ($ids)");
    if(!$db->result)
      return;

    $logements=array();
    $keys=array_keys($db->result[0]);
    foreach($db->result as $elem){
      $this->getStudent($elem['id']);
      $logements[$elem['id']]=array("id"=>$elem['id'],"studentName"=>$this->studentLastname." ".$this->studentFirstname);
      $logements[$elem['id']]["studentLastname"]=$this->studentLastname;
      $logements[$elem['id']]["studentFirstname"]=$this->studentFirstname;
      foreach($keys as $key){
	if($key!="id" and !is_numeric($key)){
	  $logements[$elem['id']][$key]=decrypt($elem[$key]);
	}
      }
    }
    $this->logements=$logements;
  }

  function getLogementsDispo(){
    $this->getLogements();
    $all=$this->logements;
    
    $ids=array();
    $db=new db();
    $db->select("housing_affect","*","semester='{$this->semester}'");
    if($db->result){
      foreach($db->result as $elem){
	unset($all[$elem['logement']]);
      }
    }
    $this->logements=$all;
  }

  function updateLogement($data){
    $fields=array("lastname","firstname","address","zipcode","city","phonenumber","cellphone","email","lastname2","firstname2","cellphone2","email2");
    $values=array();
    $tab1=array();
    $tab2=array();
    $action=null;

    $keys=array_keys($data);
    if($data["id"]){			// Update table logements
      $action="update";
      foreach($keys as $key){
	if(in_array($key,$fields)){
	  $tab1[]="$key=:$key";
	}
      }
      $sql="UPDATE {$GLOBALS['dbprefix']}logements SET ".join(",",$tab1)." WHERE id={$data['id']};";
    }
    else{				// Insert into table logements
      $action="insert";
      foreach($keys as $key){
	if(in_array($key,$fields)){
	  $tab1[]=$key;
	  $tab2[]=":$key";
	}
      }
      $sql="INSERT INTO {$GLOBALS['dbprefix']}logements (".join(",",$tab1).") VALUES (".join(",",$tab2).");";      
    }
    foreach($keys as $key){
      if(in_array($key,$fields)){
	$values[":$key"]=encrypt($data[$key]);
      }
    }

    $db=new dbh();
    $db->prepare($sql);
    $db->execute($values);

    $db=new db();
    $db->select("logements","MAX(id) AS max");
    $this->maxID=$db->result[0]['max'];

				      // Insert into logements_dispo
    if($action=="insert"){
      $semester=substr($this->semester,-4);
      $semester.=substr($this->semester,0,6)=="Spring"?1:2;
      $db=new db();
      $db->insert2("logements_dispo",array("logement_id"=>$this->maxID,"start"=>$semester));
    }
  }

  function deleteLogement($id){
      //	verifier s'il est utiliser avant de le supprimer
    $year=intval(substr($this->semester,-4));
    $semester=substr($this->semester,0,6)=="Spring"?1:2;
    $semester=$semester==1?($year-1)."2":$year."1";
    $db=new db();			// set end = semester-1
    $db->update("logements_dispo","end='$semester'","logement_id='$id'");
  }


  function sort($object,$sort){
    usort($this->$object,"cmp_$sort");
  }

  function getStudent($logement){
    $table1="{$GLOBALS['dbprefix']}students";
    $table2="{$GLOBALS['dbprefix']}housing_affect";
    $db=new db();
    $db->query("select $table1.lastname as lastname, $table1.firstname as firstname FROM $table2
      INNER JOIN $table1 ON $table2.student=$table1.id 
      WHERE $table2.logement=$logement AND $table2.semester='{$this->semester}';");
    if($db->result){
      $this->studentLastname=decrypt($db->result[0]['lastname']);
      $this->studentFirstname=decrypt($db->result[0]['firstname']);
    }
  }

  public function getStudentLogement($student){
    if(!$student)
      return;
    $db=new db();		// Select housing's info
    $db->select("housing_affect","*","student=$student AND semester like '{$this->semester}'");
    if(!$db->result)
      return;

    $this->getLogement($db->result[0]['id']);
  }

  function close($students){
    $db=new dbh();
    $db->prepare("INSERT INTO {$GLOBALS['dbprefix']}housing_closed (student,semester) VALUES (:student,:semester)");
    foreach($students as $elem){
      $db->execute(array(":student"=>$elem,":semester"=>$this->semester));
    }
  }

  function closed(){
    $db=new db();
    $db->select("housing_closed","*","student={$this->student} AND semester='{$this->semester}'");
    if($db->result)
      $this->closed2=true;
  }


  function open($students){
    $students=join(",",$students);
    $db=new db();
    $db->delete("housing_closed","student IN ($students) AND semester='{$this->semester}'");
  }


}






?>