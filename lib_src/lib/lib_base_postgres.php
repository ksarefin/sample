<?
// --------------------------------------------------------------------------------
//	クエリビルダー
//	********* 【 class QueryBuilder 】*************************
//				
//
//		コンストラクタ
//			DBBridge($dbName="", $host="", $port="", $user="", $password="")
//				$gl_databaseInfo[dbName, host, port, user, password] をあらかじめセットすること
//			query($queryStr, $a="____null____", $b="", $c="", $d="", $e="", $f="", $g="")

//
//	********* 【 依存関係 】************************************
//				$gl_databaseInfo[dbName, host, port, user, password]
//				_addslashes()
//				ztrim()
//				$gl_enc[internal]
//				(オプション)$gl_debugMode[query]
// --------------------------------------------------------------------------------
if( !@$DBBridgeConnectionResource ){
	$DBBridgeConnectionResource = null;
	$DBBridgeConnectionStatus   = false;
}


function DBBridgeConnection( $query_txt ){
	
	
	global $DBBridgeConnectionStatus,$DBBridgeConnectionResource;
	
	
	if( $DBBridgeConnectionStatus === true ){
		//AccessTimeCheck( "<font color=#FF0099>DBBridgeConnectionResource</font>" );
		return $DBBridgeConnectionResource;
	}
	
	$DBBridgeConnectionStatus = true;
	
	
	
	$DBBridgeConnectionResource = pg_connect($query_txt) or die ('Could not connect DataBase: ' . $query_txt);

	
	return $DBBridgeConnectionResource;
	
	
}

class DBBridge
{
	
	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	
	function DBBridge($dbName="", $host="", $port="", $user="", $password="")
	{
		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
		AccessTimeCheck( "<font color=#00FF00>new DBBridge</font>" );
		$databaseInfo = $GLOBALS["gl_databaseInfo"];
		$this->dbName   = strlen($dbName)   ? $dbName   : $databaseInfo["dbName"];
		$this->host     = strlen($host)     ? $host     : $databaseInfo["host"];
		$this->port     = strlen($port)     ? $port     : $databaseInfo["port"];
		$this->user     = strlen($user)     ? $user     : $databaseInfo["user"];
		$this->password = strlen($password) ? $password : $databaseInfo["password"];
		
		$this->enc = @$GLOBALS["gl_enc"];
	}

	function _link(){
		
		
		global $DBBridgeConnectionStatus,$DBBridgeConnectionResource;
		// いよいよデータベース接続
		$query_txt="";
		$query_txt .= !strlen($this->dbName) 		? "" : sprintf("dbname=%s ", $this->dbName);
		$query_txt .= !strlen($this->host) 			? "" : sprintf("host=%s ", $this->host);
		$query_txt .= !strlen($this->port) 			? "" : sprintf("port=%s ", $this->port);
		$query_txt .= !strlen($this->user) 			? "" : sprintf("user=%s ", $this->user);
		$query_txt .= !strlen($this->password) 	? "" : sprintf("password=%s ", $this->password);
		error_reporting(0);
		AccessTimeCheck( "<font color=red>DBBridge::pg_connect s</font>" );
		
		
		
		
		if( $DBBridgeConnectionStatus == false or !$DBBridgeConnectionResource ){
		
			$this->conn = DBBridgeConnection($query_txt);
			
			
			
			
			AccessTimeCheck( "<font color=red>DBBridge::pg_connect e</font>" );
			error_reporting(7);
			
			if($this->conn){
				/*if("SJIS" == $this->enc[internal]){
					pg_exec($this->conn, "set client_encoding to 'SJIS'");
				}elseif("EUC" == $this->enc[internal]){
					pg_exec($this->conn, "set client_encoding to 'EUC_JP'");
				}else{
					fatalError("gl_enc[internal] に文字コード('EUC' or 'SJIS')をセットしましょう", $this->file_name, __LINE__);
				}*/
				
				pg_set_client_encoding($this->conn, "UTF-8");
				
				return;
			}
			
			
		}else{
			
			$this->conn = $DBBridgeConnectionResource;
			return;
			
		}
		
		// 接続できなかった時は，fatalError しないで，あえてメッセージのみ表示して終了
		die("現在データベースのメンテナンス中です\n５分ほど待ってリロードしてください\n");
	}
	
	
	
