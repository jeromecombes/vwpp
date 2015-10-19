<?php
// Update : 2015-10-19

require_once "class.student.inc";

class doc{
  public $doc=null;
  public $docs=null;	// fetchAll
  public $error=0;
  public $msg="update_success";
  public $name=null;
  public $name2=null;
  public $realname=null;
  public $rel=null;
  public $size=null;
  public $student=null;
  public $type=null;
  public $type2=null;

  public function doc(){
    $student=array_key_exists("student",$_SESSION['vwpp'])?$_SESSION['vwpp']['student']:null;
    $std_id=array_key_exists("std-id",$_SESSION['vwpp'])?$_SESSION['vwpp']['std-id']:null;
    $this->student=$std_id?$std_id:$student;
  }

  public function delete($id){
    $student=$this->student;
    $db=new db();
    $db->delete("documents","id=$id AND student=$student");	// student added for security
    $this->msg="delete_success";
  }

  public function fetch($id){
    $category=isset($_SESSION['vwpp']['category'])?$_SESSION['vwpp']['category']:null;

    // Si pas de session, return
    if(!$category){
      return;
    }
    // Si admin
    elseif($category=="admin"){
      // Verif droits d'accès aux documents
      if(!in_array(3,$_SESSION['vwpp']['access'])){
	return;
      }
      // Requête pour admin
      $query="id=$id";
    }
    // Si étudiant, requête pour étudiant
    else{
      $query="id=$id AND student={$this->student} AND adminOnly<>'1'";	// student added for security
    }
    
    $db=new db();
    $db->select("documents","*",$query);
    if(!$db->result){
      $this->error=1;
      $this->msg="access_denied";
      return false;
    }
    $student=$db->result[0]['student'];
    $this->type=decrypt($db->result[0]['type'],$student);
    $this->type2=decrypt($db->result[0]['type2'],$student);
    $this->size=decrypt($db->result[0]['size'],$student);
    $this->name=decrypt($db->result[0]['name'],$student);
    $this->name2=$this->name.".".$this->type2;
    $this->realname=decrypt($db->result[0]['realname'],$student);
    $this->rel=decrypt($db->result[0]['rel'],$student);
    $this->doc=decrypt($db->result[0]['document'],$student);
  }

  public function fetchAll(){
    $student=$this->student;
    $db=new db();
	//	N'enregistre plus le doc dans le tableau : utilise trop de memoire
    //	$db->select("documents","*","student='$student'");
    $db->select("documents","type,type2,size,name,realname,rel,student,id,timestamp,adminOnly","student='$student'");
    if($db->result){
      foreach($db->result as $elem){
	$type=decrypt($elem['type'],$student);
	$type2=decrypt($elem['type2'],$student);
	$size=decrypt($elem['size'],$student);
	$name=decrypt($elem['name'],$student);
	$name2=$name.".".$type2;
	$realname=decrypt($elem['realname'],$student);
	$rel=decrypt($elem['rel'],$student);
	//	N'enregistre plus le doc dans le tableau : utilise trop de memoire
	//	$doc=decrypt($elem['document'],$student);
	$doc=null;
	$id=$elem['id'];
	$timestamp=$elem['timestamp'];
	$adminOnly=$elem['adminOnly'];
	$this->docs[]=array("type"=>$type,"type2"=>$type2,"size"=>$size,"name"=>$name,"name2"=>$name2,"doc"=>$doc,"id"=>$id,"timestamp"=>$timestamp,"rel"=>$rel,"adminOnly"=>$adminOnly);
      }
    }
  }

  public function fetchAllStudents($university=null){
    require_once "class.student.inc";
    $s=new student();
    $s->fetchAll($university);
    $students=$s->elements;
    $studentsId=array();
    foreach($s->elements as $elem){
      $studentsId[]=$elem['id'];
    }

    $studentsId=join(",",$studentsId);
    $db=new db();
	//	N'enregistre plus le doc dans le tableau : utilise trop de memoire
    //$db->select("documents","*","student IN ($studentsId)");
    $db->select("documents","type,type2,size,name,realname,rel,student,id,timestamp,adminOnly","student IN ($studentsId)");
    if($db->result){
      foreach($db->result as $elem){
	$type=decrypt($elem['type'],$elem['student']);
	$type2=decrypt($elem['type2'],$elem['student']);
	$size=decrypt($elem['size'],$elem['student']);
	$name=decrypt($elem['name'],$elem['student']);
	$name2=$name.".".$type2;
	$realname=decrypt($elem['realname'],$elem['student']);
	$rel=decrypt($elem['rel'],$elem['student']);
	//	N'enregistre plus le doc dans le tableau : utilise trop de memoire
	//	$doc=decrypt($elem['document'],$elem['student']);
	$doc=null;
	$id=$elem['id'];
	$timestamp=$elem['timestamp'];
	$adminOnly=$elem['adminOnly'];
	$lastname=$students[$elem['student']]['lastname'];
	$firstname=$students[$elem['student']]['firstname'];
//	Ajouter Lastname, Firstname
	$this->docs[]=array("type"=>$type,"type2"=>$type2,"size"=>$size,"name"=>$name,"name2"=>$name2,
	  "doc"=>$doc,"id"=>$id,"timestamp"=>$timestamp,"rel"=>$rel,"adminOnly"=>$adminOnly,
	  "lastname"=>$lastname,"firstname"=>$firstname);
      }
    }
  }

