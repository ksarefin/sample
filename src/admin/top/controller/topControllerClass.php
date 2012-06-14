<?php
/**
 * topControllerClass.php
 * 
 * @created on 2011/08/01
 * @package    WPCMS
 * @subpackage Admin
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2011/08/01 - 11:17:19 fabien 
 * 
 *File content
     topControllerClass.php
 *     
 */
 
 
 class topControllerClass extends Configuration{
 
 	
 	/**
 	 * embdjp instance
 	 */
 	protected $wpcms;
 	
 	/**
 	 * data handler for this module
 	 */
 	protected $db_model;
 	
 	/**
 	 * rss parser instance
 	 */
 	protected $rss_parser;
 	
 	/**
 	 * data class instance
 	 */
 	protected $data_class;
 	
 	/**
 	 * api domain url instance
 	 */
 	protected $api_domain;
 	
 	/**
 	 * current update version instance
 	 */
 	protected $current_version;
 	
 	
  	/**
  	 * common access for this moduel
  	 */
  	public function commonAction(){

		/**
 		 * embdjp class object
 		 */
 		$this->wpcms = new WpCms();
 		
 		/**
 		 * database model object
 		 */
 		$this->db_model = new  topModelClass();
 		
 		/**
 		 * data class object
 		 */
 		$this->data_class = new DataClass();
 		
 		/**
 		 * rss parser object
 		 */
 		$this->rss_parser = new RssParserClass();
 		
 		/**
 		 * assign api domain url
 		 */
 		$this->api_domain = 'http://kiwamiapp.com';
 		
 		/**
 		 * get office code from admin login info 
 		 */
 		$admin_info = $this->login_class->getLoginInfo($this->access_name);
 		
 		/**
 		 * assign version to view
 		 */
 		$this->viewAssign('version', C_VERSION);
 		
 		/**
 		 * get current version and assign to view
 		 */
 		$version_url = $this->api_domain.'/wpform/version';
 		$this->current_version = file_get_contents($version_url);
 		
 		if (C_VERSION != $this->current_version)
 			$this->viewAssign('current_vresion', $this->current_version);
 		
  	} // commonAction
  	
  	
  	
  	/**
  	 * index action control
  	 */
  	public function indexAction(){
  		
  		/**
  		 * login check
  		 */
  		$this->login_class->checkLogin($this->access_name);
  		
  		
  		/**
  		 * get notice rss list
  		 */
  		$this->rss_parser->load($this->api_domain.'/wpform/wpnotice/rss');
  		$getrss =   $this->rss_parser->getRSS();
	 	$getarray = $getrss["rss"]["channel"];
	 	$items = $this->rss_parser->getItems();
	 	
	 	$tmp = array();
	 	$notice_list = array();
	 	
	 	for($i=0;$i<5;$i++){
	 		foreach($getarray['item:'.$i] as $key=>$value){
	 			$tmp[$key] = $value;
	 			$tmp['label_name'] = $this->data_class->getLabelName($value['lable']);
	 		}
	 		$notice_list[] = $tmp; 
	 	}
  		
	 	/**
	 	 * view assign notice list
	 	 */
	 	$this->viewAssign('list', $notice_list);
  		
  		
  		/**
  		 * view assign page title 
  		 */
  		$this->viewAssign('page_title', "ダッシュボード");
  		
  		
  		$this->setDisplay('index');
  		
  	} // indexAction
  	
  	
  	
  	/**
  	 * login action control
  	 */
  	public function loginAction(){
  		
  		$this->setDisplay('login',false);
  	
  	} //loginAction
  	
  	
  	
  	/**
  	 * login confirm action control
  	 */
  	public function loginConfAction(){
  		
  		/**
  		 * get post data
  		 */
  		$post = $this->getPost();
  		
  		if (empty($post['name'])){
  			$msg[] = "Please enter user name";
  		}
  		
  		if (empty($post['pass'])){
  			$msg[] = "Please enter pass";
  		}
  		
  		/**
  		 * get admin information 
  		 * and then get office name
  		 */
  		$result = $this->db_model->userCheck($post);
  		
  		
  		if (empty($result)){
  			
  			$msg[] = "ログインが正しくありません。";
  			$msg[] = "ユーザ名またはパスワードを確認してください。";
  			
 		}
  		
  		if ($msg){
  			
  			$this->viewAssign('err',$msg);
  			$this->setDisplay('login', false);
  			
  		}else{
  			
  			$this->login_class->setLogin($this->access_name, $result, $post['memorise']);
  			
  			$val_array = array('');
  			$url = $this->makeUrl($val_array);
  			$this->redirect($url);
  			
  		} // if ($msg){
  		
  	} // loginConfAction
  	
  	
  	
  	/**
  	 * logout action controller
  	 */
  	public function logoutAction(){
  		
  		$id = $this->login_class->setLogout($this->access_name);
  		
  		$val_array = array('');
  		$url = $this->makeUrl($val_array);
  		$this->redirect($url);
  		
  	} // logoutAction
  	
  	
  	
  	/**
  	 * password change action
  	 */
  	public function passChangeAction(){
  		
  		/**
  		 * get admin id
  		 */
  		$url_id   = $this->getUrlParam('admin_id');
  		$admin_id = get_id($url_id);
  		
  		/**
  		 * assign to view
  		 */
  		$this->viewAssign('admin_id', $admin_id);
  		
  		
  		/**
  		 * get admin info
  		 */
  		$admin_info = $this->wpcms->getAdminInfo($admin_id);
  		
  		
  		
  		/**
  		 * assign to view
  		 */
  		$this->viewAssign('pd', $admin_info);
  		$this->viewAssign('page_title', 'パスワード');
  		
  		$this->setDisplay('form');
  		
  	} // passChangeAction
  	
  	
  	
  	/**
  	 * password save action
  	 */
  	public function saveAction(){
  		
  		/**
  		 * get admin id
  		 */
  		$url_id = $this->getUrlParam('admin_id');
  		$admin_id = get_id($url_id);
  		
  		
  		/**
  		 * get post
  		 */
  		$post = $this->getPost();
  		
  		
  		if (empty($post['pass'])){
  			
  			$err_msg[] = "パスワード入れてください";
  		}
  		
  		
  		if ($err_msg){
  			
  			/**
  			 * assign to view
  			 */
  			$this->viewAssign('err', $err_msg);
  			
  			
  			$this->setDisplay('form');
  		
  		}else {
  			
  			
  			/**
  			 * update admin_user table
  			 */
  			$this->wpcms->updatePass($post['pass'], $admin_id);
  			
  			
  			/**
  			 * redirect to top
  			 */
  			$this->redirect(ADMIN_TOP);
  			
  			
  		} // if ($err_msg){
   		
  	} // saveAction
  	
  	
  	
  	/**
  	 * update action controller
  	 */
  	public function updateAction(){
  		
  		/**
  		 * check serial number and domain
  		 */
  		$hs		= str_replace('www.', '', $_SERVER['HTTP_HOST']);
  		$serial	= $GLOBALS['server_info']['serialNum']; 
  		$request_url = $this->api_domain.'/wpform/update/domainCheck/domain/'.$hs.'/serial/'.$serial;
  		
		$method	= 'POST';
		$domain	= request($request_url,$method);
  		
		
  		if ($domain == $hs){
  			$this->updateCheck('0');		
  		}else{
  			
  			echo "You can't update"; exit;
  			$val_array = array('');
	  		$url = $this->makeUrl($val_array);
	  		$this->redirect($url);
  		}
  		
  		
  	} // updateAction
  	
  	
  	
  	/**
  	 * check update
  	 * @param $index 
  	 */
  	private function updateCheck($index){
  		
  		$request_url = $this->api_domain.'/wpform/update/updateCheck/index/'.make_id($index);
  		//print $request_url."<br>";
  		
		$method		 = 'POST';
		$get_update	 = request($request_url,$method);
		//print $get_update;
		
		if ($get_update == 'update_finish'){
			
			$version_content = "<?php define('C_VERSION', '$this->current_version'); ?>";
			$version_path = BASE_DIR.CONFIG.VERSION;
			
			$fp = fopen($version_path, 'w');
			fwrite($fp, $version_content);
			fclose($fp);
			
			$val_array = array('');
	  		$url = $this->makeUrl($val_array);
	  		$this->redirect($url);
	  		
		}else{ 
			$this->updateFile($get_update, $index);
		}					
  		
  	} // updateCheck
  	
  	
  	/**
  	 * update file
  	 * @param $file_path
  	 */
  	private function updateFile($file_path, $index){
  		
  		$request_url 	= $this->api_domain.'/wpform/update/updateFile/file/'.str_replace('/', ';', $file_path).'php';
  		//print $request_url."<br>";
  		
		$method		  	= 'POST';
		$file_content	= request($request_url,$method);
		
		if (!empty($file_content)){
			
			$up_file = BASE_DIR.'/'.$file_path;
			
			$fp = fopen($up_file, 'w');
			
			if (is_writable($up_file))
				fwrite($fp, $file_content);
				
			fclose($fp);			
		
		} // if (!empty($file_content)){
		
		$this->updateCheck($index+1);
		
  	} // updateFile

  	
 
 } // topControllerClass
 
 
 ?>