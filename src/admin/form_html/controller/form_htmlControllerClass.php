<?php
/**
 * form_htmlControllerClass.php
 * 
 * @created on 2012/03/29
 * @package    FORM
 * @subpackage Admin
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/03/29 - 17:50:16 fabien 
 * 
 *File content
     form_htmlControllerClass.php
 *     
 */
 
 
 class form_htmlControllerClass extends Configuration{
 
 	
 	/**
 	 * wpcms class instance
 	 */
 	protected $wpcms;
 	
 	/**
 	 * data model class instance
 	 */
 	protected $db_model;
 	 	
 	/**
 	 * form id instance
 	 */
 	protected $form_id;
 	
 	/**
 	 * html id instance
 	 */
 	protected $html_id;
 	
 	
 	
 	
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
 		$this->db_model = new form_htmlModelClass();
 		
 		/**
 		 * get form url id
 		 */
 		$url_id = $this->getUrlParam('form_id');
 		$this->form_id = get_id($url_id);
 		
 		/**
 		 * save form id in session and assign to view
 		 */
 		if ($this->form_id)
 			$this->setAttribute('form_id', $this->form_id);
 			
 		$this->viewAssign('form_id', $this->getAttribute('form_id'));
 		
 		/**
 		 * get html id and store in session
 		 */
 		$url_html_id = $this->getUrlParam('html_id');
 		$this->html_id = get_id($url_html_id);
 		
 		if ($this->html_id)
 			$this->setAttribute('html_id', $this->html_id);

 		/**
 		 * html id assign to view
 		 */	
 		$this->viewAssign('html_id', $this->html_id);	 		
 		
 		/**
  		 * login check
  		 */
  		$this->login_class->checkLogin($this->access_name);
  		
 		/**
  		 * page title
  		 */
  		$this->viewAssign('page_title', 'HTML編集');
 		
 	} // commonAction
 	
 	
 	
 	/**
 	 * index action controller
 	 */
 	public function indexAction(){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get form set list
 		 */
 		$form_html_list = $this->db_model->getFormHtmlList($form_id);
 		$shorted_list = array_sort($form_html_list, 'name', SORT_ASC);
 		
 		/**
 		 * make new list 
 		 */
 		$list   = array();
 		$new_id = 1;
 		foreach ($shorted_list as $row){
 			$list[] = array('html_id' => $new_id, 'name' => $row['name']);
 			$new_id++;
 		}
 		//print_r($list);

 		/**
 		 * save html list in session
 		 */
 		$this->setAttribute('html_list', $list);
 		
 		/**
 		 * html list assign to view
 		 */
 		$this->viewAssign('list', $list);
 		
 		
 		
 		$this->setDisplay('list');
 		
 	} // indexAction
 	
 	
 	
 	/**
 	 * html edit action controller
 	 */
 	public function htmlEditAction(){
 		
 		/**
 		 * get html id
 		 */
 		$html_id = $this->getAttribute('html_id');
 		$pd['html_id'] = $html_id;
 		
 		/**
 		 * get html list
 		 */
 		$html_list = $this->getAttribute('html_list');
 		
 		/**
 		 * get html name
 		 */
 		foreach ($html_list as $html){
 			if ($html['html_id'] != $html_id) continue;
 			$html_name = $html['name'];
 			break;	
 		}
 		
 		/**
 		 * html tmplate path
 		 */
 		$pd['template'] 		= $html_name;
 		$template_path 			= BASE_DIR.SRC."/form/template/".$pd['template']; 
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
 		
 	} // htmlEditAction
 	
 	
 	
 	/**
 	 * html save action controller 	 
 	 */
 	public function htmlSaveAction(){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get html id
 		 */
 		$html_id = $this->getAttribute('html_id');
 		
 		/**
 		 * get form post data and assign to view 
 		 */
 		$post = $this->getPost();
 		$this->viewAssign('pd', $post);
 		
 		/**
 		 * post data check for error
 		 */
 		if (empty($post['contents']))
 			$err_msg[] = 'Html contents can not be empay';	
 			
 		/**
 		 * if error then display form else goes to confimation page
 		 */
 		if ($err_msg){
 			
 			/**
 			 * assign error message to view
 			 */
 			$this->viewAssign('err',$err_msg);
 			
 			
 			$this->setDisplay('form');
  			
 		}else {
 			
 			/**
	 		 * get html list
	 		 */
	 		$html_list = $this->getAttribute('html_list');
	 		
	 		/**
	 		 * get html name
	 		 */
	 		foreach ($html_list as $html){
	 			if ($html['html_id'] != $html_id) continue;
	 			$html_name = $html['name'];
	 			break;	
	 		}
	 		
	 		/**
	 		 * html tmplate path
	 		 */
	 		$pd['template'] 		= $html_name;
	 		$template_path 			= BASE_DIR.SRC."/form/template/".$pd['template']; 
	 		$pd['template_path'] 	= $template_path;
	 		
	 		/**
 			 * update html template
 			 */
 			$fp = fopen($template_path, 'w');
 			fwrite($fp, $post['contents']);
 			fclose($fp);
 			
 			/**
 			 * page redirect to index
 			 */
 			$url_array = array(
 				$this->module_name, 'htmlEdit',
 				'form_id', make_id($form_id),
 				'html_id', make_id($html_id)
 			);
  			$url = $this->makeUrl($url_array);
  			$this->redirect($url);
  			
 		} // if ($err_msg){1
 		
 	} // htmlSaveAction
 
 
 
 } // form_htmlControllerClass
 
 
 ?>