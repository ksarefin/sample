<?php
/**
 * ErrorClass.inc.php
 * 
 * @created on 2011/06/09
 * @package FORM   
 * @author  Arefin Tuhin
 * @version SVN: Id: profile 2692 2011/06/09-16:24:35 fabien 
 * 
 *File content
     ErrorClass.inc.php
 *     
 */
  
  
 class ErrorCheckClass{
  	
  	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	
 	/**
 	 * contruct method
 	 */
 	function __construct(){
 		
 		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
 		
 	} // __construct
 	
 	
 	
 	/**
 	 * error check of enty from
 	 * @param $form_array
 	 * @param $post
 	 * @return error msg list
 	 */
 	public function formErrorCheck($form_array, $post){
 		
 		/*print_r($form_array);
 		print "<br><br>";
 		print_r($post);exit;*/
 		
 		
 		$err_msg = array(
 			'text' 		=> "を入力してください。",
 			'textarea'	=> "を入力してください。",
 			'options'	=> "を入力してください。",
 			'select'	=> "を選択してください。",
 			'checkbox'	=> "を選択してください。",
 			'radio'		=> "を選択してください。",
 			'image'		=> "を選択してください。",
 			'pdf'		=> "を選択してください。",
 			'ynradio'	=> "を選択してください。",
 		);
 		
 		$msg = array();
 		$form_set_entry_array = array('name', 'mail', 'address', 'birthday', 'tel', 'password');
 		
 		
 		foreach ($form_array as $key => $val){
 			
 			if (preg_match('/privacy/', $key)) continue;
 			
 			if (preg_match('/password_/', $key)){
 				
 				if (!empty($post[$key.'_pass']) && empty($post[$key.'_pass_conf'])){
 					$msg[$key] = "確認パスワード入力ください。";
 				}elseif ($post[$key.'_pass'] != $post[$key.'_pass_conf']){
 					$msg[$key] = $val['label']."と確認パスワードを同じでわありません。";
 				}
 					
 			}
 			
 			if ($val['required'] == 1){
 				//print $key."<br>";
 				//print_r($val);print "<br>";
 				
 				/**
 				 * check for image file upload
 				 */
 				/*if (preg_match('/image_[0-9]/', $key)){
 					
 					$image_msg = $this->imageCheck($post, $key, $val);
		 				
		 			if (!empty($image_msg))
		 				$msg = array_merge($msg, $image_msg);
	
		 			$post[$key] = 'Error Checked';
		 				
 				} */// if (preg_match('/image_[0-9]/', $key)){
 				
 				
 				/**
 				 * check for image file upload
 				 */
 				/*if (preg_match('/pdf_[0-9]/', $key)){
 					
 					$pdf_msg = $this->pdfCheck($post, $key, $val);
		 				
		 			if (!empty($pdf_msg))
		 				$msg = array_merge($msg, $pdf_msg);
	
		 			$post[$key] = 'Error Checked';
		 				
 				} */// if (preg_match('/pdf_[0-9]/', $key)){
 				
 				
 				/**
 				 * check set entry error
 				 */
 				$key_expl = explode('_', $key);
 				$set_key  = $key_expl[0];
 				if (in_array($set_key, $form_set_entry_array)){
 					
 					if (preg_match('/\b'.$set_key.'_[0-9]\b/', $key)){
 						
 						$chekc_function = $set_key.'Check';
	 				
		 				$set_msg = $this->$chekc_function($post, $key, $val);
		 				
		 				if (!empty($set_msg))
		 					$msg = array_merge($msg, $set_msg);
	
		 				$post[$key] = 'Error Checked';
		 				
		 			} // if (preg_match('/\bname_[0-9]\b/', $key)){
 					
 				} // if (in_array($key_expl[0], $form_set_entry_array)){
 				
 				
 				/**
 				 * check for empty value
 				 */
	 			if ( empty($post[$key])){
 					
 					$msg[$key] = $val['label'].$err_msg[$val['type']];
 				}
 				
 				/**
 				 * search text check type for text fields
 				 */
 				if (!empty($val['txt_check'])){
 					
 					$check_msg = $this->textCheck($post[$key], $key, $val, $val['txt_check']);
 					if (!empty($check_msg))
		 					$msg = array_merge($msg, $check_msg);
 				
 				} // if (!empty($val['txt_check'])){
 				
 				
 				/**
 				 * check for array values
 				 */
 				if (is_array($post[$key])){
 					
 					foreach ($post[$key] as $row){
 						
 						if (empty($row)){
 							$error = true;
 						}else{ 	
 							$error = false;
 							break;
 						}
 						
 					} // foreach ($post[$key] as $row){
 					
 					
 					/**
 					 * if empty set error message
 					 * else check for other field val
 					 */
 					if ($error === true){
 						$msg[$key] = $val['label'].$err_msg[$val['type']];
 					}
 					
 					
 					/**
			 		 * text check for other fields
			 		 */
 					if ($post[$key]['other']){
 						
			 			$other_expl = explode('::', $val['other']);
			 			if (!empty($other_expl[2])){

			 				$check_msg = $this->textCheck($post[$key]['other'], $key, $val, $other_expl[2]);
			 				if (!empty($check_msg))
				 				$msg = array_merge($msg, $check_msg);
				 					
			 			} // if (!empty($other_expl[2])){
 							
 					} // if ($post[$key]['other']){
 					
 					
 				} // if (is_array($post[$key])){
 			
 			} // if ($val['required'] == 1){
 			
 				
 			if ($post[$key] && $val['check']){
 					
 				$check_function = $val['check'].Chk;
 				$check = $this->$check_function($post[$key]);
 				
 				if ($check == false){
 					
 					$msg[$key] = $err_msg[$val['check']];
 				}
 				
 			} // if ($post[$key] && $val['check']){
 			
 		} // foreach ($form_array as $key => $val){
 		
 		//print_r($msg);exit;
 		
 		return $msg;
 		
 	} // formErrorCheck
 	
 	
 	/**
 	 * image entry error check
 	 * @param $post
 	 * @param $key
 	 * @param $val
 	 * @ if error return message
 	 */
 	/*public function imageCheck($post, $key, $val){
 		
 		if (empty($post[$key])){
 			
 			$image_type = explode('::', $val['options']);
	 		//print_r($_FILES);
	 		$filename = basename($_FILES[$key]['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1);
	
			if(empty($filename)){
				$msg[$key] = $val['label']."を選択してください。";
			}elseif(!in_array($ext, $image_type)){
				$msg[$key] = $val['label']."は「".$val['options']."」形式のファイルをアップロードしてください。";
			}
	 			
	 	} // pdfCheck	
 		
 		if ($msg)
 			return $msg;
 	 		
 	}*/ // imageCheck
 	
 	
 	
 	
 	
 	/**
 	 * pdf entry error check
 	 * @param $post
 	 * @param $key
 	 * @param $val
 	 * @ if error return message
 	 */
 	/*public function pdfCheck($key, $val){
 		
 		if (empty($post[$key])){
 			
	 		$filename = basename($_FILES[$key]['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1);
				    
	 		if(empty($filename)){
				$msg[$key] = $val['label']."を選択してください。";
			}elseif($ext != 'pdf'){
				$msg[$key] =  $val['label']."は「pdf」形式のファイルをアップロードしてください。";
			}
		 	
 		} // if (empty($post[$key])){
 		
 		if ($msg)
	 			return $msg;
 	 		
 	}*/ // pdfCheck
 	
 	
 	/**
 	 * check input value
 	 * @param $post_value
 	 * @param $key
 	 * @param $val
 	 * @param $checkType
 	 * @return if error return message
 	 */
 	public function textCheck($post_value, $key, $val, $checkType) {
 		
 		
 		switch ($checkType){
 			
 			case '2':
 				
		 		 if (preg_match("/(?:\xEF\xBD[\xA1-\xBF]|\xEF\xBE[\x80-\x9F])|[\x20-\x7E]/", $post_value))
				 	$msg[$key] = $val['label'].'を全角のみ入力してください。';
				 	
 				break;
 				
 			case '3':
 				
			 		if (!mb_ereg("^[ア-ン]+$", $post_value))
				    	$msg[$key] = $val['label'].'を全角カナのみ入力してください。';
				    
 				break;
 				
 			case '4':
 				
 					if (!mb_ereg("^[0-9]+$", $post_value))
				    	$msg[$key] = $val['label'].'を半角英数字のみ入力してください。';
				    	
 				break;
 				
 			case '5':
 				
 					if (!mb_ereg("^[0-9]|[０-９]+$", $post_value))
				    	$msg[$key] = $val['label'].'を半角数字のみ入力してください。';
				    					
 				break;
 		
 		} // switch ($checkType){
 		
 		if ($msg)
 			return $msg;
 		
 	} // textCheck
 	
 	
 	
 	/**
 	 * name entry error check
 	 * @param $post
 	 * @param $key
 	 * @param $val
 	 * @return if error return message
 	 */
 	public function nameCheck($post, $key, $val){
 		
 		foreach ($post as $p_key=>$p_val){
 			
 			if (preg_match('/\bname_[0-9]/', $p_key)){
 				
 				if (empty($post[$p_key])){
	 				
 					if (preg_match('/_kana_/', $p_key))
	 					$msg[$key.'_kana'] = $val['field_labels2'].'を入力してください。';
	 				else
	 					$msg[$key] = $val['field_labels1'].'を入力してください。';
	 				
 				} // if (empty($post[$p_key])){
 				
	 		} // if (preg_match('/\bname_[0-9]/', $key)){
	 		
 		} // foreach ($post as $key=>$val){
 		
 		if ($msg)
 			return $msg;
 	 		
 	} // nameCheck
 	
 	
 	
 	/**
 	 * mail entry error check
 	 * @param $post
 	 * @param $key
 	 * @param $val
 	 * @return if error return message
 	 */
 	public function mailCheck($post, $key, $val){
 		
 		foreach ($post as $p_key=>$p_val){
 			
 			if (preg_match('/\bmail_[0-9]/', $p_key)){
 				
 				$mail_check = $this->emailChk($post[$key.'_mail']);
 				
 				if (empty($post[$p_key])){
	 				$msg[$key] = $val['label'].'を入力してください。';
	 			}elseif ($post[$key.'_mail'] != $post[$key.'_mail_conf']){
	 				$msg[$key] = 'メールアドレスと確認メールアドレス同じにしてください。';
	 			}elseif ($mail_check === false){
	 				$msg[$key] = 'メールアドレスの形式が正しくありません。';
	 			}
	 			
	 		} // if (preg_match('/\bname_[0-9]/', $key)){
	 		
 		} // foreach ($post as $key=>$val){
 		
 		if ($msg)
 			return $msg;
 	 		
 	} // mailCheck
 	
 	
 	
 	
 	/**
 	 * address entry error check
 	 * @param $post
 	 * @param $key
 	 * @param $val
 	 * @return if error return message
 	 */
 	public function addressCheck($post, $key, $val){
 		
 		foreach ($post as $p_key=>$p_val){
 			
 			if (preg_match('/\baddress_[0-9]/', $p_key)){
 				
 				if (empty($post[$key.'_pcode_1']) || empty($post[$key.'_pcode_2']))
	 				$msg[$key.'_pcode'] = $val['field_labels1'].'を入力してください。';
		 		elseif (!is_numeric($post[$key.'_pcode_1']) || !is_numeric($post[$key.'_pcode_2']))
		 			$msg[$key.'_pcode'] = $val['field_labels1'].'を半角数字入力してください。';
		 		
		 		
		 		if (empty($post[$key.'_pref']))
		 			$msg[$key.'_pref'] = $val['field_labels2'].'を選択してください。';
	 			
		 		if (empty($post[$key.'_address_a']))
		 			$msg[$key.'_address_a'] = $val['field_labels3'].'を入力してください。';	
	 			
	 		} // if (preg_match('/\bname_[0-9]/', $key)){
	 		
 		} // foreach ($post as $key=>$val){
 		
 		if ($msg)
 			return $msg;
 	 		
 	} // addressCheck
 	
 	
 	
 	/**
 	 * birthday set entry error check
 	 * @param $post
 	 * @param $key
 	 * @param $val
 	 * @return if error return message
 	 */
 	public function birthdayCheck($post, $key, $val){
 		
 		foreach ($post as $p_key=>$p_val){
 			
 			if (preg_match('/\bbirthday_[0-9]/', $p_key)){
 				
 				if (empty($post[$key.'_year']) || empty($post[$key.'_month']) || empty($post[$key.'_day']))
	 				$msg[$key] = $val['label'].'を入力してください。';
		 		elseif (!is_numeric($post[$key.'_year']) || !is_numeric($post[$key.'_month']) || !is_numeric($post[$key.'_day']))
		 			$msg[$key] = $val['label'].'を半角数字入力してください。';
 				
	 		} // if (preg_match('/\bname_[0-9]/', $key)){
	 		
 		} // foreach ($post as $key=>$val){
 		
 		if ($msg)
 			return $msg;
 	 		
 	} // birthdayCheck
 	
 	
 	
 	
 	/**
 	 * tel set entry error check
 	 * @param $post
 	 * @param $key
 	 * @param $val
 	 * @return if error return message
 	 */
 	public function telCheck($post, $key, $val){
 		
 		foreach ($post as $p_key=>$p_val){
 			
 			if (preg_match('/\btel_[0-9]/', $p_key)){
 				
 				if (empty($post[$key.'_1']) || empty($post[$key.'_2']) || empty($post[$key.'_3']))
	 				$msg[$key] = $val['label'].'を入力してください。';
		 		elseif (!is_numeric($post[$key.'_1']) || !is_numeric($post[$key.'_2']) || !is_numeric($post[$key.'_3']))
		 			$msg[$key] = $val['label'].'を半角数字入力してください。';
 				
	 		} // if (preg_match('/\bname_[0-9]/', $key)){
	 		
 		} // foreach ($post as $key=>$val){
 		
 		if ($msg)
 			return $msg;
 	 		
 	} // telCheck
 	
 	
 	
 	/**
 	 * password set entry error check
 	 * @param $post
 	 * @param $key
 	 * @param $val
 	 * @return if error return message
 	 */
 	public function passwordCheck($post, $key, $val){
 		
 		foreach ($post as $p_key=>$p_val){
 			
 			if (preg_match('/\bpassword_[0-9]/', $p_key)){
 				
 				if (empty($post[$key.'_pass']) || empty($post[$key.'_pass_conf']))
	 				$msg[$key] = $val['label'].'を入力してください。';
	 			elseif ($post[$key.'_pass'] != $post[$key.'_pass_conf'])
	 				$msg[$key] = 'パスワードと確認パスワード同じにしてください。';
		 		elseif (strlen($post[$key.'_pass']) < $val['minlength'] || strlen($post[$key.'_pass_conf']) > $val['maxlength'])
		 			$msg[$key] = $val['label'].'は「'.$val['minlength'].'~'.$val['maxlength'].'」文字まで入力してください';
 				
	 		} // if (preg_match('/\bname_[0-9]/', $key)){
	 		
 		} // foreach ($post as $key=>$val){
 		
 		if ($msg)
 			return $msg;
 	 		
 	} // passwordCheck
 	
 	
 	
 	/**
	 * URL check
	 * @param url
	 * @return if url real domain return true
	 *         else return false
	 */
 	public function urlChk ( $url ){
 		
		$url = @parse_url($url);

		if ( ! $url) {
			return false;
		}

		$url = array_map('trim', $url);
		$url['port'] = (!isset($url['port'])) ? 80 : (int)$url['port'];
		$path = (isset($url['path'])) ? $url['path'] : '';

		if ($path == '')
		{
			$path = '/';
		}

		$path .= ( isset ( $url['query'] ) ) ? "?$url[query]" : '';

		if ( isset ( $url['host'] ) AND $url['host'] != gethostbyname ( $url['host'] ) )
		{
			if ( PHP_VERSION >= 5 )
			{
				$headers = get_headers("$url[scheme]://$url[host]:$url[port]$path");
			}
			else
			{
				$fp = fsockopen($url['host'], $url['port'], $errno, $errstr, 30);

				if ( ! $fp )
				{
					return false;
				}
				fputs($fp, "HEAD $path HTTP/1.1\r\nHost: $url[host]\r\n\r\n");
				$headers = fread ( $fp, 128 );
				fclose ( $fp );
			}
			$headers = ( is_array ( $headers ) ) ? implode ( "\n", $headers ) : $headers;
			return ( bool ) preg_match ( '#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers );
		}
		return false;
	
	} // urlChk
	
 	
 	
 	
	
	/**
	 * email address check
	 * @param mail address 
	 * @return if real mail address return true
	 *         else return false
	*/
	function emailChk($email) {
		
    	/**
    	 * first check that there's one @ symbol, and that the lengths are right
    	 */ 
    	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
        	/**
        	 * Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        	 */ 
        	return false;
    	}
    
    	
    	/**
    	 * Split it into sections to make life easier
    	 */
    	$email_array = explode("@", $email);
    	$local_array = explode(".", $email_array[0]);
    	for ($i = 0; $i < sizeof($local_array); $i++) {
        	 if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
            	return false;
        	}
    	}    
    
    	
    	/**
    	 * Check if domain is IP. If not, it should be valid domain name
    	 */
    	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { 
        	$domain_array = explode(".", $email_array[1]);
        	if (sizeof($domain_array) < 2) {
        		/**
        		 * Not enough parts to domain
        		 */
                return false;  
        	}
        	
        	for ($i = 0; $i < sizeof($domain_array); $i++) {
            	if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
                	return false;
            	}
        	}
    	}
    	
    
      return true;
    	
 	} // emailChk
 	
  	
 } // ErrorClassClass
  
  

?>