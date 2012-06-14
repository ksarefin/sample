<?php
/*
 * Created on 2009/04/22 Tuhin
 *
 * This class used for DataBase connection and exicute query
 * 
 */


class DBBridge
{
	
	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	
	function DBBridge($dbName="", $host="", $port="", $user="", $password=""){
		
		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
		
		AccessTimeCheck( "<font color=#00FF00>new DBBridge</font>" );
		$databaseInfo = @$GLOBALS["gl_databaseInfo"];
		$this->dbName   = strlen($dbName)   ? $dbName   : $databaseInfo["dbName"];
		$this->host     = strlen($host)     ? $host     : $databaseInfo["host"];
		$this->port     = strlen($port)     ? $port     : $databaseInfo["port"];
		$this->user     = strlen($user)     ? $user     : $databaseInfo["user"];
		$this->password = strlen($password) ? $password : $databaseInfo["password"];
		$this->enc = @$GLOBALS["gl_enc"];
	}

	function _link(){
		
		$this->conn = $link = mysql_connect($this->host, $this->user, $this->password) or die ('Could not connect: ' . mysql_error($this->conn));
		$this->selectDB = mysql_select_db($this->dbName, $this->conn) or die('Could not select database');
		
		# Set character_set_results
		  mysql_query("SET character_set_results=utf8", $this->conn);
		
		# Set character_set_client and character_set_connection
		  mysql_query("SET character_set_client=utf8", $this->conn);
		  mysql_query("SET character_set_connection=utf8", $this->conn);
		  
	}
	
	function query($queryStr, $a="____null____", $b="", $c="", $d="", $e="", $f="", $g=""){
		
		$queryStr = !strcmp($a, "____null____") ? $queryStr : sprintf($queryStr, $a, $b, $c, $d, $e, $f, $g);
		AccessTimeCheck( "<font color=#FF0099>".@$this->conn."</font>" );
		if(!@$this->conn && !@$this->selectDB){ 
			$this->_link();
		}
		AccessTimeCheck( "<font color=#FF0099>".$this->conn."</font>" );
		if(@$GLOBALS["gl_debugMode"]["query"]){ 
			print("<p>". nl2br($queryStr). "</p>\n");
		}
		
		@mysql_query('BEGIN', $this->conn);
		
		//print_r($queryStr);

		$resultId = mysql_query($queryStr, $this->conn) ;
		
		if(!$resultId){
			@mysql_query('ROLLBACK', $this->conn);
			die('Query failed: ' .$queryStr." <br> MySql Error:". mysql_errno($this->conn) . ": " . mysql_error($this->conn). "\n");
		}
		
		@mysql_query('COMMIT', $this->conn);
	
		return($resultId);
	}
	
	function post($data, $tabName){
		
		if(empty($data)){
			fatalError("Datas are not found", $this->file_name, __LINE__);
		}
		if(empty($tabName)){
			fatalError("Table $tabName  not fount", $this->file_name, __LINE__);
		}
		
		if($data['id']){
			$id_i = $data['id']; unset($data['id']);
			$this->update($data, $tabName, sprintf("id=%d", $id_i));
			$return = $id_i;
		} else {
			unset($data['id']);
			$return = $this->insert($data, $tabName);
		}
		return($return);
	}

	function insert($data, $tabName){
		
		$keyList = array(); 
		$valueList = array();
		
		while (list($key, $value) = each($data)){
			if(strlen($value)){
				$keyList[] = $key;
				$valueList[] = sprintf("'%s' ", _addslashes($value));
			}
		}
		
		if(!strlen($keyList[0])){
			print "Keys are not found";
		}
		
		$queryStr = sprintf("INSERT INTO %s (%s) VALUES (%s)", $tabName, join(", ", $keyList), join(",", $valueList));
		$this->query($queryStr);
	}
	
	function update($data, $tabName, $whereStr){
		
		if(!strlen($whereStr)){
			fatalError("Where values are not found", $this->file_name, __LINE__);
		}
		if(!strlen($tabName)){
			fatalError("Table $tabName  not fount", $this->file_name, __LINE__);
		}
		
		$setSection = array();
		while (list($key, $value) = each($data))
		{
			if("__null__" == $value){
				if($value == 0){
					$setSection[] = sprintf("%s=0", $key);
					continue;
				}else{
					$setSection[] = sprintf("%s=null", $key);
					continue;
				}
			}
			$setSection[] = sprintf("%s='%s'", $key, _addslashes($value));
		}
		if(!strlen($setSection[0])){
			die("Set values are not found"); 
		}
		
		$queryTxt = sprintf("UPDATE %s SET %s WHERE %s;", $tabName, join(", ", $setSection), $whereStr);
		$this->query($queryTxt);
	}
	
	function last_inserted_id($tabName="table_name"){
		
		if(!strlen($tabName)){
			fatalError("Table $tabName  not fount", $this->file_name, __LINE__);
		}
		
		$queryTxt = sprintf("SELECT id FROM %s ORDER BY id DESC  LIMIT 1 ;", $tabName);
		$temp_id = $this->refer($queryTxt);
		$last_id = $temp_id[0]['id'];
		
		return $last_id;
	}
	
	
	function refer($queryTxt){
		$return = array();
		if(!strlen($queryTxt)){ 
			die("Query string is not found"); 
		}
		
		AccessTimeCheck( "DBBridge::query" );
			$resultId = $this->query($queryTxt);
		AccessTimeCheck( "DBBridge::refer::$queryTxt" );
			$this->hitNum = @mysql_num_rows($resultId);
		AccessTimeCheck( "DBBridge::refer" );
			while ($line = @mysql_fetch_array($resultId, MYSQL_ASSOC)){
				$return[]=$line;
			}
			//$return = mysql_fetch_row($resultId);
		AccessTimeCheck( "DBBridge::pg_fetch_array" );
			@mysql_free_result($resultId);
		AccessTimeCheck( "DBBridge::pg_freeresult" );
		
		
		//mb_convert_variables(TO_ENCODING, FROM_ENCODING, $return);
		
		return($return);
	}

}



?>