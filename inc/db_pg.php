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
		$this->port=$GLOBALS['config']['port'];
		$this->user=$GLOBALS['config']['dbuser'];
		$this->password=$GLOBALS['config']['dbpass'];
		}

	function connect()
		{
		$this->conn=pg_connect("host={$this->host} port={$this->port} dbname={$this->user} password={$this->password}");
		}
	
	function query($requete)
		{
		$this->connect();
		$req=pg_query($requete,$this->conn);
		
		if(!$req)
			{
			echo "<br/><br/>### ERREUR SQL ###<br/><br/>$requete<br/><br/>";
			echo "<br/><br/>";
			$this->error=true;
			}
		elseif(strtolower(substr(trim($requete),0,6))=="select" or strtolower(substr(trim($requete),0,4))=="show")
			{
			$this->nb=pg_num_rows($req);
			for($i=0;$i<$this->nb;$i++)
				$this->result[]=pg_fetch_array($req);
			}
		if(!$this->result)
			$this->result=array();
		$this->disconnect();
		}

	function disconnect()
		{
		pg_close($this->conn);
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

	function delete($table,$where=null)
		{
		$requete="DELETE FROM `{$GLOBALS['config']['dbprefix']}$table` WHERE $where";
		$this->query($requete);
		}
	function insert($table,$values,$fields=null)
		{
		$fields=$fields?"($fields)":null;
		if(is_array($values))
		  {
		  $values="(".join("),(",$values).")";
		  }
		else
		  $values="($values)";
		$requete="INSERT INTO `{$GLOBALS['config']['dbprefix']}$table` $fields VALUES $values;";
		$this->connect();
		$req=mysql_query($requete,$this->conn);
		$this->disconnect();
		}
	}
?>