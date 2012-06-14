<?php
/**
 * form_htmlModelClass.php
 * 
 * @created on 2012/03/29
 * @package    FORM
 * @subpackage Admin
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/03/29 - 17:50:16 fabien 
 * 
 *File content
     form_htmlModelClass.php
 *     
 */
 
 
 class form_htmlModelClass extends Configuration{

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
 	 * get form html list
 	 * @param $form_id
 	 * @return html list
 	 */
 	public function getFormHtmlList($form_id){
 		
 		/**
  		 * template path
  		 */
  		$html_dir = BASE_DIR.SRC."/form/template/";
  		
 		/**
		 * Open the directory, and proceed to read its contents
		 */ 	
		if (is_dir($html_dir)) {
			
			if ($dh = opendir($html_dir)) {
        		
    			$init = 1;
    			
    			/**
    			 * read and proceed contents zip
    			 */
    			while (($file = readdir($dh)) !== false) {

    				if ($file == ".." || $file == ".") continue;
    				
    				if (preg_match('/form_'.$form_id.'/', $file)){
    					
    					$html_list[] = array(
		    				'html_id' => $init,
		    				'name'	=> $file,
	    				);
	    				
	    				$init ++;
    				
    				} // if (preg_match('/form_'.$form_id.'/', $file)){
    				
    			} // while (($file = readdir($dh)) !== false) {
    			
    		} // if ($dh = opendir($html_dir)) {
    		
		} // if (is_dir($html_dir)) {
 		
 		return $html_list;
 		
 	} // getFormHtmlList	
 	 
 
 } // form_htmlModelClass.php
 
 
 ?>