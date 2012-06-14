<?php
/**
 * updateControllerClass.php
 * 
 * @created on 2012/05/31
 * @package    FORM
 * @subpackage 
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/05/31 - 17:21:29 fabien 
 * 
 *File content
     updateControllerClass.php
 *     
 */
 
 
 class updateControllerClass extends Configuration{
 	
 	
 	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 
 	
 	/**
  	 * common access for this moduel
  	 */
 	public function commonAction(){
 		
 		
		/**
	 	 * set file name
	 	 */
	 	$path = pathinfo(__FILE__);
	 	$this->file_name = $path['filename'];
 		
 		
 	} // commonAction
 	
 	
 	
 	public function domainCheckAction(){
 		
 		/**
 		 * get user domain 
 		 */
 		$user_domain = $this->getUrlParam('domain');
 		
 		/**
 		 * get serial number
 		 */
 		$serial_number = $this->getUrlParam('serial');
 		
 		/**
 		 * check serial number and domain
 		 */
 		$get_domain = $this->db_model->checkDomainSerial($user_domain, $serial_number);
 		
 		print $get_domain;
 		
 	} // domainCheckAction
 	
 	
 	/**
 	 * update check action controller
 	 */
 	public function updateCheckAction(){
 		
 		$update_array = array(
 			'/src/admin/form_set/controller/D_form_setControllerClass.php',
 			'/src/admin/form_set/model/D_form_setModelClass.php',
 			'/src/admin/form/controller/D_formControllerClass.php',
 			'/src/admin/form_entry/controller/D_form_entryControllerClass.php',
 			'/src/web/top/controller/D_topControllerClass.php',
 		);
 		
 		$get_url_index = $this->getUrlParam('index');
 		$get_index = get_id($get_url_index);
 		
 		if (@$update_array[$get_index]){
 			echo $update_array[$get_index];
 		}else {
 			echo "update_finish";
 		}
 		
 	} // updateCheckAction
 	
 	
 	/**
 	 * update file action controller
 	 */
 	public function updateFileAction(){
 		
 		/**
 		 * get file path
 		 */
 		$url_file_name = $this->getUrlParam('file');
 		$file_name = str_replace(';', '/', $url_file_name);
 		$file_name = str_replace('phpphp', 'php', $file_name);
 		$file_path = BASE_DIR.$file_name;
 		 		
 		$file_content = file_get_contents($file_path);
 		
 		echo $file_content;
 		
 		//exit;
 		
 	} // updateFileAction
 
 
 
 } // updateControllerClass
 
 
 ?>