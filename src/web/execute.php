<?php
/**
 * execute.php
 * 
 * @created on 2011/05/13
 * @package    WPCMS    
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2011/05/13-19:35:10 fabien 
 * 
 *File content
     execute.php
 *     
 */

 try {

		 /**
		  * include common sesstings 
		  */
		 $common_settings = BASE_DIR.CONFIG.COMMON;
		 include_once ($common_settings);
 
 
 		/**
  	 	　* error class
  	 	　*/	
 		$err_class = new ErrorClass();
 		
 
 		/**
  	 	　* split server request uri that we can get
  	 	　* module name, action and others so that
  	 	　* we can control our program 
  	 	　*/
 		$access_params = split( "/", substr($_SERVER["REQUEST_URI"], 1) );
 		$datas = array();
 		$wpform_place = '-1';
 		foreach ($access_params as $key=>$val){
 			
 			if ($val == 'wpform'){
 				$wpform_place = $key;
 			}
 			
 			
 			if ( $wpform_place != '-1' && $key > $wpform_place ){
 				$datas[] = $val;
 			}
 			
 		} // foreach ($access_params as $key=>$val){
 		 		
 		/**
  	 	　* unset empty array
  	 	　*/
 		foreach ( $datas as $key=>$val){
 	
 			if(empty($val)) unset($datas[$key]);
 	
 		}
 		
 
 		/**
  	 	　* intialize source path and 
  	 	　* if access for admin then split data will shift by one element that 
  	 	　* web and admin does the same work
  	 	　*/
 		if( $datas[0] == 'admin' || $datas[0] == 'settings' || $datas[0] == 'agency' || $datas[0] == 'site_admin'){

 			if ($datas[0] == 'admin')
 				$source_path = SRC_ADMIN;
 				
 			if ($datas[0] == 'settings')
 				$source_path = SRC_SETTINGS;
 				
 			if ($datas[0] == 'agency')
 				$source_path = SRC_AGENCY;
 				
 			if ($datas[0] == 'site_admin')
 				$source_path = SRC_SITE_ADMIN;			
 				
 			$access_name = $datas[0];
 	
 	
 			if(@$datas[1]){
 				
 				array_shift($datas);
 			}else {
 			
 				unset($datas);
			}
			
 
 		}else{
 			
 			$source_path = SRC;
 			$access_name = 'web';
 		}
 		
 		
 		
 		/**
  	　	　* 
  	　	　* frist split data is for module
  	　	　* if there is no module it will go top module
  	　	　* 
  	　	　*/
 		$module = @$datas[0] ?  @$datas[0] : 'top';
 
 
 
 		/**
  	　	　* build module path and inculde that
  	　	　*/
 		$module_path = BASE_DIR.$source_path."/".$module."/controller/".$module."ControllerClass.php";
 		
 		/*if ($access_name == 'web' && $module == 'top'){
 			if (!file_exists($module_path) )
 		}*/
 	
 	
 		if(!file_exists($module_path)){
 	
 			/**
 	 	　	　* set module file error
 	 	　	　*/
 			$err_msg  = "<br>Module Name : ".$module;
 			$err_msg .= "ControllerClass Does not exists";
 			$err_msg .= "<br>Module Does not exists"; 
 			$err_class->setErr($err_msg,true);
 	 
 		}else {
 	
 			/**
 	 	　	　* include controller module
 	 	　	　* set module object
 	 	　	　*/
 			include_once $module_path ;
 	
 			$class_name = $module."ControllerClass";
 	
 			$module_class = new $class_name;
 	
 		}

 
 		/**
  	　	　* DataBase Model Class 
  	　	　*/
 		$db_model_path = BASE_DIR.$source_path."/".$module."/model/".$module."ModelClass.php";
 
 		if(file_exists($db_model_path)){

 			include_once $db_model_path;
 		}
 
 
 		/**
  	　	　* 
  	　	　* second split data is for action
  	　	　* if there is no action it will go index action
  	　	　* 
  	　	　*/
  		$action = @$datas[1] ? @$datas[1] : 'index';
 
 		if (file_exists($module_path) && !$module_class ){
 	
 			/**
 	 	　	　* set module class error
 	 	　	　*/
 			$err_msg  = "<br>Module Name : ".$module;
 			$err_msg .= "ControllerClass Does not exists";
 			$err_msg .= "<br>Class Name  : ".$class_name;
 			$err_msg .= "<br>Module Class Does not exists"; 
 			$err_class->setErr($err_msg,true);
 	
 		} elseif (file_exists($module_path) && $module_class ) {
 	
 			/** 
 	 	　	　* check commonAction method exists or not
 	 	　	　* if exists then call
 	 	　	　* 
 	 	　	　*/
 			if(method_exists($module_class,'commonAction')){
 		
 				$module_class->commonAction();
 		
 			}
 	
			/**
	 	　	　* call action methods 	
	 	　	　*/
 			$method = $action."Action";
 	
 	
 			/**
 	 	　	　* Action check
 	 	　	　*/
 			if (!method_exists($module_class, $method)){
 		
 				/**
 	 	 	　	　* set action error if action not found
 	 	 	　	　*/
 				$err_msg  = "<br>Module Name : ".$module;
 				$err_msg .= "ControllerClass Does not exists";
 				$err_msg .= "<br>Class Name  : ".$class_name;
 				$err_msg .= "<br>Action Name : ".$method;
 				$err_msg .= "<br>Action Does not exists"; 
 				$err_class->setErr($err_msg,true);
 		
 			}else {
 		
 				/**
 		 	　	　* execute action
 		 	　	　*/
 				$module_class->$method();
 		
 			} // if (!method_exists($module_class, $method)){
 	
 		} // if (file_exists($module_path) && !$module_class ){
 		
 		
 }catch (Exception $e){
 	
 	var_dump($e);
 	exit;
 }
 		
 ?>