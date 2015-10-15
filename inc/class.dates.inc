<?php
// Update : 2015-10-15

class dates{
  public $elements=array();

  public function dates(){
    $this->semester=$_SESSION['vwpp']['semester'];

  }

  public function fetch(){
    $db=new db();
    $db->select("dates","*","semester='{$this->semester}'");
    if($db->result){
      $this->elements=$db->result[0];
    }else{
      $this->elements=array("date1"=>null, "date2"=>null, "date3"=>null, "date4"=>null, 
	"date5"=>null, "date6"=>null, "date7"=>null);
    }
  }

  public function update($post){
    $db=new db();
    $db->select("dates","*","semester='{$this->semester}'");
    if($db->result){
      $db=new db();
      $db->update("dates","date1='{$post['date1']}',date2='{$post['date2']}',date3='{$post['date3']}',date4='{$post['date4']}',date5='{$post['date5']}',date6='{$post['date6']}',date7='{$post['date7']}'","semester='{$this->semester}'");
    }
    else{
      $post['semester']=$this->semester;
      $db=new db();
      $db->insert2("dates",$post);
    }

print_r($dates);

  }
}

?>