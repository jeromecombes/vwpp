<?php
// Update : 2015-10-14
require_once "config.php";
require_once "class.student.inc";

class univ4{
  public $semester=null;
  public $student=null;
  public $elements=array();
  public $error=0;
  public $msg="update_success";
  public $sort=null;


  public function univ4(){
    $student=array_key_exists("student",$_SESSION['vwpp'])?$_SESSION['vwpp']['student']:null;
    $std_id=array_key_exists("std-id",$_SESSION['vwpp'])?$_SESSION['vwpp']['std-id']:null;
    $this->student=$std_id?$std_id:$student;
    $this->semester=$_SESSION['vwpp']['semester'];
  }


  public function add($data){
    $tab=array();
    $fields=array("code","nom","nature","lien","institution","institutionAutre","discipline","niveau",
      "prof","email","jour","debut","fin","modalites","modalites1","modalites2","semester","student","note");
    foreach($fields as $field){
      $tab[":$field"]=encrypt(htmlentities($data[$field],ENT_QUOTES|ENT_IGNORE,"utf-8"));
    }
    $tab[":semester"]=$data['semester'];
    $tab[":student"]=$data['student'];
    $tab[":lien"]=$data['lien'];
    $tab[":note"]=$data['note'];

    if($data['lien']){
      $db=new db();
      $db->select("courses_univ4","*","id={$data['lien']}");
      $tab[":discipline"]=$db->result[0]['discipline'];
      $tab[":institution"]=$db->result[0]['institution'];
      $tab[":institutionAutre"]=$db->result[0]['institutionAutre'];
      $tab[":niveau"]=$db->result[0]['niveau'];
    }

    $db=new dbh();
    $db->prepare("INSERT INTO courses_univ4 (".join(",",$fields).") VALUES (:".join(",:",$fields).");");
    $db->execute($tab);
  }


  public function delete($id){
    $db=new db();
    $db->delete2("courses_univ4","id",$id);
    $this->error=0;
    $this->msg="delete_success";
  }

  public function fetch($id){
    $data=array();

    $s=new student();
    $s->fetchAll();
    $students=$s->elements;

    $db=new db();
    $db->query("SELECT * FROM `courses_univ4` WHERE `id`='$id';");
    if(!empty($db->result)){
      $keys=array_keys($db->result[0]);
      foreach($keys as $key){
	$data[$key]=decrypt($db->result[0][$key]);
      }
      $data['id']=$id;
      $data['semester']=$db->result[0]['semester'];
      $data['student']=$db->result[0]['student'];
      $data['lien']=$db->result[0]['lien'];
      $data['lock']=$db->result[0]['lock'];
      $data['note']=$db->result[0]['note'];
      $data['note2']=$data['note']==1?"Oui":"Non";
      $data['modalites1Text']=str_replace("\n","<br/>",$data['modalites1']);
      $data['modalites2Text']=str_replace("\n","<br/>",$data['modalites2']);
      $db=new db();
      $db->select("courses_univ4","*","lien='$id'");
      $data['liaison']=$db->result[0]?true:false;
      $data['studentLastname']=$students[$data['student']]['lastname'];
      $data['studentFirstname']=$students[$data['student']]['firstname'];
      $data['studentName']=$students[$data['student']]['lastname']." ".$students[$data['student']]['firstname'];
    }
    $this->elements=$data;
  }

  public function fetchAll(){
    $data=array();
    $db=new db();
    $db->query("SELECT * FROM `courses_univ4` WHERE `semester`='{$this->semester}' AND `student`='{$this->student}';");

    if(!empty($db->result)){
      $keys=array_keys($db->result[0]);
      foreach($db->result as $elem){
	foreach($keys as $key){
	  $data[$elem['id']][$key]=decrypt($elem[$key]);
	}
	$data[$elem['id']]['id']=$elem['id'];
	$data[$elem['id']]['semester']=$elem['semester'];
	$data[$elem['id']]['student']=$elem['student'];
	$data[$elem['id']]['lien']=$elem['lien'];
	$data[$elem['id']]['lock']=$elem['lock'];
	$data[$elem['id']]['note']=$elem['note'];
	$data[$elem['id']]['note2']=$data[$elem['id']]['note']==1?"Oui":"Non";
	$data[$elem['id']]['modalites1Text']=str_replace("\n","<br/>",$data[$elem['id']]['modalites1']);
	$data[$elem['id']]['modalites2Text']=str_replace("\n","<br/>",$data[$elem['id']]['modalites2']);
	$db=new db();
	$db->select("courses_univ4","*","lien='{$elem['id']}'");
	$data[$elem['id']]['liaison']=$db->result?true:false;
	$data[$elem['id']]['institution2']=$data[$elem['id']]['institution']=="Autre"?$data[$elem['id']]['institutionAutre']:$data[$elem['id']]['institution'];
      }
      usort($data,"cmp_institution2");
      // 2ème tri permettant de bien lier les cours entre eux
      $tmp=array();
      foreach($data as $elem){
	$tmp[$elem['id']]=$elem;
	if($elem['liaison']){
	  foreach($data as $elem2){
	    if($elem2['lien']==$elem['id']){
	      $tmp[$elem2['id']]=$elem2;
	    }
	  }
	}
      }
      $data=$tmp;

      $this->elements=$data;
    }
  }

