<?php
/**
 * IniParserClass.inc.php
 * 
 * @created on 2011/07/15
 * @package    ActiveIR
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2011/07/15-11:26:16 fabien 
 * 
 *File content
     IniParserClass.inc.php
 *     
 */
  
  
 class IniParserClass {
 	
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
 	 * parse ini file
 	 * @param $ini_file
 	 * @return array set
 	 */
 	
 	public function iniParse($ini_file){
 		
 		if (empty($ini_file)){
 			
 			$this->setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: ini file $ini_file empty or invalid");
 		}
 		
 		if (!file_exists($ini_file)){
 			
 			$msg = $this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: ".$ini_file." file does not exists";
 			$this->setErrMsg($msg);
 		}
 		
 		$ini_array = parse_ini_file($ini_file,true);
 		
 		return $ini_array;
 		
 	}
 	
 	
 	
 	/**
 	 * 
 	 * get from array from ini array
 	 * @param $ini_array
 	 * @param $form_name
 	 * @return $form_array
 	 */
 	public function getFormArray($ini_array, $form_name){
 		
 		if (empty($ini_array))
 			$msg[] = $this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: ini array is empty";
 		
 		if (empty($form_name))
 			$msg[] = $this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form name is empty";
 		
 		if (!is_array($ini_array) || !is_array($ini_array[$form_name]))
 			$msg[] = $this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: ini array or form name $form_name offset is not valid";	
 			
 		if ($msg){
 			$this->setErrMsg($msg);
 		}
 		
 		$separetor = '.';
 		
 		$form_array = array();
 		foreach ($ini_array[$form_name] as $key=>$val){
 			
 			$explode = explode($separetor, $key);
 			
 			$form_array[$explode[0]][$explode[1]] = $val;
 			
 		}
 		
 		return $form_array;
 				
 	} // getFormArray
 	
 	
 	
 	
 	/**
 	 * 
 	 * get array from ini array by given name
 	 * @param $ini_array
 	 * @param $name
 	 * @return $array
 	 */
 	public function getArrayByName($ini_array, $name){
 		
 		if (empty($ini_array))
 			$msg[] = $this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: ini array is empty";
 		
 		if (empty($name))
 			$msg[] = $this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: given name is empty";
 		
 		if (!is_array($ini_array) || !is_array($ini_array[$name]))
 			$msg[] = $this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg:  ini array or given name offset $name is not valid";	
 			
 		if ($msg){
 			$this->setErrMsg($msg);
 		}
 		
 		
 		return $ini_array[$name];
 		
 		
 	}
 	
 	
 	
 	/**
 	 * emplate
 	 * @param $msg
 	 * set error to error t
 	 */
 	private function setErrMsg($msg){
 		
 		$err_class = new ErrorClass();
 		
 		if ($msg){
 			
 			$err_class->setErr($msg,true);
 			return false;
 		} 
 		
 	} // setErrMsg
 	
 	
 	
 } // IniParserClass
 
 
 ?>