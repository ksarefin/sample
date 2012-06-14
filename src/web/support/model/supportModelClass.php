<?php
/**
 * supportModelClass.php
 * 
 * @created on 2012/04/06
 * @package    FORM
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/04/06 - 16:15:49 fabien 
 * 
 *File content
     supportModelClass.php
 *     
 */
 
 
 class supportModelClass extends Configuration{

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
 	 * user information check 
 	 * @param $post
 	 * return result
 	 */
 	public function userCheck($post){
 		
 		if (empty($post) || !is_array($post)) 
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: post data is empty or invalid ");  
 			
 		$QB = new QueryBuilder();
 		$QB->setInteger('user_id', $post['user_id']);
 		$QB->setEqual('domain', $post['domain']);
 		$QB->setEqual('serial_num', $post['serial']);
 		$QB->setInteger('display_flg', 1);
 		$QB->setInteger('delete_flg', 0);
 		
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM "; 
 		$sql .= " customer_tab ";
 		
 		$query_txt = $QB->out($sql);
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result)
 			return $result[0];
 		
 	} // userCheck
 	
 	
 } // supportModelClass.php
 
 
 ?>