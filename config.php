<?php
/**
 * config.php
 * 
 * @created on 2012/03/22
 * @package    VoiceLink
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2012/03/22-16:46:45 fabien 
 * 
 *File content
     config.php
 *     
 */



 /**
  * configuration class 
  */

 class Configuration extends BaseClass {
 	
 	/**
 	 * splite datas instance 
 	 */
 	protected $splite_datas;
 	
 	/**
 	 * module name instance
 	 */
 	protected $module_name;

 	/**
 	 * action name instance
 	 */
 	protected $action_name;
 	
 	/**
 	 * parameters array instance 
 	 */
 	protected $params_array;
 	
 	/**
 	 * error class instance
 	 */
 	protected  $err_class;
 	
 	/**
 	 * login class instance
 	 */
 	protected $login_class;
 	
 	/**
 	 * post data instance
 	 */
 	protected $post;
 	
 	/**
 	 * smarty instance
 	 */
 	protected $smarty;
 	
 	/**
 	 * admin information instance
 	 */
 	protected $admin_info;
 	
 	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	/**
 	 * ini host instance
 	 */
 	protected $host;
 	
 	/**
 	 * ini domain insatance
 	 */
 	protected $domain;
 	
 	/**
 	 * ini cms path instance
 	 */
 	protected $cms_path;
 	
 	
 	
 	/**
 	 * class constructor
 	 */
 	function __construct(){
 		
 		/**
 		 * set host name
 		 * set domain name
 		 * set cms path
 		 */
 		$this->host 	= $GLOBALS['server_info']['host'];
 		$this->domain 	= $GLOBALS['server_info']['domain'];
 		$this->cms_path	= $GLOBALS['server_info']['cms_path'];
 		
 		/**
 		 * get url splite datas
 		 */
 		$_split_datas = $this->splitData();
 		$this->splite_datas = $_split_datas;
 		
 		/**
 		 * get module name
 		 */
 		$_module_name = $this->moduleName();
 		$this->module_name = $_module_name;
 		$this->viewAssign('module', $this->module_name);
 		
 		
 		/**
 		 * get action name
 		 */
 		$_action_name = $this->actionName();
 		$this->action_name = $_action_name;
 		$this->viewAssign('action', $this->action_name);
 		
 		/**
 		 * get url params
 		 */
 		$_params_array = $this->setUrlParam();
 		$this->params_array = $_params_array;
 		
 		
 		/**
 		 * assign self url and access name from base class
 		 */
 		parent::__construct();
 		$this->viewAssign('self', $this->self_url);
 		$this->viewAssign('access_name', '/'.$this->access_name);
 		
 		
 		/**
 		 * error calss object
 		 */
 		$this->err_class = new ErrorClass();
 		
 		/**
 		 * login class object and get admin information
 		 */
 		$this->login_class = new LoginClass();
 		$this->admin_info = $this->login_class->getLoginInfo($this->access_name);
 		$this->viewAssign('admin_info', $this->admin_info);
 		
 		/**
 		 * smarty object
 		 */
 		global $smarty;
 		$this->smarty = $smarty; 
 		
 		/**
 		 * access post
 		 */
 		$this->setPost();
 		
 		/**
	 	 * set file name
	 	 */
	 	$path = pathinfo(__FILE__);
	 	$this->file_name = $path['filename'];
	 	
 		
 	} // __construct
 	
 	
 	/**
 	 * set splitData
 	 */
 	
 	protected function splitData(){
 		
 		/**
 		 * split server request uri that we can get
 		 * module name, action and others so that
 		 * we can control our program 
 		 */
 		$datas = explode( "/", substr($_SERVER["REQUEST_URI"], 1) );
 		
 		/**
  		 * unset empty array
  		 */
 		foreach ( $datas as $key){
 			if(empty($datas[$key])) unset($datas[$key]);
 		}
 
 		/**
  		 * if access for admin then split data will shift by one element that 
  		 * web and admin does the same work
  		 */
 		if($datas[0] == 'admin' || $datas[0] == 'settings' || $datas[0] == 'site_admin'){

 			if(@$datas[1]){
 		
 				array_shift($datas);
 		
 			}else {
 		
 				unset($datas);
 		
 			}
 		}
 		
 		return @$datas;
 		
 	}
 	
 	
 	/**
 	 * set module name
 	 */
 	
 	public function moduleName(){
 		
 		
 		/**
  		 * 
  		 * frist split data is for module
  		 * if there is no module it will go top module
  		 * 
  		 */
 
 		$module = $this->splite_datas[0] ?  $this->splite_datas[0] : 'top';
 		
 		return $module;
 		
 	}
 	
 	/**
 	 * set action name
 	 */
 	
 	public function actionName(){
 		
 		/**
  		 * second split data is for action
  		 * if there is no action it will go index action
  		 */
  
 		$action = $this->splite_datas[1] ? $this->splite_datas[1] : 'index';
 		
 		return $action;
 
 		
 	}
 	
 	
 	/**
 	 * set parameter and associate value 
 	 */
 	
 	public function setUrlParam(){
 		
 		/**
 		 * temp parameters array
 		 */
 		
 		$params = array();
 		
 		 /**
  		  * 
  		  * after frist and second splite value
  		  * it will goes for parameters with there value
  		  * if exist parameter and if not exist value it will be an error
  		  * 
  		 */
 		
 		for ($i=2; $i<=(count($this->splite_datas)-1); $i++){
 			
 			$key   = trim($this->splite_datas[$i]);
 			$value = trim($this->splite_datas[$i+1]);
 			
 			$params[$key] = $value;
 			
 			$i++;
 		}
 
 		return $params;
 		
 	}
 	
 	
 	/**
 	 * 
 	 * call for get parameter value
 	 * @param char $param
 	 * 
 	 */
 	
 	public function getUrlParam($param){
 		
 		/**
 		 * check the parameter
 		 */
 		if (empty($param))
 			setErrMsg($this->file_name." Line : ".__LINE__."<br />  Method: ".__METHOD__." Msg: param name is empty");
 		
 		return $this->params_array[$param];
 		
 	}
 	

 	
 	/**
 	 * set post data to post instance
 	 */
 	public function setPost(){
 		
 		if (isset($_POST['pd'])){
 			
 			$this->post = $_POST['pd'];
 		}
 		
 	}
 	
  
 	/**
 	 * get form submited post value
 	 */
 	public function getPost(){
 		
 		if (isset($this->post)){
 			
 			return $this->post;
 		}
 					
 	}
 	
 	
 	/**
 	 * remove post data from post instance
 	 */
 	 public function removePost(){
 	 	
 	 	if (!empty($this->post)){
 	 		
 	 		$this->post = "";
 	 	}
 	 		
 	 }
 	 
 	
 	
 	/**
 	 * get post parameter value
 	 * @param paramater name
 	 * @return post value
 	 */
 	public function getParam($name){
 		
 		if ($this->post){
 			
 			if (isset($this->post[$name]))
 				return $this->post[$name];
 			else 
 				return false;
 			
 		}
 	}
 	
 	
 	
 	
 } // Configuration

 
?>