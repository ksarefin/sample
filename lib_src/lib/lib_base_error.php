<?
//	---------------------------------------------------------------------------
//	エラークラス
//	********* 【 class FError 】********************************
//				プログラムのバグやDBアクセス不能などのシステム上のエラーで，
//				本来はあってはならないエラー(致命的エラー)
//				処理
//					エラーのメッセージを表示してすぐに exit
//	********* 【 class UError 】********************************
//				ユーザの入力ミスや，操作ミスを扱う
//				処理
//					1. エラーの内容を$gl_error に格納
//					2. $gl_error->sw でユーザエラーを検知
//					3. $gl_error->show() でエラーを表示
//					4. 操作をミスしたユーザにretry させる
// ---------------------------------------------------------------------------

// ********* 【 FError 】**************************************
//	☆準備
//			php.ini で，
//				register_globals = On  を設定すること (詳しくはOSのインストール担当に聞くこと)
//			$gl_debugMode が定義されている時はデバッグモード
//	☆使い方
//			丁寧に使う方法
//					$fatal = new FError($this->file_name, __LINE__);
//					$fatal->watch("id_i", $id_i);
//					$fatal->stop("メッセージ");
//			簡単に使う方法(一行だけ)
//					fatalError("メッセージ", $this->file_name, __LINE__)
class FError{
	// 相手の環境
	var $remote_addr;
	var $remote_port;
	var $user_agent;
	// 送信内容
	var $referer;
	var $server_port;
	var $host;
	var $request_uri;
	var $request_method;
	var $post_vars;
	var $post_list;
	// こちらの情報
	var $script_filename;
	var $position;
	var $date_str;
	var $msg;
	
	// 内部変数
	var $watchList; // "var", "val" の連想配列の配列
	var $watch_serial=0;
	var $protocol;
	var $super_mail;
	var $basePath;
	var $date_i; // UNIX_TIME
	var $debugSw;
	
	/**
 	 * file name instance
 	 */
 	protected $file_name;
	
	function FError($file, $line){
		// 相手の環境
		$this->remote_addr = $GLOBALS[REMOTE_ADDR];
		$this->remote_port = $GLOBALS[REMOTE_PORT];
		$this->user_agent = $GLOBALS[HTTP_USER_AGENT];
		// 送信内容
		$this->referer = $GLOBALS[HTTP_REFERER];
		$this->server_port = $GLOBALS[SERVER_PORT];
		$this->host = $GLOBALS[HTTP_HOST];
		$this->request_uri = $GLOBALS[REQUEST_URI];
		$this->request_method = $GLOBALS[REQUEST_METHOD];
		$this->post_vars = $GLOBALS[HTTP_POST_VARS];
		// こちらの情報
		$this->script_filename = $GLOBALS[SCRIPT_FILENAME];
		$this->position = sprintf("%s:%s", $file, $line);
		$this->date_str = date("d/"). substr(date("F"), 0, 3). date("/Y:H:i:s");
		// 内部変数
		$this->superMail = $GLOBALS[gl_superMail];
		$this->basePath = $GLOBALS[gl_basePath];
		$this->debugSw = $GLOBALS[gl_debugSw];
		
		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
	}
	
	// watch変数 の登録
	function watch($varName, $value){
		$this->watchList[$this->watch_serial++] = array("varName" => $varName, "value" => $value);
	}
	
