<?php
require_once "class.student.inc";

class univ{
    var $semester;
    var $element;
    var $elements;
    var $elemExcel;
    var $cryptedFields;
    var $lang;
    var $error;
    var $autocomplete;
    var $nb;

  function univ(){
    $this->error=0;
    $this->semester=str_replace(" ","_",$_SESSION['vwpp']['semester']);
    $this->element=array();
    $this->elements=array();
    $this->autocomplete=array();
    $this->cryptedFields=array("university_en","ufr","ufr_en","parcours","parcours_en",
	"discipline","discipline_en","departement","departement_en","licence","licence_en","niveau",
	"niveau_en","cm_name","cm_name_en","cm_code_en","cm_prof","cm_prof_en","td_name",
	"td_name_en","td_code","td_code_en","td_prof","td_prof_en");
    $this->cryptedFields2=array("university","cm_code");
  }

  function fetch($id){
    $db=new db();
    $db->select("courses_univ","*","id='$id'");
    if($db->result){
      $keys=array_keys($db->result[0]);
      $student=$db->result[0]['student'];
      foreach($keys as $key){
	if(in_array($key,array("id","student","semester","lock","ref"))){
	  $this->element[$key]=$db->result[0][$key];
	}
	elseif(in_array($key,array("university","cm_code"))){
	  $this->element[$key]=decrypt($db->result[0][$key]);
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

  function fetchByCode($univ,$code){
    $univ=encrypt($univ);
    $code=encrypt($code);

    $db=new dbh();
    $db->prepare("select * from {$GLOBALS['dbprefix']}courses_univ WHERE university=:university AND cm_code=:cm_code;");
    $db->execute(array(":university"=>$univ,":cm_code"=>$code));

    if($db->result){
      $keys=array_keys($db->result[0]);
      $student=$db->result[0]['student'];
      foreach($keys as $key){
	if(in_array($key,array("id","student","semester","lock","ref"))){
	  $this->element[$key]=$db->result[0][$key];
	}
	elseif(in_array($key,array("university","cm_code"))){
	  $this->element[$key]=decrypt($db->result[0][$key]);
	}
	elseif(!is_numeric($key)){
	  $this->element[$key]=$db->result[0][$key]?decrypt($db->result[0][$key],$student):null;
	}
      }

      foreach($db->result as $elem){
	$s=new student();
	$s->id=$elem['student'];
	$s->fetch();
	$this->students[]=$s->elements;
      }
    }
  }

  function fetchAll($university=null,$group=false){			// university filter
    $db=new db();
    if($group)
      $db->select("courses_univ","*","semester='{$this->semester}'","group by university,cm_code");
    else
      $db->select("courses_univ","*","semester='{$this->semester}'");

    if(!$db->result){
      return false;
    }
    $keys=array_keys($db->result[0]);
    $i=0;
    foreach($db->result as $elem){
      $s=new student();
      $s->id=$elem['student'];
      $s->university=$university;			// university filter
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
	  if(in_array($key,array("id","student","semester","lock","ref"))){
	    $this->elements[$i][$key]=$elem[$key];
	    $this->elemExcel[$i][$key]=html_entity_decode($elem[$key],ENT_QUOTES|ENT_IGNORE,"utf-8");
	  }
	  elseif(in_array($key,array("university","cm_code"))){
	    $this->elements[$i][$key]=decrypt($elem[$key]);
	    $this->elemExcel[$i][$key]=decrypt($elem[$key]);
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


  function fetchAllSemesters(){
    $db=new db();
    $db->select("courses_univ","*");
    $keys=array_keys($db->result[0]);
    $i=0;
    foreach($db->result as $elem){
      foreach($keys as $key){
	if(!array_key_exists($key,$this->autocomplete) and !is_numeric($key))
	  $this->autocomplete[$key]=array();
	if(in_array($key,array("id","student","semester","lock"))){
	  $this->elements[$i][$key]=$elem[$key];
	}
	else{
	  $this->elements[$i][$key]=($elem[$key] and !is_numeric($key))?decrypt($elem[$key],$elem['student']):null;
	  if($this->elements[$i][$key] and !in_array($this->elements[$i][$key],$this->autocomplete[$key]))
	    $this->autocomplete[$key][]=addslashes(html_entity_decode($this->elements[$i][$key],ENT_QUOTES,"UTF-8"));
	}
      }
    $i++;
    }
  }

  function update($data){
    if(!is_numeric($data['id']) or !is_numeric($data['student'])){
      echo "Error, ID and STUDENT must be numeric (class univ, function update)";
      return;
    }
    else{
      $values=array();
      $set=array();
      $student=$data['student'];
      $values[":id"]=$data['id'];
      $keys=array_keys($data);
      foreach($keys as $key){
	if(in_array($key,$this->cryptedFields)){
	  $set[]="$key=:$key";
	  $values[":$key"]=encrypt(htmlentities($data[$key],ENT_QUOTES | ENT_IGNORE,"UTF-8"),$student);
	}
	elseif(in_array($key,$this->cryptedFields2)){
	  $set[]="$key=:$key";
	  $values[":$key"]=encrypt(htmlentities($data[$key],ENT_QUOTES | ENT_IGNORE,"UTF-8"));
	}

      }
      $set=join(", ",$set);
      $sql="UPDATE {$GLOBALS['config']['dbprefix']}courses_univ SET $set WHERE id=:id;";

      $db=new dbh();
      $db->prepare($sql);
      $db->execute($values);
      
      if($db->error){
	$this->error=1;
	$this->msg="update_error";
      }
      else{
	$this->msg="update_success";
      }
    }
  }

  function writeAutocompleteJS(){
    $auto=$this->autocomplete;
    echo "<script type='text/JavaScript'>\n";
    echo "var autocomplete=new Array();\n";

    foreach(array_keys($auto) as $key){
      echo "autocomplete['$key']=new Array();\n";
      foreach($auto[$key] as $elem){
	echo "autocomplete['$key'].push('$elem');\n";
      }
    }
    echo "</script>\n";
  }

  function count2($student){
    $db=new db();
    $db->select("courses_univ","COUNT(*) as nb","semester='{$this->semester}' AND student='$student'");
    $this->nb=$db->result[0]['nb'];
  }

}

?>