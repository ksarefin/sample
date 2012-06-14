<?php
/**
 * form_entryControllerClass.php
 * 
 * @created on 2011/12/15
 * @package    FORM
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2011/12/15 - 20:23:20 fabien 
 * 
 *File content
     form_entryControllerClass.php
 *     
 */
 
 
 class form_entryControllerClass extends Configuration{
 
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
 	 * form entry id instance
 	 */
 	protected $form_entry_id;
 	
 	/**
 	 * entry type instance
 	 */
 	protected $entry_type;
 	
 	/**
 	 * common form array instance
 	 */
 	protected $common_form_array;
 	
 	/**
 	 * input type instance
 	 */
 	protected $input_type;
 	
 	/**
 	 * ini parser instance
 	 */
 	protected $ini_parser;
 	
 	/**
 	 * ini array instance
 	 */
 	protected $ini_array;
 	
 	
 	
 	
 	
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
 		$this->db_model = new form_entryModelClass();
 		
 		/**
 		 * data class object
 		 */
 		$this->data_class = new DataClass();
 		
 		/**
 		 * get url entry type id 
 		 */
 		$url_id = $this->getUrlParam('type');
 		$this->entry_type = get_id($url_id);
 		
 		/**
 		 * save entry type in session
 		 */
 		if ($this->entry_type)
 			$this->setAttribute('entry_type', $this->entry_type);
 		$this->viewAssign('entry_type', $this->entry_type);
 			
 		/**
 		 * get input type name
 		 * and save in session
 		 * amd assign to view
 		 */
 		$this->input_type = $this->data_class->getInputTypeName($this->entry_type);
 		if ($this->input_type)	
 			$this->setAttribute('input_type', $this->input_type);
 			
 		
 		/**
 		 * parse form ini
 		 */
 		$this->ini_parser = new IniParserClass();
 		$this->ini_array  = $this->ini_parser->iniParse(FORM_SET_INI);
 		
 		if (!empty($this->input_type)){
	 		/**
	 		 * make ini entry name and save in session
	 		 */
	 		$ini_entry_name = 'entry_form_'.$this->input_type;
	 		$this->setAttribute('ini_entry_name', $ini_entry_name);
	 		
	 		/**
	 		 * form array for specific page
	 		 */
	 		$this->form_array = $this->ini_parser->getFormArray($this->ini_array, $ini_entry_name);
	 			 		
	 	} // if (!empty($this->input_type)){
	 	
	 	
	 	/**
	 	 * common form array 
	 	 */
	 	$this->common_form_array = $this->ini_parser->getFormArray($this->ini_array, 'entry_form_common');
 		
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
 		 * get form entry url id
 		 */
 		$url_id = $this->getUrlParam('form_entry_id');
 		$this->form_entry_id = get_id($url_id);
 		
 		/**
 		 * save set id in session and assign to view
 		 */
 		if ($this->form_entry_id)
 			$this->setAttribute('form_entry_id', $this->form_entry_id);
 			
 		$this->viewAssign('form_entry_id', $this->getAttribute('form_entry_id'));
 		
 		
 		/**
 		 * view assign options count
 		 */
 		$this->viewAssign('options_count', '1');
 		
 		/**
  		 * login check
  		 */
  		$this->login_class->checkLogin($this->access_name);
 		
 		/**
  		 * page title
  		 */
  		$this->viewAssign('page_title', '個別項目');
  		
  		
  		/**
  		 * js to the view
  		 */
  		$jquery_dir = WEB_DIR.COMMOM_DIR."/scripts/jquery/";
  		
  		$js[] = $jquery_dir."jquery.textarearesizer.js";
  		$js[] = $jquery_dir."textarearesizerinit.js";
  		$js[] = $jquery_dir."options.js";
  		
  		$tinymce_dir = WEB_DIR.COMMOM_DIR."/scripts/tinymce/";
  		
  		$js[] = $tinymce_dir."tiny_mce.js";
  		$js[] = $tinymce_dir."config.js";
  		$this->viewAssign('js', $js);
  		
 		
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
 		 * search array
 		 */
 		$search_array = array('form_id' => $form_id, 'set_id' => $set_id);
 		
 		/**
 		 * set page url array
 		 */
 		$url_array = array(
 			$this->module_name, $this->action_name,
 			'form_id',	make_id($form_id),
 			'set_id',	make_id($set_id),
 		);
 		
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
 			$this->num_rows = $this->wpcms->getNumRows('form_entry_tab', $search_array);
 		
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
			$link_url = $this->self_url.'/'.$this->action_name.'/form_id/'.make_id($form_id).'/set_id/'.make_id($set_id).'/limit/'.$limit;;
			$paging = $page_class->DisPage($link_url);
			$this->viewAssign("paging",$paging);
		}
 		
		/**
		 * get list from data base and assign to view
		 */
 		$list = $this->db_model->getList($form_id, $set_id, $limit, $offse);
 		$this->viewAssign('list', $list); 		
 		
 		/**
 		 * get total row number and assign to view 
 		 */
 		$total_rows = $this->wpcms->getTotal('form_entry_tab', $search_array);
 		$this->viewAssign('total_rows', $total_rows);
 		
 		/**
 		 * make url for other page
 		 */
 		if (is_array($url_array))
 			$this->setAttribute('list_page_url', $this->makeUrl($url_array));
 		
 			
 		/**
 		 * get frist display order number
 		 */
 		$first_order = $this->wpcms->getDisplayOrder('form_entry_tab', 'first', $search_array);
 		$this->viewAssign('first_order', $first_order);
 		
 		
 		/**
 		 * get last display order number
 		 */
 		$last_order = $this->wpcms->getDisplayOrder('form_entry_tab', 'last', $search_array);
 		$this->viewAssign('last_order', $last_order);
 		
 			
 		$this->setDisplay('list'); 		
 		
 		
 	} // indexAction
 	
 	
 	
 	/**
 	 * new form action controller
 	 */
 	public function newFormAction(){
 		
 		/**
 		 * input type
 		 */
 		$pd['type'] = $this->input_type;
 		
 		/**
		 * search array
		 */
		$search_array = array('form_id' => $form_id, 'set_id' => $set_id, 'type' => $this->input_type);
 					
		/**
		 * count field name and make new field name
		 */
		$count = $this->wpcms->getNumRows('form_entry_tab',$search_array);
 		$pd['name'] = $this->input_type.'_'.($count+1);
 		
 		/**
 		 * default options fields
 		 */
 		$pd['options'] = array();
 		for ($i=0; $i<2; $i++){
 			$pd['options'][] = '';
 		}
 		
 		
 		/**
 		 * pd assign to view
 		 */
 		$this->viewAssign('pd', $pd);
 		
 		/**
 		 * get ini entry name
 		 */
 		$ini_entry_name = $this->getAttribute('ini_entry_name');
 		
 		/**
  		 * get form html and assign to view
  		 */
 		$form_html  = $this->form_class->form($this->form_array, $ini_entry_name, 'form');
 		
 		
 		/**
		 * get yes no fields form array and form html
		 */
 		if ($this->input_type == ynradio){
 			$form_array = $this->ini_parser->getFormArray($this->ini_array, 'entry_form_ynfields');
			$form_html .= $this->form_class->form($form_array, 'entry_form_ynfields', 'form');
		}
		
 		$this->viewAssign('form_html', $form_html);
 		
 		/**
 		 * get common form html and assign to view 
 		 */
 		$common_html = $this->form_class->form($this->common_form_array, 'entry_form_common', 'form');
 		$this->viewAssign('common_html', $common_html);
 		
 		
 		/**
	 	 * page redirect to form set index
	 	 */
	 	$url_array = array(
	 		'form_set', 'index',
	 		'form_id', 	make_id($form_id),
	 	);
	  	$list_page_url = $this->makeUrl($url_array);
	  	$this->viewAssign('list_page_url', $list_page_url);
 		
 		
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
 		//print_r($post);
 		
 		/**
 		 * get form array
 		 */
 		$form_array = $this->form_array;
 		
 		/**
 		 * get ini entry name
 		 */
 		$ini_entry_name = $this->getAttribute('ini_entry_name');
 		
 		/**
  		 * make form html and assign to view
  		 */
 		$form_html .= $this->form_class->form($this->form_array, $ini_entry_name, 'form');
 		
 		$input_array = array();
 		if ( $post['type'] == 'ynradio' ){
 			
 			foreach ($post as $pd_key=>$pd_val){
 				
 				if (eregi('_[0-9]_', $pd_key)){
 					
 					$expl = explode('_', $pd_key);
 					$this->viewAssign('options_count', $expl[1]);
 					
 					$input_name = $expl[0].'_'.$expl[1];
 					
 					if (!in_array($input_name, $input_array)){
 						
 						//print_r($pd_key);print ",,,,,<br>";
 						
 						array_push($input_array, $input_name);
 						
	 					/**
				 		 * make ini entry name and save in session
				 		 */
				 		$new_ini_entry_name = 'entry_form_'.$expl[0];
				 		
				 		/**
				 		 * form array for specific page
				 		 */
				 		$get_form_array = $this->ini_parser->getFormArray($this->ini_array, $new_ini_entry_name);
				 		//print_r($form_array);print "<br><br>";
				 		
	 					$new_form_array = array();
				 		 foreach ($get_form_array as $key=>$val){
				 		 	
				 		 	$new_key = $expl[0].'_'.$expl[1].'_'.$key;
				 		 	$new_form_array[$new_key] = $val; 
				 		 	
				 		 }
				 		 
				 		 if (is_array($new_form_array))
				 			$form_array = array_merge($form_array,$new_form_array);
				 		 
				 		 //$form_html .= '<div class="form_l"></div><div class="form_r">';
				 		 $form_html .= '</table>'."\n\n".'<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblAdm">'."\n".'<tr>';
				 		 $form_html .= $this->form_class->form($new_form_array, 'ynradio_'.$new_ini_entry_name, 'form', $expl[1]);
				 		 $form_html .= '</div>'."\n".'</td>'."\n".'</tr>';
				 	
				 		 
 					} // if (!in_array($input_name, $input_array)){
 					
 				} // if (eregi('_[0-9]_', $pd_key)){
 				
 			} // foreach ($post as $pd_key=>$pd_val){
 			
 			/**
			 * get yes no fields form array and form html
			 */
			$ynfields_form_array = $this->ini_parser->getFormArray($this->ini_array, 'entry_form_ynfields');
			$form_html .= $this->form_class->form($ynfields_form_array, 'entry_form_ynfields', 'form');
 			
 		} // if ( $post['type'] == 'ynradio' ){
 		
 		
 		
 		/**
 		 * assign from html and option count
 		 */
 		$this->viewAssign('form_html', $form_html);
 		
 		
 		/**
 		 * get common form html and assign to view 
 		 */
 		$common_html = $this->form_class->form($this->common_form_array, 'entry_form_common', 'conf');
 		$this->viewAssign('common_html', $common_html);
 		
 		/**
 		 * post data check for error
 		 */
 		$err_msg = $this->form_class->errorCheck($form_array, $post);
 		
 		/**
 		 * options check
 		 */
 		$option_count = 0;
 		if ($post['options']){
 			foreach ($post['options'] as $row){
 				if (!empty($row)) $option_count ++;
 			}
 		}
 		
 		if (!empty($post['options']) && $option_count < 2){
 			$err_msg[] = "選択肢を最低でも2項目以上に記入してください。";
 		}
 		
 		/**
 		 * assign error message to view
 		 */
 		$this->viewAssign('err',$err_msg);
 		
 		
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
 		 * get set id
 		 */
 		$set_id = $this->getAttribute('set_id');
 		
 		/**
 		 * get form entry id
 		 */
 		$form_entry_id = $this->getAttribute('form_entry_id');
 		
 		/**
 		 * get form entry data and assign to view
 		 * and save in session as post data
 		 */
 		$form_entry_data = $this->db_model->getFormData($form_entry_id);
 		
 		/**
 		 * make yes no fields data
 		 */
 		$ynfields = array();
 		if (!empty($form_entry_data['ynfields'])){

 			$fields = explode('|yn|', $form_entry_data['ynfields']);
 			
 			foreach ($fields as $row){
 				
 				$field_expl = explode('_', $row); 
 				$expl = explode(':=:', $row);
 				
 				$field_value = $expl[1];
 				
 				if (preg_match('/_other/', $expl[0])){
 					
 					$other_expl = explode('::', $field_value);
	 				$ynfields[$field_expl[1]][$expl[0]] = 1;
	 				$ynfields[$field_expl[1]][$expl[0].'_size'] = $other_expl[0];
	 				$ynfields[$field_expl[1]][$expl[0].'_maxlength'] = $other_expl[1];
	 				$ynfields[$field_expl[1]][$expl[0].'_check'] = $other_expl[2];
	 				
 				}else {
 				
	 				if (preg_match('/;opt;/', $expl[1])){
	 					$field_value = explode(';opt;', $expl[1]);
	 				}
	 				
	 				$ynfields[$field_expl[1]][$expl[0]] = $field_value;
 				}
 				
 				
 			} // foreach ($expl_fields as $row){
 			
 			unset($form_entry_data['ynfields']);
 			
 		} // if (!empty($form_entry_data['ynfields'])){
 		
 		/**
 		 * sort yes no field as input sequence
 		 */
 		ksort($ynfields);
 		//print_r($ynfields);
 		
 		/**
 		 * merge yes no fields to form field data
 		 */
 		foreach ($ynfields as $yn_rows){
 			
 			$form_entry_data = array_merge($form_entry_data, $yn_rows);
 		}
 		
 		/**
 		 * make field label data
 		 */
 		if ($form_entry_data['field_labels']){
 			
 			$explode = explode(';:;', $form_entry_data['field_labels']);
 			
 			foreach ($explode as $key=>$val){
 				$form_entry_data['field_labels'.($key+1)] = $val;
 			}
 		}
 		
 		
 		/**
 		 * make exemple data
 		 */
 		if ($form_entry_data['exemple']){
 			
 			$explode = explode(';:;', $form_entry_data['exemple']);
 			
 			foreach ($explode as $key=>$val){
 				
 				if ($key >0 ){
 					$form_entry_data['exemple'.$key] = $val;
 				}
 				
 				if ($key == 0) {
 					$form_entry_data['exemple'] = $val;
 				}
 				
 			}
 		}
 		

 		/**
 		 * make description data
 		 */
 		if ($form_entry_data['description']){
 			
 			$explode = explode(';:;', $form_entry_data['description']);
 			
 			foreach ($explode as $key=>$val){
 				if ($key >0 ){
 					$form_entry_data['description'.$key] = $val;
 				}
 				
 				if ($key == 0) {
 					$form_entry_data['description'] = $val;
 				}
 			}
 		}
 		
 		 		
 		/**
 		 * make option data
 		 */
 		if ($form_entry_data['options']){
 			
 			$option_expl = explode(':other:', $form_entry_data['options']);
 			$form_entry_data['options'] = explode('::', $option_expl[0]);
 			
 			if ($option_expl[1]){
	 			$other_expl = explode('::', $option_expl[1]);
	 			$form_entry_data['other'] = 1;
	 			$form_entry_data['other_size'] = $other_expl[0];
	 			$form_entry_data['other_maxlength'] = $other_expl[1];
	 			$form_entry_data['other_check'] = $other_expl[2];
 			}else {
 				$form_entry_data['other'] = 2;
 			}
 		}
 		
 		
 		/**
 		 * make value data
 		 */
 		$value = array();
 		if ($form_entry_data['value']){
 			$value_expl = explode(':other:', $form_entry_data['value']);
 			
 			foreach ($value_expl as $key=>$val){
 				if ($key >0 ){
 					$form_entry_data['value'] = array();
 					$form_entry_data['value'][] = $value_expl[0];
 					$form_entry_data['value'][] = $value_expl[1];
 				}
 				
 				if ($key == 0) {
 					$form_entry_data['value'] = $value_expl[0];
 				}
 			
 			} // foreach ($value_expl as $key=>$val){
 			
 		} // if ($form_entry_data['value']){
 		
 		
 		//print_r($form_entry_data);
 		
 		/**
 		 * form entry data save in session and assign to view
 		 */
 		$this->viewAssign('pd', $form_entry_data);
 		$this->setAttribute('post', $form_entry_data);
 		
 		/**
 		 * get ini entry name
 		 */
 		$ini_entry_name = $this->getAttribute('ini_entry_name');
 		
 		/**
  		 * get form html and assign to view
  		 */
 		$form_html  = $this->form_class->form($this->form_array, $ini_entry_name, 'conf');
 		
 		
 		$input_array = array();
 		if ( $form_entry_data['type'] == 'ynradio' ){
 			
 			foreach ($form_entry_data as $pd_key=>$pd_val){
 				
 				if (eregi('_[0-9]_', $pd_key)){
 					
 					$expl = explode('_', $pd_key);
 					$this->viewAssign('options_count', $expl[1]);
 					
 					$input_name = $expl[0].'_'.$expl[1];
 					
 					if (!in_array($input_name, $input_array)){
 						
 						//print_r($pd_key);print ",,,,,<br>";
 						
 						array_push($input_array, $input_name);
 						
	 					/**
				 		 * make ini entry name and save in session
				 		 */
				 		$new_ini_entry_name = 'entry_form_'.$expl[0];
				 		
				 		/**
				 		 * form array for specific page
				 		 */
				 		$get_form_array = $this->ini_parser->getFormArray($this->ini_array, $new_ini_entry_name);
				 		//print_r($this->ini_array);print "<br><br>";
				 		
	 					$new_form_array = array();
				 		 foreach ($get_form_array as $key=>$val){
				 		 	
				 		 	$new_key = $expl[0].'_'.$expl[1].'_'.$key;
				 		 	$new_form_array[$new_key] = $val;
				 		 	
				 		 }
				 		 
				 		  
				 		 $form_html .= '</table>'."\n\n".'<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblAdm">'."\n";
				 		 $form_html .= $this->form_class->form($new_form_array, 'ynradio_'.$new_ini_entry_name, 'form', $expl[1]);
				 	
				 		 
 					} // if (!in_array($input_name, $input_array)){
 					
 				} // if (eregi('_[0-9]_', $pd_key)){
 				
 			} // foreach ($post as $pd_key=>$pd_val){
 			
 			/**
			 * get yes no fields form array and form html
			 */
			$ynfields_form_array = $this->ini_parser->getFormArray($this->ini_array, 'entry_form_ynfields');
			$form_html .= $this->form_class->form($ynfields_form_array, 'entry_form_ynfields', 'form');
 			
 		} // if ( $post['type'] == 'ynradio' ){
 		
 		
 		
 		/**
 		 * assign from html and option count
 		 */
 		$this->viewAssign('form_html', $form_html);
 		
 		
 		
 		
 		
 		$this->viewAssign('form_html', $form_html);
 		
 		/**
 		 * get common form html and assign to view 
 		 */
 		$common_html = $this->form_class->form($this->common_form_array, 'entry_form_common', 'conf');
 		$this->viewAssign('common_html', $common_html);
 		
 		/**
	 	 * page redirect to form set index
	 	 */
	 	$url_array = array(
	 		'form_set', 'index',
	 		'form_id', 	make_id($form_id),
	 	);
	  	$list_page_url = $this->makeUrl($url_array);
	  	$this->viewAssign('list_page_url', $list_page_url);
 		
 		
 		
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
 			//$form_html  = $this->form_class->form($this->form_array, 'entry_form','conf');
 			//$this->viewAssign('form_html', $form_html);
 			
 			/**
	 		 * get common form html and assign to view 
	 		 */
	 		//$common_html = $this->form_class->form($this->common_form_array, 'entry_form_common', 'conf');
	 		//$this->viewAssign('common_html', $common_html);
	 		
 			/**
 			 * assign error message to view
 			 */
 			/*$this->viewAssign('err',$err_msg);
  			$this->setDisplay('form');
 		
 		}else {
 			*/
 			/**
 			 * build confirmation html and assign to view
 			 */
 			//$conf_html  = $this->form_class->conf($this->form_array, 'entry_form');
 			//$this->viewAssign('conf_html', $conf_html);
 			
 			/**
	 		 * get common conf html and assign to view 
	 		 */
	 		//$common_conf_html = $this->form_class->conf($this->common_form_array, 'entry_form_common');
	 		//$this->viewAssign('common_conf_html', $common_conf_html);
 			
 			
 			//$this->setDisplay('conf');
 		//}
 		
 		
 		
 	} // formConfAction
 	
 	
 	
 	/**
 	 * save action controller
 	 */
 	public function saveAction(){

 		/**
 		 * get post data
 		 */
 		$post = $this->getPost();
 		
 		/**
 		 * save post data in session and assign to view
 		 */
 		if (!empty($post))
 			$this->setAttribute('post', $post);
 		$this->viewAssign('pd', $post);
 		
 		
 		/**
	 	 * get form id
	 	 */
	 	$form_id = $this->getAttribute('form_id');
	 	if (!empty($form_id) && is_numeric($form_id))
	 		$post['form_id'] = $form_id;
	 	
	 	/**
	 	 * get set id
	 	 */
	 	$set_id = $this->getAttribute('set_id');
	 	if (!empty($set_id) && is_numeric($set_id))
	 		$post['set_id'] = $set_id;
	 		
	 	/**
	 	 * get form array
	 	 */
	 	$form_array = $this->form_array;
	 	
	 	/**
	 	 * sort post data by key 
	 	 */
	 	ksort($post);

	 		
	 	$input_array = array();
 		if ( $post['type'] == 'ynradio' ){
 			
 			foreach ($post as $pd_key=>$pd_val){
 				
 				if (eregi('_[0-9]_', $pd_key)){
 					
 					$expl = explode('_', $pd_key);
 					
 					$input_name = $expl[0].'_'.$expl[1];
 					
 					if (!in_array($input_name, $input_array)){
 						
 						//print_r($pd_key);print ",,,,,<br>";
 						
 						array_push($input_array, $input_name);
 						
 						/**
				 		 * make ini entry name and save in session
				 		 */
				 		$new_ini_entry_name = 'entry_form_'.$expl[0];
	 					
				 		/**
				 		 * form array for specific page
				 		 */
				 		$get_form_array = $this->ini_parser->getFormArray($this->ini_array, $new_ini_entry_name);
				 		
				 		
 						$new_form_array = array();
				 		 foreach ($get_form_array as $key=>$val){
				 		 	
				 		 	$new_key = $expl[0].'_'.$expl[1].'_'.$key;
				 		 	$new_form_array[$new_key] = $val; 
				 		 	
				 		 }
				 		
				 		if (is_array($new_form_array))
				 			$form_array = array_merge($form_array,$new_form_array);

				 			
				 		 
 					} // if (!in_array($input_name, $input_array)){
 					
 				} // if (eregi('_[0-9]_', $pd_key)){
 				
 			} // foreach ($post as $pd_key=>$pd_val){
 			
 		} // if ( $post['type'] == 'ynradio' ){
 		
 		//print_r($post);exit;
 		
	 			
 		/**
 		 * post data check for error
 		 */
 		$err_msg = $this->form_class->errorCheck($form_array, $post);
 		//print_r($err_msg);exit;
 		
 		/**
 		 * options check
 		 */
 		$option_count = 0;
 		if ($post['options']){
 			foreach ($post['options'] as $row){
 				if (!empty($row)) $option_count ++;
 			}
 		}
 		
 		if (!empty($post['options']) && $option_count < 2){
 			$err_msg[] = "選択肢を最低でも2項目以上に記入してください。";
 		}
 		
 		
 		/**
 		 * if error then redirect to back page else goes to confimation page
 		 */
 		if ($err_msg){
 			
 			/**
	 		 * page redirect to index
	 		 */
	 		$url_array = array(
	 			$this->module_name, 'backForm',
	 			'form_id', 	make_id($form_id),
	 			'set_id',	make_id($set_id),
	 			'type',	make_id($this->entry_type),	 		
	 		);
	  		$url = $this->makeUrl($url_array);
	  		$this->redirect($url);
 			//$this->setDisplay('form');
 			exit;
 		
 		}else {
 			
 			
 			//print_r($post);exit;
 			
 			
 			$ynfields = array();
 			$input_field_array = array();
 			if ( $post['type'] == 'ynradio' ){
	 			
	 			foreach ($post as $pd_key=>$pd_val){
	 				
	 				if (eregi('_[0-9]_', $pd_key)){
	 					
	 					$expl = explode('_', $pd_key);
	 					
	 					$input_name = $expl[0].'_'.$expl[1];
	 					
	 					
	 					if (preg_match('/'.$input_name.'_other'.'/', $pd_key)){
	 								
	 							//print_r($post[$input_name.'_other_check']);
	 							if ($post[$input_name.'_other'] == 1){
	 								$ynfields[] = $input_name.'_other'.':=:'.$post[$input_name.'_other_size'].'::'.$post[$input_name.'_other_maxlength'].'::'.$post[$input_name.'_other_check'];
	 							}
	 							unset($post[$input_name.'_other'], $post[$input_name.'_other_size'], $post[$input_name.'_other_maxlength'], $post[$input_name.'_other_check']);	 								
	 					}elseif (preg_match('/'.$input_name.'/', $pd_key)){
	 						
	 						if (is_array($pd_val)){
		 							
			 						$pd_val = join(';opt;', $pd_val);
		 						}
		 						
		 						$ynfields[] = $expl[0].'_'.$expl[1].'_'.$expl[2].':=:'.$pd_val;
	 							
	 						
	 						unset($post[$pd_key]);
	 						
	 					} // if (preg_match('/'.$input_name.'/', $pd_key)){
	 					
	 				} // if (eregi('_[0-9]_', $pd_key)){
	 				
	 			} // foreach ($post as $pd_key=>$pd_val){
	 			
	 		} // if ( $post['type'] == 'ynradio' ){

	 		$post['ynfields'] = join('|yn|', $ynfields);
	 		
 			//print_r($ynfields);exit;
 			
 			
 			/**
 			 * unset post data preview
 			 */
 			unset($post['preview']);
 			
 			/**
 			 * make field lable data and unset all lable
 			 */
 			$tmp_label = array();
 			foreach ($post as $p_key => $p_row){
 				if (preg_match('/field_labels[1-9]/', $p_key)){
 					$tmp_label[] = $p_row;
 					unset($post[$p_key]);
 				}
 			}
 			
 			$post['field_labels'] = join(';:;', $tmp_label);
 			
 			/**
 			 * make example data and unset all example
 			 */
 			$tmp_exp = array();
 			foreach ($post as $p_key => $p_row){
 				if (preg_match('/exemple/', $p_key)){
 					$tmp_exp[] = $p_row;
 					unset($post[$p_key]); 
 				}
 			}
 			
 			$post['exemple'] = join(';:;', $tmp_exp);
 			
 			
 			/**
 			 * make description data and unset all description
 			 */
 			$tmp_dis = array();
 			foreach ($post as $p_key => $p_row){
 				if (preg_match('/description/', $p_key)){
 					$tmp_dis[] = $p_row;
 					unset($post[$p_key]); 
 				}
 			}
 			
 			$post['description'] = join(';:;', $tmp_dis);
 			
 			
 			/**
	 		 * check for empty value of options
	 		 */
	 		$temp = array();
	 		if (is_array($post['options'])){
		 		foreach ( $post['options'] as $key=>$val){
		
		 			if (empty($val))
		 				unset($post['options'][$key]);
		 			else 
		 				$temp[] = $val;	
		 		}
		 		
		 		$post['options'] = $temp;
	 		}
	 		
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
	 		 * make value of post data
	 		 */
	 		if (is_array($post['value'])){
	 			$other = $post['value']['other'];
	 			unset($post['value']['other']);
	 			$values = join('::', $post['value']);
	 			$post['value'] = $values.':other:'.$other;
	 		}
	 		
	 		/**
	 		 * unset all other datas
	 		 */
	 		unset($post['other'],$post['other_size'],$post['other_maxlength'],$post['other_check']);
	 		
	 		//print_r($post);exit;
	 	
 			/**
	 		 * save post data
	 		 */
	 		$this->db_model->save($post);
	 		
	 		/**
	 		 * page redirect to index
	 		 */
	 		$url_array = array(
	 			'form_set', 'index',
	 			'form_id', 	make_id($form_id),
	 			//'set_id',	make_id($set_id),
	 		);
	  		$url = $this->makeUrl($url_array);
	  		$this->redirect($url);
 		}
 		
 	} // save
 	
 	
 	
 	/**
 	 * preview action controller
 	 */
 	public function previewAction(){
 		
 		/**
 		 * get post data and assign to view
 		 */
 		$post = $_REQUEST['pd'];
 		
 		if ($post['other'] == 1)
 			$post['other'] = $post['other_size'].'::'.$post['other_maxlength'].'::'.$post['other_check'];
 		else 	
 			$post['other'] = '';
 			
 		/**
	 	 * unset all other data and set post other data
	 	 */
	 	unset($post['other_size'],$post['other_maxlength'],$post['other_check']);
	 	
	 	if ($post['value'][0] == 1){
	 		$post['checked'] = $post['selected'] = $post['value']['other'];
	 	}elseif ($post['value'][0] == 2){
	 		$post['selected_name'] = $post['value']['other'];
	 	}elseif ($post['value'][0] == 3){
	 		$post['selected_name'] = '　';
	 	}
	 	
	 	
 		/**
 		 * generate preview html
 		 */
	 	if ($post['type'] == 'ynradio' || $post['type'] == 'image' || $post['type'] == 'pdf' || $post['type'] == 'password'){
	 		
	 		echo '<tr><th scope="row" width="200">'.$post['label'].'</th><td><p>この項目はプレビューできません。</p></td></tr>';
	 		
	 	}else {
	 		
	 		$preview['preview'] = $post; 
	 		$preview_html  = $this->form_class->form($preview, 'perview_form_'.$this->form_id.'_'.$this->set_id, 'form');
	 		echo $preview_html;
	 		
	 	}
 		//$this->viewAssign('preview_html', $preview_html);

 		
 		
 	} // previewAction
 	
 	
 	
 	
 	/**
 	 * yn field html action controller
 	 */
 	public function ynFieldHtmlAction(){
 		
 		/**
 		 * get type
 		 */
 		$url_id = $this->getUrlParam('type');
 		$type = get_id($url_id);
 		
 		if (empty($type)) return;
 		
 		/**
 		 * get option count
 		 */
 		$get_count = $this->getUrlParam('count');
 		
 		$get_type_name = $this->data_class->getYnFieldType($type);
 		
 		$ini_entry_name = 'entry_form_'.$get_type_name;
 		
 		/**
 		 * default options fields
 		 */
 		$options_name = $get_type_name.'_'.$get_count.'_options';
 		//$pd['options'] = array();
 		for ($i=0; $i<2; $i++){
 			$pd[$options_name][] = '';
 		}
 		
 		$new_form_array = array();
 		 foreach ($this->form_array as $key=>$val){
 		 	
 		 	$new_key = $get_type_name.'_'.$get_count.'_'.$key;
 		 	$new_form_array[$new_key] = $val; 
 		 	
 		 }
 		 
 		echo "<script language = 'javascript' src='/wpcms/wpcms/common/scripts/jquery/options.js'></script>";
 		
 		/**
 		 * pd assign to view
 		 */
 		$this->viewAssign('pd', $pd);
 		
 		/**
  		 * get form html and assign to view
  		 */
 		$form_html = '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblAdm" id="added_filed_'.$get_count.'">';
 		$form_html .= $this->form_class->form($new_form_array, 'ynradio_'.$ini_entry_name, 'form', $get_count, 'yes_no_ajax');
 		$form_html .= '<tr><th colspan="2"><input type="button" name="field_remove" value="この項目を削除（'.$get_type_name.'_'.$get_count.'）" id="fieldRemove_'.$get_count.'" onclick="removeField(\'added_filed_'.$get_count.':\');"></th></tr>';
 		$form_html .= '</table>';
 		
 		echo $form_html;
	 	
 		
 		
 	} // ynFieldHtmlAction
 	

 	
 	
 	
 	/**
 	 * survey add action controller
 	 */
 	public function surveyAddAction(){ 

 		$post = array();
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		if (!empty($form_id) && is_numeric($form_id))
 			$post['form_id'] = $form_id;
 		
 		/**
 		 * get set id
 		 */
 		$set_id = $this->getAttribute('set_id');
 		if (!empty($set_id) && is_numeric($set_id))
 			$post['set_id'] = $set_id;
 		
 		/**
 		 * get survey id
 		 */
 		$survey_id = $this->getUrlParam('survey_id');
 		if (!empty($survey_id) && is_numeric($survey_id))
 			$post['survey_id'] = $survey_id;
 		
 		
 		/**
 		 * get survey information
 		 */
 		$survey_info = $this->db_model->getSurveyInfo($post['survey_id']);
 		$post['label'] = $survey_info['name'];
 		$post['name'] = 'svid_'.$survey_info['id'].'_fid_'.$post['form_id'].'_sid_'.$post['set_id'];
 		$post['type'] = $survey_info['type'];
 		
 		
 		//print_r($post);exit;
 		
 		/**
 		 * save post data
 		 */
 		$this->db_model->save($post);
 		
 		/**
 		 * page redirect to index
 		 */
 		$url_array = array(
 			'form_set', 'index',
 			'form_id', 	make_id($form_id),
 			//'set_id',	make_id($set_id),
 		);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
 		
 	} // surveyAddAction
 	
 	
 	
 	/**
 	 * form option add action controller
 	 */
 	public function optionAddAction(){
 		
 		/**
 		 * get type
 		 */
 		$type = $this->getUrlParam('type');
 		
 		
 		/**
 		 * make post data
 		 */
 		switch ($type){
 			
 			case 'name':
 					
 					/**
			 		 * search array
			 		 */
			 		$search_array = array('form_id' => $form_id, 'set_id' => $set_id, 'type' => 'wp_name');
 					
			 		/**
			 		 * get counted value of image field
			 		 */
			 		$count = $this->wpcms->getNumRows('form_entry_tab',$search_array);
			 		
 					$post = array(
	 					'label'	=> '氏名_'.($count+1),
	 					'type'	=> 'wp_name',
	 					'name'	=> 'name_'.($count+1),
 					);
 				break;
 				
 			case 'tel':
 				
 					/**
			 		 * search array
			 		 */
			 		$search_array = array('form_id' => $form_id, 'set_id' => $set_id, 'type' => 'wp_tel');
 					
			 		/**
			 		 * get counted value of image field
			 		 */
			 		$count = $this->wpcms->getNumRows('form_entry_tab',$search_array);
			 		
 					$post = array(
	 					'label'	=> '電話番号_'.($count+1),
	 					'type'	=> 'wp_tel',
	 					'name'	=> 'tel_'.($count+1),
 					);
 				break;	
 				
 			case 'mail':
 				
 					/**
			 		 * search array
			 		 */
			 		$search_array = array('form_id' => $form_id, 'set_id' => $set_id, 'type' => 'wp_mail');
 					
			 		/**
			 		 * get counted value of image field
			 		 */
			 		$count = $this->wpcms->getNumRows('form_entry_tab',$search_array);
			 		
 					$post = array(
	 					'label'	=> 'メール_'.($count+1),
	 					'type'	=> 'wp_mail',
	 					'name'	=> 'mail_'.($count+1),
 					);
 				break;
 				
 			case 'birthday':
 				
 					/**
			 		 * search array
			 		 */
			 		$search_array = array('form_id' => $form_id, 'set_id' => $set_id, 'type' => 'wp_birthday');
 					
			 		/**
			 		 * get counted value of image field
			 		 */
			 		$count = $this->wpcms->getNumRows('form_entry_tab',$search_array);
			 		
 					$post = array(
	 					'label'	=> '誕生日_'.($count+1),
	 					'type'	=> 'wp_birthday',
	 					'name'	=> 'birthdat_'.($count+1),
 					);
 				break;
 			
 			case 'address':
 				
 					/**
			 		 * search array
			 		 */
			 		$search_array = array('form_id' => $form_id, 'set_id' => $set_id, 'type' => 'ajax_zip');
 					
			 		/**
			 		 * get counted value of image field
			 		 */
			 		$count = $this->wpcms->getNumRows('form_entry_tab',$search_array);
			 		
 					$post = array(
	 					'label'	=> '住所_'.($count+1),
	 					'type'	=> 'ajax_zip',
	 					'name'	=> 'address_'.($count+1),
 					);
 				break;
 				
 			case 'image':
 				
 					/**
			 		 * search array
			 		 */
			 		$search_array = array('form_id' => $form_id, 'set_id' => $set_id, 'type' => 'wp_image');
 					
			 		/**
			 		 * get counted value of image field
			 		 */
			 		$count = $this->wpcms->getNumRows('form_entry_tab',$search_array);
 					
 					$post = array(
	 					'label'	=> '画像_'.($count+1),
	 					'type'	=> 'wp_image',
	 					'name'	=> 'image_'.($count+1),
 					);
 				break;	
 			
 			case 'pdf':
 				
 					/**
			 		 * search array
			 		 */
			 		$search_array = array('form_id' => $form_id, 'set_id' => $set_id, 'type' => 'wp_pdf');
 					
			 		/**
			 		 * get counted value of image field
			 		 */
			 		$count = $this->wpcms->getNumRows('form_entry_tab',$search_array);
 					
			 		$post = array(
	 					'label'	=> 'PDF_'.($count+1),
	 					'type'	=> 'wp_pdf',
	 					'name'	=> 'pdf_'.($count+1),
 					);
 				break;
 			
 		} // switch ($type){
 		

 		/**
 		 * entry type
 		 */
 		$post['entry_type'] = 'wp_entry';
 		
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		if (!empty($form_id) && is_numeric($form_id))
 			$post['form_id'] = $form_id;
 		
 		/**
 		 * get set id
 		 */
 		$set_id = $this->getAttribute('set_id');
 		if (!empty($set_id) && is_numeric($set_id))
 			$post['set_id'] = $set_id;
 			
 		
 		//print_r($post);exit;
 		
 		/**
 		 * save post data
 		 */
 		$this->db_model->save($post);
 		
 		/**
 		 * page redirect to index
 		 */
 		$url_array = array(
 			'form_set', 'index',
 			'form_id', 	make_id($form_id),
 			//'set_id',	make_id($set_id),
 		);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
  		
  		
 		
 	} // optionAddAction
 	
 	
 	
 	
 	
 	
 	/**
 	 * require action controller
 	 */
 	public function requireAction(){
 		
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get set_id
 		 */
 		$set_id = $this->getAttribute('set_id');
 		
 		/**
 		 * get form entry id
 		 */
 		$form_entry_id = $this->getAttribute('form_entry_id');
 		
 		/**
 		 * set as non display
 		 */
 		$this->wpcms->requireChange($form_entry_id, 1, 'form_entry_tab');		
 		
 		/**
 		 * page redirect list
 		 */
 		$url_array = array(
 			'form_set', 'index',
 			'form_id',	make_id($form_id),
 			//'set_id',	make_id($set_id),
 		);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
  		
 	} // requireAction
 	
 	
 	
 	
 	/**
 	 * notRequire action controller
 	 */
 	public function notRequireAction(){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get set_id
 		 */
 		$set_id = $this->getAttribute('set_id');
 		
 		/**
 		 * get form entry id
 		 */
 		$form_entry_id = $this->getAttribute('form_entry_id');
 		
 		/**
 		 * set as non display
 		 */
 		$this->wpcms->requireChange($form_entry_id, 0, 'form_entry_tab');		
 		
 		/**
 		 * page redirect list
 		 */
 		$url_array = array(
 			'form_set', 'index',
 			'form_id',	make_id($form_id),
 			//'set_id',	make_id($set_id),
 		);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
  		
 	} // notRequireAction
 	
 	
 	
 	
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
 		 * get form entry id
 		 */
 		$form_entry_id = $this->getAttribute('form_entry_id');
 		
 		/**
 		 * set as non display
 		 */
 		$this->wpcms->displayChange($form_entry_id, 0, 'form_entry_tab');		
 		
 		/**
 		 * page redirect list
 		 */
 		$url_array = array(
 			'form_set', 'index',
 			'form_id',	make_id($form_id),
 			//'set_id',	make_id($set_id),
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
 		 * get form entry id
 		 */
 		$form_entry_id = $this->getAttribute('form_entry_id');
 		
 		/**
 		 * set as display
 		 */
 		$this->wpcms->displayChange($form_entry_id, 1, 'form_entry_tab');		
 		
 		/**
 		 * page redirect to index
 		 */
 		$url_array = array(
 			'form_set', 'index',
 			'form_id',	make_id($form_id),
 			//'set_id',	make_id($set_id),
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
 		 * get form entry id
 		 */
 		$form_entry_id = $this->getAttribute('form_entry_id');
 		
 		/**
 		 * delete set
 		 */
 		$this->wpcms->delete($form_entry_id, 'form_entry_tab');
 		
 		/**
 		 * page redirect to index
 		 */
 		$url_array = array(
 			'form_set', 'index',
 			'form_id',	make_id($form_id),
 			//'set_id',	make_id($set_id),
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
 		 * get form entry id
 		 */
 		$form_entry_id = $this->getAttribute('form_entry_id');
 		
 		/**
 		 * get order
 		 */
 		$order = $this->getUrlParam('order');
 		
 		/**
 		 * make search array
 		 */
 		$search_array = array('form_id' => $form_id, 'set_id' => $set_id);
 		
 		switch ($order){
 			
 			case 'up':
 					$this->wpcms->moveUpAsc($form_entry_id, 'form_entry_tab', $search_array);	
 				break;
 				
 			case 'down':
 					$this->wpcms->moveDownAsc($form_entry_id, 'form_entry_tab', $search_array);
 				break;
 			
 		}
 		
 		
 		/**
 		 * page redirect to index
 		 */
 		$url_array = array(
 			'form_set', 'index',
 			'form_id',	make_id($form_id),
 			//'set_id',	make_id($set_id),
 		);
  		$url = $this->makeUrl($url_array);
  		$this->redirect($url);
 		
 		
 	} // displayOrderAction
 	
 	
 	
 
 
 
 } // form_entryControllerClass
 
 
 ?>