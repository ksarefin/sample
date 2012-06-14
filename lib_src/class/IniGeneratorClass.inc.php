<?php
/**
 * IniGeneratorClass.inc.php
 * 
 * @created on 2011/07/15
 * @package	   Form	    
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2012/01/27 - 14:32:29 fabien 
 * 
 *File content
     IniGeneratorClass.inc.php
 *     
 */
 
 

 /**
  * generate ini file and ini data
  * @author arefin
  */
 class IniGeneratorClass{
 	
 	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	/**
 	 * data class instance
 	 */
 	protected $data_class;
 	
 	
 	
 	
 	/**
 	 * contruct method
 	 */
 	function __construct(){
 		
 		
 		/**
 		 * data class object
 		 */
 		$this->data_class = new DataClass();
 		
 		
 		
 		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
 		
 	} // __construct
 	
 	
 	
 	/**
 	 * create a new ini file
 	 * @param $ini_file_name
 	 */
 	public function newIniFile($ini_file_name){
 		
 		if (empty($ini_file_name) && !is_string($ini_file_name))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: ini file name is empty or invalid");
 		
 		$ini_dir = FORM_INI_DIR;
 		
 		if (!is_writable($ini_dir))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: ini file can't write on ini/form directory");
 		
 		$filename = $ini_dir.'/'.$ini_file_name.'.ini';
 		
 		$fp = fopen($filename, 'w');
 		
 		$ini_str = ";".$ini_file_name."\n;".date('Y-n-d H:s')."\n";
 		
 		fwrite($fp, $ini_str);
 		
 		fclose($fp);
 		
 		
 	} // newIniFile
 	
 	
 	
 	/**
 	 * delete ini file
 	 * @param $ini_name
 	 */
 	public function deleteIniFile($ini_name){
 		
 		
 		
 		
 	} // deleteIniFile
 	
 	
 	
 	/**
 	 * create ini data header
 	 * @param $ini_name
 	 * @param $ini_data_header
 	 */
 	public function iniDataHeader($ini_file_name, $ini_data_header){
 		
 		if (empty($ini_file_name) && !is_string($ini_file_name))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: ini file name is empty or invalid");

 		if (empty($ini_data_header) && !is_string($ini_data_header))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: ini data header is empty or invalid");
 		
 		$ini_dir = FORM_INI_DIR;
 		
 		if (!is_writable($ini_dir))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: ini file can't write on ini/form directory");
 		
 		$filename = $ini_dir.'/'.$ini_file_name.'.ini';
 		
 		$fp = fopen($filename, 'a');
 		
 		$header_str .= "\n\n";
 		$header_str .= ";#######################################################################";
 		$header_str .= "\n\n[".$ini_data_header."]\n\n";
 		
 		fwrite($fp, $header_str);
 		
 		fclose($fp);
 		
 	} // iniDataHeader
 	
 	
 	

 	/**
 	 * write ini data
 	 * @param $ini_file_name
 	 * @param $ini_data
 	 */
 	public function writeIniData($ini_file_name, $ini_data){
 		
 		if (empty($ini_file_name) && !is_string($ini_file_name))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: ini file name is empty or invalid");
 			
 		if (empty($ini_data) && !is_string($ini_data))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: ini data is empty or invalid");
 		
 		$ini_dir = FORM_INI_DIR;
 		
 		if (!is_writable($ini_dir))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: ini file can't write on ini/form directory");
 		
 		$filename = $ini_dir.'/'.$ini_file_name.'.ini';
 		
 		$fp = fopen($filename, 'a');
 		
 		fwrite($fp, $ini_data);
 		
 		fclose($fp);
 		
 		
 	} // writeIniData
 	
 	
 	
 	
 	
 	
 	/**
 	 * make ini data from raw data
 	 * @param $raw_data
 	 * @return ini data
 	 */
 	public function iniData($raw_data){
 		
 		
 		$method = $raw_data['type'].'IniData';
 		
 		if (!method_exists($this, $method)) return  false;
 		
 		$ini_data = $this->$method($raw_data);
 		
 		if (!empty($ini_data))
 			return $ini_data;
 		
 		
 	} // iniData
 	
 	
 	
 	
 	
 	/**
 	 * make text ini data
 	 * @param $raw_data
 	 * @return text ini data
 	 */
 	public function textIniData($raw_data){
 		
 		/**
 		 * get text field params
 		 */
 		$text_params = $this->data_class->getFormFieldParams($raw_data['type']);
 		
 		/**
 		 * get ini data and return
 		 */
 		$ini_data = $this->makeIniData($raw_data, $text_params); 		
 		
 		if (!empty($ini_data))
 			return $ini_data;
 		
 	} // textIniData
 	
 	
 	
 	
 	/**
 	 * make textarea ini data
 	 * @param $raw_data
 	 * @return textarea ini data
 	 */
 	public function textareaIniData($raw_data){
 		
 		/**
 		 * get textarea field params
 		 */
 		$textarea_params = $this->data_class->getFormFieldParams($raw_data['type']);
 		
 		/**
 		 * get ini data and return
 		 */
 		$ini_data = $this->makeIniData($raw_data, $textarea_params); 		
 		
 		if (!empty($ini_data))
 			return $ini_data;
 		
 	} // textareaIniData
 	
 	
 	
 	/**
 	 * make select ini data
 	 * @param $raw_data
 	 * @return select ini data
 	 */
 	public function selectIniData($raw_data){
 		
 		/**
 		 * make option data
 		 */
 		if ($raw_data['options']){
 			$option_expl 			= explode(':other:', $raw_data['options']);
 			$raw_data['options'] 	= $option_expl[0];
 			$raw_data['other'] 		= $option_expl[1];
 		}
 		
 		
 		/**
 		 * make value data
 		 */
 		if ($raw_data['value']){
 			$value_expl = explode(':other:', $raw_data['value']);
 			
 			$raw_data['value'] = $value_expl[0];
 			
 			if ($value_expl[0] == 1){
 				$raw_data['selected'] = $value_expl[1];
 			}elseif ($value_expl[0] == 2){
 				$raw_data['selected'] = 0;
 				$raw_data['selected_name'] = $value_expl[1];
 			}elseif ($value_expl[0] == 3){
 				//nothing to do;
 			}
 		
 		} // if ($raw_data['value']){
 		
 		/**
 		 * get select field params
 		 */
 		$select_params = $this->data_class->getFormFieldParams($raw_data['type']);
 		
 		/**
 		 * get ini data and return
 		 */
 		$ini_data = $this->makeIniData($raw_data, $select_params); 		
 		
 		if (!empty($ini_data))
 			return $ini_data;
 			
 		
 	} // selectIniData
 	
 	
 	
 	/**
 	 * make radio ini data
 	 * @param $raw_data
 	 * @return radio ini data
 	 */
 	public function radioIniData($raw_data){
 		
 		/**
 		 * make option data
 		 */
 		if ($raw_data['options']){
 			$option_expl 			= explode(':other:', $raw_data['options']);
 			$raw_data['options'] 	= $option_expl[0];
 			$raw_data['other'] 		= $option_expl[1];
 		}
 		
 		
 		/**
 		 * make value data
 		 */
 		if ($raw_data['value']){
 			$value_expl = explode(':other:', $raw_data['value']);
 			
 			$raw_data['value'] = $value_expl[0];
 			
 			if ($value_expl[0] == 1){
 				$raw_data['checked'] = $value_expl[1];
 			}elseif ($value_expl[0] == 3){
 				//nothing to do;
 			}
 		
 		} // if ($raw_data['value']){
 		
 		/**
 		 * get radio field params
 		 */
 		$radio_params = $this->data_class->getFormFieldParams($raw_data['type']);
 		
 		/**
 		 * get ini data and return
 		 */
 		$ini_data = $this->makeIniData($raw_data, $radio_params); 		
 		
 		if (!empty($ini_data))
 			return $ini_data;
 		
 	} // radioIniData
 	
 	
 	
 	/**
 	 * make checkbox ini data
 	 * @param $raw_data
 	 * @return checkbox ini data
 	 */
 	public function checkboxIniData($raw_data){
 		
 		/**
 		 * make option data
 		 */
 		if ($raw_data['options']){
 			$option_expl 			= explode(':other:', $raw_data['options']);
 			$raw_data['options'] 	= $option_expl[0];
 			$raw_data['other'] 		= $option_expl[1];
 		}
 		
 		/**
 		 * make value data
 		 */
 		if ($raw_data['value']){
 			$value_expl = explode(':other:', $raw_data['value']);
 			
 			$raw_data['value'] = $value_expl[0];
 			
 			if ($value_expl[0] == 1){
 				$raw_data['checked'] = $value_expl[1];
 			}elseif ($value_expl[0] == 3){
 				//nothing to do;
 			}
 		
 		} // if ($raw_data['value']){
 		
 		/**
 		 * get checkbox field params
 		 */
 		$checkbox_params = $this->data_class->getFormFieldParams($raw_data['type']);
 		
 		/**
 		 * get ini data and return
 		 */
 		$ini_data = $this->makeIniData($raw_data, $checkbox_params); 		
 		
 		if (!empty($ini_data))
 			return $ini_data;
 		
 		
 	} // checkboxIniData
 	
 	
 	
 	/**
 	 * make image field ini data
 	 * @param $raw_data
 	 * @return image field ini data
 	 */
 	public function imageIniData($raw_data){
 		
 		/**
 		 * make option data
 		 */
 		if ($raw_data['options']){
 			
 			$raw_data['checked']	= $raw_data['options'];
 			$option_expl 			= explode('::', $raw_data['options']);
 			
 			$image_options = array();
 			foreach ($option_expl as $image_type){
 				$image_options[] = $this->data_class->getImageTypeName($image_type);
 			}

 			$raw_data['options'] = join('::', $image_options);
 			
 		} // if ($raw_data['options']){
 		
 		/**
 		 * get image field params
 		 */
 		$image_params = $this->data_class->getFormFieldParams($raw_data['type']); 		
 		
 		/**
 		 * get ini data and return
 		 */
 		$ini_data = $this->makeIniData($raw_data, $image_params); 		
 		
 		if (!empty($ini_data))
 			return $ini_data;
 		
 	} // imageIniData
 	
 	
 	
 	/**
 	 * make pdf field ini data
 	 * @param $raw_data
 	 * @return pdf field ini data
 	 */
 	public function pdfIniData($raw_data){
 		
 		/**
 		 * get pdf field params
 		 */
 		$pdf_params = $this->data_class->getFormFieldParams($raw_data['type']);
 		
 		/**
 		 * get ini data and return
 		 */
 		$ini_data = $this->makeIniData($raw_data, $pdf_params); 		
 		
 		if (!empty($ini_data))
 			return $ini_data;
 			
 		
 	} // pdfIniData
 	
 	
 	
 	
 	/**
 	 * make privacy policy ini data
 	 * @param $raw_data
 	 * @return privacy policy ini data
 	 */
 	public function privacyIniData($raw_data){
 		
 		/**
 		 * get privacy policy params
 		 */
 		$privacy_params = $this->data_class->getFormFieldParams($raw_data['type']);
 		
 		/**
 		 * get ini data and return
 		 */
 		$ini_data = $this->makeIniData($raw_data, $privacy_params); 		
 		
 		if (!empty($ini_data))
 			return $ini_data;
 			 		
 		
 	} // privacyIniData 	
 	
 	
 	
 	
 	/**
 	 * make name set ini data
 	 * @param $raw_data
 	 * @return name set ini data
 	 */
 	public function nameIniData($raw_data){
 		
 		/**
 		 * get field labels and megre on raw_data
 		 */
 		$field_labels = $this->getFieldsLabel($raw_data['field_labels']);
 		if (is_array($field_labels))
 			$raw_data = array_merge($raw_data, $field_labels);
 		
 		
 		/**
 		 * get exempls and merge in raw_data
 		 */
 		$exemples = $this->getExemples($raw_data['exemple']);
 		if (!empty($exemples) && is_array($exemples))
 			$raw_data = array_merge($raw_data, $exemples);
 			
 		
 		/**
 		 * get description list and merge on raw_data
 		 */
 		$descriptions = $this->getDescriptions($raw_data['description']);
 		if (!empty($descriptions) && is_array($descriptions))
 			$raw_data = array_merge($raw_data, $descriptions);
 			
 		/**
 		 * get name set params
 		 */
 		$name_params = $this->data_class->getFormFieldParams($raw_data['type']);
 			
 		/**
 		 * get ini data and return
 		 */
 		$ini_data = $this->makeIniData($raw_data, $name_params); 		
 		
 		if (!empty($ini_data))
 			return $ini_data;
 			
 	} // nameIniData
 	
 	
 	
 	/**
 	 * make address set ini data
 	 * @param $raw_data
 	 * @return address set ini data
 	 */
 	public function addressIniData($raw_data){
 		
 		/**
 		 * get field labels and megre on raw_data
 		 */
 		$field_labels = $this->getFieldsLabel($raw_data['field_labels']);
 		if (is_array($field_labels))
 			$raw_data = array_merge($raw_data, $field_labels);
 		
 		
 		/**
 		 * get exempls and merge in raw_data
 		 */
 		$exemples = $this->getExemples($raw_data['exemple']);
 		if (!empty($exemples) && is_array($exemples))
 			$raw_data = array_merge($raw_data, $exemples);
 			
 		
 		/**
 		 * get description list and merge on raw_data
 		 */
 		$descriptions = $this->getDescriptions($raw_data['description']);
 		if (!empty($descriptions) && is_array($descriptions))
 			$raw_data = array_merge($raw_data, $descriptions);
 			
 		/**
 		 * get address set params
 		 */
 		$address_params = $this->data_class->getFormFieldParams($raw_data['type']);
 		
 		/**
 		 * get ini data and return
 		 */
 		$ini_data = $this->makeIniData($raw_data, $address_params); 		
 		
 		if (!empty($ini_data))
 			return $ini_data;
 			
 		
 	} // addressIniData
 	
 	
 	
 	
 	/**
 	 * make mail set ini data
 	 * @param $raw_data
 	 * @return mail set ini data
 	 */
 	public function mailIniData($raw_data){
 		
 		/**
 		 * get mail set params
 		 */
 		$mail_params = $this->data_class->getFormFieldParams($raw_data['type']);
 		
 		/**
 		 * get ini data and return
 		 */
 		$ini_data = $this->makeIniData($raw_data, $mail_params); 		
 		
 		if (!empty($ini_data))
 			return $ini_data;
 			
 		
 	} // mailIniData
 	
 	
 	/**
 	 * make birthday set ini data
 	 * @param $raw_data
 	 * @return birthday set ini data
 	 */
 	public function birthdayIniData($raw_data){
 		
 		/**
 		 * get field labels and megre on raw_data
 		 */
 		$field_labels = $this->getFieldsLabel($raw_data['field_labels']);
 		if (is_array($field_labels))
 			$raw_data = array_merge($raw_data, $field_labels);
 		
 		
 		/**
 		 * get exempls and merge in raw_data
 		 */
 		$exemples = $this->getExemples($raw_data['exemple']);
 		if (!empty($exemples) && is_array($exemples))
 			$raw_data = array_merge($raw_data, $exemples);
 		
 		/**
 		 * get birthday set params
 		 */
 		$birthday_params = $this->data_class->getFormFieldParams($raw_data['type']);
 		
 		/**
 		 * get ini data and return
 		 */
 		$ini_data = $this->makeIniData($raw_data, $birthday_params); 		
 		
 		if (!empty($ini_data))
 			return $ini_data;
 		
 	} // birthdayIniData
 	
 	
 	
 	
 	/**
 	 * make tel set ini data
 	 * @param $raw_data
 	 * @return tel set ini data
 	 */
 	public function telIniData($raw_data){
 		
 		/**
 		 * get field labels and megre on raw_data
 		 */
 		$field_labels = $this->getFieldsLabel($raw_data['field_labels']);
 		if (is_array($field_labels))
 			$raw_data = array_merge($raw_data, $field_labels);
 		
 		
 		/**
 		 * get exempls and merge in raw_data
 		 */
 		$exemples = $this->getExemples($raw_data['exemple']);
 		if (!empty($exemples) && is_array($exemples))
 			$raw_data = array_merge($raw_data, $exemples);
 		
 		/**
 		 * get tel set params
 		 */
 		$tel_params = $this->data_class->getFormFieldParams($raw_data['type']);
 		
 		/**
 		 * get ini data and return
 		 */
 		$ini_data = $this->makeIniData($raw_data, $tel_params); 		
 		
 		if (!empty($ini_data))
 			return $ini_data;
 		
 	} // telIniData
 	
 	
 	
 	
 	
 	/**
 	 * make yes no fields ini data
 	 * @param $raw_data
 	 * @return yes no fields ini data
 	 */
 	public function ynradioIniData($raw_data){
 		
 		/**
 		 * get field labels and megre on raw_data
 		 */
 		$field_labels = $this->getFieldsLabel($raw_data['field_labels']);
 		if (is_array($field_labels))
 			$raw_data = array_merge($raw_data, $field_labels);
 		
 		/**
 		 * get yes no fields params
 		 */
 		$ynfields_params = $this->data_class->getFormFieldParams($raw_data['type']);
 		
 		/**
 		 * get ini data and return
 		 */
 		$ini_data = $this->makeIniData($raw_data, $ynfields_params); 		
 		
 		if (!empty($ini_data))
 			return $ini_data; 		
 		
 	} // ynradioIniData
 	
 	
 	
 	/**
 	 * make password fields ini data
 	 * @param $raw_data
 	 * @return password fields ini data
 	 */
 	public function passwordIniData($raw_data){
 		
 		/**
 		 * get password fields params
 		 */
 		$password_params = $this->data_class->getFormFieldParams($raw_data['type']);
 		
 		/**
 		 * get ini data and return
 		 */
 		$ini_data = $this->makeIniData($raw_data, $password_params); 		
 		
 		if (!empty($ini_data))
 			return $ini_data; 
 		
 			
 	} // passwordIniData
 	
 	
 	
 	
 	/**
 	 * make ini data
 	 * @param $raw_data
 	 * @param $params
 	 * @return ini data
 	 */
 	private function makeIniData($raw_data, $params){
 		
 		$ini_data = "\n\n";
 		foreach ($raw_data as $key=>$val){
 			
 			if (!in_array($key, $params)) continue;
 			
 			$ini_data .= $raw_data['name'].'.'.$key.' = "'.$val.'"'."\n"; 
 		} 		
 		
 		if (!empty($ini_data))
 			return $ini_data;
 			
 	} // makeIniData
 	
 	
 	
 	
 	/**
 	 * make fields labels
 	 * @param $field_labels
 	 * @return explode field labels
 	 */
 	public function getFieldsLabel($field_labels){
 		
 		if (!empty($field_labels) && is_string($field_labels)){
 			
 			$explode = explode(';:;', $field_labels);
 			
 			$exp_field_labels = array();
 			foreach ($explode as $key=>$val){
 				$exp_field_labels['field_labels'.($key+1)] = $val;
 			}
 			
 		} // if ($raw_data['field_labels']){
 		
 		
 		if (!empty($exp_field_labels))
 			return $exp_field_labels;
 			
 		
 	} // makeFieldsLabel
 	
 	
 	
 	/**
 	 * make exemple list
 	 * @param $exemples
 	 * @return exemples list
 	 */
 	public function getExemples($exemples){
 		
 		if (!empty($exemples) && is_string($exemples)){
 			
 			$explode = explode(';:;', $exemples);
 			
 			$exemple_list = array();
 			foreach ($explode as $key=>$val){
 				
 				if ($key >0 ){
 					$exemple_list['exemple'.$key] = $val;
 				}
 				
 				if ($key == 0) {
 					$exemple_list['exemple'] = $val;
 				}
 				
 			} // foreach ($explode as $key=>$val){
 		
 		} // if ($raw_data['exemple']){
 		
 		if (!empty($exemple_list))
 			return $exemple_list;
 		
 	} // makeExamples
 	
 	
 	
 	/**
 	 * make description list
 	 * @param $descriptions
 	 * @return description list
 	 */
 	public function getDescriptions($descriptions){
 		
 		if ($descriptions){
 			
 			$explode = explode(';:;', $descriptions);
 			
 			$description_list = array();
 			foreach ($explode as $key=>$val){
 				if ($key >0 ){
 					$description_list['description'.$key] = $val;
 				}
 				
 				if ($key == 0) {
 					$description_list['description'] = $val;
 				}
 			
 			} // foreach ($explode as $key=>$val){
 		
 		} // if ($raw_data['description']){
 		
 		if (!empty($description_list))
 			return $description_list;
 		
 	} // getDescriptions
 	
 	
 	
 	
 } // BuildIniClass
 
?>