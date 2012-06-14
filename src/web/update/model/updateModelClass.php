<?php
/**
 * updateModelClass.php
 * 
 * @created on 2012/05/31
 * @package    FORM
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/05/31 - 17:21:29 fabien 
 * 
 *File content
     updateModelClass.php
 *     
 */
 
 
 class updateModelClass extends Configuration{
 	
 	
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
 	 * check domain name and seriral number
 	 * @param $domain_name
 	 * @param $serial_number
 	 * @return check informaintion
 	 */
 	public function checkDomainSerial($domain_name, $serial_number){
 		
 		if (empty($domain_name) || !is_string($domain_name))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: domain name is empty");

	 	if (empty($serial_number) || !is_numeric($serial_number))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: serial number is empty or invalid");
	 		
	 
	 	$QB = new QueryBuilder();
 		$QB->setEqual('domain', $domain_name);
 		$QB->setEqual('serial_num', $serial_number);
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
 			
 		
 	} // checkDomainSerial
 	
 	
 	
 } // updateModelClass.php
 
 
 ?>