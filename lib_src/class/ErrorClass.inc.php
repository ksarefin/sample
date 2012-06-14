<?php
/**
 * ErrorClass.inc.php
 * 
 * @created on 2011/06/09
 * @package    
 * @subpackage 
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2011/06/09-16:24:35 fabien 
 * 
 *File content
     ErrorClass.inc.php
 *     
 */
  
  
  class ErrorClass{
  	
  	/**
  	 * error message instant
  	 */
  	protected $err_msg;
  	
  	
  	/**
  	 * 
  	 * set error message
  	 * @param $err_name
  	 * @param $err_msg
  	 */
  	public function setErr($err_msg, $err_template = true){
  		
  		$smarty = new Smarty();
  		$smarty->assign('err',$err_msg);
  		
  		if ($err_template == true){
  			
  			$template_path = HOME_DIR."/layout/error.tpl";
  			//print $template_path;
			$smarty->display($template_path);
			exit;
  		}
  		
  		
  		
  		
  		//$this->_stack($err_msg, $err_name);
        //return $this; 		
  		
  	}
  	
  	
    
    /**
     * 
     * make error message stack
     * @param $err_name
     * @param $err_msg
     */
    private function _stack($err_msg, $err_name=null)
    {
        if (empty($err_name))
        	$this->err_msg[] = $err_msg;
        else 
    		$this->err_msg[$err_name] = $err_msg;
    		
        return $this;
    }
    
  	
  	
  	
  	/**
  	 * 
  	 * return error message 
  	 */
  	public function getErr(){
  		
  		return $this->err_msg;
  		
  	}
  	
  	
  	
  	/**
  	 * check for error 
  	 */
  	public function hasError(){
  		
        $count = count($this->err_msg);
        return ($count > 0) ? true : false;
        
    }
  	
  	
  	
  	
  }
 
 ?>