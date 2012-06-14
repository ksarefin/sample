<?php
/**
 * form_surveyModelClass.php
 * 
 * @created on 2011/12/15
 * @package    ActiveIR
 * @subpackage 
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2011/12/15 - 20:23:37 fabien 
 * 
 *File content
     form_surveyModelClass.php
 *     
 */
 
 
 class form_surveyModelClass extends Configuration{
 
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
 	 * construct method
 	 */
 	function __construct(){
 		
 		/**
 		 * wpcms class object
 		 */
 		$this->wpcms = new WpCms();

 		/**
 		 * assign table name
 		 */
 		$this->table = 'survey_tab';
 		
 		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
 		parent::__construct();
 		
 	} // __construct
 	
 	
 	
 	/**
 	 * 
 	 * get survey list
 	 * @return $result
 	 */
 	public function getList(){
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('delete_flg', 0);
 		$QB->setOrder(' order_num DESC ');
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM "; 
 		$sql .= $this->table;
 		
 		$query_txt = $QB->out($sql);
 		//print_r($query_txt);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		return $result;
 		
 	} // getList
 	
 	
 	
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
 			$search_array		= array('form_id'=>$data['form_id']);	
 			$data['order_num']	= ($this->wpcms->getDisplayOrder($this->table, 'last', $search_array)+1);
 		}
 		
 		$this->DB->post($data, $this->table);	
 		
 	} // save
 	
 	
 
 
 
 
 
 } // form_surveyModelClass.php
 
 
 ?>