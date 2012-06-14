<?php
/**
 * ajaxControllerClass.php
 * 
 * @created on 2012/02/09
 * @package    FORM
 * @subpackage 
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/02/09 - 10:55:24 fabien 
 * 
 *File content
     ajaxControllerClass.php
 *     
 */
 
 
 class ajaxControllerClass extends Configuration{
 
 	
 	/**
  	 * common access for this moduel
  	 */
 	public function commonAction(){
 		
 		
 		
 		
 	} // commonAction
 	
 	
 	
 	/**
 	 * value change action controller
 	 */
  	public function changeValueAction(){
    	
  		/**
  		 * get field id
  		 */
    	$field = $this->getUrlParam('field');
    	
    	/**
    	 * get field value
    	 */
    	//$value = urldecode($this->getUrlParam('value'));
    	$value	= $_POST['value'];
    	
    	/**
    	 * get check type
    	 */
    	//$checkType = $this->getUrlParam('checkType');
    	$checkType = $_POST['checkType'];
    	
    	/**
    	 * change as check type
    	 */
    	switch ($checkType){
    		
    		case '2':
    				$convert = 'zenkaku';
    			break;

    		case '3':
    				$convert = 'zenkaku_kana';
    			break;
    			
    		case '4':
    		case '5':	
    				$convert = 'hannkaku';
    			break;
    			
    	} // switch ($checkType){
    	
    	/**
    	 * for set entries like address, post
    	 */
    	preg_match('/text_[0-9]/', $field, $match);
    	if (empty($checkType) && empty($match))
    		$convert = 'hannkaku';    	
    	
    	/**
    	 * for name entry
    	 */
    	if (preg_match('/name_[0-9]_[0-9]\b/', $field))
    		$convert = 'zenkaku';
    	
    	/**
    	 * for name kana entry
    	 */
    	if (preg_match('/name_[0-9]_kana_[0-9]\b/', $field))
    		$convert = 'kana_name';
    	
    	
    	$changeed_value = "";
    	switch ($convert){
    		
    		case 'zenkaku':
    				$changeed_value =  mb_convert_kana($value, "K", 'utf-8');
	    		break;
	    	
	    	case 'zenkaku_kana':
    				$changeed_value =  mb_convert_kana($value, "KV", 'utf-8');
    			break;
    		
	    	case 'hannkaku':					
    				$changeed_value =  mb_convert_kana($value, "anrsV", 'utf-8');
    			break;
    		
    	}
    	
    	
    	if ($changeed_value)
    		echo $changeed_value;
    	else
    		echo $value;
    		
    	exit;
    	
    } // changedvalueAction
 
 
 
 } // ajaxControllerClass
 
 
 ?>