  public function fetchAllStudents($GradesOnly=false){
    $s=new student();
    $s->fetchAll();
    $students=$s->elements;

    $data=array();
    $db=new db();
    $req="SELECT * FROM `courses_univ4` WHERE `semester`='{$this->semester}';";
    if($GradesOnly){
      $req="SELECT * FROM `courses_univ4` WHERE `semester`='{$this->semester}' AND note='1';";
    }
    $db->query($req);

    if(!empty($db->result)){
      $keys=array_keys($db->result[0]);
      foreach($db->result as $elem){
	foreach($keys as $key){
	  $data[$elem['id']][$key]=decrypt($elem[$key]);
	}
	$data[$elem['id']]['id']=$elem['id'];
	$data[$elem['id']]['semester']=$elem['semester'];
	$data[$elem['id']]['student']=$elem['student'];
	$data[$elem['id']]['lien']=$elem['lien'];
	$data[$elem['id']]['lock']=$elem['lock'];
	$data[$elem['id']]['note']=$elem['note'];
	$data[$elem['id']]['note2']=$data[$elem['id']]['note']==1?"Oui":"Non";
	$data[$elem['id']]['modalites1Text']=str_replace("\n","<br/>",$data[$elem['id']]['modalites1']);
	$data[$elem['id']]['modalites2Text']=str_replace("\n","<br/>",$data[$elem['id']]['modalites2']);
	$db=new db();
	$db->select("courses_univ4","*","lien='{$elem['id']}'");
	$data[$elem['id']]['liaison']=$db->result?true:false;
	$data[$elem['id']]['institution2']=$data[$elem['id']]['institution']=="Autre"?$data[$elem['id']]['institutionAutre']:$data[$elem['id']]['institution'];
	$data[$elem['id']]['studentName']=$students[$elem['student']]['lastname']." ".$students[$elem['student']]['firstname'];
      }

      $sort=$this->sort?"cmp_".$this->sort:"cmp_institution2";
      usort($data,$sort);
      // 2ème tri permettant de bien lier les cours entre eux

      $masters=array();
      $slaves=array();

      foreach($data as $elem){
	if($elem['lien']){
	  $slaves[]=$elem;
	}
	else{
	  $masters[]=$elem;
	}
      }
      
      $tmp=array();
      foreach($masters as $elem){
	$tmp[$elem['id']]=$elem;
	if($elem['liaison']){
	  foreach($slaves as $elem2){
	    if($elem2['lien']==$elem['id']){
	      $tmp[$elem2['id']]=$elem2;
	    }
	  }
	}
      }
      $data=$tmp;

      $this->elements=$data;
    }
  }

  public function lock($id){
    $db=new db();
    $db->select("courses_univ4","`lock`","id='$id'");
    if($db->result[0]['lock']==1){
      $db=new db();
      $db->update2("courses_univ4",array("`lock`"=>0),array("id"=>$id));
      $this->result=0;
    }
    else{
      $db=new db();
      $db->update2("courses_univ4",array("`lock`"=>1),array("id"=>$id));
      $this->result=1;
    }
  }


  public function update($data){
    $fields=array("code","nom","nature","lien","institution","institutionAutre","discipline","niveau",
      "prof","email","jour","debut","fin","note","modalites","modalites1","modalites2","semester","student");
    foreach($fields as $field){
      $tab[":$field"]=encrypt(htmlentities($data[$field],ENT_QUOTES|ENT_IGNORE,"utf-8"));
    }
    $tab[":semester"]=$data['semester'];
    $tab[":student"]=$data['student'];
    $tab[":lien"]=$data['lien'];
    $tab[":note"]=$data['note'];

    //	Si le cours est lié à un autre, récupération des infos de l'autre cours
    if($data['lien']){
      $db=new db();
      $db->select("courses_univ4","*","id={$data['lien']}");
      $tab[":discipline"]=$db->result[0]['discipline'];
      $tab[":institution"]=$db->result[0]['institution'];
      $tab[":institutionAutre"]=$db->result[0]['institutionAutre'];
      $tab[":niveau"]=$db->result[0]['niveau'];
    }

    $set=array();
    foreach($fields as $field){
      $set[]="$field=:$field";
    }
    $set=join(",",$set);

    $db=new dbh();
    $db->prepare("UPDATE `courses_univ4` SET $set WHERE `id`='{$data['id']}';");
    $db->execute($tab);

    // Mise à jour des cours liés
    $db=new db();
    $db->select("courses_univ4","id","lien='{$data['id']}'");
    if($db->result){
      $db2=new dbh();
      $db2->prepare("UPDATE `courses_univ4` SET institution=:institution,institutionAutre=:institutionAutre,discipline=:discipline,niveau=:niveau WHERE id=:id;");
      foreach($db->result as $elem){
	$tab2=array(":institution"=>$tab[':institution'],":institutionAutre"=>$tab[':institutionAutre'],":discipline"=>$tab[':discipline'],":niveau"=>$tab[':niveau'],":id"=>$elem['id']);
	$db2->execute($tab2);
      }
    }
  }

  public function updateModalites($data){
    $tab=array();
    $tab[":modalites1"]=encrypt(htmlentities($data["modalites1"],ENT_QUOTES|ENT_IGNORE,"utf-8"));
    $tab[":modalites"]=encrypt(htmlentities($data["modalites"],ENT_QUOTES|ENT_IGNORE,"utf-8"));
   
    $db=new dbh();
    $db->prepare("UPDATE `courses_univ4` SET modalites=:modalites,modalites1=:modalites1 WHERE `id`='{$data['id']}';");
    $db->execute($tab);
  }

}


?>