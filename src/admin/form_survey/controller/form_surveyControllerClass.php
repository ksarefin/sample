<?php
/**
 * form_surveyControllerClass.php
 * 
 * @created on 2011/12/15
 * @package    ActiveIR
 * @subpackage 
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2011/12/15 - 20:23:37 fabien 
 * 
 *File content
     form_surveyControllerClass.php
 *     
 */
 
 
 class form_surveyControllerClass extends Configuration{
 
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
 	 * set id instance
 	 */
 	protected $set_id;
 	
 	
 	
 	
 	
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
 		$this->db_model = new form_surveyModelClass();
 		
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
 		 * get set url id
 		 */
 		$url_id = $this->getUrlParam('set_id');
 		$this->set_id = get_id($url_id);
 		
 		/**
 		 * save set id in session and assign to view
 		 */
 		if ($this->set_id)
 			$this->setAttribute('set_id', $this->set_id);
 			
 		$this->viewAssign('set_id', $this->getAttribute('set_id'));
 		
 		/**
  		 * login check
  		 */
  		$this->login_class->checkLogin($this->access_name);
 		
 		/**
  		 * page title
  		 */
  		$this->viewAssign('page_title', 'アンケート');
  		
 		
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
 		 * get set id
 		 */
 		$set_id = $this->getAttribute('set_id');
 		
 		/**
		 * get list from data base and assign to view
		 */
 		$list = $this->db_model->getList();
 		$this->viewAssign('list', $list); 		
 		
 		 		
 			
 		$this->setDisplay('list'); 		
 		
 	} // indexAction
 
 
 
 } // form_surveyControllerClass
 
 
 ?>