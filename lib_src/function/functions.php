<?php
/**
 * functions.php
 * 
 * @created on 2011/07/20
 * @package    ActiveIR
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2011/07/20-15:28:32 fabien 
 * 
 *File content
     functions.php
 *     
 */

	
   
	/**
	 * html code filter
	 * @param string
	 * @return filterd code
	 */
	function h( $str ) {
		if ( !isset($str) || $str == "" ) {
			return;
		}
		return htmlspecialchars($str, ENT_QUOTES);
	}
	
	
	
	
	/**
	 * html code filter from array data
	 * @param $data
	 * @param $ignore_keys 
	 * @return filtered array
	 */
	function h_array($data, $ignore_keys = NULL) {
		 
		if ( is_array($data) ){
			foreach( $data as $key => $val ) {
				
				/**
				 * ignor html filter for ignors key
				 */	
				if ( in_array($key, (array)$ignore_keys, TRUE) ) {
					continue;
				}
				
				
				/**
				 * html filter of array data
				 */
				if ( is_array($val) ) {

					$data[$key] = h_array($data[$key], $ignore_keys);
				} else {
					
					$data[$key] = h($val);
				}
			}
			
			
		} else {
			
			/**
			 * when data is not array
			 */
			$data = h($data);
		}
		
		return $data;
	}
	
	
	/**
	 * short an array
	 * @param $array
	 * @param $on
	 * @param $order
	 * @return shorted array
	 */
	function array_sort($array, $on, $order=SORT_ASC){
			
	    $new_array = array();
	    $sortable_array = array();
	
	    if (count($array) > 0) {
	        foreach ($array as $k => $v) {
	            if (is_array($v)) {
	                foreach ($v as $k2 => $v2) {
	                    if ($k2 == $on) {
	                        $sortable_array[$k] = $v2;
	                    }
	                }
	            } else {
	                $sortable_array[$k] = $v;
	            }
	        }
	
	        switch ($order) {
	            case SORT_ASC:
	                asort($sortable_array);
	            break;
	            case SORT_DESC:
	                arsort($sortable_array);
	            break;
	        }
	
	        foreach ($sortable_array as $k => $v) {
	            $new_array[$k] = $array[$k];
	        }
	    }
	
	    return $new_array;
	    
	} // array_sort

	
	
	/**
	 * SJIS to UTF8 convertion
	 * @param string
	 * @return converted string
	 */
	function sjis2utf8( $str ) {
		if ( empty($str) ) {
			return;
		}
		if ( !is_array($str) ) {
			return mb_convert_encoding($str, 'UTF-8', 'SJIS-win');
		} else {
			mb_convert_variables(mb_internal_encoding(), 'SJIS-win', $str);
			return $str;
		}
	}
	
	
	
	
	
	/**
	 * zenkaku to hankaku convertion
	 * @param string
	 * @return hankaku string
	 */
	function zen2han( $str ) {
		if ( empty($str) ) {
			return;
		}
		return mb_convert_kana( $str, "kas" );
	}
	
	
	
	
	
	/**
	 * hankaku to zenkaku convertion
	 * @param string
	 * @return zenkaku string
	 */
	function han2zen( $str ) {
		if ( empty($str) ) {
			return;
		}
		return mb_convert_kana( $str, "KASV" );
	}

	
	
	
	/**
	 * Mail address check
	 * @param mail address 
	 * @return if real mail address return true
	 *         else return false
	*/
	function check_email_address($email) {
    	// First, we check that there's one @ symbol, and that the lengths are right
    	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
        	// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        	return false;
    	}
    
    	// Split it into sections to make life easier
    	$email_array = explode("@", $email);
    	$local_array = explode(".", $email_array[0]);
    	for ($i = 0; $i < sizeof($local_array); $i++) {
        	 if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
            	return false;
        	}
    	}    
    
    	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
        	$domain_array = explode(".", $email_array[1]);
        	if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
        	}
        	
        	for ($i = 0; $i < sizeof($domain_array); $i++) {
            	if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
                	return false;
            	}
        	}
    	}
    	return true;
 	}
 	
 	
 	
 	
 	
 	/**
	 * URL check
	 * @param url
	 * @return if url real domain return true
	 *         else return false
	*/
 	function is_valid_url ( $url )
	{
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
	}
	
	
	
	
	/**
	 * Random generator
	 * @param password_length
	 * @return generated password
	 */
	function random_generator($length){
		$randPass= "";
		if($length){
			$keys = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
			for($i = 0; $i < $length; $i ++) {
	  			$randPass .= $keys[rand(0, strlen($keys))];
			}
		}
		
		return $randPass;
	}
	
	
	
	
	
	/**
	 * Read csv file 
	 * @param file data, split_flag
	 * @return Returns array of csv datas
	 */
	function csv_read ($fileLineList, $split_flag = FALSE ) {
		$csv_file = $fileLineList;
		$str_flag = TRUE;
		$cnt = 0;
		
		// parsing file data
		for( $i = 0; $csv_file[$i]; $i++ ) {
			$cnt = $cnt + substr_count($csv_file[$i],"\"");
			if( (($cnt%2) == 0 || $cnt == 0) && $str_flag ) {
				$line_str[] = $csv_file[$i];
			} else {
				$str_flag   = FALSE;
				$temp_str[] = $csv_file[$i];
				if( ($cnt%2) == 0 ) {
					$line_str[] = join("",$temp_str);
					unset($temp_str);
					$str_flag   = TRUE;
				}
			}
		}
		
		// parsing line data
		for( $i = 0; $line_str[$i]; $i++ ) {
			if ( empty($line_str[$i]) ) continue;
			
			// replace newline and car.return to newline	
			if(ereg("^([,]+(\x0D\x0A|\x0D|\x0A)|(\x0D\x0A|\x0D|\x0A))$",$line_str[$i])){$line_str[$i] = "\n";}
	
			$temp_line_str = split("\"",$line_str[$i]);
			$cnt = count($temp_line_str);
			for( $p = 0; $p < $cnt; $p++ ) {
				if( $p%2 != 0 ) {
					// replace come to html char
					$temp_line_str[$p] = preg_replace("/,/","&#44;",$temp_line_str[$p]);
				}
			}
			
			// make line dara
			$line_str[$i] = join("\"",$temp_line_str);
			// make array and convert encoding to utf-8
			$split_line = split(",",mb_convert_encoding(@$line_str[$i],"UTF-8","Shift-JIS"));
			$cnt = count($split_line);
			
			// replace special char,newline and car.return to empty
			for( $p = 0; $cnt > $p; $p++ ) {
				$split_line[$p]=preg_replace("/^[\"]/","",$split_line[$p]);
				if( !$split_line[$p+1] ) {$split_line[$p]=preg_replace("/(\x0D\x0A|\x0D|\x0A)$/","",$split_line[$p]);}
				$split_line[$p]=preg_replace("/[\"]$/","",$split_line[$p]);
			}
					
			if( $split_flag ) {
				// make array of line data
				$split_data[] = $split_line;
			} else {
				// make same as line data
				$tmp_line_str[] = join(",",$split_line);
			}
			unset($split_line);
		}
		
		// again replace special char to quoted and Commas  	
		if( $split_flag ) {
			for( $i = 0; $split_data[$i]; $i++ ) {
				$cnt = count($split_data[$i]);
					
				for( $p=0; $p < $cnt; $p++ ) {
					$split_data[$i][$p] = preg_replace("/&#44;/",",",$split_data[$i][$p]);
					$split_data[$i][$p] = preg_replace("/\x22\x22/","\x22",$split_data[$i][$p]);
				}
			}
			// array of csv
			return $split_data;
		} else {
			for( $i = 0; $tmp_line_str[$i]; $i++ ) {
				for( $p = 0; $tmp_line_str[$i][$p]; $p++ ) {
					$tmp_line_str[$i][$p] = preg_replace("/&#44;/",",",$tmp_line_str[$i][$p]);
					$tmp_line_str[$i][$p] = preg_replace("/\x22\x22/","\x22",$tmp_line_str[$i][$p]);
				}
			}
			// line array of csv
			return $tmp_line_str;
		}
	}
	
	
	
	
	
	  
    /**
	 * Make id
	 * @param int id
	 * return  id
	 */
    function make_id($id) {
    	// make url_id
    	if($id){
    		
    		for ($i=0; $i<=4;$i++){

    			$first_rand .= rand(1, 9);
    			$last_rand	.= rand(1, 9);
    		}
    			
    		$url_id = $first_rand.$id.$last_rand;
    	
    		return $url_id;
    	}else{
    		return false;
    	}
    	
    }
    
    
    
    
    
    /**
	 * Get id
	 * @param url id
	 * return id
	 */
    function get_id($url_id) {
    	// search id in substring
    	if($url_id){
    		$removed_frist_part = substr($url_id,5);
    		$id = substr($removed_frist_part,0,-5);
    		
    		return $id;
    	}else{
    		return false;
    	}
    }
    
    
    
	
	
    // Check data is 0 or not; if value 0 return 1 otherwise return 0
	function isZero($text){
		return(
			("0" == sprintf("%s", $text)) ? 1 : 0
		);
	}
	
	
	
	
	// Check data is null or not; return true if null otherwise return true
	function isNull($text){
		return(!strlen($text));
	}

	
	
	
	
	/**
	 * Check data or array is null or not 
	 * @param input
	 * @return true if null otherwise return flase
	 */ 
	function isNN($in){
		
	  if(is_array($in)){
	  	
		return (count($in)>0);
		
	  }else{
	  	
		return (sprintf("%d",$in)>0);
		
	  }
	  
	} // isNN
	
	
	
	
	/**
	 * Remove full size or the half size blank space
	 * @param $intput
	 * @return
	 */ 
	function _ztrim($input){
		
		$input = trim($input);
		$input = ereg_replace("^( |　)+", "", $input);
		$input = ereg_replace("( |　)+$", "", $input);
		
		return $input;
		
	} // _ztrim
	
	
	
	
	/** 
	 * trim zenkaku/hankaku blank space
	 * @param $input
	 * @return ztrimed value
	 */
	function ztrim($input){
		
		if(is_array($input)){

			while (list($key, $value) = each($input)){
				$input[$key] = _ztrim($value);
			}
			reset($input);
			
		} else {
			
			$input = _ztrim($input);
			
		}
		
		return($input);
		
		
	} // ztrim

	
	
	
	/** 
    * data trim function
    * @param data
    * @return trim data
    */
	function trims($pds){
		
		if(is_array($pds)){

			while (list($key, $value) = each($pds)){
				$results[$key] = trims($value);
			}
			
		}elseif(isset($pds)){
			
			$results = trim($pds);
			
		}
		
		return($results);
		
	} // trims
	
	
	
	

	/**
	 * Remove full size or the half size blank of before and after
	 * @param $input
	 * @return trimed vlaule
	 */
	function _trims($input){
		
		$input = trim($input);
		$input = ereg_replace("^( |　)+", "", $input);
		$input = ereg_replace("( |　)+$", "", $input);
		
		return $input;
		
	} // _trims

	
	
	
	
	/**
	 * Arrange by keyword
	 */ 
	function keySplit($searchStr){
		
		$searchStr = ereg_replace("　", " ", $searchStr);
		$searchStr = trim($searchStr);
		$searchList = split(" +", $searchStr);
		
		return($searchList);
		
	} // keySplit
	
	
	
	function fc( $source, $target ) {
		if ( is_dir( $source ) ) {
			@mkdir( $target );
			$d = dir( $source );
			while ( FALSE !== ( $entry = $d->read() ) ) {
				if ( $entry == '.' || $entry == '..' ) {
					continue;
				}
				$Entry = $source . '/' . $entry; 
				if ( is_dir( $Entry ) ) {
					fc( $Entry, $target . '/' . $entry );
					continue;
				}
				copy( $Entry, $target . '/' . $entry );
			}
	 
			$d->close();
		}else {
			copy( $source, $target );
		}
	}
	
	function full_del( $source) {
		if ( is_dir( $source ) ) {
			$d = dir( $source );
			while ( FALSE !== ( $entry = $d->read() ) ) {
				if ( $entry == '.' || $entry == '..' ) {
					continue;
				}
				$Entry = $source . '/' . $entry; 
				if ( is_dir( $Entry ) ) {
					full_del( $Entry );
					continue;
				}
				
				unlink( $Entry);
			}
	 
			$d->close();
		}else {
			unlink( $source );
		}
	}
	
	
	
	
	/**
	 * add slashe to string
	 * @param $text
	 * @return slash added string
	 */
	function _addslashes($text){
		
		return(addslashes($text));
		
	} // _addslashes


	

	/**
 	 * 
 	 * set error to error template
 	 * @param $msg
 	 */
	function setErrMsg($msg){
 		
 		$err_class = new ErrorClass();
 		
 		if ($msg){
 			
 			$err_class->setErr($msg,true);
 			return false;
 		}
 	} // setErrMsg
 	
 	
 	
 	
 	/**
 	 * calculate string
 	 * @param $mathString
 	 * @return calculated value
 	 */
 	function calc_string( $mathString ){	
 		
 		$cf_DoCalc = create_function("", "return (" . $mathString . ");" );		
 		
 		return $cf_DoCalc();
 	
 	} // calc_string
 	
 	
 	
 	
 	/**
  	 * url request function so that can get html source
   	 * @param  $url
  	 * @param  $method
  	 * @param  $posts
  	 * @return html source
     */
 	function request($url, $method="GET", $posts=array()){
	
		/**
	 	 * parse given url
	 	 */
 		$urls = parse_url($url);
		//print_r(parse_url($url));
	
	
	
		/**
	 	　* make headers with give url and parameters
	 	　*/
		$request  = sprintf("%s %s%s HTTP/1.0\r\n", $method, @$urls['path'], strlen(@$urls['query']) ? sprintf("?%s", @$urls['query']) : "");
		$request .= sprintf("Host: %s\r\n", $urls['host']);
		$request .= sprintf("User-Agent: %s\r\n", $_SERVER['HTTP_USER_AGENT']);
	
	
	
		/**
	 	　* for post method
	 	　*/
		if($method == "POST"){
		
		
			/**
		 	　* simplification post datas that can make query string
		 	　*/
			while(list($name, $value) = each($posts)){
				$postdatas[] = sprintf("%s=%s", $name, urlencode($value));
			}
			
			if (is_array($postdatas))
				$postdata = join("&", $postdatas);
			else
				$postdata = $postdatas;
		
		
			/**
		 　	　* make header with post datas
		 	　*/
			$request .= sprintf("Content-Type: application/x-www-form-urlencoded\r\n");
			$request .= sprintf("Content-Length: %d\r\n", strlen($postdata));
			$request .= sprintf("\r\n");
			$request .= sprintf("%s", $postdata);
		
		}else{
		
			$request .= sprintf("\r\n");
		
		}
	
	
	
		/**
	 　	　* 
	 	　* remote file socket open for supplied url
	 	　* then make a request to that server
	 	　* cullect response until end of file
	 	　* 
	 	　*/
		$fp = @$urls['scheme']=="https" ? fsockopen(sprintf("ssl://%s", @$urls['host']), 443) : fsockopen(@$urls['host'], 80);
		fputs($fp, $request);
		while(!feof($fp)){
			@$response .= @fgets($fp);
		}
		fclose($fp);
	
	
	
		/**
	 	　* split response data as newline, tab
	 	　* first element of split data is header
	 	　* and the second is html source here as body
	 	　*/
		$datas = split("\r\n\r\n", $response, 2);
		$header = $datas[0];
		$body   = $datas[1];
	
	
		/**
	 	　* return the html source
	 	　*/
		return($body);
	
	}//request
	
	
	
	
	/**
	 * Send Mail
	 * @param mail from 
	 * @param mail subject
	 * @param mail body
	 * @param mail to
	*/
	function send_mail($from, $subject, $body, $to){
		
		$header_info  = sprintf("From: %s<%s>",mb_encode_mimeheader($from,"ISO-2022-JP"),$from);
		$header_info .= "\nContent-Type: text/plain;charset=ISO-2022-JP\nX-Mailer: PHP/".phpversion();
		//$subject = mb_convert_encoding($subject,'ISO-2022-JP','UTF-8');;
		$body = mb_convert_encoding($body,'ISO-2022-JP','UTF-8');
		
		// メール送信
		@mb_send_mail($to, $subject, $body, $header_info);

	} // send_mail
	
	
	
	/**
	 * Mail address check
	 * @param mail address 
	 * @return if real mail address return true
	 *         else return false
	*/
	function check_email($email) {
    	// First, we check that there's one @ symbol, and that the lengths are right
    	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
        	// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        	return false;
    	}
    
    	// Split it into sections to make life easier
    	$email_array = explode("@", $email);
    	$local_array = explode(".", $email_array[0]);
    	for ($i = 0; $i < sizeof($local_array); $i++) {
        	 if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
            	return false;
        	}
    	}    
    
    	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
        	$domain_array = explode(".", $email_array[1]);
        	if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
        	}
        	
        	for ($i = 0; $i < sizeof($domain_array); $i++) {
            	if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
                	return false;
            	}
        	}
    	}
    	return true;
    	
 	} // check_email
 	
 	
 	
 	/**
	 * URL check
	 * @param url
	 * @return if url real domain return true
	 *         else return false
	*/
 	function check_url ( $url )
	{
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
		
	} // check_url
	
	
	
	
	/**
	 * check uploaded file and save 
	 * @param $field
	 * @param $file_types
	 * @param $category
	 * @return new file name
	 */
	function file_upload($field, $file_types, $category) {
   		
		if(!empty($field)) {
			
			$filename = basename($_FILES[$field]['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1);
			
			// file upload to server
			if(in_array($ext, $file_types)) {
				
				$upload_dir = UPLOAD.'/'.$category.'/';
				
				if (!is_dir($upload_dir)){
					mkdir($upload_dir, 0777, true);
  					chmod($upload_dir, 0777);
				}
				
				
				/**
				 * uploaded file save
				 */
				$new_file = time()."_".$field.".".$ext;
				$newname  = $upload_dir."/".$new_file;
		       
		        if(move_uploaded_file($_FILES[$field]['tmp_name'],$newname)) {
		        	return $new_file;
				}					
		        
			} // if(in_array($ext, $types)) {
			
		} //if(!empty($field)) {
		
	} // file_upload
	
 
 
 
 
 ?>