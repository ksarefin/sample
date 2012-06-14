<?php
/**
 * form_reportControllerClass.php
 * 
 * @created on 2012/02/09
 * @package    FORM
 * @subpackage Edirot
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/02/09 - 17:35:25 fabien 
 * 
 *File content
     form_reportControllerClass.php
 *     
 */
 
 
 class form_reportControllerClass extends Configuration{
 	
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
 		$this->db_model = new form_reportModelClass();
 		
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
 		 * get set url id
 		 */
 		$url_set_id = $this->getUrlParam('set_id');
 		$this->set_id = get_id($url_set_id);
 		
 		/**
 		 * save set id in session and assign to view
 		 */
 		if ($this->set_id)
 			$this->setAttribute('set_id', $this->set_id);
 			
 		$this->viewAssign('set_id', $this->set_id);	
 		
 		/**
  		 * login check
  		 */
  		$this->login_class->checkLogin($this->access_name);
 		
 		/**
  		 * page title
  		 */
  		$this->viewAssign('page_title', 'フォーム集計');
 		
 	} // commonAction
 	
 	
 	
 	/**
 	 * index action controller
 	 */
 	public function indexAction(){
 		
 		//$calender = $this->CalendarBuild();
 		//$this->viewAssign('calender', $calender);
 		
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
		 * get page view list
		 */
 		$list = $this->db_model->getPageViewList($limit, $offset);
 	
 		/**
 		 * page view list assign to view
 		 */
 		$this->viewAssign('list', $list);
 		
 		/**
 		 * get total row number and assign to view 
 		 */
 		$total_rows = $this->db_model->getTotalRows();
 		$this->viewAssign('total_rows', $total_rows);
 		
 		/**
 		 * data base row count and assign to view
 		 */
 		if (empty($this->num_rows))
 			$this->num_rows = $this->db_model->getNumRows();
 		
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
 	 * monthly report display action controller
 	 */
 	public function monthlyReportAction(){

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
 		$offse = ($page_no-1) * $limit;
 		
 		/**
 		 * set number to dispaly list number on view
 		 */
 		$this->viewAssign('number', (($page_no-1)*$limit));
 		
 		/**
		 * get page view list
		 */
 		$list = $this->db_model->getMonthlyReportList($form_id, $limit, $offse);
 	
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
 			$page_class = new PageClass(count($list), $page_no, $limit);
 			$this->viewAssign('prev', $page_class->isPrev());
			$this->viewAssign('prev_pn', $page_no-1);
			$this->viewAssign('next', $page_class->isNext());
			$this->viewAssign('next_pn', $page_no+1);
			$link_url = $this->self_url.'/'.$this->action_name.'/form_id/'.make_id($form_id).'/limit/'.$limit;
			$paging = $page_class->DisPage($link_url);
			$this->viewAssign("paging",$paging);
		}
 		
		
 		
 		$this->setDisplay('monthly_list');
 		
 	} // monthlyReportAction	
 	
 	
 	
 	
 	/**
 	 * survey report view controller
 	 */
 	public function surveyReportAction(){
 		
 		
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
 		$offse = ($page_no-1) * $limit;
 		
 		/**
 		 * set number to dispaly list number on view
 		 */
 		$this->viewAssign('number', (($page_no-1)*$limit));
 		
 		/**
		 * get page view list
		 */
 		$list = $this->db_model->getSurveyReportList($limit, $offse);
 	
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
 			$page_class = new PageClass(count($list), $page_no, $limit);
 			$this->viewAssign('prev', $page_class->isPrev());
			$this->viewAssign('prev_pn', $page_no-1);
			$this->viewAssign('next', $page_class->isNext());
			$this->viewAssign('next_pn', $page_no+1);
			$link_url = $this->self_url.'/'.$this->action_name.'/limit/'.$limit;
			$paging = $page_class->DisPage($link_url);
			$this->viewAssign("paging",$paging);
			
		} // if ($limit == 'all'){
 		
		
 		
 		$this->setDisplay('survey_report');
 		
 		
 	} // surveyReportAction
 	
 	
 	
 	
 	/**
 	 * set survey report view controller
 	 */
 	public function SetSurveyReportAction(){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get set id
 		 */
 		$set_id = $this->getAttribute('set_id');
 		
 		/**
 		 * get post data
 		 */
 		$post = $this->getPost();
 		
 		/**
 		 * post data assign to view and save in session
 		 */
 		if (!empty($post)){
 			$this->viewAssign('pd', $post);
 			$this->viewAssign('post', $post); 		
 		}
 		
 		/**
 		 * set page url array
 		 */
 		$url_array = array(
 			$this->module_name, $this->action_name,
 			'form_id', make_id($form_id),
 			'set_id', make_id($set_id),
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
 		 * get set survey list
 		 */
 		$survey_list = $this->db_model->getSurleyList($form_id, $set_id);
 		//print_r($survey_list);
 		
 		
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
 			$page_class = new PageClass(count($survey_list), $page_no, $limit);
 			$this->viewAssign('prev', $page_class->isPrev());
			$this->viewAssign('prev_pn', $page_no-1);
			$this->viewAssign('next', $page_class->isNext());
			$this->viewAssign('next_pn', $page_no+1);
			$link_url = $this->self_url.'/'.$this->action_name.'/form_id/'.make_id($form_id).'/set_id/'.make_id($set_id).'/limit/'.$limit;
			$paging = $page_class->DisPage($link_url);
			$this->viewAssign("paging",$paging);
			
		} // if ($limit == 'all'){
		
		
		/**
		 * for limited time search
		 * convert start date and end date into mktime
		 */
		$params = array();
		if ($post['report_type'] == 2){
			
			if (!empty($post['start'])){
				$expl_start_date = explode('/', $post['start']);
				$params['start_date'] = mktime(0, 0, 0, $expl_start_date[1], $expl_start_date[2], $expl_start_date[0]);
			}
			
			if (!empty($post['end'])){
				$expl_end_date = explode('/', $post['end']);
				$params['end_date'] = mktime(0, 0, 0, $expl_end_date[1], $expl_end_date[2], $expl_end_date[0]);
			}
			
		} //if ($post['report_type'] == 2){
		
		/**
 		 * get set survey list
 		 */
 		$survey_list = $this->db_model->getSurleyList($form_id, $set_id, $limit, $offset);
 		
 		/**
 		 * get survey list option count 
 		 * and survey list assign to view 
 		 */
 		$list = array();
 		foreach ($survey_list as $row){
 			
 			$tmp_row = array();
 			
 			$tmp_row = $row;
 			
 			/**
 			 * check for other option
 			 * and explode options to make array
 			 */
 			$expl = array();
 			if (preg_match(':other:', $row['options'])){
 				$expl = explode(':other:', $row['options']);
 				$opt_expl = explode('::', $expl[0]);
 			}else {
 				$opt_expl = explode('::', $row['options']);
 			}
 			
 			/**
 			 * get option count
 			 */
 			$option_key = 1;
 			$total_count = 0;
 			foreach ($opt_expl as $option){
 				$opt_count = $this->db_model->getOptionCount($form_id, $set_id, $row['id'], $option_key, $params);
 				$total_count += $opt_count;
 				$tmp_row['option'][] = array('name' => $option, 'count'=>$opt_count);
 				$option_key++;
 			}
 			
 			/**
 			 * get other count
 			 */
 			if (!empty($expl[1])){
 				
 				$opt_count = $this->db_model->getOptionCount($form_id, $set_id, $row['id'], ':other:', $params);
 				$total_count += $opt_count;
 				$tmp_row['option'][] = array('name' => 'その他', 'count'=>$opt_count);
 				
 			}
 			
 			/**
 			 * make total count
 			 */
 			$tmp_row['total_count'] = $total_count;
 			
 			/**
 			 * generate survey list
 			 */
 			$list[] = $tmp_row;
 			
 		} // foreach ($survey_list as $row){
 		
 		
 		/**
 		 * survey list assign to view and save in session
 		 */
 		$this->viewAssign('list', $list);
 		$this->setAttribute('list', $list);
 		//print_r($list);
 		
 		/**
  		 * inculde css and js to view
  		 */
  		$static_dir = WEB_DIR.COMMOM_DIR."/static";
  		$css[] = $static_dir."/css/datePicker.css";
  		$css[] = $static_dir."/css/jquery.ui.theme.css";
  		$css[] = $static_dir."/css/jquery.ui.datepicker.css";
  		$css[] = $static_dir."/css/jquery.ui.core.css";
  		$this->viewAssign('css', $css);
  		
  		$js[]  = $static_dir."/scripts/jquery-1.7.1.js";
  		$js[]  = $static_dir."/scripts/jquery.ui.core.js";
  		$js[]  = $static_dir."/scripts/jquery.ui.datepicker.js";
  		$this->viewAssign('js', $js);
 		
 		
 		$this->setDisplay('set_survey_list');
 		
 	} // SetSurveyReportAction
 	
 	
 	
 	
 	
 	/**
 	 * report csv download action controller
 	 */
 	public function surveyReportCsvAction(){
 		
 		/**
 		 * get form id
 		 */
 		$form_id = $this->getAttribute('form_id');
 		
 		/**
 		 * get form title
 		 */
 		$get_form_record = $this->wpcms->getColumnsVal(array('title'), 'id', $form_id, 'form_tab');
 		$form_title = $get_form_record['title'];
 		
 		/**
 		 * get set id
 		 */
 		$set_id = $this->getAttribute('set_id');
 		
 		/**
 		 * get set title
 		 */
 		$get_set_record = $this->wpcms->getColumnsVal(array('title'), 'id', $set_id, 'set_tab');
 		$set_title = $get_set_record['title'];
 		
 		/**
 		 * get post data
 		 */
 		$post = $this->getAttribute('post');
 		
 		/**
 		 * get report list
 		 */
 		$list = $this->getAttribute('list');
 		//print_r($list);exit;
 		
 		/**
 		 * assign csv data array
 		 */
 		$csv_data = array();
 		
 		$csv_data[] = "\n".$set_title.'('.$form_title.')'."\n";
 		
 		if ($post['report_type'] == 2)
 			$csv_data[] = 'の期間　　：'.$post['start'].'～'.$post['end']."\n\n";
 		else 
 		 	$csv_data[] = '全期間'."\n\n";
 		
 		/**
 		 * make csv data array
 		 */
 		
 		foreach ($list as $row){
 			
 			$tmp_list = array();
 			$tmp_list[] = $row['name'];
 			
 			foreach ($row['option'] as $option_row){
 				
 				if ($option_row['count'] > 0)
 					$tmp_list[] = $option_row['name'].':'.$option_row['count'].':'.number_format(($option_row['count']*100)/$row['total_count'], 2, '.', '').'%';
 				else
 					$tmp_list[] = $option_row['name'].':'.$option_row['count'].':0%';
 					 				
 			} // foreach ($row['option'] as $option_row){
 			
 			$csv_data[] = implode(',', $tmp_list);
 			 
 		} // foreach ($list as $row){
 		
 		
 		/**
		 * make csv text from csv data array
		 */
		$csv_text = mb_convert_encoding(implode("\n", $csv_data), "Shift_JIS");
		
		
		/**
		 * make csv downloadable
		 */
		header("Cache-Control: public");
		header("Pragma: public");
		
		$csv_name = $set_title.'('.$form_title.')';
		header(sprintf("Content-disposition: attachment; filename=%s.csv",$set_title));
		header(sprintf("Content-type: application/octet-stream; name=%s.csv",$set_title));

		echo $csv_text;
		exit;
		
		
 		
 	} // surveyReportCsvAction
 	
 	
 	 	
 	
 	
 	public function CalendarBuild()
		{
			

			define("ADAY", (60*60*24));
			
			$Entrymonth = '5';			 
			$Entryyear  = '2013';
			 
			 if (!checkdate($Entrymonth, 1, $Entryyear)) {
			     $nowArray = getdate();
			     $month = $nowArray['mon'];
			     if($month<10){
			     	$month = "0".$month;
			     }
			     $year = $nowArray['year'];
			 } else {
			     $month = $Entrymonth;
			     if($month<10){
			     	$month = "0".$Entrymonth;
			     }
			     $year = $Entryyear;
			 }
			 $start = mktime (12, 0, 0, $month, 1, $year);
			 $firstDayArray = getdate($start);

			$todayInfo = getDate();
			
			
			if($Calendar_Language==1){
			 	$days = Array("..", "..", "..", "..",
			 	"..", "..", "..");
			 	
			 	
			 	$print .="<th colspan=\"7\" scope=\"col\" align=\"center\">".$year."^".$month."..</th>";
			 	
				$print .="</tr>";
				$print .="<tr align=\"center\" bgcolor=\"#CCCCCC\">";
			}
			else{
			 	$days = Array("S", "M", "T","W", "T", "F","S");
			 	
			 	$print .="<div id=\"cal_cont\"><h3 id=\"year_month\"><span id=\"yearn\">".$year.'</span><span id="monthn">'.$month.'</span></h3></div>';
			 	
			}
			
			$print  .='<table id="calenderBox">
  							<tr>
    							<td>';
			
			
			
			$sun = ""; $mon = ""; $tue = ""; $wed =""; $thu=""; $fri=""; $sat="";
			 
			 for($count=0; $count < (6*7); $count++) {
			 	
			 	 $dayArray = getdate($start);
			 	 $url = $session_url_domain."/".$loginid_cal."/"."day".$dayArray['mday']."/"."month".$dayArray['mon']."/"."mail_year".$dayArray['year']."/"."blog_date=1";
			 	 
			 	 if(($count % 7) == 0){
			 	 	
			 	 	if($sun==""){
			 	 		
			 	 		$sun .= '<table id="sunday">
							  	<tr>
    								<td>S</td>
  							  	</tr>';
			 	 	}
			 	 	
			 	 	if($count < $firstDayArray['wday'] || $dayArray['mon'] != $month) {
			        	$sun .='<tr>
    								<td>&nbsp;</td>
  							  	</tr>';
			     	} else {
			     		
			     		
			     			$sun .='<tr>
    									<td>'.$dayArray['mday'].'</td>
  									</tr>';
			         	 

			     		$start += ADAY;
			       	}
			       	
			       	if($count==35){
			       		$sun .= '</table></td>';
			       	}
			       	
			       	
			     }
			 	 
			 	 if(($count % 7) == 1){
			 	 	if($mon==""){
			 	 		$mon .= '<td><table>
							  	<tr>
    								<td>M</td>
  							  	</tr>';
			 	 	}
			 	 	
			 	 	if($count < $firstDayArray['wday'] || $dayArray['mon'] != $month) {
			        	$mon .='<tr>
    								<td>&nbsp;</td>
  							  	</tr>';
			     	} else {
			     		
			     		
			     			$mon .='<tr>
    									<td>'.$dayArray['mday'].'</td>
  									</tr>';
			         	 

			     		$start += ADAY;
			       	}
			       	
			       	if($count==36){
			       		$mon .= '</table></td>';
			       	}
			 	 }			   
			 	 
			 	 if(($count % 7) == 2){
			 	 	if($tue==""){
			 	 		$tue .= '<td><table>
							  	<tr>
    								<td>T</td>
  							  	</tr>';
			 	 	}
			 	 	
			 	 	if($count < $firstDayArray['wday'] || $dayArray['mon'] != $month) {
			        	$tue .='<tr>
    								<td>&nbsp;</td>
  							  	</tr>';
			     	} else {
			     		
			     		
			         	
			     			$tue .='<tr>
    									<td>'.$dayArray['mday'].'</td>
  									</tr>';
			         	 

			     		$start += ADAY;
			       	}
			       	
			       	if($count==37){
			       		$tue .= '</table></td>';
			       	}
			 	 }
			 	 
			 	 if(($count % 7) == 3){
			 	 	if($wed==""){
			 	 		$wed .= '<td><table>
							  	<tr>
    								<td>W</td>
  							  	</tr>';
			 	 	}
			 	 	
			 	 	if($count < $firstDayArray['wday'] || $dayArray['mon'] != $month) {
			        	$wed .='<tr>
    								<td>&nbsp;</td>
  							  	</tr>';
			     	} else {
			     		
			     			$wed .='<tr>
    									<td>'.$dayArray['mday'].'</td>
  									</tr>';
			         	 

			     		$start += ADAY;
			       	}
			       	
			       	if($count==38){
			       		$wed .= '</table></td>';
			       	}
			 	 }     
			 	 
			 	 if(($count % 7) == 4){
			 	 	if($thu==""){
			 	 		$thu .= '<td><table>
							  	<tr>
    								<td>T</td>
  							  	</tr>';
			 	 	}
			 	 	
			 	 	if($count < $firstDayArray['wday'] || $dayArray['mon'] != $month) {
			        	$thu .='<tr>
    								<td>&nbsp;</td>
  							  	</tr>';
			     	} else {
			     		
			     		
			     			$thu .='<tr>
    									<td>'.$dayArray['mday'].'</td>
  									</tr>';
			         	 

			     		$start += ADAY;
			       	}
			       	
			       	if($count==39){
			       		$thu .= '</table></td>';
			       	}
			 	 }
			 	 
			 	 if(($count % 7) == 5){
			 	 	if($fri==""){
			 	 		$fri .= '<td><table>
							  	<tr>
    								<td>F</td>
  							  	</tr>';
			 	 	}
			 	 	
			 	 	if($count < $firstDayArray['wday'] || $dayArray['mon'] != $month) {
			        	$fri .='<tr>
    								<td>&nbsp;</td>
  							  	</tr>';
			     	} else {
			     		
			     		
			     			$fri .='<tr>
    									<td>'.$dayArray['mday'].'</td>
  									</tr>';
			         	 

			     		$start += ADAY;
			       	}
			       	
			       	if($count==40){
			       		$fri .= '</table></td>';
			       	}
			 	 }
			 	 
			 	 if(($count % 7) == 6){
			 	 	if($sat==""){
			 	 		$sat .= '<td><table id="sutarday">
							  	<tr>
    								<td>S</td>
  							  	</tr>';
			 	 	}
			 	 	
			 	 	if($count < $firstDayArray['wday'] || $dayArray['mon'] != $month) {
			        	$sat .='<tr>
    								<td>&nbsp;</td>
  							  	</tr>';
			     	} else {
			     		$sat .='<tr>
    									<td>'.$dayArray['mday'].'</td>
  									</tr>';
			         	 

			     		$start += ADAY;
			       	}
			       	
			       	if($count==41){
			       		$sat .= '</table></td>';
			       	}
			 	 }
			 	 
			 }
			 
			 $print .= $sun.$mon.$tue.$wed.$thu.$fri.$sat;
			 
			 

			 $print .="</tr>
						</table>";
			 
			 
			 $print  .='<table class="preNext_table">
  							<tr>
								<td>
    							<div class="preNext">';
			 if($Entrymonth==1){
			  	$mon_1=12;
			  	$year_1=$Entryyear-1;
			 }else{			
			  	$mon_1=$Entrymonth-1;
			  	$year_1=$Entryyear;
			 }	
			 
			 
			 $url1 = $session_url_domain."/".$loginid_cal."/"."DD".$dayArray['mday']."/"."MM".$mon_1."/"."YY".$year_1;			
			 $print .= "<a href=\"$url1\">".'<span class="leftPre">PREV</span>'."</a>";
			
			 $mon=$dayArray['mon'];
			 $url2 = $session_url_domain."/".$loginid_cal."/"."DD".$dayArray['mday']."/"."MM".$mon."/"."YY".$dayArray['year'];
			 $print .= "<a href=\"$url2\">".'<span class="rightNext">NEXT</span>'."</a>";  
			 
			 
			 
			 $print .="</div>
			 			</td>
			 			</tr>
						</table>";	
			 
			 					 
			 return $print;
		
	  }
 	
 
 
 
 } // form_reportControllerClass
 
 
 ?>