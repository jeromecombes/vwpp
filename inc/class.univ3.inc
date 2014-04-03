<?php
require_once "class.student.inc";

class univ3{
  public $semester=null;
  public $student=null;
  public $elements=array();
  public $error=0;
  public $msg="update_success";


  public function univ3(){
    $this->semester=$_SESSION['vwpp']['semester'];
    $this->student=$_SESSION['vwpp']['std-id']?$_SESSION['vwpp']['std-id']:$_SESSION['vwpp']['student'];
  }


  public function addCM($cm){
    $db=new db();
    $db->insert2("courses_univ3",array("student"=>$this->student,"semester"=>$this->semester,"cm"=>$cm));
  }

  public function addTD($td,$cm){
    $db=new db();
    $db->update("courses_univ3","td='$td'","semester='{$this->semester}' AND student='{$this->student}' AND cm='$cm'");
  }


  public function addNewCourse($course){
      //	Add CM in courses_cm
    $cm=array(":university"=>$course["university"],":code"=>$course["code"],":semester"=>$this->semester);
    $fields=array("ufr","parcours","discipline","departement","licence","niveau","nom","prof","email","jour1","debut1","fin1","jour2","debut2","fin2","credits");
    foreach($fields as $field){
      $cm[":".$field]=encrypt(htmlentities($course[$field],ENT_QUOTES|ENT_IGNORE,"utf-8"));
    }
    $db=new dbh();
    $db->prepare("INSERT INTO courses_cm (university,code,semester,ufr,parcours,discipline,departement,licence,niveau,nom,prof,email,jour1,debut1,fin1,jour2,debut2,fin2,credits)
      VALUES (:university,:code,:semester,:ufr,:parcours,:discipline,:departement,:licence,:niveau,:nom,:prof,:email,:jour1,:debut1,:fin1,:jour2,:debut2,:fin2,:credits);");
    $db->execute($cm);

      //	Add CM for current student
    $this->fetchCM($course['university'],$course['code']);
    $this->addCM($this->elements['id']);
  }


  public function addNewTD($course){
      //	Add TD in courses_td
    $td=array(":university"=>$course["university"],":code"=>$course["code"],":semester"=>$this->semester);
    $fields=array("nom","nom_en","prof","email","jour1","debut1","fin1","jour2","debut2","fin2");
    foreach($fields as $field){
      $td[":".$field]=encrypt(htmlentities($course[$field],ENT_QUOTES|ENT_IGNORE,"utf-8"));
    }
    $db=new dbh();					// Ajouter jour1,debut1,fin1,jour2,debut2,fin2
    $db->prepare("INSERT INTO courses_td (university,code,semester,nom,nom_en,prof,email,jour1,debut1,fin1,jour2,debut2,fin2)
      VALUES (:university,:code,:semester,:nom,:nom_en,:prof,:email,:jour1,:debut1,:fin1,:jour2,:debut2,:fin2);");
    $db->execute($td);

      //	Add TD for current student
    $this->fetchTD($course['university'],$course['code']);
    $this->addTD($this->elements['id'],$course['cm_id']);
  }


  public function deleteCM($cm){
	//		Select the TD id
    $db=new db();
    $db->select("courses_univ3","td","student='{$this->student}' AND semester='{$this->semester}' AND cm='{$cm}'");
    $td=$db->result[0]['td'];

	//		Delete the TD if not use by other students
    $db=new db();
    $db->select("courses_univ3","*","td='{$td}'");
    if($db->nb==1){
      $db=new db();
      $db->delete("courses_td","id='{$td}'");
    }

	//		Delete Student's registration
    $db=new db();
    $db->delete("courses_univ3","student='{$this->student}' AND semester='{$this->semester}' AND cm='{$cm}'");

	//		Delete the courses (CM) if not use by other students
    $db=new db();
    $db->select("courses_univ3","*","cm='{$cm}'");
    if(!$db->result){
      $db=new db();
      $db->delete("courses_cm","id='{$cm}'");
    }

    $this->msg="delete_success";
  }

  public function deleteTD($cm){
	//		Select the TD id
    $db=new db();
    $db->select("courses_univ3","td","student='{$this->student}' AND semester='{$this->semester}' AND cm='{$cm}'");
    $td=$db->result[0]['td'];

	//		Delete the TD if not use by other students
    $db=new db();
    $db->select("courses_univ3","*","td='{$td}'");
    if($db->nb==1){
      $db=new db();
      $db->delete("courses_td","id='{$td}'");
    }

	//		Update Student's registration
    $db=new db();
    $db->update("courses_univ3","td=''","student='{$this->student}' AND semester='{$this->semester}' AND cm='{$cm}'");


    $this->msg="delete_success";
  }

  public function fetch($id){
    $db=new db();
    $db->select("courses_univ3","*","id='$id'");
    if(!$db->result){
      return false;
    }

    $tab=array();
    $cm=array();
    $td=array();
    $db2=new db();
    $db2->select("courses_cm","*","id='{$db->result[0]['cm']}'");
    if($db2->result){
      $d=$db2->result[0];
      $keys=array_keys($d);
      foreach($keys as $key){
	if(!is_numeric($key))
	  $cm[$key]=decrypt($d[$key]);
      }
      $cm["university"]=$d["university"];
      $cm["code"]=$d['code'];
      $cm["id"]=$d['id'];

      if($cm["jour1"] and $cm["debut1"] and $cm["fin1"]){
	$cm["jour1_txt"]=str_replace(array(1,2,3,4,5,6,7),array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),$cm["jour1"]);
	$cm["debut1_txt"]="de ".str_replace(":","h",$cm["debut1"]);
	$cm["fin1_txt"]="à ".str_replace(":","h",$cm["fin1"]);
	$cm["horaires1"]="{$cm["jour1_txt"]} {$cm["debut1_txt"]} {$cm["fin1_txt"]}";
      }
      if($cm["jour2"] and $cm["debut2"] and $cm["fin2"]){
	$cm["jour2_txt"]=str_replace(array(1,2,3,4,5,6,7),array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),$cm["jour2"]);
	$cm["debut2_txt"]="de ".str_replace(":","h",$cm["debut2"]);
	$cm["fin2_txt"]="à ".str_replace(":","h",$cm["fin2"]);
	$cm["horaires2"]="{$cm["jour2_txt"]} {$cm["debut2_txt"]} {$cm["fin2_txt"]}";
      }

    }
    $db2=new db();
    $db2->select("courses_td","*","id='{$db->result[0]['td']}'");
    $td["id"]=$db->result[0]['td'];
    if($db2->result){
      $d=$db2->result[0];
      $keys=array_keys($d);
      foreach($keys as $key){
	if(!is_numeric($key))
	  $td[$key]=decrypt($d[$key]);
      }
      $td["university"]=$d["university"];
      $td["code"]=$d['code'];
      $td["id"]=$d['id'];
    }
    $tab=array("cm"=>$cm,"td"=>$td);

  $this->elements=$tab;
  }

