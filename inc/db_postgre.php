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
		$req=pg_query($this->conn,$requete);
		
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
		$where=$where?"WHERE $where":null;
		$requete="SELECT $infos FROM {$GLOBALS['config']['dbprefix']}$table $where $options";
		$this->query($requete);
		}

	function update($table,$set,$where)
		{
		$requete="UPDATE {$GLOBALS['config']['dbprefix']}$table SET $set WHERE $where";
		$this->connect();
		$req=pg_send_query($this->conn,$requete);
		$res1 = pg_get_result($this->conn);
		echo pg_result_error($res1);
		$this->disconnect();
//		exit;
		}
	function update2($table,$fields,$ids)
		{
		$this->connect();
		pg_update($this->conn,$table,$fields,$ids);
		$res1 = pg_get_result($this->conn);
		echo pg_result_error($res1);
		$this->disconnect();
		}

	function delete2($table,$field,$ids)
		{
		$ids=join("','",$ids);
		$this->connect();
		pg_send_query($this->conn,"DELETE FROM $table where $field in ('$ids');");
		$this->disconnect();
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
		$requete="INSERT INTO {$GLOBALS['config']['dbprefix']}$table $fields VALUES $values;";
		$this->connect();
		$req=pg_send_query($this->conn,$requete);
		$this->disconnect();
		}
	function insert2($table,$values,$options=null)
		{
		$this->connect();
		if(is_array($values[0]))
		  foreach($values as $elem)
		    pg_insert($this->conn,$table,$elem);
		else
		   pg_insert($this->conn,$table,$values);
		$this->disconnect();
		}
	}
?>