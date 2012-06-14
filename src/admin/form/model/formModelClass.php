<?php
/**
 * formModelClass.php
 * 
 * @created on 2011/12/13
 * @package    Form
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2011/12/13 - 17:15:35 fabien 
 * 
 *File content
     formModelClass.php
 *     
 */
 
 
 class formModelClass extends Configuration{

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
 		$this->table = 'form_tab';
 		
 		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
 		parent::__construct();
 		
 	} // __construct
 	
 	
 	
 	/**
 	 * 
 	 * get form list
 	 * @param $limit
 	 * @param $offset
 	 * @return $result
 	 */
 	public function getList($limit = null, $offset = null){
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('delete_flg', 0);
 		$QB->setOrder(' order_num DESC ');
 		
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
 		
 		return $result;
 		
 	} // getList
 	
 	
 	
 	
 	
 	
 	/**
 	 * get form data
 	 * @param $form_id
 	 * @return form data
 	 */
 	public function getFormData($form_id){
 		
 		if (empty($form_id) || !is_numeric($form_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: form id is empty");
 		
	 		
	 	$QB = new QueryBuilder();
	 	$QB->setInteger('id', $form_id);
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
 			$data['entry_date']		= time();
 			$data['order_num']		= ($this->wpcms->getDisplayOrder('form_tab', 'last')+1);
 		}

 			
 		$this->DB->post($data, $this->table);	
 		
 	} // save
 	
 	
 	
 	
 
 
 } // formModelClass.php
 
 
 ?>