<?php
include_once "config.php";

class user{
  public $auth=false;
  public $elements=array();
  public $password=null;
  public $token=null;

  function fetch($id){
    $db=new db();
    $db->select("users","*","id='$id'");
    $this->elements=$db->result[0];
  }

  function fetchAll(){
    $db=new db();
    $db->select("users");
    $this->elements=$db->result;
  }

  function fetchUsersAlerts(){
    $db=new db();
    $db->select("users","*","alerts=1");
    if($db->result){
      foreach($db->result as $elem){
	$this->elements[]=$elem['email'];
      }
    }
  }

  function login(){
    $db=new db();
    $db->select("users","*","token='{$this->token}' AND password='{$this->password}'");
    if($db->result){
      $_SESSION['vwpp']['login']=$this->login;
      $_SESSION['vwpp']['login_id']=$db->result[0]['id'];
      $_SESSION['vwpp']['access']=unserialize($db->result[0]['access']);
      $_SESSION['vwpp']['category']="admin";
      $_SESSION['vwpp']['login_univ']=$db->result[0]['university'];
      $_SESSION['vwpp']['login_name']=$db->result[0]['firstname']." ".$db->result[0]['lastname'];
      $_SESSION['vwpp']['language']=$db->result[0]['language'];
      $_SESSION['vwpp']['email']=$db->result[0]['email'];
      $this->auth=true;
    }
  }

  function setPassword($clearPassword){
    $this->password=md5($clearPassword);
  }

  function setToken($email){
    $this->token=md5($email);
  }


  function update($data){
    $id=$data['id'];
    unset($data['id']);

    $data2=array();
    $keys=array_keys($data);
    foreach($keys as $key){
      $set[]="$key=:$key";
      $data2[":$key"]=$data[$key];
    }
    $set=join(",",$set);
    $db=new dbh();
    $db->prepare("UPDATE `users` SET $set WHERE `id`='$id';");
    $db->execute($data2);
  }


/*
  function user(){

  }

  function add($data){
    

  }
*/










}

?>