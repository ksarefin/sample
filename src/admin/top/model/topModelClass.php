<?php
/**
 * topModelClass.php
 * 
 * @created on 2011/08/01
 * @package    ActiveIR
 * @subpackage 
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2011/08/01 - 11:17:19 fabien 
 * 
 *File content
     topModelClass.php
 *     
 */
 
 
 class topModelClass extends Configuration{
 	
 	
 	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	
 	/**
 	 * contruct method
 	 */
 	function __construct(){
 		
 		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
 		
 		parent::__construct();
 		
 	} // __construct
 
 	
 	
    /**
 	 * user check 
 	 * @param $user
 	 * return result
 	 */
 	public function userCheck($post){
 		
 		if (empty($post) || !is_array($post))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: post data is empty or invalid array ");
 			
 			
 			
 		
 		$fields = array('id','name','passwd','type');
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('activeuser', 1);
 		$QB->setInteger('type', 1);
 		$QB->setEqual('name', $post['name']);
 		$QB->setEqual('passwd', $post['pass']);
 		$QB->setOrder(" id DESC ");
 		$QB->setLimit(1);
 		
 		$sql  = " SELECT ";
 		$sql .= join(",", $fields);
 		$sql .= " FROM ";
 		$sql .= 'account_users';
 		
 		$query_txt = $QB->out( $sql );
		//print_r($query_txt);
 		
 		$result = $this->DB->refer($query_txt);
 		//print_r($result);exit;
 		
 		return $result[0];
 		
 	} // userCheck
 	
 	
 
 
 
 
 
 } // topModelClass.php
 
 
 ?>