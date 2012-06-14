<?php
/**
 * responseModelClass.php
 * 
 * @created on 2012/03/08
 * @package    FORM
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/03/08 - 18:23:10 fabien 
 * 
 *File content
     responseModelClass.php
 *     
 */
 
 
 class responseModelClass extends Configuration{
 	
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
 		$this->table = 'customer_tab';
 		
 		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
 		parent::__construct();
 		
 	} // __construct
 	
 	
 	/**
 	 * get domain and serial result
 	 * @param $post
 	 * @return list
 	 */
 	public function getResult($post){
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('user_id', $post['user_id']);
 		$QB->setEqual('domain', $post['domain']);
 		$QB->setEqual('serial_num', $post['serial']);
 		$QB->setInteger('display_flg', 1);
 		$QB->setInteger('delete_flg', 0);
 		
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM "; 
 		$sql .= $this->table;
 		
 		$query_txt = $QB->out($sql);
 		$result = $this->DB->refer($query_txt);
 		
 		if (empty($result)){
 			echo 'false';
 			exit;
 		}
 		
 	} // getResult
 	
 	
 	/**
 	 * get domain name
 	 * @param $post
 	 * @return domain name
 	 */
 	public function getDomainNmae($post){
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('user_id', $post['user_id']);
 		$QB->setEqual('domain', $post['domain']);
 		$QB->setEqual('serial_num', $post['serial']);
 		$QB->setInteger('display_flg', 1);
 		$QB->setInteger('delete_flg', 0);
 		
 		
 		$sql  = " SELECT ";
 		$sql .= " domain ";
 		$sql .= " FROM "; 
 		$sql .= $this->table;
 		
 		$query_txt = $QB->out($sql);
 		$result = $this->DB->refer($query_txt);
 		$domain = $result[0]['domain'];
 		if ($domain)
 			return $domain;
 		
 	} // getDomainNmae
 	
 	
 
 } // responseModelClass.php
 
 
 ?>