	function query($queryStr, $a="____null____", $b="", $c="", $d="", $e="", $f="", $g="")
	{
		$queryStr = !strcmp($a, "____null____") ? $queryStr : sprintf($queryStr, $a, $b, $c, $d, $e, $f, $g);
		
		AccessTimeCheck( "<font color=#FF0099>".$this->conn."</font>" );
		if(!$this->conn){ // 接続してなかったら接続
			$this->_link();
		}
		
		
		AccessTimeCheck( "<font color=#FF0099>".$this->conn."</font>" );
		if($GLOBALS["gl_debugMode"]["query"]){ // デバッグモード
			print("<p>". nl2br($queryStr). "</p>\n");
		}

		//print "<br><br><br><br>";
		//print_r($queryStr);exit;

		$queryId = pg_exec($this->conn, $queryStr);
		
		//print $queryId; 
		//print "<br><br><br><br>";
		

		if(!$queryId){
			$tmpStr = pg_errormessage($this->conn);
			fatalError("クエリーミスです\n$queryStr\n$tmpStr", $this->file_name, __LINE__);
		}
		return($queryId);
	}

	function post($data, $tabName){
		// エラーチェック
		if(empty($data)){
			fatalError("データがセットされていません", $this->file_name, __LINE__);
		}
		if(empty($tabName)){
			fatalError("\$tabName がセットされていません", $this->file_name, __LINE__);
		}
		// モード($query_mode)を決定する
		// $query_mode, $unique_key, $data[$unique_key]
		if($data[id]){
			$id = $data[id]; unset($data[id]);
			$this->update($data, $tabName, sprintf("id=%d", $id));
			$return = $id;
		} else {
			unset($data[id]);
			$return = $this->insert($data, $tabName);
			$tmp = $this->refer(sprintf("select currval('%s_id_seq'::text)", $tabName));
			$return = $tmp[0][currval];
		}
		return($return);
	}

	function insert($data, $tabName)
	{
		$keyList = array(); $valueList = array();
		while (list($key, $value) = each($data))
		{
			if(strlen($value)){

				$keyList[] = $key;
				$valueList[] = sprintf("'%s'", _addslashes($value));
			}
		}
		if(!strlen($keyList[0])){
			print '入力データが空です';
		}
		$queryStr = sprintf("insert into %s(%s) values(%s); %s",
			$tabName, join(",", $keyList), join(",", $valueList), $add_query);
		$this->query($queryStr);
	}

	function update($data, $tabName, $whereStr)
	{
		if(!strlen($whereStr)){
			fatalError("どこの行を更新するのか不明です", $this->file_name, __LINE__);
		}
		if(!strlen($tabName)){
			fatalError("テーブルが不明です", $this->file_name, __LINE__);
		}
		// $setSection, を求める
		$setSection = array();
		while (list($key, $value) = each($data))
		{
//			if(!strlen($value)){
//				continue;
//			}
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
			die("更新データが空です"); // todo
		}
		// 最終的なクエリーを求める
		$queryTxt = sprintf("update %s set %s where %s;", $tabName, join(",", $setSection), $whereStr);
		
		//print "<br><br>";
		//print_r($queryTxt);
		//print "<br><br>";
		
		$this->query($queryTxt);
	}
	
	
	
	
	
	
	// クエリを引数として結果をHASHの配列として返す
	// ヒット数は $this->hitNum に格納
//	function refer($queryTxt, $nextId=0, $maxRows=200){
	function refer($queryTxt, $nextId=0, $maxRows=200000000){
		
		
		if(!strlen($queryTxt)){ // エラーチェック
			die("クエリーがセットされていません"); // todo
		}
		
		
		AccessTimeCheck( "DBBridge::query" );
			$resultId = $this->query($queryTxt); // getAll は、データを全部用意するので遅そうだから使わない
		
		
		AccessTimeCheck( "DBBridge::refer::$queryTxt" );
			$this->hitNum = pg_numrows($resultId);

			
		AccessTimeCheck( "DBBridge::refer" );
			//for($i=$nextId; $i < min($this->hitNum, $nextId + $maxRows); ++$i){
			//	$return[] = pg_fetch_array($resultId, $i);
			//}
			$return = pg_fetch_all($resultId);
	
		mb_convert_variables(TO_ENCODING, FROM_ENCODING, $return);
			
		/*
		while ( $row = @pg_fetch_array($resultId,PGSQL_BOTH)){
			$return[] = $row; 
		}*/
		
		AccessTimeCheck( "DBBridge::pg_fetch_array" );
			pg_freeresult($resultId);
		AccessTimeCheck( "DBBridge::pg_freeresult" );
			return($return);
	}
	
	function returnDbId(){
		if(!$this->conn){ // 接続してなかったら接続
			$this->_link();
		}
		return $this->conn;
	}
}
?>
