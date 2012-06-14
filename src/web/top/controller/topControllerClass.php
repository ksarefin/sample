<?php
/**
 * topControllerClass.php
 * 
 * @created on 2012/01/25
 * @package    From
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/01/25 - 15:51:53 fabien 
 * 
 *File content
     topControllerClass.php
 *     
 */


 class topControllerClass extends Configuration {
 	
 	
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
 	 * form class instance
 	 */
 	protected $html_code_class;
 	
 	/**
 	 * mail template class instance
 	 */
 	protected $mail_template_class;
 	
 	/**
 	 * error check instance
 	 */
 	protected $error_ckeck;
 	
 	/**
 	 * form id instance
 	 */
 	protected $form_id;
 	
 	/**
 	 * form data instance
 	 */
 	protected $form_data;
 	
 	/**
 	 * ini parser instance
 	 */
 	protected $ini_parser;
 	
 	/**
 	 * form page instance
 	 */
 	protected $page;
 	
 	
 
 	
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
 		$this->db_model = new topModelClass();
 		
 		/**
 		 * data class object
 		 */
 		$this->data_class = new DataClass();
 		
 		/**
 		 * parse form ini
 		 */
 		$this->ini_parser = new IniParserClass();
 		
 		/**
 		 * form class object
 		 */
 		$this->html_code_class = new HtmlCodeClass();
 		
 		/**
 		 * mail template class object
 		 */
 		$this->mail_template_class = new MailTemplateClass();
 		
 		/**
 		 * error check class object
 		 */
 		$this->error_ckeck = new ErrorCheckClass();
 		
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
  		 * get form information
  		 */
 		if ($this->getAttribute('form_id')) 
 			$this->form_data = $this->db_model->getFormData($this->getAttribute('form_id'));
 			
 		/**
 		 * get form url page no
 		 */
 		$url_page_no = $this->getUrlParam('page');
 		$this->page = get_id($url_page_no);
 		
 		/**
 		 * page no save in session and assign to view
 		 */
 		$page = $this->page ? $this->page : 1; 
 		$this->setAttribute('page', $page);
 		$this->viewAssign('page', $page);	
 		
 		 		
 		/**
 		 * get form list assign to view
 		 */
 		$list = $this->db_model->getFormList();
 		$this->viewAssign('list', $list);
 		
 		
 		/**
  		 * assign form title as page title
  		 */
 		$this->viewAssign('page_title', $this->form_data['title']);
 		
  		
 	} // commonAction
 	
 	
 	
 	
 	/**
 	 * index action controller
 	 */
 	public function indexAction(){
 		
 		
 		/**
  		 * page title
  		 */
 		$this->viewAssign('page_title', 'Form 一覧');
 		
 		
 		$this->setDisplay('list');
 		
 	} // indexAction
 	
 	
 	/**
 	 * error action controller
 	 */
 	public function errorAction(){
 		
 		/**
 		 * get error msg
 		 */
 		$err_msg = $this->getAttribute('err_msg');
 		
 		
 		$this->setDisplay('error');
 		
 	} // errorAction
 	
 	
 	
 	/**
 	 * new entry action controller
 	 */
 	public function newEntryAction(){
 		
 		/**
 		 * for empty form data
 		 */
 		if (empty($this->form_data)){
 			
 			/**
 			 * page redirect to error
 			 */
 			$url_array = array(	
	 			$this->module_name, 'error', 
	 		);
 			$redirect_url = $this->makeUrl($url_array);
	  		$this->redirect($redirect_url);
 			
 			exit;
 		}
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get page no
 		 */
 		$page = $this->getAttribute('page');
 		
 		/**
 		 * generate html code and assign to view 
 		 */
 		$this->htmlCode();
 		
 		/**
 		 * get ini hearder information to page count
 		 */
 		$ini_header = $this->getAttribute('ini_header');
 		
 		/**
 		 * view assign total page
 		 */
 		$total_page = count($ini_header)-1;
 		$this->viewAssign('total_page', $total_page);
 				
 		/**
 		 * check where it is last page or not
 		 */
 		if ($page == count($ini_header))
 			$this->viewAssign('last_page', 'last');
 		else 
 			$this->viewAssign('last_page', 'page');
 		
 		/**
 		 * update form view
 		 */
 		$this->db_model->pageViewUpdate('form', 'form_view', $form_id);
 		
 		
 		/**
 		 * template name
 		 */
 		if ($this->form_data['form_style'] == 2)
 			$template = 'form_'.$form_id.'_'.$page;
 		else 
 			$template = 'form_'.$form_id;
 			
 			
 		$this->setDisplay($template);
 		
 		
 	} // newEntryAction
 	
 	
 	
 	
 	/**
 	 * back form action controller
 	 */
 	public function backFormAction(){
 		
 		/**
 		 * for empty form data
 		 */
 		if (empty($this->form_data)){
 			
 			/**
 			 * page redirect to error
 			 */
 			$url_array = array(	
	 			$this->module_name, 'error', 
	 		);
 			$redirect_url = $this->makeUrl($url_array);
	  		$this->redirect($redirect_url);
 			
 			exit;
 		}
 		
 	
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get page no
 		 */
 		$page = $this->getAttribute('page');
 		 		
 		/**
 		 * get ini hearder information to page count
 		 */
 		$ini_header = $this->getAttribute('ini_header');
 		
 		/**
 		 * view assign total page
 		 */
 		$total_page = count($ini_header)-1;
 		$this->viewAssign('total_page', $total_page);
 				
 		/**
 		 * check where it is last page or not
 		 */
 		if ($page == count($ini_header))
 			$this->viewAssign('last_page', 'last');
 		else 
 			$this->viewAssign('last_page', 'page');
 		 			
 		/**
 		 * get form array
 		 */
 		$form_array = $this->getAttribute('form_array');
 		
 		/**
 		 * get form information
 		 */
 		$form_data = $this->form_data;
 		
 		/**
 		 * get post data and assign to view
 		 */
 		$post = $this->getAttribute('back_post');
 		//print_r($post);
 		//exit;
 		
 		/**
 		 * get back paging post data
 		 */
 		$get_back_paging_post = $this->getAttribute('back_paging_post');
 		
 		/**
 		 * for paging style form
 		 */
 		if ($form_data['form_style'] == 2)
 			$post = $get_back_paging_post;
 		
 		/**
 		 * redirect to new form when post data is empty
 		 */
 		if (empty($post)){
 			
 			/**
	 		 * page redirect back form
	 		 */
	 		$url_array = array(	
	 			$this->module_name, 'newEntry', 
	 			'form_id', make_id($form_id)
	 		);
 			$redirect_url = $this->makeUrl($url_array);
	  		$this->redirect($redirect_url);
 			
	  		exit;
 		
 		} // if (empty($post)){
 		
 		/**
 		 * make values and other values for options fields 
 		 */
 		/*foreach ($post as $key=>$val){

 			if (preg_match('/:other:/', $val)){
 				
 				$post[$key] = array();
 				
 				$val_expl = explode(':other:', $val);
 				
 				if (preg_match('/::/', $val_expl[0])){
 					$post[$key][] = explode('::', $val_expl[0]);
 				}else {
 					$post[$key][] = $val_expl[0];
 				}
 				
 				$post[$key][] = $val_expl['1'];
 				
 				
 			}else{
 				
 				if (preg_match('/::/', $val)){
 					$post[$key] = explode('::', $val);
 				}else {
 					$post[$key] = $val;
 				}
 				 
 			} // if (preg_match('/:other:/', $val)){
 			
 		} // foreach ($post as $key=>$val){
 		*/
 		//print_r($post);
 		
 		/**
 		 * post data assign to view
 		 */
 		$this->viewAssign('pd', $post);
 		

 		/**
 		 * make yes no fields from array
 		 */
 		if (is_array($post)){
 			
 			foreach ($post as $key=>$val){
 			
	 			if (preg_match('/\bynradio_[0-9]\b/', $key)){
	 				
		 			if ($form_data['form_style'] == 2)
		 				$ynpost_key = $paging_post[$key];
		 			elseif ($form_data['form_style'] == 1)
		 				$ynpost_key = $post[$key];	
	 			
	 				/**
	 				 * if ynradio value is 1
	 				 */
	 				if ($ynpost_key == 1){
	 					$ynfields_form_array = $form_array[$key]['form_array'];
	 					$form_array = array_merge($form_array,$ynfields_form_array);
	 				}
	 				
	 			} // if (preg_match('/\bynradio_[0-9]\b/', $key)){
	 			
	 		} // foreach ($post as $key=>$val){
 			
 		} // if (is_array($post)){
 		
 		//print_r($form_array);
 		
 		/**
 		 * post data check for error
 		 */
 		//$err_msg = $this->error_ckeck->formErrorCheck($form_array, $post);
 		//print_r($err_msg);
 		
 		/**
 		 * get error message form session
 		 */
 		$err_msg = $this->getAttribute('err_msg');
 		//print_r($err_msg);
 		
 		/**
 		 * error messege assign to view
 		 */
 		$this->viewAssign('err', $err_msg);
 		
 		/**
 		 * generate html code and assign to view 
 		 */
 		$this->htmlCode('back');
 		
 		/**
 		 * template name
 		 */
 		if ($this->form_data['form_style'] == 2)
 			$template = 'form_'.$form_id.'_'.$page;
 		else 
 			$template = 'form_'.$form_id;

 		
 			
 		$this->setDisplay($template);		
 		
 	} // backFormAction
 	
 	
 	
 	/**
 	 * confirm action controller
 	 */
 	public function confAction(){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get page no
 		 */
 		$page = $this->getAttribute('page');
 		
 		/**
 		 * get form array
 		 */
 		$form_array = $this->getAttribute('form_array');
 		//print_r($form_array);exit;
 		
 		/**
 		 * get form information
 		 */
 		$form_data = $this->form_data;
 		
 		/**
 		 * if empty form array redirect to new form 
 		 */
 		if (empty($form_array)){
 			
 			/**
	 		 * page redirect new form
	 		 */
	 		$url_array = array(	
	 			$this->module_name, 'newEntry', 
	 			'form_id', make_id($form_id)
	 		);
 			$redirect_url = $this->makeUrl($url_array);
	  		$this->redirect($redirect_url);
 			
	  		exit;
	  		
 		} // if (empty($form_array)){
 		
 		
 		
 		/**
 		 * get post data
 		 */
 		$post = $this->getPost();
 		//print_r($post);exit;
 		
 		/**
 		 * get paging post data
 		 */
 		$paging_post = $this->getAttribute('paging_post');
 		
 		/**
 		 * save post data
 		 */
 		$save_post = array();
 		if (!empty($post))
 			$save_post = $post ;
 			
 		/**
 		 * for paging style form
 		 */
 		$page_post = $post;
 		
 		if (empty($post) && empty($paging_post)){
 			
 			/**
	 		 * page redirect new form
	 		 */
	 		$url_array = array(	
	 			$this->module_name, 'newEntry', 
	 			'form_id', make_id($form_id)
	 		);
 			$redirect_url = $this->makeUrl($url_array);
	  		$this->redirect($redirect_url);
 			
	  		exit;
 			
 		} // if (empty($post)){
 		
 		//print_r($post);exit;
 		
 		/**
 		 * make fields values which have other option
 		 */
 		foreach ($post as $key=>$val){
 			
 			
 			/**
 			 * make value for options fields 
 			 */
 			if (is_array($val)){
 				
 				if (array_key_exists('other', $val)){
	 				$other = $val['other'];
	 				unset($val['other'],$post[$key]);
	 				
	 				if (key_exists(1, $val))
		 				$post[$key][] = $val;
		 			else
		 				$post[$key][] = $val[0];
		 				 	
		 			$post[$key][] = $other;
 				}else {
 					$post[$key] = $val;
 				}
 				
 				/*if (array_key_exists('other', $val)){
	 				$other = $val['other'];
	 				unset($val['other']);
	 				$values = join('::', $val);
		 			$post[$key] = $values.':other:'.$other;
 				}else {
 					$post[$key] = join('::', $val);
 				}*/
 			
 			} // if ($is_array($val)){
 			
 		} // foreach ($post as $key=>$val){
 		
 		//print_r($post);exit;
 		
 		
 		
 		/**
 		 * make confrimation from array
 		 */
 		$conf_form_array = array();
 		foreach ($form_array as $f_key=>$f_val){
 			
 			/**
 			 * confrimation form array
 			 */
 			$conf_form_array[$f_key] = $form_array[$f_key];
 			
 			/**
 			 * yes no radio fields
 			 */
 			if (preg_match('/\bynradio_[0-9]\b/', $f_key)){
 				
 				/**
 				 * get paging post data 
 				 */
 				$paging_post = $this->getAttribute('paging_post');
 				
 			
	 			if ($form_data['form_style'] == 2)
	 				$ynpost_key = $post[$f_key] ? $post[$f_key] : $paging_post[$f_key];
	 			elseif ($form_data['form_style'] == 1)
	 				$ynpost_key = $post[$f_key];	
 			
 			
 				/**
 				 * if ynradio value is 1
 				 */
 				if ($ynpost_key == 1){
 					$ynfields_form_array = $form_array[$f_key]['form_array'];
 					$conf_form_array = array_merge($conf_form_array,$ynfields_form_array);
 				}
 			
 			} // if (preg_match('/\bynradio_[0-9]\b/', $f_key)){
 			
 		} // foreach ($form_array as $f_key=>$f_val){
 		 
 		//print_r($conf_form_array);exit;
 		
 		/**
 		 * assign final page confirm array
 		 */
 		$final_confirm_array = $conf_form_array; 		
 		
 		/**
 		 * get ini hearder information to page count
 		 */
 		$ini_header = $this->getAttribute('ini_header');
 		
 		
 		/**
 		 * for paging form
 		 */
 		if ($form_data['form_style'] == 2){
 			
 			$page_conf_form_array = array();
 			
 			
 			/**
 			 * get ini header for page
 			 */
 			$page_header = $ini_header[$page-1];
 			$expl = explode('_', $page_header);
 			$set_id = $expl[(count($expl)-1)];
 			$get_paging_entry_list = $this->db_model->getPagingEntry($form_id, $set_id);
 					
 			foreach ($get_paging_entry_list as $page_key => $page_val){
 						
 				if(preg_match('/\bprivacy_[0-9]/', $page_val['name'])) continue;
 						
 					$page_conf_form_array[$page_val['name']] = $form_array[$page_val['name']];
 					
 			} // foreach ($get_paging_entry_list as $page_key => $page_val){
 					
 			
 			foreach ($conf_form_array as $c_key=>$c_val){
 				
 				if (key_exists($c_key, $post)){
 					
 					/**
 					 * for yes no radio fields
 					 */
		 			if (preg_match('/\bynradio_[0-9]_/', $c_key))
		 				$page_conf_form_array[$c_key] = $c_val;
		 			else	
 						$page_conf_form_array[$c_key] = $form_array[$c_key];
 					
 				}else{
 					
 					
 					/**
	 				 * for set form fields
	 				 */
 					foreach ($post as $c_p_key => $c_p_val){
 						
 						if(preg_match('/\b'.$c_key.'_/', $c_p_key))
 							$page_conf_form_array[$c_key] = $form_array[$c_key];
 					
 					} // foreach ($post as $c_p_key => $c_p_val){
 					
 					
 					/**
 					 * for uploded file
 					 */
 					if (!empty($_FILES)){
 						
 						foreach ($_FILES as $file_key => $file_val){
 							if (preg_match('/\bynradio_[0-9]/', $c_key)){
 								
 								if (preg_match('/\bynradio_[0-9]/', $file_key, $match))
 									$page_conf_form_array[$c_key] = $form_array[$match[0]]['form_array'][$c_key];
 								
 							}elseif ($file_key == $c_key){
 								$page_conf_form_array[$c_key] = $form_array[$c_key];
 							}
		 					
 						} // foreach ($_FILES as $file_key = $file_val){
 						
 					} // if (!empty($_FILES)){
 					
 					
 					
 				} // if (key_exists($c_key, $post)){
 				
 			} // foreach ($conf_form_array as $c_key=>$c_val){
 			
 			/**
 			 * assign page confirm form array to confirm form array
 			 */
 			$conf_form_array = $page_conf_form_array;
 			
 		} // if ($form_data['form_style'] == 2){
 		
 		//print_r($conf_form_array);exit;
 		
 		
 		/**
 		 * search image and pdf fields
 		 */
 		$image_fields	 = array();
 		$pdf_fields		 = array();
 		foreach ($conf_form_array as $cf_key=>$cf_val){
 			
 			/**
 			 * search image fields
 			 */
 			if (preg_match('/image_[0-9]/', $cf_key))
 				$image_fields[] = $cf_key;
 			
 			/**
 			 * search pdf fields
 			 */
 			if (preg_match('/pdf_[0-9]/', $cf_key))
 				$pdf_fields[] = $cf_key;
 		
 		} // foreach ($form_array as $f_key=>$f_val){
 		
 		
 		/**
 		 * image files check and upload
 		 * pdf files check and upload
 		 */ 
 		foreach ($image_fields as $image_field){
 			
 			if (empty($post[$image_field])){	

 				if($_FILES[$image_field]['name']){
 					
 					if (is_array($conf_form_array[$image_field]['options'])){
 						
 						foreach ($conf_form_array[$image_field]['options'] as $image_type){
 							$image_types[] = $this->data_class->getImageTypeName($image_type);
 						}
 					
 					}elseif (preg_match('/::/', $conf_form_array[$image_field]['options']))	
 						$image_types = explode('::', $conf_form_array[$image_field]['options']);
						
 					$save_post[$image_field] = $post[$image_field] = file_upload($image_field, $image_types, 'image');
 					
 					
 					
 					/**
 					 * for paging style form
 					 */
 					if ($form_data['form_style'] == 2)
 						$page_post[$image_field] = $post[$image_field];
					
				}

 			} // if (empty($post[$image_field])){
				
		} // foreach ($image_fields as $image_field){
		
		
		foreach ($pdf_fields as $pdf_field){
			
			if (empty($post[$pdf_field])){
				
				if($_FILES[$pdf_field]['name']){
					
					$save_post[$pdf_field] = $post[$pdf_field] = file_upload($pdf_field, array('pdf'), 'pdf');
					
					/**
 					 * for paging style form
 					 */
 					if ($form_data['form_style'] == 2)
 						$page_post[$pdf_field] = $post[$pdf_field];
				 
				} // if($_FILES[$pdf_field]['name']){
				
			} // if (empty($post[$pdf_field])){

		} // foreach ($pdf_fields as $pdf_field){			
		
		//print_r($post); 
 		//print_r($conf_form_array); exit;
 		
		/**
		 * save post data set in session
		 */
		$this->setAttribute('save_post', $save_post);
 		
 		/**
 		 * post data check for error
 		 */
 		$err_msg = $this->error_ckeck->formErrorCheck($conf_form_array, $post);
 		//print_r($err_msg);exit;
 		
 		
 		/**
 		 * post data save in session for back form
 		 */
 		if (!empty($post))
 			$this->setAttribute('back_post', $post);
 		
 		/**
 		 * back paging post data
 		 */
 		$back_paging_post = $post;
 			
 		/**
 		 * post data assign to view
 		 */
 		if (!empty($post))
 			$this->viewAssign('pd', h_array($post));
 		
 			
 		/**
 		 * get back paging post
 		 */
 		$get_back_paging_post = $this->getAttribute('back_paging_post');
 		$this->removeAttribute('back_paging_post');

 		if (!empty($get_back_paging_post) && is_array($get_back_paging_post))
 			$set_back_paging_post = array_merge($get_back_paging_post, $back_paging_post);
 		else 
 			$set_back_paging_post = $back_paging_post;
 					
 		/**
 		 * back paging post data save in session
 		 */
 		$this->setAttribute('back_paging_post', $set_back_paging_post);
 		
 		
 		/**
 		 * if error then display form else goes to confimation page
 		 */
 		if ($err_msg){
 			
 			
 			/**
 			 * error message save in session
 			 */
 			$this->setAttribute('err_msg', $err_msg);
 			
 			/**
	 		 * page redirect back form
	 		 */
 			$url_array = array(	
		 		$this->module_name, 'backForm', 
		 		'form_id', make_id($form_id)
		 	);
 			
		 	if (!empty($page)) {
 				$url_array = array_merge($url_array, array('page', make_id($page)));
 			}
 			
 			$redirect_url = $this->makeUrl($url_array);
 			$this->redirect($redirect_url);
 			
 			exit;
 		
 		}else {
 			
 			//print_r($post);
 			
 			/**
 			 * remove err_msg from session
 			 */
 			$this->removeAttribute('err_msg');
 			
 			/**
 			 * confirm display
 			 */
 			if ($form_data['form_style'] == 1){
 				
 				/**
 				 * form_style assign to view
 				 */
 				$this->viewAssign('form_style', 'consul');
 			
	 			/**
	 			 * build confirmation html and assign to view
	 			 */
	 			$conf_html  = $this->html_code_class->htmlConf($conf_form_array, 'post_form_'.$form_id);
	 			$this->viewAssign('conf_html', $conf_html);
	 			
	 			/**
	 			 * generate mail template and mail template save in session
	 			 */
	 			$mail_template = $this->mail_template_class->MailTemplate($conf_form_array, 'mail_template_'.$form_id);
	 			$this->setAttribute('mail_template', $mail_template);
	 			
	 			/**
		 		 * update form view
		 		 */
		 		$this->db_model->pageViewUpdate('form', 'conf_view', $form_id);
		 		
	 			
	 			$this->setDisplay('conf');
	 			
 			}elseif ($form_data['form_style'] == 2){
 				
 				/**
 				 * form_style assign to view
 				 */
 				$this->viewAssign('form_style', 'paging');
 				
 				
 				/**
 				 * get paging post data 
 				 */
 				$paging_post = $this->getAttribute('paging_post');
 				$this->removeAttribute('paging_post');
 				/**
 				 * merge new post data to paging post array
 				 */
 				if (!empty($paging_post) && is_array($paging_post))
 					$paging_post = array_merge($paging_post, $page_post);
 				else 
 					$paging_post = $page_post;
 					
 				//print_r($paging_post);exit;
 				
 				/**
 				 * post data save in session for paging
 				 */
 				$this->setAttribute('paging_post', $paging_post);
 				
 				/**
 				 * get ini hearder information to page count
 				 */
 				$ini_header = $this->getAttribute('ini_header');
 				
 				/**
 				 * check where it is last page or not
 				 */
 				if (count($ini_header) != $page){
 					
 					$next_page = $page+1;
 					
 					if ($next_page == count($ini_header))
 						$this->viewAssign('last_page', 'last');
 					else 
 						$this->viewAssign('last_page', 'page');
 					
 					/**
			 		 * page redirect to new page
			 		 */
		 			$url_array = array(	
				 		$this->module_name, 'newEntry', 
				 		'form_id', make_id($form_id),
				 		'page', make_id($next_page),
				 	);
		 			$redirect_url = $this->makeUrl($url_array);
		 			$this->redirect($redirect_url);
			  		
 				}elseif (count($ini_header) == $page){
 					
 					//print_r($final_confirm_array);exit;
 					 					
 					/**
 					 * paging post data assign to view
 					 */
 					$this->viewAssign('pd', $set_back_paging_post);
 					
 					/**
		 			 * build final confirmation html and assign to view
		 			 */
		 			$conf_html  = $this->html_code_class->htmlConf($final_confirm_array, 'post_form_'.$form_id);
		 			$this->viewAssign('conf_html', $conf_html);
		 			
		 			/**
		 			 * generate mail template and mail template save in session
		 			 */
		 			$mail_template = $this->mail_template_class->MailTemplate($final_confirm_array, 'mail_template_'.$form_id);
		 			$this->setAttribute('mail_template', $mail_template);
		 			
		 			/**
			 		 * update form view
			 		 */
			 		$this->db_model->pageViewUpdate('form', 'conf_view', $form_id);
			 		
			 		
		 			
		 			$this->setDisplay('conf');
 				
 				} // if (count($ini_header) != $page){
 				
 				//exit;
 				
 			} // if ($form_data['form_style'] == 1){
 			
 		} // if ($err_msg){ 		
 		
 	} // confAction
 	
 	
 	
 	
 	/**
 	 * save action controller
 	 */
 	public function saveAction(){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get post data
 		 */
 		$post = $this->getAttribute('save_post');
 		//print_r($post);exit;
 		
 		/**
 		 * get paging post data 
 		 */
 		$paging_post = $this->getAttribute('paging_post');
 		//print_r($paging_post);exit;
 		
 		/**
 		 * get form information
 		 */
 		$form_data = $this->form_data;
 		//print_r($form_data);exit;
 		
 		/**
 		 * post data for paging style form
 		 */
 		if ($form_data['form_style'] == 2){
 			$post = $paging_post;
 		}
 		
 		/**
 		 * make data for data base  
 		 */
 		$set_data  = array();
 		$set_array = array();
 		foreach ($post as $p_key=>$p_val){
 			
 			/**
 			 * make options data for data base
 			 */
 			if (is_array($p_val)){
 				
 				if (key_exists('other', $p_val)){
	 				$other = $p_val['other'];
	 				unset($p_val['other'],$post[$p_key]);
	 				
	 				if (key_exists(1, $p_val))
		 				$post[$p_key]  = join('::', $p_val);
		 			else
		 				$post[$p_key] = $p_val[0];
		 				 	
		 			$post[$p_key] = $post[$p_key].':other:'.$other;
		 			
 				}else {
 					$post[$p_key] = join('::', $p_val);
 				}

 				//print $post[$p_key]."<br /><br />";
 			
 			} // if (is_array($p_val)){
 			
 			
 			$p_key_expl = explode('_', $p_key);
 			$field_key	= $p_key_expl[0].'_'.$p_key_expl[1];
 			
 			/**
 			 * make name data
 			 */
 			if (preg_match('/name_[0-9]/', $p_key)){
 				
 				$set_data['name'][$field_key][] = $p_key.':=:'.$p_val;
 				unset($post[$p_key]);
 				 				
 			} // if (preg_match('/name_[0-9]/', $p_key)){
 			
 			
 			/**
 			 * make address data
 			 */
 			if (preg_match('/address_[0-9]/', $p_key)){
 				
 				$set_data['address'][$field_key][] = $p_key.':=:'.$p_val;
 				unset($post[$p_key]);
 				 				
 			} // if (preg_match('/address_[0-9]/', $p_key)){
 			
 			/**
 			 * make mail data
 			 */
 			if (preg_match('/mail_[0-9]/', $p_key)){
 				
 				$auto_mail = $this->db_model->checkAutoMail($form_id, $p_key);
 				if ($auto_mail == 1){
 					if (preg_match('/_conf/', $p_key)) continue;
 					$auto_mail_array[] = $p_val;
 				}
 				
 				$set_data['mail'][$field_key][] = $p_key.':=:'.$p_val;
 				unset($post[$p_key]);print "<br />";
 				
 			} // if (preg_match('/mail_[0-9]/', $p_key)){
 			
 			//print_r($auto_mail_array);
 			
 			
 			/**
 			 * make birthday data
 			 */
 			if (preg_match('/birthday_[0-9]/', $p_key)){
 				
 				$set_data['birthday'][$field_key][] = $p_key.':=:'.$p_val;
 				unset($post[$p_key]);
 				 				
 			} // if (preg_match('/birthday_[0-9]/', $p_key)){
 			
 			
 			/**
 			 * make tel data
 			 */
 			if (preg_match('/tel_[0-9]/', $p_key)){
 				
 				$set_data['tel'][$field_key][] = $p_key.':=:'.$p_val;
 				unset($post[$p_key]);
 				 				
 			} // if (preg_match('/tel_[0-9]/', $p_key)){
 			
 			
 			/**
 			 * make password data
 			 */
 			if (preg_match('/password_[0-9]/', $p_key)){
 				
 				$set_data['password'][$field_key][] = $p_key.':=:'.$p_val;
 				unset($post[$p_key]);
 				 				
 			} // if (preg_match('/password_[0-9]/', $p_key)){
 			
 			
 			/**
 			 * update survey set answer count
 			 */
 			if (preg_match('/svid_[0-9]_fid_[0-9]_sid_[0-9]/', $p_key)){
 				
 				$expl_survey_name = explode('_sid_', $p_key);
 				$set_id = $expl_survey_name[1];
 				
 				if (!in_array($set_id, $set_array)){
 					$this->db_model->updateAnswerCount($p_key);
 					array_push($set_array, $set_id);
 				}
 			
 			} // if (preg_match('/_svid_[0-9]_fid_[0-9]_sid_[0-9]/', $p_key)){
 			
 			
 			if (preg_match('/svid_[0-9]_fid_[0-9]_sid_[0-9]/', $p_key)){

 				if (!empty($p_val)){
 					$this->db_model->updateSurveyReport($p_key, $post[$p_key]);
 				}
 				
 			} // if (preg_match('/_svid_[0-9]_fid_[0-9]_sid_[0-9]/', $p_key)){
 			
 			
 		} // foreach ($post as $p_key=>$p_val){
 		
 		//print_r($post);
 		//exit;
 		
 		
 		/**
 		 * make ynradio data for data base
 		 */
 		$ynradio = array();
 		foreach ($post as $p_key=>$p_val){
 			
 			/**
 			 * make ynradio data
 			 */
 			if (preg_match('/ynradio_[0-9]/', $p_key)){
 				
 				$p_key_expl  		 	 = explode('_', $p_key);
 				$ynradio_key 		 	 = $p_key_expl[0].'_'.$p_key_expl[1];
 				$ynradio[$ynradio_key][] = $p_key.':=:'.$p_val;				
 				
 				unset($post[$p_key]);
 			
 			} // if (preg_match('/ynradio_[0-9]/', $p_key)){
 			
 			/*if (preg_match('/_svid_[0-9]_fid_[0-9]_sid_[0-9]/', $p_key)){

 				if (!empty($p_val)){
 					$this->db_model->updateSurveyReport($p_key, $p_val);
 				}
 				
 			} // if (preg_match('/_svid_[0-9]_fid_[0-9]_sid_[0-9]/', $p_key)){
 			*/
 			
 		} // foreach ($post as $p_key=>$p_val){
 		
 		
 		/**
 		 * merge ynradio fields in post data
 		 */
 		foreach ($ynradio as $yn_key=>$yn_val){
 			
 			$post[$yn_key] = join('|fd|', $yn_val);
 			
 		} // foreach ($ynradio as $yn_key=>$yn_val){
 		
 		
 		/**
 		 * make set data for data base
 		 */
 		foreach ($set_data as $set_row){
 			
 			foreach ($set_row as $s_key=>$s_val){
 				$post[$s_key] = join('|fd|', $s_val);
 			}
 			
 		} // foreach ($set_data as $set_row){
 		
 		
 		//print_r($post);exit;
 		
 		/**
 		 * unset post page no
 		 */
 		unset($post['page_no']);
 		
 		if (!empty($auto_mail_array))
 			$post['mail_send'] = 1;
 		
 		/**
 		 * insert into data base
 		 */
 		$this->db_model->save($form_id, $post);
 		
 		/**
 		 * replace array
 		 */
 		$replace_array = array('<br>', '<br />', '<p>', '</p>');
 		
 		/**
 		 * get mail template
 		 */
 		$mail_template = str_replace($replace_array, "\n", $this->getAttribute('mail_template'));
 		
 		/**
 		 * customer mail body
 		 */
 		$customer_mail_body = str_replace($replace_array, "\n", $form_data['customer_mail_header'])."\n\n".$mail_template."\n\n".str_replace($replace_array, "\n", $form_data['customer_mail_footer']);
 		
 		/**
 		 * admin mail body
 		 */
 		$admin_mail_body = str_replace($replace_array, "\n", $form_data['admin_mail_header'])."\n\n".$mail_template."\n\n".str_replace($replace_array, "\n", $form_data['admin_mail_footer']);
 		 		
 		/**
 		 * send mail to customer
 		 */
 		foreach ($auto_mail_array as $mail){
	 		send_mail($form_data['admin_mail1'], $form_data['customer_mail_title'], $customer_mail_body, $mail);
	 	}
 		
 		/**
 		 * mail send to admin
 		 */
 		if (!empty($form_data['admin_mail1']))
 			send_mail($form_data['admin_mail1'], $form_data['admin_mail_title'], $admin_mail_body, $form_data['admin_mail1']);
 		
 		if (!empty($form_data['admin_mail2']))
 			send_mail($form_data['admin_mail2'], $form_data['admin_mail_title'], $admin_mail_body, $form_data['admin_mail2']);
 			
 		if (!empty($form_data['admin_mail3']))
 			send_mail($form_data['admin_mail3'], $form_data['admin_mail_title'], $admin_mail_body, $form_data['admin_mail3']);	
 		
 		/**
 		 * save mail contents
 		 */	
 		$mail_data = array(
 			'mail_from'		=> $form_data['admin_mail1'],
 			'mail_to'		=> $auto_mail_array[0],
 			'mail_subject'	=> $form_data['customer_mail_title'],
 			'mail_body'		=> $customer_mail_body,
 		);
 		if (!empty($auto_mail_array[0])){
 			$this->db_model->saveMailContent($form_id, $mail_data);
 		}
 		
 		/**
 		 * update form view
 		 */
 		$this->db_model->pageViewUpdate('form', 'send_view', $form_id);
 		
 		/**
 		 * remove post data form session
 		 */
 		$this->removeAttribute('post');
 		$this->removeAttribute('paging_post');
 		
 		/**
	 	 * page redirect form index
	 	 */
	 	$url_array = array(	
	 		$this->module_name, 'thanks',
	 	);
 		$redirect_url = $this->makeUrl($url_array);
	  	$this->redirect($redirect_url);
 			
 		exit;
 		
 	} // saveAction
 	
 	
 	
 	/**
 	 * thank you page action controller
 	 */
 	public function thanksAction(){
 		
 		/**
 		 * get form data
 		 */
 		$form_data = $this->form_data;
 		
 		/**
 		 * get thanks content and assign to view
 		 */
 		$this->viewAssign('thanks', $form_data['thanks']);
 		
 		$this->setDisplay('thanks'); 		
 		
 	} // thanksAction
 	
 	
 	
 	
 	/**
 	 * top page view
 	 */
 	public function topPageViewAction(){
 		
 		$this->db_model->pageViewUpdate('top', 'top_view');
 		exit;
 		
 	} // topPageViewAction
 	 	
 	
 	
 	
 	/**
 	 * generate form html code
 	 */
 	private function htmlCode($type='form'){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get form set list
 		 */
 		$form_set_list = $this->db_model->getFormSetList($form_id);
 		//print_r($form_set_list);

 		/**
 		 * ini header list
 		 */
 		$ini_header = array();
 		foreach ($form_set_list as $set_row){
 			$check = $this->db_model->checkFormEntry($form_id, $set_row['id']);	
 			
 			if ($check > 0)	
 				$ini_header[] = 'publish_form_'.$form_id.'_'.$set_row['id'];
 		}
 		
 		/**
 		 * save ini header in session
 		 */
 		$this->setAttribute('ini_header', $ini_header);
 		
 		/**
 		 * form ini directory
 		 */
 		$ini_dir  = FORM_INI_DIR;
 		$ini_path = $ini_dir.'/'.'formset_'.$form_id.'.ini';
 		
 		if (!file_exists($ini_path)){
 			
 			$this->setDisplay('error');
 			exit;
 		}
 		
 		/**
 		 * parse form ini
 		 */
 		$ini_parser = new IniParserClass();
 		$ini_array  = $ini_parser->iniParse($ini_path);
 		
 		
 		
 		/**
 		 * make form html
 		 */
 		$form_html = "";
 		$form_array = array();
 		foreach ($ini_header as $ini_row){
	 		
	 		/**
	 		 * form array for specific page
	 		 */
 			$form_set_array = array();
	 		$form_set_array = $ini_parser->getFormArray($ini_array, $ini_row);
	 		$form_set_array_kyes = array_keys($form_set_array);
	 		
	 		if (is_array($form_set_array))
	 			$form_array = array_merge($form_array, $form_set_array);
	 			
 			/**
	 		 * get yes no field form array
	 		 */
	 		foreach ($form_set_array_kyes as $set_key){
	 			if (preg_match('/ynradio_[0-9]/', $set_key)){
	 				
	 				$ynform_array[$set_key] = $form_set_array[$set_key];
	 				$ynform_array[$set_key]['form_array'] = $this->html_code_class->makeYesNoFieldsData($set_key, $form_set_array[$set_key]);
	 				
	 				if (is_array($ynform_array))
	 					$form_array = array_merge($form_array, $ynform_array);
	 			}
	 		}
	 				 		
	 		/**
	 		 * generate html code
	 		 */
	 		$form_html .= '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle">';
	 		$form_html .= $this->html_code_class->htmlForm($form_set_array, $ini_row, $type);
	 		$form_html .= '</table>';

	 	} // foreach ($ini_header as $ini_row){
	 	
	 	/**
	 	 * form array save session 
	 	 */
	 	if (is_array($form_array))
	 		$this->setAttribute('form_array', $form_array);
	 	
	 	/**
 		 * assign from html and option count
 		 */
 		$this->viewAssign('form_html', $form_html);
 		
 		
 	} // htmlCode
 	
 
 } // topControllerClass
 
 
 ?>