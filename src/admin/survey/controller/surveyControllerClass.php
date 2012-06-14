<?php
/**
 * surveyControllerClass.php
 * 
 * @created on 2011/12/21
 * @package    ActiveIR
 * @subpackage 
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2011/12/21 - 19:25:13 fabien 
 * 
 *File content
     surveyControllerClass.php
 *     
 */
 
 
 class surveyControllerClass extends Configuration{
 	
 	
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
 	 * form class instance
 	 */
 	protected $form_class;

 	/**
 	 * numbers of rows instance
 	 */
 	protected $num_rows;
 	
 	/**
 	 * survey id instance
 	 */
 	protected $survey_id;
 	
 	
 	
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
 		$this->db_model = new surveyModelClass();
 		
 		/**
 		 * parse form ini
 		 */
 		$ini_parser = new IniParserClass();
 		$ini_array  = $ini_parser->iniParse(FORM_SET_INI);
 		
 		/**
 		 * form array for specific page
 		 */
 		$this->form_array = $ini_parser->getFormArray($ini_array, 'survey_entry_form');
 		
 		/**
 		 * form class object
 		 */
 		$this->form_class = new FormClass();
 		
 		/**
 		 * get survey url id
 		 */
 		$url_id = $this->getUrlParam('survey_id');
 		$this->survey_id = get_id($url_id);
 		
 		/**
 		 * save survey id in session and assign to view
 		 */
 		if ($this->survey_id)
 			$this->setAttribute('survey_id', $this->survey_id);
 			
 		$this->viewAssign('survey_id', $this->getAttribute('survey_id'));
 		
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
 			$this->num_rows = $this->wpcms->getNumRows('survey_tab');
 		
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
 		$total_rows = $this->wpcms->getTotal('survey_tab');
 		$this->viewAssign('total_rows', $total_rows);
 		
 		/**
 		 * make url for other page
 		 */
 		if (is_array($url_array))
 			$this->setAttribute('list_page_url', $this->makeUrl($url_array));
 		
 		
 		/**
 		 * get frist display order number
 		 */
 		$first_order = $this->wpcms->getDisplayOrder('survey_tab', 'first');
 		$this->viewAssign('first_order', $first_order);
 		
 		
 		/**
 		 * get last display order number
 		 */
 		$last_order = $this->wpcms->getDisplayOrder('survey_tab', 'last');
 		$this->viewAssign('last_order', $last_order);
 		
 			
 		$this->setDisplay('list');
 		
 	} // indexAction
 	
 	
 	/**
 	 * new form action controller
 	 */
 	public function newFormAction(){
 		
 		/**
 		 * default options fields
 		 */
 		$pd['options'] = array();
 		for ($i=0; $i<4; $i++){
 			$pd['options'][] = '';
 		}
 		
 		
 		/**
 		 * pd assign to view
 		 */
 		$this->viewAssign('pd', $pd);
 		
 		
 		/**
  		 * build form html and assign to view
  		 */
 		$form_html  = $this->form_class->form($this->form_array, 'survey_entry_form','form');
 		$this->viewAssign('form_html', $form_html);
 		
 		/**
	 	 * back to survey list page
	 	 */
	 	$url_array = array(	'survey' );
	  	$back_page_url = $this->makeUrl($url_array);
	  	$this->viewAssign('back', $back_page_url);
	  	
	  	
 		
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
 		
 		/**
 		 * post data check for error
 		 */
 		$err_msg = $this->form_class->errorCheck($this->form_array, $post);
 		
 		
 		/**
 		 * error check for options
 		 */
 		if (count($post['options']) < 2){
 			$err_msg[] = '少なくて二つ以上の項目を入力してください';
 		}
 		
 		if (count($post['options'])==0){
 			/**
	 		 * default options fields
	 		 */
	 		$post['options'] = array();
	 		for ($i=0; $i<4; $i++){
	 			$post['options'][] = '';
	 		}
	 	}
	 	
	 	/**
	 	 * assign post data to view
	 	 */
	 	$this->viewAssign('pd', $post);
 		
 		/**
 		 * assign error message to view
 		 */
 		$this->viewAssign('err',$err_msg);
 		
 		/**
  		 * build form html and assign to view
  		 */
 		$form_html  = $this->form_class->form($this->form_array, 'survey_entry_form','form');
 		$this->viewAssign('form_html', $form_html);
 		
 		
 		/**
	 	 * back to survey list page
	 	 */
	 	$url_array = array(	'survey' );
	  	$back_page_url = $this->makeUrl($url_array);
	  	$this->viewAssign('back', $back_page_url);
	  	
	  	
 		
 		$this->setDisplay('form');
 		
 	} // backFormAction
 	
 	
 	
 	
 	/**
 	 * form edit action controller
 	 */
 	public function editFormAction(){
 		
 		/**
 		 * get from id
 		 */
 		$survey_id = $this->getAttribute('survey_id');
 		//print_r($survey_id);
 		
 		/**
 		 * get form data and assign to view
 		 * and save in session as post data
 		 */
 		$form_data = $this->db_model->getFormData($survey_id);
 		
 		/**
 		 * make option data
 		 */
 		if ($form_data['options']){
 			
 			$option_expl = explode(':other:', $form_data['options']);
 			$form_data['options'] = explode('::', $option_expl[0]);
 			
 			if ($option_expl[1]){
	 			$other_expl = explode('::', $option_expl[1]);
	 			$form_data['other'] = 1;
	 			$form_data['checked'] = 1;
	 			$form_data['other_size'] = $other_expl[0];
	 			$form_data['other_maxlength'] = $other_expl[1];
	 			$form_data['other_check'] = $other_expl[2];
 			}else {
 				$form_data['other'] = 2;
 			}
 		
 		} // if ($form_data['options']){
 		
 		
 		/**
 		 * make value data
 		 */
 		$value = array();
 		if ($form_data['value']){
 			$value_expl = explode(':other:', $form_data['value']);
 			
 			foreach ($value_expl as $key=>$val){
 				if ($key >0 ){
 					$form_data['value'] = array();
 					$form_data['value'][] = $value_expl[0];
 					$form_data['value'][] = $value_expl[1];
 				}
 				
 				if ($key == 0) {
 					$form_data['value'] = $value_expl[0];
 				}
 			
 			} // foreach ($value_expl as $key=>$val){
 			
 		} // if ($form_entry_data['value']){
 		
 		
 		//print_r($form_data);
 		
 		$this->viewAssign('pd', $form_data);
 		$this->setAttribute('post', $form_data);
 		
 		/**
 		 * make form html
 		 */
 		$form_html  = $this->form_class->form($this->form_array, 'survey_entry_form', 'form');
 		$this->viewAssign('form_html', $form_html);
 		
 		/**
 		 * get list page url and assign as back url to view 
 		 */
 		$this->viewAssign('back', $this->getAttribute('list_page_url'));
 		
 		
 		
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
 		
 		/**
 		 * check for empty options
 		 */
 		$temp = array();
 		foreach ($post['options'] as $key=>$val){

 			if (empty($val))
 				unset($post['options'][$key]);
 			else 
 				$temp[] = $val;	
 		}
 		
 		$post['options'] = $temp;
 		
 		/**
 		 * save post data in session and assign to view
 		 */
 		if (!empty($post))
 			$this->setAttribute('post', $post);
 		$this->viewAssign('pd', $post);
 		
 		
 		
 		/**
 		 * post data check for error
 		 */
 		$err_msg = $this->form_class->errorCheck($this->form_array, $post);
 		
 		
 		/**
 		 * error check for options
 		 */
 		if (count($post['options']) < 2){
 			$err_msg[] = '少なくて二つ以上の項目を入力してください';
 		}
 		
 		/**
 		 * make back url
 		 */
 		if ($post['id']){
 			$url_array = array($this->module_name, 'editForm');
 		}else {
 			$url_array = array($this->module_name, 'backForm');
 		}
  		$back_url = $this->makeUrl($url_array);
	  		
  		$this->viewAssign('back', $back_url);
	  		
 		
 		/**
 		 * if error then display form else goes to confimation page
 		 */
 		if ($err_msg){
 			
 			/**
 			 * build form html and assign to view
 			 */
 			$form_html  = $this->form_class->form($this->form_array, 'survey_entry_form','conf');
 			$this->viewAssign('form_html', $form_html);
 			
 			/**
 			 * assign error message to view
 			 */
 			$this->viewAssign('err',$err_msg);
  			$this->setDisplay('form');
 		
 		}else {
 			
 			/**
 			 * build confirmation html and assign to view
 			 */
 			$conf_html  = $this->form_class->conf($this->form_array, 'survey_entry_form');
 			$this->viewAssign('conf_html', $conf_html);
 			
 			
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
 		$post = $this->getPost();
 		//print_r($post);exit;
 		
 		/**
 		 * check for empty value of options
 		 */
 		$temp = array();
 		foreach ($post['options'] as $key=>$val){

 			if (empty($val))
 				unset($post['options'][$key]);
 			else 
 				$temp[] = $val;	
 		}
 		
 		$post['options'] = $temp;
 		
 		/**
 		 * save post data in session and assign to view
 		 */
 		if (!empty($post))
 			$this->setAttribute('post', $post);
 		
 		
 		/**
 		 * post data check for error
 		 */
 		$err_msg = $this->form_class->errorCheck($this->form_array, $post);
 		
 		
 		/**
 		 * error check for options
 		 */
 		if (count($post['options']) < 2){
 			$err_msg[] = '少なくて二つ以上の項目を入力してください';
 		}
 		
 		
 		//print_r($err_msg);exit;
 		
 		/**
 		 * if error then display form else goes to confimation page
 		 */
 		if ($err_msg){
 			
 			/**
	 		 * page redirect to index
	 		 */
	 		if ($post['id'])
 				$url_array = array(	$this->module_name, 'backForm', 'survey_id', make_id($post['id']));
 			else 
 				$url_array = array(	$this->module_name, 'backForm',	);
	  		$url = $this->makeUrl($url_array);
	  		$this->redirect($url);
 			
 			exit;
 		
 		}else {
 			
 			
	 		/**
		 	 * make options data in string
		 	 */
		 	if (!empty($post['options']))
		 		$options = join('::', $post['options']);
		
		 	/**
		 	 * make other data and join with options
		 	 */
		 	if ($post['other'] == 1){
		 		$other = $post['other_size'].'::'.$post['other_maxlength'].'::'.$post['other_check'];
		 		$post['options'] = $options.':other:'.$other;
		 	}else {
		 		$post['options'] = $options;
		 	}
		 	
		 	/**
		 	 * unset all other datas
		 	 */
		 	unset($post['other'],$post['other_size'],$post['other_maxlength'],$post['other_check']);
		 	
		 	
		 	/**
		 	 * make value of post data
		 	 */
	 		if (is_array($post['value'])){
		 		$other = $post['value']['other'];
		 		unset($post['value']['other']);
		 		$values = join('::', $post['value']);
		 		$post['value'] = $values.':other:'.$other;
		 	}
		 		
		 	
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
	  		
 		}

 		
 	} // save
 	
 	
 	/**
 	 * non display action controller
 	 */
 	public function nonDisplayAction(){
 		
 		/**
 		 * get survey_id
 		 */
 		$survey_id = $this->getAttribute('survey_id');
 		
 		$this->wpcms->displayChange($survey_id, 0, 'survey_tab');		
 		
 		
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
 		 * get survey_id
 		 */
 		$survey_id = $this->getAttribute('survey_id');
 		
 		$this->wpcms->displayChange($survey_id, 1, 'survey_tab');		
 		
 		
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
 		 * get survey_id
 		 */
 		$survey_id = $this->getAttribute('survey_id');
 		
 		$this->wpcms->delete($survey_id, 'survey_tab');
 		
 		
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
 		 * get survey_id
 		 */
 		$survey_id = $this->getAttribute('survey_id');
 		
 		/**
 		 * get order
 		 */
 		$order = $this->getUrlParam('order');
 		
 		 		
 		switch ($order){
 			
 			case 'up':
 					$this->wpcms->moveUp($survey_id, 'survey_tab');	
 				break;
 				
 			case 'down':
 					$this->wpcms->moveDown($survey_id, 'survey_tab');
 				break;
 			
 		}
 		
 		
 		/**
 		 * page redirect to index
 		 */
 		$url_array = array($this->module_name);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
 		
 		
 	} // displayOrderAction
 	
 	
 	
 	
 	
 
 
 
 } // surveyControllerClass
 
 
 ?>