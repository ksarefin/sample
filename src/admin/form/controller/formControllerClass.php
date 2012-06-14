<?php
/**
 * formControllerClass.php
 * 
 * @created on 2011/12/13
 * @package    Form
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2011/12/13 - 17:15:35 fabien 
 * 
 *File content
     formControllerClass.php
 *     
 */
 
 
 class formControllerClass extends Configuration{
 
 	/**
 	 * wpcms class instance
 	 */
 	protected $wpcms;
 	
 	/**
 	 * data model class instance
 	 */
 	protected $db_model;
 	 	
 	/**
 	 * form array instance
 	 */
 	protected $form_array;
 	
 	/**
 	 * thanks html array instance
 	 */
 	protected $thanks_html_array;
 	
 	/**
 	 * customer mail html instance
 	 */
 	protected $customer_mail_html_array;
 	
 	/**
 	 * admin mail html instance
 	 */
 	protected $admin_mail_html_array;
 	
 	/**
 	 * form class instance
 	 */
 	protected $form_class;

 	/**
 	 * numbers of rows instance
 	 */
 	protected $num_rows;
 	
 	/**
 	 * form id instance
 	 */
 	protected $form_id;
 	
 	
 	
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
 		$this->db_model = new formModelClass();
 		
 		/**
 		 * parse form ini
 		 */
 		$ini_parser = new IniParserClass();
 		$ini_array  = $ini_parser->iniParse(FORM_SET_INI);
 		
 		/**
 		 * form array for specific page
 		 */
 		$this->form_array = $ini_parser->getFormArray($ini_array, 'form_content');
 		
 		/**
 		 * thank you html array
 		 */
 		$this->thanks_html_array = $ini_parser->getFormArray($ini_array, 'thanks_page_entry');
 		
 		/**
 		 * customer mail html array
 		 */
 		$this->customer_mail_html_array = $ini_parser->getFormArray($ini_array, 'customer_mail_entry');
 		
 		/**
 		 * admin mail html array
 		 */
 		$this->admin_mail_html_array = $ini_parser->getFormArray($ini_array, 'admin_mail_entry');
 		
 		/**
 		 * form class object
 		 */
 		$this->form_class = new FormClass();
 		
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
  		 * page title
  		 */
  		$this->viewAssign('page_title', 'フォーム編集');
  		
  		/**
  		 * login check
  		 */
  		$this->login_class->checkLogin($this->access_name);  		
  		
  		/**
  		 * js to the view
  		 */
  		$jquery_dir = WEB_DIR.COMMOM_DIR."/scripts/jquery/";
  		
  		$js[] = $jquery_dir."/jquery.textarearesizer.js";
  		$js[] = $jquery_dir."/textarearesizerinit.js";
  		
  		$tinymce_dir = WEB_DIR.COMMOM_DIR."/scripts/tinymce/";
  		
  		$js[] = $tinymce_dir."tiny_mce.js";
  		$js[] = $tinymce_dir."config.js";
      $js[] = $tinymce_dir."config2.js";
  		$this->viewAssign('js', $js);
  		
 		
 	} // commonAction
 	
 	
 	
 	/**
 	 * index action controller
 	 */
 	public function indexAction(){
 		
 		/**
 		 * set page url array
 		 */
 		$url_array = array($this->module_name, $this->action_name);
 		
 		/**
 		 * get page number from url and set attribute
 		 */
 		$page_no = $this->getUrlParam('page');
 		
 		/**
 		 * set page number to 1 if page number is empty and assign to view
 		 */
 		if (empty($page_no)){
 			$page_no = 1;
 		}else {
 			if (is_numeric($page_no))
 				array_push($url_array, 'page',$page_no);
 		}
 		$this->viewAssign('page_no', $page_no);
 		
 		/**
 		 * get page limit from parameter
 		 */
 		$limit = $this->getUrlParam('limit');
 		if (is_numeric($limit))
 			$this->setAttribute('limit', $limit);
 		
 		/**
 		 * if page limit is empty set page limit and assign to view
 		 */	
 		if (empty($limit)){
 			$limit = ADMIN_DISP;
 		}else {
 			if (is_numeric($limit))
 				array_push($url_array, 'limit', $limit);
 		}
 		$this->viewAssign('limit', $limit);
 		
 		/**
 		 * set paging offset
 		 */
 		$offse = ($page_no-1) * $limit;
 		
 		/**
 		 * set number to dispaly list number on view
 		 */
 		$this->viewAssign('number', (($page_no-1)*$limit));
 		
 		/**
 		 * data base row count and assign to view
 		 */
 		if (empty($this->num_rows))
 			$this->num_rows = $this->wpcms->getNumRows('form_tab');
 		
 		$this->viewAssign('num_rows', $this->num_rows);	
 			
 		
 		/**
 		 * if show all in one page
 		 */
		if ($limit == 'all'){
 			$limit = 0;
 			$this->viewAssign("paging",'<li><span>1</span></li>');
 		}else {
 			
 			/**
 			 * get paging html, previous, next page info and assign to view
 		 	 */
 			$page_class = new PageClass($this->num_rows, $page_no, $limit);
 			$this->viewAssign('prev', $page_class->isPrev());
			$this->viewAssign('prev_pn', $page_no-1);
			$this->viewAssign('next', $page_class->isNext());
			$this->viewAssign('next_pn', $page_no+1);
			$link_url = $this->self_url.'/'.$this->action_name.'/limit/'.$limit;;
			$paging = $page_class->DisPage($link_url);
			$this->viewAssign("paging",$paging);
		}
 		
		/**
		 * get list from data base and assign to view
		 */
 		$list = $this->db_model->getList($limit, $offse);
 		$this->viewAssign('list', $list); 		
 		
 		/**
 		 * get total row number and assign to view 
 		 */
 		$total_rows = $this->wpcms->getTotal('form_tab');
 		$this->viewAssign('total_rows', $total_rows);
 		
 		/**
 		 * make url for other page
 		 */
 		if (is_array($url_array))
 			$this->setAttribute('list_page_url', $this->makeUrl($url_array));
 		
 		
 		/**
 		 * get frist display order number
 		 */
 		$first_order = $this->wpcms->getDisplayOrder('form_tab', 'first');
 		$this->viewAssign('first_order', $first_order);
 		
 		
 		/**
 		 * get last display order number
 		 */
 		$last_order = $this->wpcms->getDisplayOrder('form_tab', 'last');
 		$this->viewAssign('last_order', $last_order);
 		
 			
 		$this->setDisplay('list');
 		
 	} // indexAction
 	
 	
 	
 	/**
 	 * new form action controller
 	 */
 	public function newFormAction(){
 		
 		/**
  		 * build form html and assign to view
  		 */
 		$form_html  = $this->form_class->form($this->form_array, 'form_content','form');
 		$this->viewAssign('form_html', $form_html);
 		
 		/**
  		 * build thanks html and assign to view
  		 */
 		$thanks_html  = $this->form_class->form($this->thanks_html_array, 'thanks_page_entry','form');
 		$this->viewAssign('thanks_html', $thanks_html);
 		
 		/**
  		 * build customer mail html and assign to view
  		 */
 		$customer_mail_html  = $this->form_class->form($this->customer_mail_html_array, 'customer_mail_entry','form');
 		$this->viewAssign('customer_mail_html', $customer_mail_html);
 		
 		/**
  		 * build admin mail html and assign to view
  		 */
 		$admin_mail_html  = $this->form_class->form($this->admin_mail_html_array, 'admin_mail_entry','form');
 		$this->viewAssign('admin_mail_html', $admin_mail_html);
 		
 		/**
 		 * get list page url and assign to view 
 		 */
 		$this->viewAssign('list_page_url', $this->getAttribute('list_page_url'));
 		
 		
 		$this->setDisplay('form');
 		 		
 	} // newFormAction
 	
 	
 	/**
 	 * from back action controller
 	 */
 	public function backFormAction(){
 		
 		/**
 		 * get post data
 		 */
 		$post = $this->getAttribute('post');
 		$this->viewAssign('pd', $post);
 		
 		
 		/**
 		 * make form html
 		 */
 		$form_html  = $this->form_class->form($this->form_array, 'form_content', 'conf');
 		$this->viewAssign('form_html', $form_html);
 		
 		
 		/**
  		 * build thanks html and assign to view
  		 */
 		$thanks_html  = $this->form_class->form($this->thanks_html_array, 'thanks_page_entry','conf');
 		$this->viewAssign('thanks_html', $thanks_html);
 		
 		/**
  		 * build customer mail html and assign to view
  		 */
 		$customer_mail_html  = $this->form_class->form($this->customer_mail_html_array, 'customer_mail_entry','conf');
 		$this->viewAssign('customer_mail_html', $customer_mail_html);
 		
 		/**
  		 * build admin mail html and assign to view
  		 */
 		$admin_mail_html  = $this->form_class->form($this->admin_mail_html_array, 'admin_mail_entry','conf');
 		$this->viewAssign('admin_mail_html', $admin_mail_html);
 		
 		/**
 		 * get list page url and assign to view 
 		 */
 		$this->viewAssign('list_page_url', $this->getAttribute('list_page_url'));
 		
 		
 		$this->setDisplay('form');
 		
 	} // backFormAction
 	
 	
 	
 	/**
 	 * form edit action controller
 	 */
 	public function editFormAction(){
 		
 		/**
 		 * get from id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		
 		/**
 		 * get form data and assign to view
 		 * and save in session as post data
 		 */
 		$form_data = $this->db_model->getFormData($form_id);
 		$this->viewAssign('pd', $form_data);
 		$this->setAttribute('post', $form_data);
 		
 		/**
 		 * make form html
 		 */
 		$form_html  = $this->form_class->form($this->form_array, 'form_content', 'conf');
 		$this->viewAssign('form_html', $form_html);
 		
 		/**
  		 * build thanks html and assign to view
  		 */
 		$thanks_html  = $this->form_class->form($this->thanks_html_array, 'thanks_page_entry','conf');
 		$this->viewAssign('thanks_html', $thanks_html);
 		
 		/**
  		 * build customer mail html and assign to view
  		 */
 		$customer_mail_html  = $this->form_class->form($this->customer_mail_html_array, 'customer_mail_entry','conf');
 		$this->viewAssign('customer_mail_html', $customer_mail_html);
 		
 		/**
  		 * build admin mail html and assign to view
  		 */
 		$admin_mail_html  = $this->form_class->form($this->admin_mail_html_array, 'admin_mail_entry','conf');
 		$this->viewAssign('admin_mail_html', $admin_mail_html);
 		
 		
 		/**
 		 * get list page url and assign to view 
 		 */
 		$this->viewAssign('list_page_url', $this->getAttribute('list_page_url'));
 		
 		
 		
 		$this->setDisplay('form');
 		
 	} // editFormAction
 	
 	
 	/**
 	 * from entry confirm action controller
 	 */
 	public function formConfAction(){
 		
 		/**
 		 * get post data
 		 */
 		$post = $this->getPost();
 		
 		if (!empty($post))
 			$this->setAttribute('post', $post);
 		$this->viewAssign('pd', $post);
 		
 		
 		
 		/**
 		 * post data check for error
 		 */
 		$err_msg = $this->form_class->errorCheck($this->form_array, $post);
 		
 		
 		
 		/**
 		 * if error then display form else goes to confimation page
 		 */
 		if ($err_msg){
 			
 			/**
 			 * build form html and assign to view
 			 */
 			$form_html  = $this->form_class->form($this->form_array, 'form_content','conf');
 			$this->viewAssign('form_html', $form_html);
 			
 			/**
	  		 * build thanks html and assign to view
	  		 */
	 		$thanks_html  = $this->form_class->form($this->thanks_html_array, 'thanks_page_entry','conf');
	 		$this->viewAssign('thanks_html', $thanks_html);
	 		
	 		/**
	  		 * build customer mail html and assign to view
	  		 */
	 		$customer_mail_html  = $this->form_class->form($this->customer_mail_html_array, 'customer_mail_entry','conf');
	 		$this->viewAssign('customer_mail_html', $customer_mail_html);
	 		
	 		/**
	  		 * build admin mail html and assign to view
	  		 */
	 		$admin_mail_html  = $this->form_class->form($this->admin_mail_html_array, 'admin_mail_entry','conf');
	 		$this->viewAssign('admin_mail_html', $admin_mail_html);
 			
 			/**
 			 * assign error message to view
 			 */
 			$this->viewAssign('err',$err_msg);
 			
 			
 			/**
	 		 * get list page url and assign to view 
	 		 */
	 		$this->viewAssign('list_page_url', $this->getAttribute('list_page_url'));
	 		
 			
  			$this->setDisplay('form');
 		
 		}else {
 			
 			/**
 			 * build confirmation html and assign to view
 			 */
 			$conf_html  = $this->form_class->conf($this->form_array, 'form_content');
 			$this->viewAssign('conf_html', $conf_html);
 			
 			/**
	  		 * build thanks html and assign to view
	  		 */
	 		$thanks_html  = $this->form_class->conf($this->thanks_html_array, 'thanks_page_entry','conf');
	 		$this->viewAssign('thanks_html', $thanks_html);
	 		
	 		/**
	  		 * build customer mail html and assign to view
	  		 */
	 		$customer_mail_html  = $this->form_class->conf($this->customer_mail_html_array, 'customer_mail_entry','conf');
	 		$this->viewAssign('customer_mail_html', $customer_mail_html);
	 		
	 		/**
	  		 * build admin mail html and assign to view
	  		 */
	 		$admin_mail_html  = $this->form_class->conf($this->admin_mail_html_array, 'admin_mail_entry','conf');
	 		$this->viewAssign('admin_mail_html', $admin_mail_html);
 			
 			
 			/**
 			 * make back page url and assign to view
 			 */
 			$url_array = array( $this->module_name, 'backForm');
 			$back_url = $this->makeUrl($url_array);
 			$this->viewAssign('back', $back_url);
 			
 			
 			$this->setDisplay('conf');
 		}
 		
 		
 		
 	} // formConfAction
 	
 	
 	
 	/**
 	 * save action controller
 	 */
 	public function saveAction(){

 		/**
 		 * get post data
 		 */
 		$post = $this->getAttribute('post');
 		
 		/**
 		 * save post data
 		 */
 		$this->db_model->save($post);
 		
 		/**
 		 * page redirect to index
 		 */
 		$url_array = array($this->module_name);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
 		
 	} // save
 	
 	
 	/**
 	 * non display action controller
 	 */
 	public function nonDisplayAction(){
 		
 		/**
 		 * get form_id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		$this->wpcms->displayChange($form_id, 0, 'form_tab');		
 		
 		
 		/**
 		 * page redirect to index
 		 */
 		$url_array = array($this->module_name);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
 		
 	} // nonDisplayAction
 	
 	
 	
 	/**
 	 * display action controller
 	 */
 	public function displayAction(){
 		
 		/**
 		 * get form_id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		$this->wpcms->displayChange($form_id, 1, 'form_tab');		
 		
 		
 		/**
 		 * page redirect to index
 		 */
 		$url_array = array($this->module_name);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
 		
 	} // displayAction
 	
 	
 	
 	/**
 	 * delete action controller
 	 */
 	public function deleteAction(){
 		
 		/**
 		 * get form_id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * update delete flg
 		 */
 		$this->wpcms->delete($form_id, 'form_tab');
 		
 		/**
 		 * update display order
 		 */
 		$this->wpcms->updateDisplayOrder($form_id, 'form_tab');
 		
 		/**
 		 * page redirect to index
 		 */
 		$url_array = array($this->module_name);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
  		
 	} // deleteAction
 	
 	
 	
 	/**
 	 * display order action controller
 	 */
 	public function displayOrderAction(){
 		
 		/**
 		 * get form_id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get order
 		 */
 		$order = $this->getUrlParam('order');
 		
 		 		
 		switch ($order){
 			
 			case 'up':
 					$this->wpcms->moveUp($form_id, 'form_tab');	
 				break;
 				
 			case 'down':
 					$this->wpcms->moveDown($form_id, 'form_tab');
 				break;
 			
 		}
 		
 		
 		/**
 		 * page redirect to index
 		 */
 		$url_array = array($this->module_name);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
 		
 		
 	} // displayOrderAction
 	
 	
 	
 	
 
 
 
 } // formControllerClass
 
 
 ?>