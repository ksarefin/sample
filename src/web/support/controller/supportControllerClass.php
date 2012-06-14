<?php
/**
 * supportControllerClass.php
 * 
 * @created on 2012/04/06
 * @package    FORM
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/04/06 - 16:15:49 fabien 
 * 
 *File content
     supportControllerClass.php
 *     
 */
 
 
 class supportControllerClass extends Configuration{

 	/**
 	 * wpcms class instance
 	 */
 	protected $wpcms;
 	
 	/**
 	 * model class instance
 	 */
 	protected $db_model;
 	
 	/**
 	 * login class instance
 	 */
 	protected $login_class;
 	
 	/**
 	 * login name insatance
 	 */
 	protected $login_name;
 	
 	/**
 	 * type instance
 	 */
 	protected $type;
 	
 	/**
 	 * domain inatance
 	 */
 	protected $domain;
 	
 	
 	
 	/**
  	 * common access for this moduel
  	 */
 	public function commonAction(){
 		
 		/**
 		 * wpcms class object
 		 */
 		$this->wpcms = new WpCms();
 		
 		/**
 		 * database model class object
 		 */
 		$this->db_model = new supportModelClass();
 		
 		/**
 		 * login class object
 		 */
 		$this->login_class = new LoginClass();
 		
 		/**
 		 * get type and save in session
 		 */
 		$this->type = $this->getUrlParam('type');
 		if ($this->type)
 			$this->setAttribute('type', $this->type);		
 		
 		/**
 		 * type assign to view
 		 */
 		$this->viewAssign('type', $this->getAttribute('type'));
 		
 		/**
 		 * get domain name and save in session
 		 */
 		$this->domain = $this->getUrlParam('domain');
 		if ($this->domain)
 			$this->setAttribute('domain', $this->domain);
 		
 		/**
 		 * assign to view
 		 */
 		$this->viewAssign('domain', $this->getAttribute('domain'));
 		
 		/**
 		 * login name
 		 */
 		$this->login_name = $this->access_name.'_'.$this->type.'_'.$this->domain;
 		
 		/**
 		 * url params array
 		 */
 		$this->params = array('type', $this->getAttribute('type'), 'domain', $this->getAttribute('domain'));
 		
 		/**
 		 * page title
 		 */
 		$this->viewAssign('title', 'サポート');
 		
 	} // commonAction
 	
 	
 	
 	/**
 	 * index action controller
 	 */
 	public function indexAction(){
 		
 		/**
 		 * check login
 		 */
 		$this->login_class->checkLogin($this->login_name, $this->module_name, $this->params);
 		
 		/**
 		 * redirect to inquery form page
 		 */
 		header("Location: http://kiwamiapp.com/wpform/form/newEntry/form_id/42753544875");
 		exit;
 		
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
  		
  		if (empty($post['user_id'])){
  			$msg[] = "お客様番号入力してください。";
  		}
  		
  		if (empty($post['domain'])){
  			$msg[] = "ドメイン名入力してください。";
  		}
  		
  		if (empty($post['serial'])){
  			$msg[] = "シリアルナンバー入力してください。";
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
  			
  			$this->login_class->setLogin($this->login_name, $result, $post['memorise']);
  			
  			$url_array = array($this->module_name);
  			$url = $this->makeUrl($url_array);
  			$this->redirect($url);
  			
  		} // if ($msg){
  		
  	} // loginConfAction
  	
  	
  	
  	/**
  	 * logout action controller
  	 */
  	public function logoutAction(){
  		
  		$id = $this->login_class->setLogout($this->login_name);
  		
  		$url_array = array($this->module_name);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
  		
  	} // logoutAction
 
 
 
 } // supportControllerClass
 
 
 ?>