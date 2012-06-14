<?php
/**
 * fileControllerClass.php
 * 
 * @created on 2012/02/08
 * @package    FORM
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/02/08 - 17:41:54 fabien 
 * 
 *File content
     fileControllerClass.php
 *     
 */
 
 
 class fileControllerClass extends Configuration{
 
 	/**
 	 * get module name instance
 	 */
 	protected $get_module;
 	
 	/**
 	 * image name instance
 	 */
 	protected $image_name;
 	
 	/**
 	 * pdf name instance
 	 */
 	protected $pdf_name;
 	
 	
 	
 	
 	/**
  	 * common access for this moduel
  	 */
 	public function commonAction(){
 		
 		/**
 		 * get module name
 		 */
 		$this->get_module = $this->getUrlParam('module');
 		
 		/**
 		 * get image name
 		 */
 		$this->image_name = $this->getUrlParam('image_name');
 		
 		/**
 		 * get pdf name
 		 */
 		$this->pdf_name = $this->getUrlParam('pdf_name');
 		
 		
 	} // commonAction
 	
 	
 	
 	/**
 	 * image display action controller
 	 */
 	public function imageDisplayAction(){
 		
 		if ($this->module_name)
 			$image_upload_dir = UPLOAD.'/image/'.$this->get_module;
 		else 
 			$image_upload_dir = UPLOAD.'/image';
 			
 		$image_file_path = $image_upload_dir.'/'.$this->image_name;
 		
 		$ext = substr($this->image_name, strrpos($this->image_name, '.') + 1);
 		$ext = str_replace('jpg', 'jpeg', trim($ext));
 		
	    header("Cache-Control: public");
	    header("Pragma: public");
		header("Content-Type: image/".$ext);
		readfile( $image_file_path );
 		
 	} // imageDisplayAction
 	
 	
 	
 	/**
 	 * pdf display action controller
 	 */
 	public function pdfDisplayAction(){
 		
 		$pdf_upload_dir = UPLOAD.'/pdf';
 		$pdf_file_path = $pdf_upload_dir.'/'.$this->pdf_name;
 		
 		header('Content-type: application/pdf');
	    readfile($pdf_file_path);
 		
 	} // pdfDisplayAction
 
 
 
 } // fileControllerClass
 
 
 ?>