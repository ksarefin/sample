<?php
/**
 * form_setControllerClass.php
 * 
 * @created on 2011/12/15
 * @package    ActiveIR
 * @subpackage 
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2011/12/15 - 16:04:55 fabien 
 * 
 *File content
     form_setControllerClass.php
 *     
 */
 
 
 class form_setControllerClass extends Configuration{
 
 	/**
 	 * wpcms class instance
 	 */
 	protected $wpcms;
 	
 	/**
 	 * model class instance
 	 */
 	protected $db_model;
 	
 	/**
 	 * data class instance
 	 */
 	protected $data_class;
 	 	
 	/**
 	 * form array instance
 	 */
 	protected $form_array;
 	
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
 	 * set id instance
 	 */
 	protected $set_id;
 	
 	/**
 	 * set type instance
 	 */
 	protected $set_type;
 	
 	
 	
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
 		$this->db_model = new form_setModelClass();
 		
 		/**
 		 * data class object
 		 */
 		$this->data_class = new DataClass();

 		
 		/**
 		 * get entry type list and assign to view
 		 */
 		$entry_type = $this->data_class->entryType();
 		$this->viewAssign('entry_type', $entry_type); 		
 		
 		/**
 		 * parse form ini
 		 */
 		$ini_parser = new IniParserClass();
 		$ini_array  = $ini_parser->iniParse(FORM_SET_INI);
 		
 		/**
 		 * form array for specific page
 		 */
 		$this->form_array = $ini_parser->getFormArray($ini_array, 'form_set_entry');
 		
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
 		 * get set type
 		 */
 		$this->set_type = $this->getUrlParam('type');
 		
 		/**
 		 * set type save in session and assign to view
 		 */
 		if ($this->set_type)
 			$this->setAttribute('set_type', $this->set_type);
 		$this->viewAssign('set_type', $this->getAttribute('set_type'));

 		/**
  		 * login check
  		 */
  		$this->login_class->checkLogin($this->access_name);
 		
 		/**
  		 * page title
  		 */
  		$this->viewAssign('page_title', 'フォーム');
  		
 		
 		
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
 		 * search array
 		 */
 		$search_array = array('form_id' => $form_id);
 		
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
 			$this->num_rows = $this->wpcms->getNumRows('set_tab', $search_array);
 		
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
			$link_url = $this->self_url.'/'.$this->action_name.'/form_id/'.make_id($form_id).'/limit/'.$limit;;
			$paging = $page_class->DisPage($link_url);
			$this->viewAssign("paging",$paging);
		}
 		
		/**
		 * get list from data base and assign to view
		 */
 		$list = $this->db_model->getList($form_id, $limit, $offse);
 		$this->viewAssign('list', $list); 		
 		
 		/**
 		 * get total row number and assign to view 
 		 */
 		$total_rows = $this->wpcms->getTotal('set_tab', $search_array);
 		$this->viewAssign('total_rows', $total_rows);
 		
 		/**
 		 * make url for other page
 		 */
 		if (is_array($url_array))
 			$this->setAttribute('list_page_url', $this->makeUrl($url_array));
 		
 			
 		/**
 		 * get frist display order number
 		 */
 		$first_order = $this->wpcms->getDisplayOrder('set_tab', 'first', $search_array);
 		$this->viewAssign('first_order', $first_order);
 		
 		
 		/**
 		 * get last display order number
 		 */
 		$last_order = $this->wpcms->getDisplayOrder('set_tab', 'last', $search_array);
 		$this->viewAssign('last_order', $last_order);
 		
 		
 		/**
 		 * make form entry list
 		 */
 		$entry_list = array();
	 	foreach ($list as $row){
	 		
	 		/**
	 		 * set id
	 		 */
	 		$set_id = $row['id'];
	 		
	 		/**
	 		 * search array
	 		 */
	 		$search_array = array('form_id' => $form_id, 'set_id' => $set_id);
	 		
	 		/**
	 		 * set page url array
	 		 */
	 		/*$url_array = array(
	 			$this->module_name, $this->action_name,
	 			'form_id',	make_id($form_id),
	 			'set_id',	make_id($set_id),
	 		);*/
	 		
	 		/**
	 		 * get page number from url and set attribute
	 		 */
	 		//$page_no = $this->getUrlParam('page');
	 		
	 		/**
	 		 * set page number to 1 if page number is empty and assign to view
	 		 */
	 		/*
	 		if (empty($page_no)){
	 			$page_no = 1;
	 		}else {
	 			if (is_numeric($page_no))
	 				array_push($url_array, 'page',$page_no);
	 		}
	 		$this->viewAssign('page_no', $page_no);
	 		*/
	 		
	 		/**
	 		 * get page limit from parameter
	 		 */
	 		/*
	 		$limit = $this->getUrlParam('limit');
	 		if (is_numeric($limit))
	 			$this->setAttribute('limit', $limit);
	 		*/
	 		/**
	 		 * if page limit is empty set page limit and assign to view
	 		 */	
	 		/*if (empty($limit)){
	 			$limit = ADMIN_DISP;
	 		}else {
	 			if (is_numeric($limit))
	 				array_push($url_array, 'limit', $limit);
	 		}
	 		$this->viewAssign('limit', $limit);
	 		*/
	 		
	 		/**
	 		 * set paging offset
	 		 */
	 		//$offse = ($page_no-1) * $limit;
	 		
	 		/**
	 		 * set number to dispaly list number on view
	 		 */
	 		//$this->viewAssign('number', (($page_no-1)*$limit));
	 		
	 		/**
	 		 * data base row count and assign to view
	 		 */
	 		//if (empty($this->num_rows))
	 		//	$this->num_rows = $this->wpcms->getNumRows('form_entry_tab', $search_array);
	 		
	 		//$this->viewAssign('num_rows', $this->num_rows);	
	 			
	 		
	 		/**
	 		 * if show all in one page
	 		 */
			/*if ($limit == 'all'){
	 			$limit = 0;
	 			$this->viewAssign("paging",'<li><span>1</span></li>');
	 		}else {
	 		*/	
	 			/**
	 			 * get paging html, previous, next page info and assign to view
	 		 	 */
	 		/*	$page_class = new PageClass($this->num_rows, $page_no, $limit);
	 			$this->viewAssign('prev', $page_class->isPrev());
				$this->viewAssign('prev_pn', $page_no-1);
				$this->viewAssign('next', $page_class->isNext());
				$this->viewAssign('next_pn', $page_no+1);
				$link_url = $this->self_url.'/'.$this->action_name.'/form_id/'.make_id($form_id).'/set_id/'.make_id($set_id).'/limit/'.$limit;;
				$paging = $page_class->DisPage($link_url);
				$this->viewAssign("paging",$paging);
			}*/
	 		
			/**
			 * get list from data base and assign to view
			 */
	 		$tmp_list = array();
	 		include_once ADMIN_FORM_ENTRY_MODEL;
	 		$editor_form_entry_model = new form_entryModelClass();
	 		$form_entry_list = $editor_form_entry_model->getList($form_id, $set_id);
	 		foreach ($form_entry_list as $entry_row){
	 			$entry_row['entry_type'] = $this->data_class->getEntryTypeId($entry_row['type']);
	 			$tmp_list['list'][] = $entry_row;
	 		}
	 		
	 		/**
	 		 * get total row number and assign to view 
	 		 */
	 		$tmp_list['total_rows'] = $this->wpcms->getTotal('form_entry_tab', $search_array);
	 		
	 		/**
	 		 * make url for other page
	 		 */
	 		/*if (is_array($url_array))
	 			$this->setAttribute('list_page_url', $this->makeUrl($url_array));
	 		*/
	 			
	 		/**
	 		 * get frist display order number
	 		 */
	 		$tmp_list['first_order'] = $this->wpcms->getDisplayOrder('form_entry_tab', 'first', $search_array);
	 		
	 		/**
	 		 * get last display order number
	 		 */
	 		$tmp_list['last_order'] = $this->wpcms->getDisplayOrder('form_entry_tab', 'last', $search_array);
	 		
	 		/**
	 		 * assign entry list
	 		 */
	 		$entry_list[$row['id']] = $tmp_list;
	 		
	 	} // foreach ($list as $row){
 		
 		
 		/**
 		 * entry list save in session and assign to view 
 		 */
	 	$this->setAttribute('entry_list', $entry_list);
	 	$this->viewAssign('entry_list', $entry_list);
 		//print_r($entry_list);
 		
	 	
	 	/**
	 	 * get survey list and assign to view 
	 	 */
	 	$survey_list = $this->db_model->getSurveyList();
	 	$this->viewAssign('survey_list', $survey_list);
	 	
 		
 			
 		$this->setDisplay('list');
 		
 	} // indexAction
 	
 	
 	
 	/**
 	 * new form action controller
 	 */
 	public function newFormAction(){
 		
 		/**
 		 * get set type
 		 */
 		$type = $this->getUrlParam('type');
 		$this->viewAssign('type', $type);
 		
 		/**
  		 * build form html and assign to view
  		 */
 		$form_html  = $this->form_class->form($this->form_array, 'form_set_entry','form');
 		$this->viewAssign('form_html', $form_html);
 		
 		
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
  		 * build form html and assign to view
  		 */
 		$form_html  = $this->form_class->form($this->form_array, 'form_set_entry','form');
 		$this->viewAssign('form_html', $form_html);
 		
 		/**
 		 * post data check for error
 		 */
 		$err_msg = $this->form_class->errorCheck($this->form_array, $post);
 		
 		/**
 		 * assign error message to view
 		 */
 		$this->viewAssign('err',$err_msg);
 		
 		
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
 		 * get set id
 		 */
 		$set_id = $this->getAttribute('set_id');
 		
 		/**
 		 * get set data and assign to view
 		 * and save in session as post data
 		 */
 		$set_data = $this->db_model->getSetData($set_id);
 		
 		$this->viewAssign('pd', $set_data);
 		$this->setAttribute('post', $set_data);
 		
 		/**
 		 * make form html
 		 */
 		$form_html  = $this->form_class->form($this->form_array, 'form_set_entry', 'edit');
 		$this->viewAssign('form_html', $form_html);
 		
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
 		/*$post = $this->getPost();
 		
 		if (!empty($post))
 			$this->setAttribute('post', $post);
 		$this->viewAssign('pd', $post);
 		*/
 		
 		
 		/**
 		 * post data check for error
 		 */
 		//$err_msg = $this->form_class->errorCheck($this->form_array, $post);
 		
 		
 		
 		/**
 		 * if error then display form else goes to confimation page
 		 */
 		//if ($err_msg){
 			
 			/**
 			 * build form html and assign to view
 			 */
 		//	$form_html  = $this->form_class->form($this->form_array, 'form_set_entry','conf');
 		//	$this->viewAssign('form_html', $form_html);
 			
 			/**
 			 * assign error message to view
 			 */
 		//	$this->viewAssign('err',$err_msg);
  		//	$this->setDisplay('form');
 		
 		//}else {
 			
 			/**
 			 * build confirmation html and assign to view
 			 */
 		/*	$conf_html  = $this->form_class->conf($this->form_array, 'form_set_entry');
 			$this->viewAssign('conf_html', $conf_html);
 			
 			
 			$this->setDisplay('conf');
 		}*/
 		
 		
 		
 	} // formConfAction
 	
 	
 	
 	/**
 	 * save action controller
 	 */
 	public function saveAction(){
 		
 		/**
 		 * get from id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get set id
 		 */
 		$set_id = $this->getAttribute('set_id'); 

 		/**
	 	 * get set type
	 	 */
	 	$set_type = $this->getAttribute('set_type');
	 		
	 		
 		
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
	 		 * page redirect to index
	 		 */
	 		$url_array = array(
	 			$this->module_name, 'backForm',
	 			'form_id', make_id($form_id),
	 			'set_id', make_id($set_id),
	 			'set_type', $set_type,
	 		);
	  		$url = $this->makeUrl($url_array);
	  		$this->redirect($url);
 		
 		}else {

 			
 			if (!empty($form_id) && is_numeric($form_id))
	 			$post['form_id'] = $form_id;
	 		
	 		if (!empty($set_type))
	 			$post['set_type'] = $set_type;
	 		
	 		/**
	 		 * save post data
	 		 */
	 		$this->db_model->save($post);
	 		
	 		
	 		/**
	 		 * page redirect to index
	 		 */
	 		$url_array = array(
	 			$this->module_name, 'index',
	 			'form_id', make_id($form_id),
	 		);
	  		$url = $this->makeUrl($url_array);
	  		$this->redirect($url);
 			
 		}
 		
 		
 	} // save
 	
 	
 	/**
 	 * non display action controller
 	 */
 	public function nonDisplayAction(){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get set_id
 		 */
 		$set_id = $this->getAttribute('set_id');
 		
 		/**
 		 * set as non display
 		 */
 		$this->wpcms->displayChange($set_id, 0, 'set_tab');		
 		
 		/**
 		 * page redirect list
 		 */
 		$url_array = array(
 			$this->module_name, 'index',
 			'form_id', make_id($form_id),
 		);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
 		
 	} // nonDisplayAction
 	
 	
 	
 	/**
 	 * display action controller
 	 */
 	public function displayAction(){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get set_id
 		 */
 		$set_id = $this->getAttribute('set_id');
 		
 		/**
 		 * set as display
 		 */
 		$this->wpcms->displayChange($set_id, 1, 'set_tab');		
 		
 		/**
 		 * page redirect to index
 		 */
 		$url_array = array(
 			$this->module_name, 'index',
 			'form_id', make_id($form_id),
 		);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
 		
 	} // displayAction
 	
 	
 	
 	/**
 	 * delete action controller
 	 */
 	public function deleteAction(){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get set_id
 		 */
 		$set_id = $this->getAttribute('set_id');
 		
 		/**
 		 * delete set
 		 */
 		$this->wpcms->delete($set_id, 'set_tab');
 		
 		/**
 		 * delete all set entry from form_entry_tab
 		 */
 		$this->db_model->deleteFormEntry($form_id, $set_id);
 		
 		/**
 		 * page redirect to index
 		 */
 		$url_array = array(
 			$this->module_name, 'index',
 			'form_id', make_id($form_id),
 		);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
  		
 	} // deleteAction
 	
 	
 	
 	/**
 	 * display order action controller
 	 */
 	public function displayOrderAction(){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get set id
 		 */
 		$set_id = $this->getAttribute('set_id');
 		
 		/**
 		 * get order
 		 */
 		$order = $this->getUrlParam('order');
 		
 		/**
 		 * make search array
 		 */
 		$search_array = array('form_id' => $form_id);
 		
 		switch ($order){
 			
 			case 'up':
 					$this->wpcms->moveUpAsc($set_id, 'set_tab', $search_array);	
 				break;
 				
 			case 'down':
 					$this->wpcms->moveDownAsc($set_id, 'set_tab', $search_array);
 				break;
 			
 		}
 		
 		
 		/**
 		 * page redirect to index
 		 */
 		$url_array = array(
 			$this->module_name, 'index',
 			'form_id', make_id($form_id),
 		);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
 		
 		
 	} // displayOrderAction
 	
 	
 	
 	
 	/**
 	 * preview action controller
 	 */
 	public function previewAction(){
 		
 		/**
 		 * get page number
 		 */
 		$url_page = $this->getUrlParam('page');
 		$page = $url_page ? get_id($url_page) : 1;
 		
 		/**
 		 * page number assign to view
 		 */
 		$this->viewAssign('page', $page);
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get form data
 		 */
 		$form_data = $this->db_model->getFormData($form_id);
 		
 		/**
 		 * view assign form style
 		 */
 		$this->viewAssign('form_style', $form_data['form_style']);
 		 		
 		/**
 		 * create ini file and ini data
 		 */
 		$this->IniFileAndIniData($ini_header);
 		
 		/**
 		 * form ini directory
 		 */
 		$ini_dir  = FORM_INI_DIR;
 		$ini_path = $ini_dir.'/'.'formset_'.$form_id.'.ini';
 		
 		/**
 		 * parse form ini
 		 */
 		$ini_parser = new IniParserClass();
 		$ini_array  = $ini_parser->iniParse($ini_path);
 		
 		/**
 		 * form class object
 		 */
 		//$form_class = new FormClass();
 		$form_class = new HtmlCodeClass();
 		
 		/**
 		 * make form html
 		 */
 		if ($form_data['form_style'] == 1){
 		
 			/**
 			 * for consul form style
 			 */
	 		$form_html = "";
	 		foreach ($ini_header as $ini_row){
		 		
		 		/**
		 		 * form array for specific page
		 		 */
	 			$form_array = array();
		 		$form_array = $ini_parser->getFormArray($ini_array, $ini_row);
		 		//print_r($form_array);print "<br><br>";
		 		$form_html .= '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle">';
		 		$form_html .= $form_class->htmlForm($form_array, $ini_row, 'form');
		 		$form_html .= '</table>';
	
		 	} // foreach ($ini_header as $ini_row){
		 	
 		}elseif ($form_data['form_style'] == 2){
 			
 			/**
		 	 * form array for specific page
		 	 */
	 		$form_array = array();
		 	$form_array = $ini_parser->getFormArray($ini_array, $ini_header[$page-1]);
		 	$form_html .= '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle">';
		 	$form_html .= $form_class->htmlForm($form_array, $ini_row, 'form');
		 	$form_html .= '</table>';
		 	
 		} // if ($form_data['form_style'] == 1){ 
 		
 		
 		/**
 		 * write html code to cache
 		 */
 		$cache_dir = HOME_DIR."/cache";
 		$file = $cache_dir."/".$form_id."_".$page.".tpl";
	 		
	 	$fp = fopen($file, 'w');
	 	fwrite($fp, $form_html);
	 	fclose($fp);
	 		
	 	$fetch_html = $this->smarty->fetch($file);
	 		
	 	/**
	 	 * assign from html and option count
	 	 */
	 	$this->viewAssign('form_html', $fetch_html);
	 	
	 	
	 	/**
	 	 * check for last page
	 	 * and assign to view
	 	 */
	 	if (count($ini_header) == $page+1){
	 		$this->viewAssign('last_page', 'last');
	 	}else {
	 		$this->viewAssign('last_page', 'paging');
	 	}
	 	
	 	
	 	/**
  		 * assign form title
  		 */
 		$this->viewAssign('form_title', $form_data['title']);
 		
 		
 		
 		$this->setDisplay('preview', false);
 		
 	} // previewAction
 	
 	
 	
 	
 	/**
 	 * publish action controller
 	 */
 	public function publishAction(){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get form information
 		 */
 		$form_data = $this->db_model->getFormData($form_id);
 		//print_r($form_data);exit;
 		
 		/**
 		 * create ini file and ini data
 		 */
 		$this->IniFileAndIniData($ini_header);
 		
 		/**
 		 * form ini directory
 		 */
 		$ini_dir  = FORM_INI_DIR;
 		$ini_path = $ini_dir.'/'.'formset_'.$form_id.'.ini';
 		
 		/**
 		 * parse form ini
 		 */
 		$ini_parser = new IniParserClass();
 		$ini_array  = $ini_parser->iniParse($ini_path);
 		
 		/**
 		 * form class object
 		 */
 		//$form_class = new FormClass();
 		$form_class = new HtmlCodeClass();
 		
 		/**
 		 * make form html
 		 */
 		$form_top_html = '
 			<!-- section -->

			<div class="section">
			
			<h3>{$page_title}</h3> 
			
			<!-- お問い合わせフォームエリア -->
			<div class="contactMain">';
		
 		if ($form_data['form_style'] == 2){
 			$form_top_html .= '<span>Step : {$page}/{$total_page}</span>';
 		}
 		
		$form_top_html .= '
			
			{if $err}
			<ul class="wpfErrorList">
			<li>未記入の項目、または入力に誤りがあります。<span class="icoError">マーク</span>の表示されている項目をご確認ください。</li>
			</ul>
			{/if}
			
 		';
 		
		$form_top_detail .= '
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle">
				<div class="wpfConfirmBox">
					<p class="fontS"><p>'.$form_data['detail'].'</p></p>
			</div>
			</table>';
		
		$form_buttom_html .= '
			 	<div class="wpfAgree">';
		
		if ($form_data['form_style'] == 2){
			
			$form_buttom_html .= '
			 	{if $page> 1}
				<input type="button" name="backPage" value="先へ" onClick="window.location=\'{$self}/backForm/form_id/{$form_id|make_id}/page/{($page-1)|make_id}\';"/>
				{/if}
				
				{if $page && $last_page != \'last\'}
				<input type="button" name="backPage" value="次へ" onClick="window.location=\'{$self}/backForm/form_id/{$form_id|make_id}/page/{($page+1)|make_id}\';"/>
				{/if}';
			
		} // if ($form_data['form_style'] == 2){
		
 		
 		/**
		 * add form submit button
		 */
		 $form_buttom_html .= '
			<p>
			<input type="submit" name="wpfAgreeBtn" id="wpfAgreeBtn" value="入力内容を確認する" />
			<noscript><input type="submit" name="wpfAgreeBtn" id="wpfAgreeBtnNoscrpt" value="入力内容を確認する" /></noscript>
			</p>
			</div>
			
			</form>
			
			</div>
			<!-- /お問い合わせフォームエリア -->
				
			</div>
				
			<!-- /section -->
					 	
		';
 		
 		$h_form_html = "";
 		foreach ($ini_header as $header_key=>$ini_row){
	 		
	 		/**
	 		 * form array for specific page
	 		 */
 			$form_array = array();
 			$header_html = "";
	 		$form_array = $ini_parser->getFormArray($ini_array, $ini_row);
	 		$header_html .= '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle">';
	 		$header_html .= $form_class->htmlForm($form_array, $ini_row, 'form');
	 		$header_html .= '</table>';
	 		$h_form_html .= $header_html;
	 		
	 		if ($form_data['form_style'] == 2){
	 			
	 			$paging_html = $form_top_html;
	 			if ($header_key == 0)
	 				$paging_html .= $form_top_detail;
	 			$paging_html .= '<form id="wpfForm" name="wpfForm" method="post" action="{$self}/conf/form_id/{$form_id|make_id}/page/{$page|make_id}" enctype="multipart/form-data">';
	 			$paging_html .= '<input type="hidden" name="pd[page_no]" value="{$page|make_id}" />';
	 			$paging_html .= $header_html;
	 			$paging_html .= $form_buttom_html;
	 			

			 	/**
			 	 * wirte html to tpl file
			 	 */
		 		$tpl_name	= 'form_'.$form_id.'_'.($header_key+1).'.tpl';
		 		$tpl_dir	= BASE_DIR.SRC.'/top/template';
		 		$tpl_path	= $tpl_dir.'/'.$tpl_name;
		 		
		 		$fp = fopen($tpl_path, 'w');
		 		fwrite($fp, $paging_html);
		 		fclose($fp);
		 		
	 		} // if ($form_data['form_style'] == 1){
	 		
	 	} // foreach ($ini_header as $ini_row){
	 	
	 	
	 	if ($form_data['form_style'] == 1){
	 		
	 		$form_html  = $form_top_html;
	 		$form_html .= $form_top_detail; 
	 		$form_html .= '<form id="wpfForm" name="wpfForm" method="post" action="{$self}/conf/form_id/{$form_id|make_id}" enctype="multipart/form-data">';
	 		$form_html .= $h_form_html;
	 		$form_html .= $form_buttom_html;
		 	
		 	/**
		 	 * wirte html to tpl file
		 	 */
	 		$tpl_name	= 'form_'.$form_id.'.tpl';
	 		$tpl_dir	= BASE_DIR.SRC.'/top/template';
	 		$tpl_path	= $tpl_dir.'/'.$tpl_name;
	 		
	 		$fp = fopen($tpl_path, 'w');
	 		fwrite($fp, $form_html);
	 		fclose($fp);
	 		
	 	} // if ($form_data['form_style'] == 0){
	 	
 		
 		
 		/**
		 * get list from data base and assign to view
		 */
 		$list = $this->db_model->getList($form_id);
 		
 		
 		/**
 		 * make form entry list
 		 */
 		$database_fields = array();
 		foreach ($list as $row){
	 		
	 		/**
	 		 * set id
	 		 */
	 		$set_id = $row['id'];
	 		
	 		/**
	 		 * search array
	 		 */
	 		$search_array = array('form_id' => $form_id, 'set_id' => $set_id);
	 		
			/**
			 * get list from data base and assign to view
			 */
	 		$tmp_list = array();
	 		$form_set_entry_list = $this->db_model->getPreviewList($form_id, $set_id);
	 		foreach ($form_set_entry_list as $entry_set_row){
	 			$database_fields[] = $entry_set_row['name'];
	 		}
	 		
	 	} // foreach ($list as $row){
 		
 		//print_r($database_fields);exit;
 		
	 	$database_fields[] = 'mail_send';
 		
	 	
	 	/**
	 	 * make table name
	 	 */
	 	$table_name = 'post_form_'.$form_id.'_tab';
	 	
	 	
	 	/**
	 	 * create or alter post form table
	 	 */
	 	$this->wpcms->postFormTable($table_name, $database_fields);
	 	
	 	
	 	/**
 		 * page redirect to index
 		 */
 		$url_array = array(
 			$this->module_name, 'index',
 			'form_id', make_id($form_id),
 		);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
  		 		
 		
 	} // publishAction
 	
 	
 	
 	/**
 	 * create ini file and html code
 	 */
 	public function IniFileAndIniData(&$ini_header=null){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
		 * get list from data base and assign to view
		 */
 		$list = $this->db_model->getList($form_id);
 		//print_r($list);exit;
 		
 		/**
 		 * make form entry list
 		 */
 		$form_entry_list = array();
	 	foreach ($list as $row){
	 		
	 		/**
	 		 * set id
	 		 */
	 		$set_id = $row['id'];
	 		
	 		/**
	 		 * search array
	 		 */
	 		$search_array = array('form_id' => $form_id, 'set_id' => $set_id);
	 		
			/**
			 * get list from data base and assign to view
			 */
	 		$tmp_list = array();
	 		$form_set_entry_list = $this->db_model->getPreviewList($form_id, $set_id);
	 		
	 		foreach ($form_set_entry_list as $entry_set_row){
	 			if (!empty($entry_set_row['survey_id'])){
	 				unset($entry_set_row['options'],$entry_set_row['value']);
	 				$survey_info = $this->db_model->getSurveyInfo($entry_set_row['survey_id']);
	 				$entry_set_row['options'] 		= $survey_info['options'];
	 				$entry_set_row['value'] 		= $survey_info['value'];
	 				$entry_set_row['description'] 	= $survey_info['description'];
	 			}
	 			$entry_set_row['entry_type'] = $this->data_class->getEntryTypeId($entry_set_row['type']);
	 			$tmp_list['list'][] = $entry_set_row;
	 		}
	 		
	 		/**
	 		 * assign entry list
	 		 */
	 		$form_entry_list[$row['id']] = $tmp_list;
	 		
	 	} // foreach ($list as $row){
 		
 		//print_r($form_entry_list);exit;
 		
 		/**
 		 * build ini class object
 		 */
 		$ini_generator_class = new IniGeneratorClass();
 		
 		
 		$preview_html	= "";
 		$ini_data_list	= array();
 		$ini_header		= array();
 		$entry_list		= array();
 		foreach ($form_entry_list as $set_id => $set_list){
 			
 			$entry_list = $set_list['list'];
 			//print_r($entry_list);print "<br><br>";
 			
 			/**
 			 * data header for ini file
 			 */
 			$header_name = 'publish_form_'.$form_id.'_'.$set_id;
 			
 			if (!is_array($entry_list)) continue;
 			
 			/**
 			 * make ini header list
 			 */
 			$ini_header[] = $header_name;
 			
 			/**
 			 * ini data list
 			 */
 			foreach ($entry_list as $entry_row){
 				$ini_data_list[$header_name][$entry_row['name']] = $ini_generator_class->iniData($entry_row);
 			}
 			
 		} // foreach ($form_entry_list as $set_id => $set_list){
 		//print_r($ini_data_list);exit;
 		
 		
 		/**
 		 * create a new ini file
 		 */
 		$ini_file_name = 'formset_'.$form_id;
 		$ini_generator_class->newIniFile($ini_file_name);
 		
 		foreach ($ini_data_list as $ini_key=>$ini_val){
 			
 			/**
 			 * create new ini data header
 			 */
 			$ini_generator_class->iniDataHeader($ini_file_name, $ini_key);
 			
 			foreach ($ini_val as $ini_data){
 				
 				/**
 				 * write ini data
 				 */
 				$ini_generator_class->writeIniData($ini_file_name, $ini_data);
 				
 			}
 			
 		} // foreach ($ini_data as $ini_key=>$ini_val){
 		
 		//exit;
 		
 		
 	} // IniFileAndIniData
 	
 	
 
 
 } // form_setControllerClass
 
 
 ?>