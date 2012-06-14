<?php
/**
 * wpnoticeModelClass.php
 * 
 * @created on 2011/10/28
 * @package    FORM
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2011/10/28 - 19:07:29 fabien 
 * 
 *File content
     wpnoticeModelClass.php
 *     
 */
 
 
 class wpnoticeModelClass extends Configuration{
 
 	/**
 	 * table instance
 	 */
 	private $table;
 	
 	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	
 	
 	function __construct(){

 		/**
 		 * set table name
 		 */
 		$this->table = 'notice_tab';
 		
 		
 		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
 		parent::__construct();
 	}
 	
 
 
 	/**
 	 * get notice list from notice table
 	 * @param $limit
 	 * @param $offset
 	 * @return $result
 	 */
 	public function getList($limit = null, $offset = null){
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('delete_flg', 0);
 		$QB->setOrder(' id DESC ');
 		
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
 	 * 
 	 * get notice detail
 	 * @param  $notice_id
 	 * @return notice detail 
 	 */
 	public function getDetail($notice_id){
 		
 		if (empty($notice_id) || !is_numeric($notice_id))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: notice id is empty or invalid");

 		$QB = new QueryBuilder();
	 	$QB->setInteger('id', $notice_id);
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
 			
 	} // getDetail
 	
 
 
 
 } // wpnoticeModelClass.php
 
 
 ?>