  public function fetchAll(){
    $db=new db();
    $db->select("courses_univ3","*","student='{$this->student}' AND semester='{$this->semester}'");
    if(!$db->result){
      return false;
    }

    $tab=array();
    foreach($db->result as $elem){
      $cm=array();
      $td=array();
      $cm['lock']=$elem['lockCM'];		// Verrou Ne marche pas
      $td['lock']=$elem['lockTD'];

      $db2=new db();
      $db2->select("courses_cm","*","id='{$elem['cm']}'");
      if($db2->result){
	$d=$db2->result[0];
	$keys=array_keys($d);
	foreach($keys as $key){
	  if(!is_numeric($key))
	    $cm[$key]=decrypt($d[$key]);
	}
	$cm["university"]=$d["university"];
	$cm["code"]=$d['code'];
	$cm["id"]=$d['id'];

	if($cm["jour1"] and $cm["debut1"] and $cm["fin1"]){
	  $cm["jour1_txt"]=str_replace(array(1,2,3,4,5,6,7),array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),$cm["jour1"]);
	  $cm["debut1_txt"]="de ".str_replace(":","h",$cm["debut1"]);
	  $cm["fin1_txt"]="à ".str_replace(":","h",$cm["fin1"]);
	  $cm["horaires1"]="{$cm["jour1_txt"]} {$cm["debut1_txt"]} {$cm["fin1_txt"]}";
	}
	if($cm["jour2"] and $cm["debut2"] and $cm["fin2"]){
	  $cm["jour2_txt"]=str_replace(array(1,2,3,4,5,6,7),array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),$cm["jour2"]);
	  $cm["debut2_txt"]="de ".str_replace(":","h",$cm["debut2"]);
	  $cm["fin2_txt"]="à ".str_replace(":","h",$cm["fin2"]);
	  $cm["horaires2"]="{$cm["jour2_txt"]} {$cm["debut2_txt"]} {$cm["fin2_txt"]}";
	}

      }
      $db2=new db();
      $db2->select("courses_td","*","id='{$elem['td']}'");
      $td["id"]=$elem['td'];
      if($db2->result){
	$d=$db2->result[0];
	$keys=array_keys($d);
	foreach($keys as $key){
	  if(!is_numeric($key))
	    $td[$key]=decrypt($d[$key]);
	}
	$td["university"]=$d["university"];
	$td["code"]=$d['code'];
	$td["id"]=$d['id'];

	if($td["jour1"] and $td["debut1"] and $td["fin1"]){
	  $td["jour1_txt"]=str_replace(array(1,2,3,4,5,6,7),array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),$td["jour1"]);
	  $td["debut1_txt"]="de ".str_replace(":","h",$td["debut1"]);
	  $td["fin1_txt"]="à ".str_replace(":","h",$td["fin1"]);
	  $td["horaires1"]="{$td["jour1_txt"]} {$td["debut1_txt"]} {$td["fin1_txt"]}";
	}
	if($td["jour2"] and $td["debut2"] and $td["fin2"]){
	  $td["jour2_txt"]=str_replace(array(1,2,3,4,5,6,7),array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),$td["jour2"]);
	  $td["debut2_txt"]="de ".str_replace(":","h",$td["debut2"]);
	  $td["fin2_txt"]="à ".str_replace(":","h",$td["fin2"]);
	  $td["horaires2"]="{$td["jour2_txt"]} {$td["debut2_txt"]} {$td["fin2_txt"]}";
	}

      }
      $tab[]=array("cm"=>$cm,"td"=>$td);
    }

  $this->elements=$tab;
  }

  public function fetchAllCM(){
    $db=new db();
    $db->select("courses_cm","*","semester='{$this->semester}'");
    if(!$db->result){
      return false;
    }

    $tab=array();
    $keys=array_keys($db->result[0]);

    foreach($db->result as $elem){
      $cm=array();
      foreach($keys as $key){
	if(!is_numeric($key))
	  $cm[$key]=decrypt($elem[$key]);
      }
      $cm["university"]=$elem["university"];
      $cm["code"]=$elem['code'];
      $cm["id"]=$elem['id'];

      if($cm["jour1"] and $cm["debut1"] and $cm["fin1"]){
	$cm["jour1_txt"]=str_replace(array(1,2,3,4,5,6,7),array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),$cm["jour1"]);
	$cm["debut1_txt"]="de ".str_replace(":","h",$cm["debut1"]);
	$cm["fin1_txt"]="à ".str_replace(":","h",$cm["fin1"]);
	$cm["horaires1"]="{$cm["jour1_txt"]} {$cm["debut1_txt"]} {$cm["fin1_txt"]}";
      }
      if($cm["jour2"] and $cm["debut2"] and $cm["fin2"]){
	$cm["jour2_txt"]=str_replace(array(1,2,3,4,5,6,7),array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),$cm["jour2"]);
	$cm["debut2_txt"]="de ".str_replace(":","h",$cm["debut2"]);
	$cm["fin2_txt"]="à ".str_replace(":","h",$cm["fin2"]);
	$cm["horaires2"]="{$cm["jour2_txt"]} {$cm["debut2_txt"]} {$cm["fin2_txt"]}";
      }
    $tab[]=$cm;
    }

  $this->elements=$tab;
  }

  public function fetchAllTD(){
    $db=new db();
    $db->select("courses_td","*","semester='{$this->semester}'");
    if(!$db->result){
      return false;
    }

    $tab=array();
    $keys=array_keys($db->result[0]);

    foreach($db->result as $elem){
      $td=array();
      foreach($keys as $key){
	if(!is_numeric($key))
	  $td[$key]=decrypt($elem[$key]);
      }
      $td["university"]=$elem["university"];
      $td["code"]=$elem['code'];
      $td["id"]=$elem['id'];

      if($td["jour1"] and $td["debut1"] and $td["fin1"]){
	$td["jour1_txt"]=str_replace(array(1,2,3,4,5,6,7),array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),$td["jour1"]);
	$td["debut1_txt"]="de ".str_replace(":","h",$td["debut1"]);
	$td["fin1_txt"]="à ".str_replace(":","h",$td["fin1"]);
	$td["horaires1"]="{$td["jour1_txt"]} {$td["debut1_txt"]} {$td["fin1_txt"]}";
      }
      if($td["jour2"] and $td["debut2"] and $td["fin2"]){
	$td["jour2_txt"]=str_replace(array(1,2,3,4,5,6,7),array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),$td["jour2"]);
	$td["debut2_txt"]="de ".str_replace(":","h",$td["debut2"]);
	$td["fin2_txt"]="à ".str_replace(":","h",$td["fin2"]);
	$td["horaires2"]="{$td["jour2_txt"]} {$td["debut2_txt"]} {$td["fin2_txt"]}";
      }

    //	Add CM Info
    $db=new db();
    $db->select("courses_univ3","*","td={$elem['id']}");
    $cm=$db->result[0]['cm'];
    $this->fetchCMById($cm);
    $td['cm_code']=$this->elements['code'];
    $td['cm_nom']=$this->elements['nom'];
    $td['cm_id']=$cm;

    $tab[]=$td;
    }

  $this->elements=$tab;
  }

  public function fetchCM($univ,$code){
    $db=new db();
    $db->select("courses_cm","*","university='$univ' AND code='$code' AND semester='{$this->semester}'");
    $cm=array();
    if($db->result){
      $d=$db->result[0];
      $keys=array_keys($d);
      foreach($keys as $key){
	if(!is_numeric($key))
	  $cm[$key]=decrypt($d[$key]);
      }
      $cm["university"]=$d["university"];
      $cm["code"]=$d['code'];
      $cm["id"]=$d['id'];
      $this->elements=$cm;
    }
  }

  public function fetchCMById($id){
    $db=new db();
    $db->select("courses_cm","*","id='$id'");
    $cm=array();
    if($db->result){
      $d=$db->result[0];
      $keys=array_keys($d);
      foreach($keys as $key){
	if(!is_numeric($key))
	  $cm[$key]=decrypt($d[$key]);
      }
      $cm["university"]=$d["university"];
      $cm["code"]=$d['code'];
      $cm["id"]=$d['id'];
      $this->elements=$cm;
    }
  }

  public function fetchStudents($cm,$university){
    $db=new db();
    $db->select("courses_univ3","*","cm=$cm");
    if(!$db->result)
      return false;

    $s=new student();
    $s->fetchAll($university);
    $students=array();

    foreach($db->result as $elem){
      if($s->elements[$elem['student']])
	$students[]=$s->elements[$elem['student']];
    }
    $this->students=$students;
  }


  public function fetchStudentsTD($td,$university){
    $db=new db();
    $db->select("courses_univ3","*","td=$td");
    if(!$db->result)
      return false;

    $s=new student();
    $s->fetchAll($university);
    $students=array();

    foreach($db->result as $elem){
      if($s->elements[$elem['student']])
	$students[]=$s->elements[$elem['student']];
    }
    $this->students=$students;
  }

  public function fetchTD($var1,$var2=null){		// $var1 = univ or id	; $var2= code or null
    if($var2){
      $db=new db();
      $db->select("courses_td","*","university='$var1' AND code='$var2' AND semester='{$this->semester}'");
    }
    else{
      $db=new db();
      $db->select("courses_td","*","id=$var1");
    }

    $td=array();
    if($db->result){
      $d=$db->result[0];
      $keys=array_keys($d);
      foreach($keys as $key){
	if(!is_numeric($key))
	  $td[$key]=decrypt($d[$key]);
      }
      $td["university"]=$d["university"];
      $td["code"]=$d['code'];
      $td["id"]=$d['id'];

      if($td["jour1"] and $td["debut1"] and $td["fin1"]){
	$td["jour1_txt"]=str_replace(array(1,2,3,4,5,6,7),array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),$td["jour1"]);
	$td["debut1_txt"]="de ".str_replace(":","h",$td["debut1"]);
	$td["fin1_txt"]="à ".str_replace(":","h",$td["fin1"]);
	$td["horaires1"]="{$td["jour1_txt"]} {$td["debut1_txt"]} {$td["fin1_txt"]}";
      }
      if($td["jour2"] and $td["debut2"] and $td["fin2"]){
	$td["jour2_txt"]=str_replace(array(1,2,3,4,5,6,7),array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),$td["jour2"]);
	$td["debut2_txt"]="de ".str_replace(":","h",$td["debut2"]);
	$td["fin2_txt"]="à ".str_replace(":","h",$td["fin2"]);
	$td["horaires2"]="{$td["jour2_txt"]} {$td["debut2_txt"]} {$td["fin2_txt"]}";
      }

      //	Add CM Info
      $db=new db();
      $db->select("courses_univ3","*","td={$td['id']}");
      $cm=$db->result[0]['cm'];
      $this->fetchCMById($cm);
      $td['cm_code']=$this->elements['code'];
      $td['cm_nom']=$this->elements['nom'];
      $td['cm_id']=$cm;

      $this->elements=$td;
    }
  }

  public function fetchVeryAll($university=null){
    //		Select All Students
    $s=new student();
    $s->fetchAll($university);
    foreach($s->elements as $student){
      $students[$student['id']]['std_lastname']=$student['lastname'];
      $students[$student['id']]['std_firstname']=$student['firstname'];
      $students[$student['id']]['std_email']=$student['email'];
      $students[$student['id']]['std_homeInstitution']=$student['homeInstitution'];
    }
    
    //		Courses Registration
    $db=new db();
    $db->select("courses_univ3","*","semester='{$this->semester}'");
    $courses=$db->result;

    //		Courses Info (CM)
    $this->fetchAllCM();
    $cm=$this->elements;

    $tab=array();
    foreach($cm as $elem){
      foreach($courses as $course){
	if($course['cm']==$elem['id']){
	  if($students[$course['student']]){
	    $tab[]=array_merge($elem,$students[$course['student']]);
	  }
	}
      }
    }
    $this->elements=$tab;
  }

  public function fetchVeryAllTD($university=null){
    //		Select All Students
    $s=new student();
    $s->fetchAll($university);
    foreach($s->elements as $student){
      $students[$student['id']]['std_lastname']=$student['lastname'];
      $students[$student['id']]['std_firstname']=$student['firstname'];
      $students[$student['id']]['std_email']=$student['email'];
    }
    
    //		Courses Registration
    $db=new db();
    $db->select("courses_univ3","*","semester='{$this->semester}'");
    $courses=$db->result;

    //		Courses Info (TD)
    $this->fetchAllTD();
    $td=$this->elements;

    $tab=array();
    foreach($td as $elem){
      foreach($courses as $course){
	if($course['td']==$elem['id']){
	  if($students[$course['student']]){
	    $tmp=array_merge($elem,$students[$course['student']]);
    //		CM Info
	    $this->fetchCMById($course['cm']);
	    $cm['cm_code']=$this->elements['code'];
	    $cm['cm_nom']=$this->elements['nom'];
	    $cm['cm_nom_en']=$this->elements['nom_en'];
	    $cm['cm_prof']=$this->elements['prof'];
	    $tab[]=array_merge($tmp,$cm);
	  }
	}
      }
    }
    $this->elements=$tab;
  }

  public function lock($action,$cm_id){
    $db=new db();
    switch($action){
      case "lockCM" 	: $db->update("courses_univ3","lockCM=1","cm=$cm_id AND semester='{$this->semester}' AND student='{$this->student}'");	break;
      case "unLockCM" 	: $db->update("courses_univ3","lockCM=0","cm=$cm_id AND semester='{$this->semester}' AND student='{$this->student}'");	break;
      case "lockTD" 	: $db->update("courses_univ3","lockTD=1","cm=$cm_id AND semester='{$this->semester}' AND student='{$this->student}'");	break;
      case "unLockTD" 	: $db->update("courses_univ3","lockTD=0","cm=$cm_id AND semester='{$this->semester}' AND student='{$this->student}'");	break;
    }
  }

  public function update($data){
    $keys=array_keys($data);
    $tab=array();
    foreach($keys as $key){
      if(in_array($key,array("id","university","code","semester")))
	$tab[":$key"]=$data[$key];
      else
	$tab[":$key"]=encrypt(htmlentities($data[$key],ENT_QUOTES|ENT_IGNORE,"utf-8"));
    }


    $db=new dbh();
    if(in_array("id",$keys)){			//	Update
      unset($keys["id"]);
      $tmp=array();
      foreach($keys as $key)
	$tmp[]="$key=:$key";

      $set=join(",",$tmp);
      $db->prepare("UPDATE courses_cm set $set WHERE id=:id");
      $db->execute($tab);
    }
    else{					//	Insert
    }
      
  }

  public function updateTD($data){
    $keys=array_keys($data);
    $tab=array();
    foreach($keys as $key){
      if(in_array($key,array("id","university","code","semester")))
	$tab[":$key"]=$data[$key];
      else
	$tab[":$key"]=encrypt(htmlentities($data[$key],ENT_QUOTES|ENT_IGNORE,"utf-8"));
    }


    $db=new dbh();
    if(in_array("id",$keys)){			//	Update
      unset($keys["id"]);
      $tmp=array();
      foreach($keys as $key)
	$tmp[]="$key=:$key";

      $set=join(",",$tmp);
      $db->prepare("UPDATE courses_td set $set WHERE id=:id");
      $db->execute($tab);
    }
    else{					//	Insert
    }
      
  }

}


?>