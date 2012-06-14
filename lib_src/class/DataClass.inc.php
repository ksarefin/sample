<?php
/**
 * DataClass.inc.php
 * 
 * @created on 2011/07/15
 * @package    ActiveIR
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2011/07/15-20:08:33 fabien 
 * 
 *File content
     DataClass.inc.php
 *     
 */
  

 class DataClass{
 	
 	
 	/**
 	 * ini parser instance
 	 */
 	private $ini_parser;
 	
 	
 	/**
 	 * ini array instance
 	 */
 	private $ini_array;
 	
 	
 	function __construct(){
 		
 		
 		/**
 		 * ini parser
 		 */
 		$this->ini_parser = new IniParserClass();
 		
 		/**
 		 * ini array for common ini value
 		 */
 		$this->ini_array  = $this->ini_parser->iniParse(COMMON_INI);
 		
 		
 	}
 	
 	
 	
 	/**
 	 * get prefecture list
 	 * make pref list
 	 * @return pref list 
 	 */
 	public function getPrefList(){
 		
 		
 		$pref_array = $this->ini_parser->getArrayByName($this->ini_array, 'prefecture');
 		
 		return $pref_array;
 		
 	}
 	
 	
 	/**
 	 * parse prefecture.ini 
 	 * make pref array
 	 * @return pref array 
 	 */
 	public function prefecture(){
 		
 		
 		$pref_array = $this->ini_parser->getArrayByName($this->ini_array, 'prefecture');
 		
 		return $pref_array;
 		
 	} // prefecture
 	
 	
 	
 	/**
 	 * make month array
 	 * @return month array
 	 */
 	public function month(){
		
 		$init = 1;
 		while ($init<=12){
 			
 			$month[$init] = $init."月"; 
 			
 			$init++;
 		}
 		
 		return $month;
 		
 	}
 	
 	
 	
 	
 	
 	/**
 	 * make day array of month 
 	 * @return day array
 	 */
 	public function day(){
		
 		$init = 1;
 		while ($init<=31){
 			
 			$day[$init] = $init."日"; 
 			
 			$init++;
 		}
 		
 		return $day;
 		
 	}
 	
 	
 	
 		
 	
 	
 	
 	/**
 	 * @return current date
 	 */
 	public function dateValue(){
 		
 		return date('Y/m/d');
 		
 	}
 	
 	
 	
 	
 	
 	
 	/**
 	 * make year array list
 	 * @return year list
 	 */
 	public function year(){
 		
 		
 		$index = 1;
 		
 		$year = array();
 		
 		for ($init = 2000; $init<=2015; $init++){
 			
 			$year[$init] = $init.'年';

 			$index++;
 		}
 		
 		
 		return $year;
 	}
 	
 	
 	
 	/**
 	 * get inquiry type list
 	 * @return list
 	 */
	public function getInquiryTypeList(){
		
		$list = $this->ini_parser->getArrayByName($this->ini_array, 'inquiry_type');
 		
 		return $list;
		
	}
	
	
	
	/**
	 * get inquiry business type
	 * @return list
	 */
	public function getInquiryBusinessType(){
		
		$list = $this->ini_parser->getArrayByName($this->ini_array, 'inquiry_business_type');
 		
 		return $list;
		
	}
	
	
	/**
	 * get input type
	 * @return list
	 */
	public function inputType(){
		
		$input_type_list = array();
		
		$list = $this->ini_parser->getArrayByName($this->ini_array, 'entry_type');
 		
		foreach ($list as $key=>$val){

			$expl = explode('::', $val);
			$input_type_list[$key] = $expl[1];
		}
		
 		return $input_type_list;
		
	}
	
	
	/**
	 * get input type name
	 * @param type id
	 * @return type name
	 */
	public function getInputTypeName($input_type_id){
		
		if (empty($input_type_id) || !is_numeric($input_type_id)) return false;
		
		/**
		 * get input type list
		 */
		$input_type_list = $this->inputType();
		foreach ($input_type_list as $key=>$val){
			
			if ($key != $input_type_id) continue;
			
			return $val;
		}
		
		
	}
	
	
	/**
	 * get entry type
	 * @return list
	 */
	public function entryType(){
		
		$entry_type_list = array();
		
		$list = $this->ini_parser->getArrayByName($this->ini_array, 'entry_type');
 		
		foreach ($list as $key=>$val){
			
			$expl = explode('::', $val);
			$entry_type_list[$key] = $expl[0];			
		}
		
 		return $entry_type_list;
		
	}
	
	
	/**
	 * get entry type id
	 * @param $input_type_name
	 * @return entry type id
	 */
	public function getEntryTypeId($input_type_name){
		
		if (empty($input_type_name) || !is_string($input_type_name)) return false;
		
		/**
		 * get input list
		 */
		$input_type_list = $this->inputType();
		
		foreach ($input_type_list as $key=>$val){
			
			if ($input_type_name != $val) continue;
			
			return $key;
		}
		
	}
	
	
	
	/**
	 * get survey type	 
	 * @return list
	 */
	public function surveyType(){
		
		$list = $this->ini_parser->getArrayByName($this->ini_array, 'survey_type');
 		
 		return $list;
		
	}
	
	
 	/**
	 * get form style	 
	 * @return list
	 */
	public function formStyle(){
		
		$list = $this->ini_parser->getArrayByName($this->ini_array, 'form_style');
 		
 		return $list;
		
	}
	
	
	/**
	 * get required options
	 * @return list
	 */
	public function isRequired(){
		
		$list = $this->ini_parser->getArrayByName($this->ini_array, 'require_type');
 		
 		return $list;
		
	}
	
	
 	/**
	 * get auto set options
	 * @return list
	 */
	public function autoSet(){
		
		$list = $this->ini_parser->getArrayByName($this->ini_array, 'auto_set');
 		
 		return $list;
		
	}
	
	
	
	/**
	 * get other otions
	 * @return list
	 */
 	public function isOther(){
		
		$list = $this->ini_parser->getArrayByName($this->ini_array, 'other_type');
 		
 		return $list;
		
	}
	
	
	/**
	 * get pull down selected type
	 */
	public function pullDownSelect(){
		
		$list = $this->ini_parser->getArrayByName($this->ini_array, 'selected_type');
 		
 		return $list;
 		
	}
	
	
	/**
	 * get checked type
	 */
	public function checkedType(){
		
		$list = $this->ini_parser->getArrayByName($this->ini_array, 'selected_type');
 		
		unset($list[2]);
		
 		return $list;
		
	}
	
 	
 	
 	/**
	 * get check type
	 * @return list
	 */
	public function checkType(){
		
		$list = $this->ini_parser->getArrayByName($this->ini_array, 'check_type');
 		
 		return $list;
		
	}
	
	
	/**
	 * get check type name
	 * @param $check
	 * @return check name
	 */
	public function getCheckName($check){
		
		if (empty($check) || !is_numeric($check)) return false;
		
		$list = $this->checkType();
		
		$check_name = "";
		foreach ($list as $key=>$val){
			
			if ($key != $check) continue;
			
			$check_name = $val;
		}
		
		return $check_name;			
		
	}
	
	
	/**
	 * get image type
	 */
	public function imageType(){

		$list = $this->ini_parser->getArrayByName($this->ini_array, 'image_type');
 		
 		return $list;
		
	}
	
	
	/**
	 * get image type name
	 * @param $image_type
	 * @return image type name
	 */
	public function getImageTypeName($image_type){
		
		if (empty($image_type) || !is_numeric($image_type)) return false;
		
		$image_type_list = $this->imageType();
		
		foreach ($image_type_list as $key=>$val){
			
			if ($image_type != $key) continue;
			
			$image_type_name = $val;
		}
		
		if ($image_type_name)
			return $image_type_name;
		
	}
	
	
	
 	/**
	 * get agreement type
	 */
	public function agreeType(){

		$list = $this->ini_parser->getArrayByName($this->ini_array, 'agree_type');
 		
 		return $list;
		
	}
	
	/**
	 * get agreement type
	 */
	public function yearType(){

		$list = $this->ini_parser->getArrayByName($this->ini_array, 'year_type');
 		
 		return $list;
		
	}
	
	
 	/**
	 * get year type name
	 * @param $value
	 * @return field type name
	 */
	public function getYearTypeName($value){
		
		$list = $this->ini_parser->getArrayByName($this->ini_array, 'year_type');
 		
		if (@$list[$value])
			return $list[$value];
		
	}
	
	
	
	/**
	 * get yes no field type
	 */
	public function ynFields(){
		
		$list = $this->ini_parser->getArrayByName($this->ini_array, 'yn_fields');
 		
 		foreach ($list as $key=>$val){

			$expl = explode('::', $val);
			$input_type_list[$key] = $expl[0];
		}
		
 		return $input_type_list; 
		
	}
	
	
	/**
	 * get yes no field type
	 * @param $value
	 * @return field type name
	 */
	public function getYnFieldType($value){
		
		$list = $this->ini_parser->getArrayByName($this->ini_array, 'yn_fields');
 		
 		foreach ($list as $key=>$val){
 			
 			if ($key != $value) continue;
 			
			$expl = explode('::', $val);
			$field_name = $expl[1];
		}
		
		return $field_name;
		
	}
	
	
	/**
	 * get form fields params
	 * @param $filed_name
	 * @return param list
	 */
 	public function getFormFieldParams($filed_type){
 		
 		$filed_name = $filed_type.'_params';

		$list = $this->ini_parser->getArrayByName($this->ini_array, $filed_name);
 		
 		return $list;
		
	} // getFormFieldParams
	
 	
	
 	/**
 	 * make notice label
 	 * @return notice label
 	 */
 	public function notice_label(){
 		
 		$notice_label = $this->ini_parser->getArrayByName($this->ini_array, 'notice_label');
 		
 		return $notice_label;
 		
 	} // notice_label
 	
 	
 	
 	/**
 	 * get notice label name
 	 * @param $label_id
 	 * @return label name
 	 */
 	public function getLabelName($label_id){
 		
 		/**
 		 * get label list
 		 */
 		$label_list = $this->notice_label();
 		
 		foreach ($label_list as $key=>$val){
 			
 			if ($key != $label_id) continue;
 			
 			$label_name = $val;
 			
 			break;
 		}
 		
 		
 		if ($label_name)
 			return $label_name;
 		
 	} // getLabelName
 	
 	
 	
 } // DataClass
  
  
 
 ?>