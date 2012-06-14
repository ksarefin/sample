<?php
/**
 * LoginClass.inc.php
 * 
 * @created on 2011/06/21
 * @package    FORM
 * @subpackage Login
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2011/06/21-15:41:52 fabien 
 * 
 *File content
     LoginClass.inc.php
 *     
 */
  
 
 /**
  * 
  * login class
  * use for set login information,
  * get login information,
  * check login
  * 
  */
 class LoginClass extends BaseClass{
 	
 	
 	/**
 	 * function set login information
 	 * @param $name
 	 * @param $value
 	 */
 	public function setLogin($name, $value, $memorise = null){
 		
 		//print_r($name);exit;
 		
 		
 		if (empty($memorise)){
	 		
 			$_SESSION[$name] = $value;
 		
 		}else {
 			
 			setcookie($name, join('::', $value), time()+60*60*24*365, '/'); 
 		}
 		
 	}
 	
 	
 	/**
 	 * function get login information
 	 * @param $name
 	 * return login info
 	 */
 	public function getLoginInfo($name){
 		
 		
 		//print_r($_COOKIE);
 		
 		if (@$_COOKIE[$name]){
 			
 			$explode = explode('::', $_COOKIE[$name]);
 			
 			$return = array(
	 			'id' 			=> $explode[0],
	 			'name' 			=> $explode[1],
	 			'pass' 			=> $explode[2],
	 			'type' 			=> @$explode[3],
	 		);
 			
 			
 		}else {
 			
 			$return = $_SESSION[$name];
 		}
 		
 		//print_r($return);exit;
 		
 		return $return;
 		
 	}
 	
 	
 	/**
 	 * check whether login information have or not
 	 * @param $name
 	 * @param $module_name
 	 * @param $params
 	 * if not login info 
 	 */
 	public function checkLogin($name, $module_name = null, $params = null){
 		
 		$module_name = $module_name ? $module_name : 'top';
 		
 		$url_array = array($module_name ,'login');
 		if (is_array($params))
 			$url_array = array_merge($url_array, $params);
 		$page = $this->makeUrl($url_array);
 		
 		$login_check = $_SESSION[$name] ? $_SESSION[$name] : $_COOKIE[$name];
 		
 		if (empty($login_check)){

 			//print_r($page);
 			$this->redirect($page);
 		}
 		
 	}
 	
 	
 	/**
 	 * remove login infomation from session
 	 * @param $name
 	 */
 	public function setLogout($name){
 		
 		if (empty($name)) return false;
 		
 		
 		unset($_SESSION[$name]);
 		
 		setcookie($name, '', time()+60*60*24*365, '/'); 
 	}
 	
 	
 	
 }  

 
 
 
 
 
 
 
 
 
 ?>