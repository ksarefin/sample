<?php
/**
 * form_entryModelClass.php
 * 
 * @created on 2011/12/15
 * @package    ActiveIR
 * @subpackage Form Entry
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2011/12/15 - 20:23:20 fabien 
 * 
 *File content
     form_entryModelClass.php
 *     
 */
 
 
 class form_entryModelClass extends Configuration{
 
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
 		$this->table = 'form_entry_tab';
 		
 		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
 		parent::__construct();
 		
 	} // __construct
 	
 	
 	
 	/**
 	 * 
 	 * get list from set table
 	 * @param $form_id
 	 * @param $limit
 	 * @param $offset
 	 * @return $result
 	 */
 	public function getList($form_id, $set_id, $limit = null, $offset = null){

 		if (empty($form_id) || !is_numeric($form_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form id is empty");
	 		
	 	if (empty($set_id) || !is_numeric($set_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: set id is empty");	
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('form_id', $form_id);
 		$QB->setInteger('set_id', $set_id);
 		$QB->setInteger('delete_flg', 0);
 		$QB->setOrder(' order_num ASC ');
 		
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
 		
 		//print_r($query_txt);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		return $result;
 		
 	} // getList
 	
 	
 	
 	
 	/**
 	 * get survey list
 	 * @param $survey_id
 	 * @return $result
 	 */
 	public function getSurveyInfo($survey_id){
 		
 		if (empty($survey_id) || !is_numeric($survey_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: survey id is empty");
	 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('id', $survey_id);
 		$QB->setInteger('delete_flg', 0);
 		
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM "; 
 		$sql .= " survey_tab ";
 		
 		$query_txt = $QB->out($sql);
 		//print_r($query_txt);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		return $result[0];
 		
 	} // getSurveyInfo
 	
 	
 	
 	
 	
 	/**
 	 * get form entry data
 	 * @param $form_entry_id
 	 * @return entry data
 	 */
 	public function getFormData($form_entry_id){
 		
 		if (empty($form_entry_id) || !is_numeric($form_entry_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form_entry_id id is empty");
 		
	 		
	 	$QB = new QueryBuilder();
	 	$QB->setInteger('id', $form_entry_id);
 		$QB->setInteger('delete_flg', 0);
	 		
	 	$sql  = " SELECT ";
	 	$sql .= " * ";
	 	$sql .= " FROM ";
	 	$sql .= $this->table;
	 	
	 	$query_txt = $QB->out($sql);
 		
	 	$result = $this->DB->refer($query_txt);

 		$form_data = $result[0];
 		
 		return $form_data;	
	 		
 		
 	} // getFormData
 	
 	
 	
 	/**
 	 * save post data
 	 * @param array $post
 	 */
 	public function save($post){
 		
 		if (empty($post) || !is_array($post))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: parameter post is empty or not valid array ");
 		
 		$data					= $post;
 		$data['display_flg']	= 1;
 		$data['delete_flg']		= 0;
 		$data['admin_user_id']	= $this->admin_info['id'];
 			
 		if (!empty($post['id']) && is_numeric($post['id'])){
 			$data['id'] 			= $post['id'];
 			$data['update_date']	= time();
 		}else {
 			$data['entry_date']	= time();
 			$data['update_date']	= time();
 			$search_array		= array('form_id'=>$data['form_id'], 'set_id'=>$data['set_id']);	
 			$data['order_num']	= ($this->wpcms->getDisplayOrder($this->table, 'last', $search_array)+1);
 		}
 		
 		$this->DB->post($data, $this->table);	
 		
 	} // save
 
 
 
 
 } // form_entryModelClass.php
 
 
 ?>