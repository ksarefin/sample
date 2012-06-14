<?php
/**
 * topModelClass.php
 * 
 * @created on 2012/01/25
 * @package    Form
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/01/25 - 15:51:53 fabien 
 * 
 *File content
     topModelClass.php
 *     
 */
 
 
 class topModelClass extends Configuration{
 	
 	
 	/**
 	 * wpcms instance
 	 */
 	private $wpcms; 
 	
 	/**
 	 * table instance
 	 */
 	private $table;
 	
 	/**
 	 * file name instance
 	 */
 	protected $file_name;

 	
 	
 	/**
 	 * class construct
 	 */
 	function __construct(){
 		
 		/**
 		 * wpcms class object
 		 */
 		$this->wpcms = new WpCms();

 		/**
 		 * assign table name
 		 */
 		$this->table = 'form_tab';
 		
 		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
 		parent::__construct();
 		
 	} // __construct
 	
 	
 	/**
 	 * get form list
 	 * @return list
 	 */
 	public function getFormList(){
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('display_flg', 1);
 		$QB->setInteger('delete_flg', 0);
 		$QB->setOrder(' order_num DESC ');
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM "; 
 		$sql .= $this->table;
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		return $result;
 		
 	} // getFormList
 	
 	
 	
 	/**
 	 * get form information
 	 * @param $form_id
 	 * @return form data
 	 */
 	public function getFormData($form_id){
 		
 		if (empty($form_id) || !is_numeric($form_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form id is empty");

	 	
	 	$QB = new QueryBuilder();
	 	$QB->setInteger('id', $form_id);
 		$QB->setInteger('display_flg', 1);
 		$QB->setInteger('delete_flg', 0);
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM "; 
 		$sql .= $this->table;
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result)
 			return $result[0];
	 		
 		
 	} // getFormData
 	
 	
 	
 	
 	/**
 	 * get form list
 	 * @param $form_id
 	 * @return form data
 	 */
 	public function getFormSetList($form_id){
 		
 		if (empty($form_id) || !is_numeric($form_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form id is empty");
 		
	 		
	 	$QB = new QueryBuilder();
	 	$QB->setInteger('form_id', $form_id);
 		$QB->setInteger('display_flg', 1);
	 	$QB->setInteger('delete_flg', 0);
	 	$QB->setOrder(' order_num ASC ');
	 		
	 	$sql  = " SELECT ";
	 	$sql .= " * ";
	 	$sql .= " FROM ";
	 	$sql .= " set_tab ";
	 		
	 	$query_txt = $QB->out($sql);
	 	
	 	//print_r($query_txt);
 		
 		$result = $this->DB->refer($query_txt);

 		return $result;	
	 		
 		
 	} // getFormSetList
 	
 	
 	
 	
 	/**
 	 * save form data
 	 * @param $form_id
 	 * @param $form_data
 	 */
 	public function save($form_id, $form_data){
 		
 		if (empty($form_id) || !is_numeric($form_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form id is empty");
 		
	 	if (empty($form_data) || !is_array($form_data))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form data is empty or invalid");
	 		
	 	
	 	/**
	 	 * make extra data
	 	 */
	 	$form_data['form_id'] 		= $form_id;	
	 	$form_data['display_flg'] 	= 1;
	 	$form_data['delete_flg']	= 0;
	 	$form_data['entry_date']	= time();
	 	
	 	/**
	 	 * table name
	 	 */
	 	$tabName = 'post_form_'.$form_id.'_tab';
	 	
	 	
	 	/**
	 	 * insert into data base
	 	 */
	 	$this->DB->post($form_data, $tabName);
	 	
 		
 	} // save
 	
 	
 	
 	/**
 	 * update page view count
 	 * @param $access
 	 * @param $page_view
 	 * @param $form_id
 	 */
 	public function pageViewUpdate($access, $page_view, $form_id=null){
 		
 		/**
 		 * check entry month 
 		 */
 		$entry_month = date('Y/m');
 		$this->wpcms->checkEntryMonth($entry_month, $access, $form_id);
 		
 		
 		/**
 		 * update top page view count
 		 */
 		$sql  = " UPDATE ";
 		$sql .= " form_report ";
 		$sql .= " SET ";
 		$sql .= $page_view." = (".$page_view."+1) ";
 		$sql .= " WHERE ";
 		$sql .= " check_month = '".$entry_month."' ";
 		$sql .= " AND ";
 		$sql .= " page_view  = '".$access."' ";
 		
 		if (!empty($form_id) && is_numeric($form_id)){
 			$sql .= " AND ";
 			$sql .= " form_tab_id  = '".$form_id."' ";
 		}
 		//print $sql;exit;
 
 		$this->DB->refer($sql);
 		
 		
 	} // topViewUpdate 
 	
 	
 	
 	/**
 	 * update set table answer count
 	 * @param $form_entry_survey_name
 	 */
 	public function updateAnswerCount($form_entry_survey_name){

 		if (empty($form_entry_survey_name) || !is_string($form_entry_survey_name))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form_entry_survey_name is empty or invalid ");
	 		
	 	$expl_svid = explode('svid_', $form_entry_survey_name);
	 	$expl_svid_val = explode('_', $expl_svid[1]);
	 	$svid = $expl_svid_val[0];
	 	
	 	$expl_fid = explode('_fid_', $form_entry_survey_name);
	 	$expl_fid_val = explode('_', $expl_fid[1]);
	 	$fid = $expl_fid_val[0];
	 	
	 	$expl_sid = explode('_sid_', $form_entry_survey_name);
	 	$expl_sid_val = explode('_', $expl_sid[1]);
	 	$sid = $expl_sid_val[0];
	 	
	 	/**
	 	 * update answer count
	 	 */
	 	$sql  = " UPDATE ";
 		$sql .= " set_tab ";
 		$sql .= " SET ";
 		$sql .= " answer_count = (answer_count+1) ";
 		$sql .= " WHERE ";
 		$sql .= " id  = '".$sid."' ";
 		//print $sql;
 		//exit;
 
 		$this->DB->refer($sql);
	 	
	 	
 		
 	} // updateAnswerCount
 	
 	
 	
 	
 	/**
 	 * update survey report
 	 * @param $survey_name
 	 * @param $value
 	 */
 	public function updateSurveyReport($survey_name, $value){
 		
 		if (empty($survey_name) || !is_string($survey_name))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: survey name is empty or invalid ");
 		
	 	if (empty($value) || !is_string($value))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: survey value is empty or invalid ");
	 		
	 	
	 	$data['survey_name'] = $survey_name;
	 	$data['answer'] 	 = $value;
	 	$data['entry_date']	 = time();
	 	
	 	$expl_svid 			= explode('svid_', $survey_name);
	 	$expl_svid_val 		= explode('_', $expl_svid[1]);
	 	$data['survey_id'] 	= $expl_svid_val[0];
	 	
	 	$expl_fid 			= explode('_fid_', $survey_name);
	 	$expl_fid_val 		= explode('_', $expl_fid[1]);
	 	$data['form_id'] 	= $expl_fid_val[0];
	 	
	 	$expl_sid 			= explode('_sid_', $survey_name);
	 	$expl_sid_val 		= explode('_', $expl_sid[1]);
	 	$data['set_id'] 	= $expl_sid_val[0];
	 	
	 	
	 	$this->DB->post($data, 'survey_report_tab');	
	 	
 	} // updateSurveyReport
 	
 	
 	/**
 	 * check server data
 	 * @param $post
 	 */
 	public function checkData($post){ 
 		
 		if (empty($post) || !is_array($post)) 
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: post data is empty or invalid ");  
 		
 		$request_url = 'http://kiwamiapp.com/wpform/response/ds'; 
 		$method  = 'POST';
 		$post['host']= $_SERVER['HTTP_HOST'];
 		$response= request($request_url,$method,$post);
 		
 		return $response; 
 	
 	} // checkData
 	
 	
 	/**
 	 * full installation of wpform
 	 * @param $post
 	 */
 	public function fullInstall($post){ 
 		
 		if (empty($post) || !is_array($post)) 
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: post data is empty or invalid ");  
 		
 		$request_url = 'http://kiwamiapp.com/wpform/response/install/'; 
 		$method  = 'POST';	
 		$post['host']= $_SERVER['HTTP_HOST'];	
 		$post['web'] = $GLOBALS['gl_wpcms_Info']['wpcms_path']; 
 		$response= request($request_url,$method,$post);
 		
 		print $response; 
 		
 	} // fullInstall
 
 
 	/**
 	 * get form entry information
 	 * @param $form_id
 	 * @param $set_id
 	 * @return entry count
 	 */
 	public function checkFormEntry($form_id, $set_id){
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('form_id', $form_id);
 		$QB->setInteger('set_id', $set_id);
 		$QB->setInteger('display_flg', 1);
 		$QB->setInteger('delete_flg', 0);
 		
 		
 		$sql  = " SELECT ";
 		$sql .= " count(id) as id_count ";
 		$sql .= " FROM "; 
 		$sql .= " form_entry_tab ";
 		
 		$query_txt = $QB->out($sql);
 		$result = $this->DB->refer($query_txt);
 		
 		return $result[0]['id_count'];
 		
 		
 	} // checkFormEntry
 	
 	
 	
 	/**
 	 * chekc for auto mail address
 	 * @param $form_id
 	 * @param $mail
 	 * @return auto_mail
 	 */
 	public function checkAutoMail($form_id, $mail){
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('form_id', $form_id);
 		$QB->setEqual('type', 'mail');
 		$QB->setEqual('name', str_replace('_mail', '', $mail));
 		$QB->setInteger('display_flg', 1);
 		$QB->setInteger('delete_flg', 0);
 		
 		
 		$sql  = " SELECT ";
 		$sql .= " auto_mail ";
 		$sql .= " FROM "; 
 		$sql .= " form_entry_tab ";
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		return $result[0]['auto_mail'];
 		
 	} // checkAutoMail
 	
 	
 	
 	
 	/**
 	 * get paging entry
 	 * @param $form_id
 	 * @param $set_id
 	 * @return entry list
 	 */
 	public function getPagingEntry($form_id, $set_id){
 		
 		if (empty($form_id) || !is_numeric($form_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form id is empty or invalid ");
 		
	 	if (empty($set_id) || !is_numeric($set_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: set id is empty or invalid ");

	 		
	 	$QB = new QueryBuilder();
 		$QB->setInteger('form_id', $form_id);
 		$QB->setInteger('set_id', $set_id);
 		$QB->setInteger('display_flg', 1);
 		$QB->setInteger('delete_flg', 0);
 		
 		
 		$sql  = " SELECT ";
 		$sql .= " name ";
 		$sql .= " FROM "; 
 		$sql .= " form_entry_tab ";
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result)
 			return $result;
 		
 	} // getPagingEntry
 	
 	
 	
 	/**
 	 * save mail content
 	 * @param $form_id
 	 * @param $mail_data
 	 */
 	public function saveMailContent($form_id, $mail_data){
 		
 		if (empty($form_id) || !is_numeric($form_id))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form id is empty or invalid ");
 		
 		if (empty($mail_data) || !is_array($mail_data))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: mail content is empty or invalid array");
 			
 		$data 				= $mail_data;
 		$data['form_id'] 	= $form_id;
 		$data['entry_date']	= time();
 		
 		$this->DB->post($data, 'form_mail_tab');
 		
 	} // saveMailContent
 	
 	
 
 } // topModelClass.php
 
 
 ?>