<?php
/**
 * form_cssControllerClass.php
 * 
 * @created on 2012/02/22
 * @package    FORM
 * @subpackage 
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/02/22 - 13:34:50 fabien 
 * 
 *File content
     form_cssControllerClass.php
 *     
 */
 
 
 class form_cssControllerClass extends Configuration{

 	/**
 	 * wpcms class instance
 	 */
 	protected $wpcms;
 	
 	/**
 	 * data model class instance
 	 */
 	protected $db_model;
 	
 	/**
 	 * css id instance
 	 */
 	protected $css_id;
 	
 	
 	
 	
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
 		$this->db_model = new form_cssModelClass();
 		
 		/**
 		 * get css id and store in session
 		 */
 		$url_css_id = $this->getUrlParam('css_id');
 		$this->css_id = get_id($url_css_id);
 		
 		if ($this->css_id)
 			$this->setAttribute('css_id', $this->css_id);

 		/**
 		 * css id assign to view
 		 */	
 		$this->viewAssign('css_id', $this->css_id);	
 		
 		/**
  		 * login check
  		 */
  		$this->login_class->checkLogin($this->access_name);
 		
 		/**
  		 * page title
  		 */
  		$this->viewAssign('page_title', 'CSS');
 		
 		
 	} // commonAction
 	
 	
 	
 	/**
 	 * index action controller
 	 */
 	public function indexAction(){
 		
 		/**
 		 * get css list
 		 */
 		//$css_list = $this->db_model->getCssList();
 		$css_list[] = array(
	    	'css_id' => 1,
	    	'name'	 => 'user.css',
    	);
 		
 		/**
 		 * css list assign to view and save in session
 		 */
 		$this->viewAssign('list', $css_list);
 		$this->setAttribute('css_list', $css_list);
 		
 		
 		
 		$this->setDisplay('list'); 		
 		
 	} // indexAction
 	
 	
 	
 	
 	/**
 	 * css edit action controller
 	 */
 	public function cssEditAction(){
 		
 		/**
 		 * get css id
 		 */
 		$css_id = $this->getAttribute('css_id');
 		$pd['css_id'] = $css_id;
 		
 		/**
 		 * get css list
 		 */
 		$css_list = $this->getAttribute('css_list');
 		
 		/**
 		 * get css name
 		 */
 		foreach ($css_list as $css){
 			if ($css['css_id'] != $css_id) continue;
 			$css_name = $css['name'];
 			break;	
 		}
 		
 		/**
 		 * css tmplate path
 		 */
 		$pd['template'] 		= $css_name;
 		$template_path 			= BASE_DIR.'/wpcms/common/static/css/'.$pd['template']; 
 		$pd['template_path'] 	= $template_path;
 		
 		/**
 		 * get template contents
 		 */
 		$pd['contents'] = file_get_contents($template_path);
 		
 		/**
 		 * pd assign to view
 		 */
 		$this->viewAssign('pd', $pd);
 		
 		
 		$this->setDisplay('form');
 		
 		
 	} // cssEditAction
 	
 	
 	/**
 	 * css save action controller
 	 */
 	public function cssSaveAction(){
 		
 		/**
 		 * get css id
 		 */
 		$css_id = $this->getAttribute('css_id');
 		
 		/**
 		 * get form post data and assign to view 
 		 */
 		$post = $this->getPost();
 		$this->viewAssign('pd', $post);
 		
 		/**
 		 * post data check for error
 		 */
 		if (empty($post['contents']))
 			$err_msg[] = 'CSS内容を入力してください。';	
 			
 		
 		/**
 		 * if error then display form else goes to confimation page
 		 */
 		if ($err_msg){
 			
 			/**
 			 * assign error message to view
 			 */
 			$this->viewAssign('err',$err_msg);
 			
 			
 			$this->setDisplay('css_form');
  			
 		}else {
 			
 			/**
	 		 * get css list
	 		 */
	 		$css_list = $this->getAttribute('css_list');
	 		
	 		/**
	 		 * get css name
	 		 */
	 		foreach ($css_list as $css){
	 			if ($css['css_id'] != $css_id) continue;
	 			$css_name = $css['name'];
	 			break;	
	 		}
	 		
	 		/**
	 		 * css tmplate path
	 		 */
	 		$pd['template'] 		= $css_name;
	 		$template_path 			= BASE_DIR.'/wpcms/common/static/css/'.$pd['template']; 
	 		$pd['template_path'] 	= $template_path;
	 		
	 		/**
 			 * update css template
 			 */
 			$fp = fopen($template_path, 'w');
 			fwrite($fp, $post['contents']);
 			fclose($fp);
 			
 			/**
 			 * page redirect to index
 			 */
 			$url_array = array($this->module_name, 'cssEdit', 'css_id', make_id($css_id));
  			$url = $this->makeUrl($url_array);
  			$this->redirect($url);
  			
 		} // if ($err_msg){
 		
 		
 	} // cssSaveAction
 	
 	
 	
 } // form_cssControllerClass
 
 
 ?>