  public function getPhoto($student){
    $this->photo=null;
    $db=new db();
    $rel=encrypt("Photo",$student);
    $db->select("documents","*","student='$student' and rel='$rel'","order by timestamp desc");
    if($db->result){
      $type2=decrypt($db->result[0]['type2'],$student);
      if(!in_array($type2,array("jpeg","jpg","png"))){
	return;
      }
      $Fnm = $GLOBALS['config']['docsFolder']."/data/photo_$student.$type2";
      // Vérifie si le fichier existe dans /data et s'il n'existe pas une nouvelle version dans la BDD
      $age=null;
      if(file_exists($Fnm)){
	$age=filemtime($Fnm);
      }
      // Si fichier n'existe pas dans /data ou si version plus récente dans la base de données
      // On le créé à partir de la BDD
      if($db->result[0]['timestamp']>$age){
	$doc=decrypt($db->result[0]['document'],$student);
	$inF = fopen($Fnm,"w");
	fputs($inF,$doc);
	fclose($inF);
      }
      $url = $GLOBALS['config']['url']."/data/photo_$student.$type2";
      $this->photo="<img src='$url' alt='$student' style='width:200px;'/>\n";
      return;
    }
  }
  
  public function update($files,$docs){
    $student=$this->student;
    $timestamp=mktime();
    $s=new student();
    $s->id=$student;
    $s->fetch();
    $studentName=$s->elements['lastname']."_".$s->elements['firstname'];

    foreach($GLOBALS['config']['documentType'] as $elem){
      $nbType[$elem]=0;
    }

    for($i=0;$i<count($docs);$i++){
      $rel2=$docs[$i][1];
      $rel2=empty($rel2)?"Other":$rel2;
      $rel3=$rel2;
      $rel2=str_replace(" ","_",$rel2);
      $rel2=str_replace("é","e",$rel2);
      if($nbType[$rel3]){
	$name=$rel2."_".$studentName."(".($nbType[$rel3]++).")";
      }
      else{
	$name=$rel2."_".$studentName;
	$nbType[$docs[$i][1]]=2;
      }
      $name=encrypt($name,$student);
      $tmp=explode(".",$files['name'][$i]);
      $type2=encrypt(strtolower($tmp[count($tmp)-1]),$student);
      $rel=htmlentities($rel3,ENT_QUOTES|ENT_IGNORE,"utf-8");
      $rel=encrypt($rel,$student);
      $realname=encrypt($files['name'][$i],$student);
      $type=encrypt($files['type'][$i],$student);
      $size=encrypt($files['size'][$i],$student);
      $adminOnly=array_key_exists(2,$docs[$i])?1:0;

      //	update database if file exists
      if($docs[$i][0]){

	if($files['name'][$i]){	// new upload : set size and type
	  $fp      = fopen($files['tmp_name'][$i], 'r');
	  $document= encrypt(fread($fp, filesize($files['tmp_name'][$i])),$student);
	  fclose($fp);

	  $sql="update {$GLOBALS['dbprefix']}documents set student=:student,name=:name,rel=:rel,realname=:realname,type=:type,type2=:type2,size=:size,timestamp=:timestamp,document=:document,adminOnly=:adminOnly WHERE id=:id;";
	  $update=array(":student"=>$student,":name"=>$name,":rel"=>$rel,":realname"=>$realname,":type"=>$type,":type2"=>$type2,":size"=>$size,":timestamp"=>$timestamp,":document"=>$document,":adminOnly"=>$adminOnly,":id"=>$docs[$i][0]);
	}
	else{			// else only update text infos
	  $sql="update {$GLOBALS['dbprefix']}documents set student=:student,name=:name,rel=:rel,adminOnly=:adminOnly WHERE id=:id;";
	  $update=array(":student"=>$student,":name"=>$name,":rel"=>$rel,":adminOnly"=>$adminOnly,":id"=>$docs[$i][0]);
	}
	$db=new dbh();
	$db->prepare($sql);
	$db->execute($update);
      }
      //		insert infos into database if new file
      elseif($files['size'][$i]){
	$fp      = fopen($files['tmp_name'][$i], 'r');
	$document= encrypt(fread($fp, filesize($files['tmp_name'][$i])),$student);
	fclose($fp);

	$insert=array(":student"=>$student,":name"=>$name,":rel"=>$rel,":realname"=>$realname,":type"=>$type,":type2"=>$type2,":size"=>$size,":timestamp"=>$timestamp,":document"=>$document,":adminOnly"=>$adminOnly);
	$sql="INSERT INTO {$GLOBALS['dbprefix']}documents (student,name,rel,realname,type,type2,size,timestamp,document,adminOnly) VALUES  (:student,:name,:rel,:realname,:type,:type2,:size,:timestamp,:document,:adminOnly);";
	$db=new dbh();
	$db->prepare($sql);
	$db->execute($insert);
      }

    }
  }






}

?>
