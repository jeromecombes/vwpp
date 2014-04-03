<?php

class db
	{
	var $host;
	var $dbname;
	var $user;
	var $password;
	var $conn;
	var $result;
	var $nb;
	var $error;
	
	function db()
		{
		$this->host=$GLOBALS['config']['dbhost'];
		$this->dbname=$GLOBALS['config']['dbname'];
		$this->user=$GLOBALS['config']['dbuser'];
		$this->password=$GLOBALS['config']['dbpass'];
		}

	function connect()
		{
		$this->conn=mysql_connect($this->host,$this->user,$this->password);
		mysql_select_db($this->dbname,$this->conn);
		}
	
	function query($requete)
		{
		$this->connect();
		$req=mysql_query($requete,$this->conn);
		
		if(!$req)
			{
			echo "<br/><br/>### ERREUR SQL ###<br/><br/>$requete<br/><br/>";
			echo mysql_error();
			echo "<br/><br/>";
			$this->error=true;
			}
		elseif(strtolower(substr(trim($requete),0,6))=="select" or strtolower(substr(trim($requete),0,4))=="show")
			{
			$this->nb=mysql_num_rows($req);
			for($i=0;$i<$this->nb;$i++)
				$this->result[]=mysql_fetch_array($req);
			}
		if(!$this->result)
			$this->result=array();
		$this->disconnect();
		}

	function disconnect()
		{
		mysql_close($this->conn);
		}

	function select($table,$infos=null,$where=null,$options=null)
		{
		$infos=$infos?$infos:"*";
		$where=$where?$where:"1";
		$requete="SELECT $infos FROM `{$GLOBALS['config']['dbprefix']}$table` WHERE $where $options";
		$this->query($requete);
		}

	function update($table,$set,$where)
		{
		$requete="UPDATE `{$GLOBALS['config']['dbprefix']}$table` SET $set WHERE $where";
		$this->query($requete);
		}

	function update2($table,$fields,$ids){
		$tab=array();
		$keys=array_keys($fields);
		foreach($keys as $elem){
		  $tab[]="$elem='{$fields[$elem]}'";
		}
		$set=join(",",$tab);
		$tab=array();
		$keys=array_keys($ids);
		foreach($keys as $elem){
		  $tab[]="$elem='{$ids[$elem]}'";
		}
		$where=join(",",$tab);
		$this->update($table,$set,$where);
	}

	function delete($table,$where=1)
		{
		$requete="DELETE FROM `{$GLOBALS['config']['dbprefix']}$table` WHERE $where";
		$this->query($requete);
		}

	function delete2($table,$field,$ids)
		{
		$ids=is_array($ids)?join("','",$ids):$ids;
		$this->query("DELETE FROM `{$GLOBALS['config']['dbprefix']}$table` where $field in ('$ids');");
		}

	function insert($table,$values,$fields=null)
		{
		$fields=$fields?"($fields)":null;
		if(is_array($values)){
		  for($i=0;$i<count($values);$i++){
		    $values[$i]=substr($values[$i],1,-1);
		    //$values[$i]=mysql_real_escape_string($values[$i],$this->conn);
		    $values[$i]="'".$values[$i]."'";
		  }
		  $values="(".join("),(",$values).")";
		}
		else{
		  $values=substr($values,1,-1);
		  $values=mysql_real_escape_string($values,$this->conn);
		  $values="('$values')";
		}
		$requete="INSERT INTO `{$GLOBALS['config']['dbprefix']}$table` $fields VALUES $values;";
		$this->connect();
		$req=mysql_query($requete,$this->conn);
		if(mysql_error()){
		  echo mysql_error();
		  echo "<br/>".$requete;
		  }
		$this->disconnect();
		}

	function insert2($table,$values,$options=null){
		$tab=array();
		if(array_key_exists(0,$values)){
		  $fields=array_keys($values[0]);
		  $fields=join(",",$fields);

		  foreach($values as $elem){
		    $tab[]="'".join("','",$elem)."'";
		    }
		}
		else{
		  $fields=array_keys($values);
		  $fields=join(",",$fields);

		  $tab[]="'".join("','",$values)."'";
		}
		  
		$this->insert($table,$tab,$fields);
		}

	}

class dbh{
  var $dbhost;
  var $dbname;
  var $dbuser;
  var $dbpass;
  var $pdo;
  var $stmt;
  var $result;


  function dbh(){
    $this->dbhost=$GLOBALS['config']['dbhost'];
    $this->dbname=$GLOBALS['config']['dbname'];
    $this->dbuser=$GLOBALS['config']['dbuser'];
    $this->dbpass=$GLOBALS['config']['dbpass'];

    $this->pdo=new PDO("mysql:host={$this->dbhost};dbname={$this->dbname}",$this->dbuser,$this->dbpass);
  }

  function exec($sql){
    $this->pdo->exec($sql);
  }

  function prepare($sql){
    $this->stmt=$this->pdo->prepare($sql);
  }

  function execute($data){
    $this->stmt->execute($data);
    $this->result=$this->stmt->fetchAll();
  }

}

?>