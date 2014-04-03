<?php

class doc{
  $type=null;
  $size=null;
  $name=null;
  $doc=null;

  public function fetch($id){
    $db=new dbh();
    $db->prepare("select * from {$GLOBALS['dbprefix']}documents where id=:id;");
    $db->execute(array(":id"=>$id));
    $student=$db->result[0]['student'];
    $this->type=decypt($db->result[0]['type'],$student);
    $this->size=decypt($db->result[0]['size'],$student);
    $this->name=decypt($db->result[0]['realname'],$student);
    $this->doc=decypt($db->result[0]['document'],$student);
  }








}

?>