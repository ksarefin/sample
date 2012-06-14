<?php
/**
 * form_mailControllerClass.php
 * 
 * @created on 2012/04/18
 * @package    FORM
 * @subpackage 
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/04/18 - 15:46:24 fabien 
 * 
 *File content
     form_mailControllerClass.php
 *     
 */
 
 
 class form_mailControllerClass extends Configuration{
 
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
 		$this->db_model = new form_mailModelClass();
 		
 		/**
 		 * data class object
 		 */
 		$this->data_class = new DataClass();
 		
 		
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
  		 * login check
  		 */
  		$this->login_class->checkLogin($this->access_name);
 		
 		/**
  		 * page title
  		 */
  		$this->viewAssign('page_title', 'フォームメール集計');
  		
 		
 	} // commonAction
 	
 	
 	
 	/**
 	 * index action controller
 	 */
 	public function indexAction(){
 		
 		/**
 		 * set page url array
 		 */
 		$url_array = array(
 			$this->module_name, $this->action_name,
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
 		$offset = ($page_no-1) * $limit;
 		
 		/**
 		 * set number to dispaly list number on view
 		 */
 		$this->viewAssign('number', (($page_no-1)*$limit));
 		
 		/**
		 * get form mail list
		 */
 		$list = $this->db_model->getFormList($limit, $offset);
 		
 		/**
 		 * page view list assign to view
 		 */
 		$this->viewAssign('list', $list);
 		 		
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
 			$page_class = new PageClass($total_rows, $page_no, $limit);
 			$this->viewAssign('prev', $page_class->isPrev());
			$this->viewAssign('prev_pn', $page_no-1);
			$this->viewAssign('next', $page_class->isNext());
			$this->viewAssign('next_pn', $page_no+1);
			$link_url = $this->self_url.'/'.$this->action_name.'/limit/'.$limit;;
			$paging = $page_class->DisPage($link_url);
			$this->viewAssign("paging",$paging);
		}
 		
		
 		
 		$this->setDisplay('list');
 		
 		
 	} // indexAction
 	
 	
 	
 	/**
 	 * form mail report action controller
 	 */
 	public function mailReportAction(){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * set page url array
 		 */
 		$url_array = array(
 			$this->module_name, $this->action_name,
 			'form_id', make_id($form_id),
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
 		$offset = ($page_no-1) * $limit;
 		
 		/**
 		 * set number to dispaly list number on view
 		 */
 		$this->viewAssign('number', (($page_no-1)*$limit));
 		
 		/**
		 * get form mail list
		 */
 		$list = $this->db_model->getFormMailList($form_id, $limit, $offset);
 		
 		/**
 		 * page view list assign to view
 		 */
 		$this->viewAssign('list', $list);
 		 		
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
 			$page_class = new PageClass($total_rows, $page_no, $limit);
 			$this->viewAssign('prev', $page_class->isPrev());
			$this->viewAssign('prev_pn', $page_no-1);
			$this->viewAssign('next', $page_class->isNext());
			$this->viewAssign('next_pn', $page_no+1);
			$link_url = $this->self_url.'/'.$this->action_name.'/form_id/'.make_id($form_id).'/limit/'.$limit;;
			$paging = $page_class->DisPage($link_url);
			$this->viewAssign("paging",$paging);
		}
 		
		
 		$this->setDisplay('report');
 		
 	} // mailReportAction
 	
 	
 	
 	/**
 	 * mail detail action controller
 	 */
 	public function mailDetailAction(){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get mail id
 		 */
 		$url_mail_id = $this->getUrlParam('mail_id');
 		$mail_id = get_id($url_mail_id);

 		/**
 		 * get mail data and assign to view
 		 */
 		$mail_info = $this->db_model->getMialData($mail_id);
 		$this->viewAssign('mail_info', $mail_info);
 		
 		
 		$this->setDisplay('detail');
 		
 	} // mailDetailAction
 	
 	
 	
 	/**
 	 * csv download action controller
 	 */
 	public function csvDownAction(){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get form entry field list
 		 */
 		$form_field_list = $this->db_model->getFormFieldList($form_id);
 		//print_r($form_field_list);
 		
 		foreach ($form_field_list as $field_row){
 			
 			if (preg_match('/^privacy_/', $field_row['name'])) continue;
 			
 			if (preg_match('/^name_[0-9]/', $field_row['name'])){
 				
 				$expl = explode(';:;', $field_row['field_labels']);
 				$csv_header[$field_row['name'].'_1'] 		= $expl[0].'-'.$expl[2];
 				$csv_header[$field_row['name'].'_2'] 		= $expl[0].'-'.$expl[3];
 				$csv_header[$field_row['name'].'_kana_1'] 	= $expl[1].'-'.$expl[4];
 				$csv_header[$field_row['name'].'_kana_2'] 	= $expl[1].'-'.$expl[5];
 				continue;
 			}
 			
 			if (preg_match('/^address_[0-9]/', $field_row['name'])){
 				
 				$expl = explode(';:;', $field_row['field_labels']);
 				$csv_header[$field_row['name'].'_pcode'] 		= $expl[0];
 				$csv_header[$field_row['name'].'_pref'] 		= $expl[1];
 				$csv_header[$field_row['name'].'_address_a'] 	= $expl[2];
 				$csv_header[$field_row['name'].'_address_b'] 	= $expl[3];
 				continue;
 			}
 			
 			if (preg_match('/^birthday_[0-9]/', $field_row['name'])){
 				
 				$expl = explode(';:;', $field_row['field_labels']);
 				$csv_header[$field_row['name'].'_year_type'] 	= '年式';
 				$csv_header[$field_row['name'].'_year'] 		= $field_row['label'].'-'.$expl[0];
 				$csv_header[$field_row['name'].'_month'] 		= $field_row['label'].'-'.$expl[1];
 				$csv_header[$field_row['name'].'_day'] 			= $field_row['label'].'-'.$expl[2];
 				continue;
 			}
 			
 			if (preg_match('/^ynradio_[0-9]/', $field_row['name'])){
 				
 				$yn_expl = explode('|yn|', $field_row['ynfields']);
 				$yn_field_array = array();
 				
 				foreach ($yn_expl as $ym_row){
 					
 					$yn_row_expl = explode('_', $ym_row);
 					
 					$yn_field = $yn_row_expl[0].'_'.$yn_row_expl[1];
 					
 					$yn_field_expl = explode(':=:', $yn_row_expl[2]);
 					
 					$yn_field_list[$field_row['name'].'_'.$yn_field]['name'] = $field_row['name'].'_'.$yn_field;
 					$yn_field_list[$field_row['name'].'_'.$yn_field][$yn_field_expl[0]] = $yn_field_expl[1];
 					

 					if (!in_array($yn_field, $yn_field_array)){
 						$yn_field_array[$yn_row_expl[1]] = $yn_field;
 					}else 
 						continue;
 				} // foreach ($yn_expl as $ym_row){
 				
 				/**
			 	 * sort yes no field as input sequence
			 	 */
			 	ksort($yn_field_array);
 				
 				//print_r($yn_expl);
 				//print_r($yn_field_list);
 				//print_r($yn_field_array);
 				
 				if (is_array($yn_field_array)){
 					$csv_header[$field_row['name']] = $field_row['label'];
 					foreach ($yn_field_array as $yn_field){
 						$csv_header[$field_row['name'].'_'.$yn_field] = $field_row['label'].'-'.$yn_field_list[$yn_field]['label'];
 					}
 				} // if (is_array($yn_field_array)){
 				
 				
 				continue;
 			}
 			
 			$csv_header[$field_row['name']] = $field_row['label']; 
 		}
 		
 		//print_r($csv_header);
 		
 		/**
 		 * get mail data list
 		 */
 		$mail_data_list = $this->db_model->getFormMailData($form_id);
 		//print_r($mail_data_list[0]);
 		//$mail_data_list_t[]=$mail_data_list[0];
 		//$mail_data_list_t[]=$mail_data_list[1];
 		
 		$form_data_list = array();
 		
 		if (is_array($mail_data_list) && !empty($mail_data_list)){
	 		foreach ($mail_data_list as $mail_data){
	 			$tmp_data = array();
	 				
	 			foreach ($csv_header as $header_key=>$header_value){
	 				
	 				foreach ($mail_data as $data_key => $data_value){
	 					
	 					if (preg_match('/^privacy_/', $data_key)) continue;
	 					
		 				
	 					/**
	 					 * for name set
	 					 */
	 					if (preg_match('/^name_[0-9]/', $data_key)){
		 				
			 				$expl = explode('|fd|', $data_value);
			 				$exp_name_1 = explode(':=:', $expl[0]);
			 				$exp_name_2 = explode(':=:', $expl[1]);
			 				$exp_kana_1 = explode(':=:', $expl[2]);
			 				$exp_kana_2 = explode(':=:', $expl[3]);
			 				
			 				if ($header_key == $exp_name_1[0])
			 					$tmp_data[$header_key] = $exp_name_1[1];
			 				
			 				if ($header_key == $exp_name_2[0])
			 					$tmp_data[$header_key] = $exp_name_2[1];
			 				
			 				if ($header_key == $exp_kana_1[0])
			 					$tmp_data[$header_key] = $exp_kana_1[1];
			 				
			 				if ($header_key == $exp_kana_2[0])
			 					$tmp_data[$header_key] = $exp_kana_2[1];
			 					
			 			} // if (preg_match('/^name_[0-9]/', $header_key)){
			 			
			 			
			 			/**
			 			 * for address set
			 			 */
		 				if (preg_match('/^address_[0-9]/', $data_key)){
		 				
			 				$expl = explode('|fd|', $data_value);
			 				
			 				$exp_pcode_1	= explode(':=:', $expl[0]);
			 				$exp_pcode_2	= explode(':=:', $expl[1]);
			 				$exp_pref		= explode(':=:', $expl[2]);
			 				$exp_address_a	= explode(':=:', $expl[3]);
			 				$exp_address_b	= explode(':=:', $expl[4]);
			 				
			 				if ($header_key == str_replace('_1', '', $exp_pcode_1[0]))
			 					$tmp_data[$header_key] = $exp_pcode_1[1].'-'.$exp_pcode_2[1];
			 				
			 				if ($header_key == $exp_pref[0])
			 					$tmp_data[$header_key] = $exp_pref[1];
			 					
			 				if ($header_key == $exp_address_a[0])
			 					$tmp_data[$header_key] = $exp_address_a[1];
			 					
			 				if ($header_key == $exp_address_b[0])
			 					$tmp_data[$header_key] = $exp_address_b[1];
			 				
			 			} // if (preg_match('/^address_[0-9]/', $header_key)){
			 			
			 			
			 			/**
			 			 * for birthday set
			 			 */
			 			if (preg_match('/^birthday_[0-9]/', $data_key)){
			 				
			 				$expl = explode('|fd|', $data_value);
			 				
			 				$exp_year_type	= explode(':=:', $expl[0]);
			 				$exp_year		= explode(':=:', $expl[1]);
			 				$exp_month		= explode(':=:', $expl[2]);
			 				$exp_day		= explode(':=:', $expl[3]);
			 				
			 				if ($header_key == $exp_year_type[0])
			 					$tmp_data[$header_key] = $this->data_class->getYearTypeName($exp_year_type[1]);
			 					
			 				if ($header_key == $exp_year[0])
			 					$tmp_data[$header_key] = $exp_year[1];
			 					
			 				if ($header_key == $exp_month[0])
			 					$tmp_data[$header_key] = $exp_month[1];
			 					
			 				if ($header_key == $exp_day[0])
			 					$tmp_data[$header_key] = $exp_day[1];
			 				
			 			} // if (preg_match('/^birthday_[0-9]/', $header_key)){
			 			
			 			
			 			/**
			 			 * for mail
			 			 */
			 			if (preg_match('/^mail_[0-9]/', $data_key)){
			 				
			 				$expl = explode('|fd|', $data_value);
			 				$exp_mail	= explode(':=:', $expl[0]);
			 				
			 				if ($header_key == str_replace('_mail', '', $exp_mail[0]))
			 					$tmp_data[$header_key] = $exp_mail[1];
			 					
			 				continue;
			 						 				
			 			} // if (preg_match('/^mail_[0-9]/', $data_key)){
			 			
			 			
			 			/**
			 			 * for tel number
			 			 */
			 			if (preg_match('/^tel_[0-9]/', $data_key)){
			 				
			 				$expl = explode('|fd|', $data_value);
			 				
			 				$exp_tel_1	= explode(':=:', $expl[0]);
			 				$exp_tel_2	= explode(':=:', $expl[1]);
			 				$exp_tel_3	= explode(':=:', $expl[2]);
			 				
			 				if ($header_key == str_replace('_1', '', $exp_tel_1[0]))
			 					$tmp_data[$header_key] = $exp_tel_1[1].'-'.$exp_tel_2[1].'-'.$exp_tel_3[1];
			 					
			 				continue;
			 						 				
			 			} // if (preg_match('/^tel_[0-9]/', $data_key)){
			 			
			 			
			 			/**
			 			 * for password
			 			 */
			 			if (preg_match('/^password_[0-9]/', $data_key)){
			 				
			 				$expl = explode('|fd|', $data_value);
			 				$exp_password	= explode(':=:', $expl[0]);
			 				
			 				if ($header_key == str_replace('_pass', '', $exp_password[0]))
			 					$tmp_data[$header_key] = $exp_password[1];
			 					
			 				continue;
			 						 				
			 			} // if (preg_match('/^password_[0-9]/', $data_key)){
			 			
			 			
			 			/**
			 			 * for yes no fields
			 			 */
			 			if (preg_match('/^ynradio_[0-9]/', $data_key, $match)){
			 				
			 				$expl = explode('|fd|', $data_value);
			 				
			 				foreach ($expl as $yn_row){
			 					$yn_row_expl = explode(':=:', $yn_row);
			 					
			 					if ($header_key == $yn_row_expl[0]){
			 						
			 						
			 						/**
			 						 * for yes no label
			 						 */
			 						if ($match[0] == $header_key){
			 							
			 							$value = $this->getYesNoLabel($form_field_list, $data_key, $yn_row_expl[1]);
						 				$tmp_data[$header_key] = $value;
						 				
						 				continue;
						 				
			 						} // if ($match[0] == $header_key){
			 						
			 						
			 						/**
			 						 * for yes no field's select and radio option 
			 						 */
			 						if (preg_match('/^ynradio_[0-9]_select_[0-9]/', $yn_row_expl[0], $match) || preg_match('/^ynradio_[0-9]_radio_[0-9]/', $yn_row_expl[0], $match)){
			 							
			 							if ($match[0] != $header_key) continue;
						 				
						 				$expl = explode(':other:', $yn_row_expl[1]);
						 				$value = $this->getYesNoOptionValue($yn_field_list, $yn_row_expl[0], $expl[0]);
						 				
						 				if (!empty($expl[1]))
						 					$tmp_data[$header_key] = $value.',その他：'.$expl[1];
						 				else
						 					$tmp_data[$header_key] = $value;
						 				
						 				continue;
						 				
						 			} // if (preg_match('/^ynradio_[0-9]_select_[0-9]/', $yn_row_expl[0], $match) || preg_match('/^ynradio_[0-9]_radio_[0-9]/', $yn_row_expl[0], $match)){
						 			
						 			
						 			/**
						 			 * for yes no field's checkbox option
						 			 */
						 			if (preg_match('/^ynradio_[0-9]_checkbox_[0-9]/', $yn_row_expl[0], $match)){
			 				
						 				if ($match[0] != $header_key) continue;
						 				
						 				$expl = explode(':other:', $yn_row_expl[1]);
						 				$option_expl = explode('::', $expl[0]);
						 				
						 				$value = array();
						 				foreach ($option_expl as $row)
						 					$value[] = $this->getYesNoOptionValue($yn_field_list, $yn_row_expl[0], $row);
						 				
						 				if (!empty($expl[1]))
						 					$tmp_data[$header_key] = join(',', $value).',その他：'.$expl[1];
						 				else
						 					$tmp_data[$header_key] = join(',', $value);
						 					
						 				continue;
						 				
						 			} // if (preg_match('/^checkbox_[0-9]/', $data_key)){
						 			
						 			
			 						$tmp_data[$header_key] = $yn_row_expl[1];
			 					}
			 						
			 				}
			 				
			 				continue;
			 			} // if (preg_match('/^ynradio_[0-9]/', $header_key)){
			 			
			 			
			 			/**
			 			 * for select and radion fields
			 			 */
			 			if (preg_match('/^select_[0-9]/', $data_key, $match) || preg_match('/^radio_[0-9]/', $data_key, $match)){
			 				
			 				if ($match[0] != $header_key) continue;
			 				
			 				$expl = explode(':other:', $data_value);
			 				$value = $this->getOptionValue($form_field_list, $data_key, $expl[0]);
			 				
			 				if ($data_key == $header_key ){
			 					if (!empty($expl[1]))
			 						$tmp_data[$header_key] = $value.',その他：'.$expl[1];
			 					else
			 						$tmp_data[$header_key] = $value;
			 				}
			 				continue;
			 				
			 			} // if (preg_match('/^select_[0-9]/', $data_key, $match) || preg_match('/^radio_[0-9]/', $data_key, $match)){
			 			
			 			
			 			/**
			 			 * for checkbox field
			 			 */
			 			if (preg_match('/^checkbox_[0-9]/', $data_key, $match)){
			 				
			 				if ($match[0] != $header_key) continue;
			 				
			 				$expl = explode(':other:', $data_value);
			 				$option_expl = explode('::', $expl[0]);
			 				
			 				$value = array();
			 				foreach ($option_expl as $row)
			 					$value[] = $this->getOptionValue($form_field_list, $data_key, $row);
			 				
			 				if ($data_key == $header_key ){
			 					
			 					if (!empty($expl[1]))
			 						$tmp_data[$header_key] = join(',', $value).',その他：'.$expl[1];
			 					else
			 						$tmp_data[$header_key] = join(',', $value);
			 					
			 				}
			 					
			 				continue;
			 				
			 			} // if (preg_match('/^checkbox_[0-9]/', $data_key)){
			 			
			 			
			 			/**
			 			 * for survey options
			 			 */
			 			if (preg_match('/^svid_[0-9]_fid_[0-9]_sid_[0-9]/', $data_key, $match)){
			 				
			 				if ($match[0] != $header_key) continue;
			 				
			 				$survey_expl = explode('_', $data_key);
			 				$survey_id = $survey_expl[1];
			 				
			 				$expl = explode(':other:', $data_value);
			 				
			 				$value = $this->getSurveyOptionValue($survey_id, $data_key, $expl[0]);
			 				
			 				if (!empty($expl[1]))
			 					$tmp_data[$header_key] = $value.',その他：'.$expl[1];
			 				else
			 					$tmp_data[$header_key] = $value;
			 					
			 				continue;
			 				
			 			} // if (preg_match('/^svid_[0-9]_fid_[0-9]_sid_[0-9]/', $data_key, $match)){
			 			
			 			
			 			/**
			 			 * for image field
			 			 */
			 			if (preg_match('/^image_[0-9]/', $data_key, $match)){
			 				
			 				if ($match[0] != $header_key) continue;
			 				
			 				if (!empty($data_value))
			 					$tmp_data[$header_key] = _HTTP.$GLOBALS['gl_wpcms_Info']['wpcms_path'].'/wpform/file/imageDisplay/image_name/'.$data_value;
			 				else 
			 					$tmp_data[$header_key] = "";
			 					
			 				continue;
			 				
			 			} // if (preg_match('/^image_[0-9]/', $data_key, $match)){
			 			
			 			
			 			/**
			 			 * for pdf field
			 			 */
			 			if (preg_match('/^pdf_[0-9]/', $data_key, $match)){
			 				
			 				if ($match[0] != $header_key) continue;
			 				
			 				if (!empty($data_value))
			 					$tmp_data[$header_key] = _HTTP.$GLOBALS['gl_wpcms_Info']['wpcms_path'].'/wpform/file/pdfDisplay/pdf_name/'.$data_value;
			 				else 
			 					$tmp_data[$header_key] = "";
			 					
			 				continue;
			 				
			 			} // if (preg_match('/^pdf_[0-9]/', $data_key, $match)){
			 			
						 			
						 			
			 			
	 					if ($data_key == $header_key ){
	 						$tmp_data[$header_key] = $data_value;
	 					}
	 					
	 					
	 				} // foreach ($mail_data as $data_key => $data_value){
	 				
	 			} // foreach ($csv_header as $header_key=>$header_value){
	 			
	 			//$form_data_list[] = $tmp_data;
	 			$form_data_list[] = implode(',', $tmp_data);
	 			
	 		} // foreach ($mail_data_list as $mail_data){
 		
 		} // if (is_array($mail_data_list) && !empty($mail_data_list)){
 		
 		
 		//print_r($form_data_list);
 		//exit;
 		
 		/**
 		 * make csv header text
 		 */
 		$csv_header_txt =  mb_convert_encoding(implode(',', $csv_header), "Shift_JIS");
 		
 		/**
 		 * make csv data
 		 */
 		$csv_data_txt = mb_convert_encoding(implode("\n", $form_data_list), "Shift_JIS");
 		
 		/**
		 * make csv downloadable
		 */
		header("Cache-Control: public");
		header("Pragma: public");
		
		$csv_name = "form_name"; 
		
		header(sprintf("Content-disposition: attachment; filename=%s.csv",$csv_name));
		header(sprintf("Content-type: application/octet-stream; name=%s.csv",$csv_name));

		/**
		 * make csv text
		 */
		$csv_txt = $csv_header_txt."\n".$csv_data_txt;
		
		echo $csv_txt;
		exit;
 		
 	} // csvDownAction
 	
 	
 	
 	/**
 	 * get option value
 	 * @param $form_field_list
 	 * @param $field_name
 	 * @param $option_value
 	 */
 	private function getOptionValue($form_field_list, $field_name, $option_value){
 		
 		foreach ($form_field_list as $form_row){
 			
 			if ($form_row['name'] == $field_name){
 				
 				$options = explode('::', $form_row['options']);
 				array_unshift($options, 0);
 				unset($options[0]);
 				
 				if (@$options[$option_value])
 					return $options[$option_value];
 			}
 			
 		} // foreach ($form_field_list as $form_row){
 		
 	} // getOptionValue
 	
 	
 	
 	/**
 	 * get yes no label option value
 	 * @param $form_field_list
 	 * @param $field_name
 	 * @param $option_value
 	 */
 	private function getYesNoLabel($form_field_list, $field_name, $option_value){
 		
 		foreach ($form_field_list as $form_row){
 			
 			if ($form_row['name'] == $field_name){
 				
 				$options = explode(';:;', $form_row['field_labels']);
 				array_unshift($options, 0);
 				unset($options[0]);
 				
 				if (@$options[$option_value])
 					return $options[$option_value];
 			}
 			
 		} // foreach ($form_field_list as $form_row){
 		
 	} // getYesNoLabel
 	 	
 	
 	/**
 	 * get yes no option value
 	 * @param $yn_field_list
 	 * @param $field_name
 	 * @param $option_value
 	 */
 	private function getYesNoOptionValue($yn_field_list, $field_name, $option_value){
 		
 		foreach ($yn_field_list as $yn_row){
 			
 			if ($yn_row['name'] == $field_name){
 				
 				$options = explode(';opt;', $yn_row['options']);
 				array_unshift($options, 0);
 				unset($options[0]);
 				
 				if (@$options[$option_value])
 					return $options[$option_value];
 			}
 			
 		} // foreach ($form_field_list as $form_row){
 		
 	} // getOptionValue
 	
 	
 	/**
 	 * get survey option value
 	 * @param $survey_id
 	 * @param $field_name
 	 * @param $option_value
 	 */
 	private function getSurveyOptionValue($survey_id, $field_name, $option_value){
 		
 		/**
 		 * get survey data
 		 */
 		$survey_data = $this->db_model->getSurveyData($survey_id);
 		
 		foreach ($survey_data as $row){
 			
 			$options = explode('::', $row['options']);
 			array_unshift($options, 0);
 			unset($options[0]);
 			
 			if ($row['type'] == 'radio'){
 				
 				if (@$options[$option_value])
 					return $options[$option_value];
 					
 			}elseif ($row['type'] == 'checkbox'){
 				
 				$option_expl = explode('::', $option_value);
 						
		 		$value = array();
		 		foreach ($option_expl as $row)
		 			$value[] = @$options[$row];				
 				
		 		if ($value)
		 			return join(',', $value);
		 			
 			} // if ($survey_data['type'] == 'radio'){
 			
 		} // foreach ($survey_data as $row){
 		
 	} // getSurveyOptionValue
 	
 	
 	
 
 } // form_mailControllerClass
 
 
 ?>