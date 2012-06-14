<?php
/**
 * form_mailModelClass.php
 * 
 * @created on 2012/04/18
 * @package    FORM
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/04/18 - 15:46:24 fabien 
 * 
 *File content
     form_mailModelClass.php
 *     
 */
 
 
 class form_mailModelClass extends Configuration{

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
 		$this->table = 'form_mail_tab';
 		
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
 	public function getFormList($limit = null, $offset = null){
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('delete_flg', 0);
 		$QB->setOrder('order_num DESC ');
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM ";
 		$sql .= " form_tab ";
 		
 		$query_txt = $QB->out( $sql );
 		
 		if (!empty($limit) && is_numeric($limit)){
 			$query_txt .= " LIMIT ".$limit; 
 		}
 		
 		if (!empty($offset) && is_numeric($offset)){
 			$query_txt .= " OFFSET ".$offset;
 		}
 		
 		$result = $this->DB->refer($query_txt);
 		
 		$list = array();
 		foreach ($result as $row){
 			
 			$tmp = $row;
 			$tmp['mail_count'] = $this->getMailCount($row['id']);
 			$list[] = $tmp;
 		}
 		
 		if ($list)
	 		return $list;
 		
 	} // getFormList 	
 	
 	

 	
 	/**
 	 * get form mail list
 	 * @param $form_id
 	 * @return list
 	 */
 	public function getFormMailList($form_id, $limit = null, $offset = null){
 		
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('form_id', $form_id);
 		$QB->setOrder('id DESC');
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM "; 
 		$sql .= $this->table;
 		
 		$query_txt = $QB->out($sql);
 		
 		if (!empty($limit) && is_numeric($limit)){
 			$query_txt .= " LIMIT ".$limit; 
 		}
 		
 		if (!empty($offset) && is_numeric($offset)){
 			$query_txt .= " OFFSET ".$offset;
 		}
 		
 		$result = $this->DB->refer($query_txt);
 		
 		$list = array();
 		foreach ($result as $row){
 			
 			$tmp = $row;
 			$tmp['form_name']  = $this->getFormName($row['form_id']);
 			$tmp['mail_count'] = $this->getMailCount($row['form_id']);
 			$list[] = $tmp;
 		}
 		
 		if ($list)
	 		return $list;
 		
 	} // getFormMailList
 	
 	
 	
 	/**
 	 * get mail count
 	 * @param $form_id
 	 * @return mail count
 	 */
 	public function getMailCount($form_id){
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('form_id', $form_id);
 			
 		$sql  = " SELECT ";
 		$sql .= " count(id) AS count_id";
 		$sql .= " FROM ";
 		$sql .= $this->table;
 		
 		$query_txt = $QB->out( $sql );
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if($result) 
 			$num_rows = $result[0]['count_id'];
 			
 		return $num_rows;
 		
 	} // getMailCount
 	
 	
 	
 	/**
 	 * get form name
 	 * @param $form_id
 	 * @return form title
 	 */
 	public function getFormName($form_id){
 		
 		if (empty($form_id) || !is_numeric($form_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form id is empty or invalid");
	 		
	 		
	 	$QB = new QueryBuilder();
	 	$QB->setInteger('id', $form_id);
	 	
	 	$sql  = " SELECT ";
 		$sql .= " title ";
 		$sql .= " FROM ";
 		$sql .= " form_tab ";
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result)
 			return $result[0]['title'];
	 	
 	} // getFormName
 	
 	
 	
 	/**
 	 * get mail data
 	 * @param $mail_id
 	 * @return mail info
 	 */
 	public function getMialData($mail_id){
 		
 		if (empty($mail_id) || !is_numeric($mail_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: mail id is empty or invalid");
 		
	 	$QB = new QueryBuilder();
	 	$QB->setInteger('id', $mail_id);
	 	
	 	$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM ";
 		$sql .= $this->table;
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result)
 			return $result[0];
 			
 	} // getMialData
 	
 	
 	
 	/**
 	 * get form count
 	 * @return total count
 	 */
 	public function getFormCount(){
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('delete_flg', 0);
 		
 		$sql  = " SELECT ";
 		$sql .= " count(id) as count_id ";
 		$sql .= " FROM ";
 		$sql .= " form_tab ";
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result) 
 			$total = $result[0]['count_id'];
 		
 		return $total;
 	
 	} // getFormCount
 	
 	
 	
 	/**
 	 * get form fields list
 	 * @param $form_id
 	 */
 	public function getFormFieldList($form_id){
 		
 		if (empty($form_id) || !is_numeric($form_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form id is empty or invalid");
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('form_id', $form_id);
 		$QB->setInteger('display_flg', 1);
 		$QB->setInteger('delete_flg', 0);
 		
 		$sql  = " SELECT ";
 		$sql .= " type, name, label, field_labels, options, ynfields ";
 		$sql .= " FROM ";
 		$sql .= " form_entry_tab ";
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result) 
 			return $result;
 		
 	} // getFormFieldList
 	
 	
 	
 	/**
 	 * get form mail data
 	 * @param $form_id
 	 * @return form mail data list
 	 */
 	public function getFormMailData($form_id){
 		
 		if (empty($form_id) || !is_numeric($form_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form id is empty or invalid");
	 	
	 	$QB = new QueryBuilder();
 		$QB->setInteger('form_id', $form_id);
 		$QB->setInteger('mail_send', 1);
 		$QB->setOrder('id DESC');
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM ";
 		$sql .= " post_form_".$form_id."_tab ";
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result) 
 			return $result;
 			
 		
 	} // getFormMailData
 	
 	
 	
 	/**
 	 * get survey data
 	 * @param $survey_id
 	 * @return survey informaiton
 	 */
 	public function getSurveyData($survey_id){
 		
 		if (empty($survey_id) || !is_numeric($survey_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: survey id is empty or invalid");
	 	
	 	$QB = new QueryBuilder();
 		$QB->setInteger('id', $survey_id);
 		$QB->setInteger('display_flg', 1);
 		$QB->setInteger('delete_flg', 0);
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM ";
 		$sql .= " survey_tab ";
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result) 
 			return $result;
 			
 	} // getSurveyData
 	
 	
 	
 } // form_mailModelClass.php
 
 
 ?>