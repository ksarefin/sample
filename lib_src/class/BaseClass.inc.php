<?php
/**
 * BaseClass.inc.php
 * 
 * @created on 2011/04/22
 * @package    kentei
 * @subpackage quiz
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2011/04/22-12:13:36 fabien 
 * 
 *File content
     BaseClass.inc.php
 *     
 */



 /**
  * 
  * Basic Class for all Controler
  * @author arefin
  *
  */

 class BaseClass{
 	
 	/**
 	 * Database object 
 	 */
 	public $DB;
 	
 	/**
 	 * Excuting php
 	 */
 	public $self_url; 
 	
 	/**
 	 * access_name instance
 	 */
 	public $access_name;
 	
 	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	
 	/**
 	 * contruct method
 	 */
 	function __construct(){
 		
 		global $access_name;
 		
 		/**
 		 * access name assign
 		 */
 		$this->access_name = $access_name;
 		
 		
 		/**
 		 * set DataBase Object to use every where
 		 */
 		$this->setDB();
 		
 		
 		/**
 		 * set Server Script to use every where
 		 */
 		$this->setSelfUrl();
 		
 		
 		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
 		
 	} // __construct
 	
 	
 	
 	/**
 	 * set Server Script SelfUrl
 	 */
 	public function setSelfUrl(){
 		
 		/**
 		 * global variables 
 		 */
 		global $module;
 		$wpcms_path = $GLOBALS['server_info']['wpcms_path'];
 		
 		if ($this->access_name == 'admin'  || $this->access_name == 'settings' || $this->access_name == 'agency' || $this->access_name == 'site_admin'){

 			$this->self_url = $wpcms_path.'/wpform/'.$this->access_name."/".$module;
 		}else{

 			$this->self_url = $wpcms_path.'/wpform/'.$module;
 		}
 		
 	}
 	
 	
 	
 	/**
 	 * get Server Script SelfUrl
 	 */
 	public function getSelfUrl(){
 		
 		/**
 		 * self url
 		 */
 		return $this->self_url;
 		
 	}
 	
 	
 	
 	/**
 	 * get access name 
 	 */
 	public function getAccessName(){
 		
 		return $this->access_name;
 	}
 	
 	
 	
 	/**
 	 * set DataBase object
 	 */
 	public function setDB(){
 		
 		/**
 		 * DataBase Object instance 
 		 */
 		$DBObject = new DBBridge();
 		$this->DB = $DBObject;
 		
 	}
 	
 	
 	/**
 	 * get DataBase Object
 	 */
 	
 	public function getDB(){
 		
 		/**
 		 * this DataBase object
 		 */
 		return $this->DB;
 		
 	}
 	
 	
 	
 	/**
 	 * 
 	 * Set attribute function 
 	 * Which store in session
 	 * @param string $attribute_name
 	 * @param  $attribute
 	 * 
 	 */
 	public function setAttribute($attribute_name, $attribute){
 		
 		
 		if (empty($attribute_name) || empty($attribute) ) return false;
 		
 		/**
 		 * Create new attribute use array
 		 */
 		$newAttribute[$attribute_name] = $attribute;
  		
 		/**
 		 * get previous attributes from session
 		 * marge new attribute with previous attribute or
 		 * use for very frist time 
 		 */
 		if($_SESSION['attribute']){
 			$allAttribute = $_SESSION['attribute'];
  			$newAllAttribute = array_merge($allAttribute,$newAttribute);
 		}else {
 			$newAllAttribute = $newAttribute;
 		}
 		
 		/**
		 * store all attributes in session
 		 */
 		
 		$_SESSION['attribute'] = $newAllAttribute;
 		
 		 
 	}
 	
 	
 	/**
 	 * remove attribute
 	 * @param $attribute_name
 	 */
 	public function removeAttribute($attribute_name){
 		
 		if (!empty($attribute_name))
 			unset($_SESSION['attribute'][$attribute_name]);
 		else 	
 			return false;
 			
 	}
 	
 	
 	
 	/**
 	 * Get attribute value for a attribute name
 	 * @param string $attribute_name
 	 */
 	public function getAttribute($attribute_name){
		
 		return $$attribute_name = $_SESSION['attribute'][$attribute_name];
 		
 	}
 	
 	
 	
 	/**
 	 * Get all attribute from session
 	 */
 	public function getAllAttribute(){
 		
 		return $_SESSION['attribute'];
 	}
 	
 	
 	/**
 	 * view assign
 	 */
 	public function viewAssign($name,$assgin){
 		
 		if (empty($name)) return false;
 		
 		global $smarty;
 		
 		$smarty->assign($name,$assgin);
 		
 	}
 	
 	
 	/**
 	 * 
 	 * Create clear display page
 	 * @param template $template
 	 */
 	public function setDisplay($template,$use_layout=true){
 		
 		if (empty($template))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg:  parameter template is empty");
 		
 		/**
 		 * Get Globals variables
 		 */
 		global $type,$category;
 		
 		
 		$access_name = $this->access_name;
 		
 		/**
 		 * Get all attribute
 		 */
 		$allAttribute = $this->getAllAttribute();
 		
 		
 		/**
 		 * Makes attribut by attribute name
 		 * for use in display page 
 		 */
 		if (is_array($allAttribute)){
 			foreach ($allAttribute as $key=>$value){
 				$$key = $value;
 			}
 		}
 		
 		
 		/**
 		 * Get the template and make output 
 		 */
 		
 		global $source_path, $module, $smarty, $err_class;
 		$template_path = BASE_DIR.$source_path."/".$module."/template/".$template.".tpl";
 		
 		if (!file_exists($template_path))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: template ".$template_path." does not exists ");
 			
 		
 		$content = $smarty->fetch($template_path);
 		$smarty->assign('content',$content);
 		
 		if ($content){
 			
 			if ($use_layout == false){
 				
 				$smarty->display($template_path);
 			}else {
 				
 				$menu_path = HOME_DIR."/layout/".$access_name."_menu.tpl";
 				$menu = $smarty->fetch($menu_path);
 				$smarty->assign('menu', $menu);
 			
 				$layout = HOME_DIR."/layout/".$access_name."_layout.tpl";
 			
 				$smarty->display($layout);
 			}
 			
 			
 		}else {
 			
 			$err_class->setErr($template_path,'template');
 			$err_class->setErr($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: template does not exist");
 		}
 		/*
 		$home_dir = realpath(dirname(__FILE__)."/../");
 		include_once ($home_dir."/".$template);
 		exit;
 		*/
 		
 	}
 	
 	
 	
 	/**
 	 * redirecting page
 	 * @param $redirect_url
 	 */
 	public function redirect($redirect_url){
 		
 		header(sprintf("Location: %s",$redirect_url));
 		exit;
 		
 	}
 	
 	
 	
 	
 	/**
 	 * make url from array
 	 */
 	public function makeUrl($url_array){
 		
 		if ($this->access_name != 'web'){
 			
 			array_unshift($url_array, $this->access_name);
 		}
 		
 		if (!is_array($url_array)) return false;
 		
 		$wpcms_path = $GLOBALS['server_info']['wpcms_path'];
 		
 		$url = $wpcms_path.'/wpform/'.join('/', $url_array);
 		return $url;
 		
 	}
 	
 	
 	
 	
 	
 	

 }
  
 ?>