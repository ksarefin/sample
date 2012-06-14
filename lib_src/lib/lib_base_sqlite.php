<?php
/*
 * Created on 2009/04/22 Tuhin
 *
 * This class used for DataBase connection and exicute query
 * 
 */


include_once("lib_base.php");


class DBBridge
{
	
 	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	
 	
	function DBBridge($dbName='cms_test.sqlite'){
		
		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
		$databaseInfo = @$GLOBALS["gl_databaseInfo"];
		$this->dbName   = strlen($dbName)   ? $dbName   : $databaseInfo["dbName"];
		$this->enc = @$GLOBALS["gl_enc"];
	}
	
	
	function _link(){
		$cms_dir = realpath(dirname($this->file_name.'/../../../'));
		$this->conn = sqlite_open($cms_dir.'/db/'.$this->dbName);
		if(!$this->conn){
			die ('Could not connect: ' . sqlite_error_string($this->conn));
		}
		
		
	}
	
	function query($queryStr, $a="____null____", $b="", $c="", $d="", $e="", $f="", $g=""){
		
		$queryStr = !strcmp($a, "____null____") ? $queryStr : sprintf($queryStr, $a, $b, $c, $d, $e, $f, $g);
		
		if(!$this->conn){
			$this->_link();
		}
		
		if(@$GLOBALS["gl_debugMode"]["query"]){ 
			print("<p>". nl2br($queryStr). "</p>\n");
		}
		
		@sqlite_query ($this->conn, 'BEGIN');
		
		//print_r($queryStr);
		
		$resultID = sqlite_query($this->conn, $queryStr) ;
		
		if(!$resultID){
			@sqlite_query('ROLLBACK', $this->conn);
			die('Query failed: ' .$queryStr."\n");
		}
		
		@sqlite_query('COMMIT', $this->conn);
	
		return($resultID);
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
		
		$keyList = array(); $valueList = array();
		
		while (list($key, $value) = each($data))
		{	
		
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
		
		$resultID = $this->query($queryTxt);
		
		$this->hitNum = @sqlite_num_rows($resultID);
		
		while ($line = @sqlite_fetch_array($resultID, SQLITE_ASSOC)){
			$return[]=$line;
		}
		
		return($return);
	}

}



?>
