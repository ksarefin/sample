<?php
/**
 * form_cssModelClass.php
 * 
 * @created on 2012/02/22
 * @package    FORM
 * @subpackage 
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/02/22 - 13:34:50 fabien 
 * 
 *File content
     form_cssModelClass.php
 *     
 */
 
 
 class form_cssModelClass extends Configuration{ 
 	
 	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	
 	
 	/**
 	 * construct method
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
 	 * get css list
 	 */
 	public function getCssList(){
 		
 		/**
  		 * directori to reaad zip
  		 */
  		$css_dir = BASE_DIR."/wpcms/common/static/css/";
  		
 		/**
		 * Open the directory, and proceed to read its contents
		 */ 	
		if (is_dir($css_dir)) {
			
			if ($dh = opendir($css_dir)) {
        		
    			$init = 1;
    			
    			/**
    			 * read and proceed contents zip
    			 */
    			while (($file = readdir($dh)) !== false) {

    				if ($file == ".." || $file == ".") continue;
    				
    				$css_list[] = array(
	    				'css_id' => $init,
	    				'name'	=> $file,
    				);
    				
    				$init ++;
    				
    			} // while (($file = readdir($dh)) !== false) {
    		} // if ($dh = opendir($css_dir)) {
		} // if (is_dir($css_dir)) {
 		
 		return $css_list;
 		
 	} // getCssList	
 	
 	
 } // form_cssModelClass.php
 
 
 ?>