	// メールで知らせる
	function send(){
		unset($out_txt);
		$out_txt .= sprintf("%s\n\n\n", $this->msg);
		$out_txt .= "********* 【 デバッグ情報 】********************************\n";
		$out_txt .= sprintf("%s\n", $this->date_str);
		$out_txt .= sprintf("*ソース*\n%s\n", $this->script_filename);
		$out_txt .= sprintf("*位置*\n%s\n", $this->position);
		for($i=0; $this->watchList[$i]; ++$i){
			$out_txt .= '$'. sprintf("%s=%s\n", $this->watchList[$i][varName], $this->watchList[$i][value]);
		}
		$out_txt .= "********* 【 相手の環境 】**********************************\n";
		$out_txt .= sprintf("*REMOTE*\n%s:%d\n*AGENT*\n%s\n", $this->remote_addr, $this->remote_port, $this->user_agent);
		
		$out_txt .= "********* 【 送信内容 】************************************\n";
		$out_txt .= sprintf("*REFERER*\n%s\n", $this->referer);
		$out_txt .= "*REQUEST*\n";
		switch($this->server_port){
			case 80: // http
				$out_txt .= sprintf("http://%s%s\n", $this->host, $this->request_uri);
				break;
			case 443: // https
				$out_txt .= sprintf("https://%s%s\n", $this->host, $this->request_uri);
				break;
			default: // http
				$out_txt .= sprintf("http://%s:%d%s\n", $this->host, $this->server_port, $this->request_uri);
				break;
		}
		$out_txt .= sprintf("*METHOD*\n%s\n", $this->request_method);
		if("POST" == $this->request_method){
			$out_txt .= "☆送信データ\n";
			$this->parse_post_vars($this->post_vars);
			$out_txt .= join("\n", $this->post_list);
		}
		// メール出力
		$this->date_i=time();
		$subject = sprintf("[%d]%s", $this->date_i, $this->host);
		if($this->debugSw){
			print nl2br($out_txt);
		} else {
//			print nl2br($out_txt);
//			mail($this->superMail, $subject, $out_txt);
		}
	}
	
	function stop($msg){
		$this->msg = $msg;
		$this->send(); // メール
		if(!$this->debugSw){
//			$this->location(); // 飛ばす
			1;
		}
		print("<html><body>");
		print "<br><br>".$msg."<br><br>";
		printf("<div>エラーが発生しました</div>");
		printf("<div><a href=%s>戻る</a></div>", $this->basePath);
		print("</body></html>\n");
		exit(1);
	}
	
	// post で送信したデータを再帰的に解析する
	function parse_post_vars($hash, $base=""){
		while (list($key, $value) = each($hash)){
			$varName = isNull($base) ? $key : sprintf("%s[%s]", $base, $key);
			switch(gettype($value)){
				case "array":
					$this->parse_post_vars($value, $varName);
					break;
				default:
					$this->post_list[] = sprintf("$%s=%s", $varName, $value);
			}
		}
	}
}

// すぐに終了させるためのラッパ
function fatalError($msg, $file, $line){
	
	$fatal = new FError($file, $line);
	$fatal->stop($msg);
}



// ********* 【 UError 】**************************************
// 使い方
//		error_push($msg, $code_txt);  でエラーを格納して
//		$gl_error->sw でエラーを検知
//		$gl_error->show() でエラーの内容を表示
class UError{
	var $data; // エラーメッセージデータ
	var $sw;		// エラーが格納されているかどうかのフラッグ
	var $code_txt; // エラーコードを格納
	
	function push($msg, $code_txt=""){
		if("" == $msg){
			fatalError("警告メッセージが格納されておりません", $this->file_name, __LINE__);
		}
		$this->data = $msg;
		$this->code = $code_txt;
		$this->sw = 1;
		return(1);
	}
	
	function show(){
		if($this->sw){
			print $this->data;
		}
		return(1);
	}

	function word(){
	  if($this->sw){
		$out=$this->data;
	  }
	  return $out;
	}
}

$gl_error = new UError;

function errorPush($msg, $code_txt=""){
	global $gl_error;
	$gl_error->push($msg, $code_txt);
}
function ehe($str="here",$name=""){
  if(is_array($str)){
  	print "<hr>";
	print "array";
  	print "<pre>";
	print $name."=";
	print_r($str);
  	print "</pre>";
	print "<hr>";
  }elseif(is_object($str)){
  	print "<hr>";
	print "object";
  	print "<pre>";
	print $name."=";
	print_r($str);
  	print "</pre>";
	print "<hr>";
  }
  else{
	print "<table border=3><tr><td>";
	print $name.'='.$str;
	print "</table>\n";
  }
}



?>
