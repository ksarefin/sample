<?php
/**
 * MailTemplateClass.inc.php
 * 
 * @created on 2012/01/30
 * @package    Form
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/03/15-16:32:14 fabien 
 * 
 *File content
     MailTemplateClass.inc.php
 *     
 */
 

 class MailTemplateClass{
 	
 	/**
 	 * data class instance
 	 */
 	protected $data_class;
 	
 	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	/**
 	 * smarty instance
 	 */
 	protected $smarty;
 	
 	/**
 	 * contruct method
 	 */
 	function __construct(){
 		
 		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
 		
 	} // __construct
 	
 	
 	
 	/**
 	 * generate mail template
 	 * @param $form_array
 	 * @param $form_name
 	 * @return $conf_html
 	 */
 	public function MailTemplate($form_array, $form_name){
 		
 		if (empty($form_array))
 			if (empty($form_id) || !is_numeric($form_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: from array if empty");
 		
	 	/**
	 	 * smarty object
	 	 */
 		global $smarty;
 		$this->smarty = $smarty;
 		
 		/**
 		 * data class object
 		 */
 		$this->data_class = new DataClass();
 		
 			
 		$mail_template = "";
 		$form_field = array();
 		
 		foreach ($form_array as $key=>$val){
 			
 			$form_field = $form_array[$key];
 			
 			if ($form_field['type'] == 'privacy' ) continue;

 			$method = $form_field['type'].'MailTemplate';
 		
	 		//if (method_exists($this, $method))
	 		$mail_template .= $this->$method($key, $form_field);
	 		
 		}
 		
 		$cache_dir = HOME_DIR."/cache";
 		
 		$file = $cache_dir."/".$form_name.".tpl";
 		
 		$fp = fopen($file, 'w');
 		fwrite($fp, $mail_template);
 		fclose($fp);
 		
 		$fetch_html = $this->smarty->fetch($file);

 		return $fetch_html;

 		
 		
 	} // MailTemplate
 	
 	
 	
 	/**
 	 * generate mail template for text input
 	 * @param $key
 	 * @param $form_field
 	 * @return text mail template
 	 */
 	public function textMailTemplate($key, $form_field){
 		
 		$mail_body = '【'.$form_field['label'].'】 {if $pd.'.$key.'}'."<br>".'{$pd.'.$key.'}{/if}'."<br><br>";
 		
 		return $mail_body;
 		
 	} // textMailTemplate
 	 	
 	
 	/**
 	 * generate mail template for textarea input
 	 * @param $key
 	 * @param $form_field
 	 * @return textarea mail template
 	 */
 	public function textareaMailTemplate($key, $form_field){
 		
 		$mail_body = '【'.$form_field['label'].'】 {if $pd.'.$key.'}'."<br>".'{$pd.'.$key.'} {/if}'."<br><br>";

 		return $mail_body;
 		
 	} // textareaMailTemplate
 	

 	/**
 	 * generate mail template for pulldown input
 	 * @param $key
 	 * @param $form_field
 	 * @return pulldown mail template
 	 */
 	public function selectMailTemplate($key, $form_field){
 		if ($form_field['options']){
 			if (is_array($form_field['options']))
 				$options = $form_field['options'];
 			elseif (preg_match('/::/', $form_field['options']))
 				$options = explode('::', $form_field['options']);
 			array_unshift($options, 0);
 			unset($options[0]);
 			$this->smarty->assign($key.'_options',$options);
 		}
 		$mail_body = '【'.$form_field['label'].'】
{foreach from=$'.$key.'_options key=id item=val }
{if $id == $pd.'.$key; 
if ($form_field['other'])
$mail_body .= '.0';
$mail_body .= '}{$val}
{/if}
{/foreach}';
 		if ($form_field['other']){
 			$mail_body .= "\n".'その他 : {$pd.'.$key.'.1}';
 		}
 		$mail_body .= "\n\n";
 		return $mail_body;
 	} // selectMailTemplate

 	/**
 	 * generate mail template for radio input
 	 * @param $key
 	 * @param $form_field
 	 * @return radio mail template
 	 */
 	public function radioMailTemplate($key, $form_field){
 		if ($form_field['options']){
 			if (is_array($form_field['options']))
 				$options = $form_field['options'];
 			elseif (preg_match('/::/', $form_field['options']))
 				$options = explode('::', $form_field['options']);
 			array_unshift($options, 0);
 			unset($options[0]);
 			$this->smarty->assign($key.'_options',$options);
 		}
 		$mail_body = '【'.$form_field['label'].'】
{foreach from=$'.$key.'_options key=id item=val }
{if $id == $pd.'.$key; 
if ($form_field['other'])
$mail_body .= '.0';
$mail_body .= '}{$val}
{/if}
{/foreach}';
 		if ($form_field['other']){
			$mail_body .= '（{$pd.'.$key.'.1}）';
 		}
 		$mail_body .= "\n\n";
		return $mail_body;
 		
 	} // radioMailTemplate
 	
 	
 	
 	/**
 	 * generate mail template for checkbox input
 	 * @param $key
 	 * @param $form_field
 	 * @return checkbox mail template
 	 */
 	public function checkboxMailTemplate($key, $form_field){
 		
 		if ($form_field['options']){
 			
 			if (is_array($form_field['options']))
 				$options = $form_field['options'];
 			elseif (preg_match('/::/', $form_field['options']))
 				$options = explode('::', $form_field['options']);
 			
 			array_unshift($options, 0);
 			unset($options[0]);
 			$this->smarty->assign($key.'_options',$options);
 		}
 		
 		
 		$mail_body = '【'.$form_field['label'].'】
{foreach from=$'.$key.'_options key=id item=val }
{if is_array($pd.'.$key; 
if ($form_field['other'])
$mail_body .= '.0';
$mail_body .=')}
{if in_array($id , $pd.'.$key;
if ($form_field['other'])
$mail_body .= '.0';
$mail_body .= ')}{$val}{/if}			
{elseif $id == $pd.'.$key; 
if ($form_field['other'])
$mail_body .= '.0';
$mail_body .= '}{$val}
{/if}
{/foreach}';
 		$mail_body .= "\n"; 
 		if ($form_field['other']){
 			$mail_body .= '（{$pd.'.$key.'.1}）'."\n";
 		} 		
 		$mail_body .= "\n"; 
 		return $mail_body;
 		
 	} // checkboxMailTemplate
 	
 	
 	/**
 	 * generate mail template for image input
 	 * @param $key
 	 * @param $form_field
 	 * @return image mail template
 	 */
 	public function imageMailTemplate($key, $form_field){
 		
 		$mail_body = '【'.$form_field['label'].'】 {if $pd.'.$key.'}'."<br>"._HTTP.$GLOBALS['gl_wpcms_Info']['wpcms_path'].'/wpform/file/imageDisplay/image_name/{$pd.'.$key.'} {/if}'."<br><br>";
 		
 		return $mail_body;
 		
 	} // imageMailTemplate
 	
 	
 	
 	
 	/**
 	 * generate mail template for pdf input
 	 * @param $key
 	 * @param $form_field
 	 * @return pdf mail template
 	 */
 	public function pdfMailTemplate($key, $form_field){
 		
 		$mail_body = '【'.$form_field['label'].'】 {if $pd.'.$key.'} '."<br>"._HTTP.$GLOBALS['gl_wpcms_Info']['wpcms_path'].'/wpform/file/pdfDisplay/pdf_name/{$pd.'.$key.'} {/if}'."<br><br>";
 		
 		return $mail_body;
 		
 	} // pdfMailTemplate
 	
 	
 	/**
 	 * generate mail template for name input
 	 * @param $key
 	 * @param $form_field
 	 * @return name mail template
 	 */
 	public function nameMailTemplate($key, $form_field){
 		
 		$mail_body  = '【'.$form_field['field_labels1'].'】 {$pd.'.$key.'_1}　{$pd.'.$key.'_2}'."\n";
 		$mail_body .= '【'.$form_field['field_labels2'].'】 {$pd.'.$key.'_kana_1}　{$pd.'.$key.'_kana_2}'."\n\n";
 		
 		return $mail_body;
 		
 	} // nameMailTemplate
 	
 	
 	
 	/**
 	 * generate mail template for mail input
 	 * @param $key
 	 * @param $form_field
 	 * @return mail mail template
 	 */
 	public function mailMailTemplate($key, $form_field){
 		
 		$mail_body = '【'.$form_field['label'].'】 {$pd.'.$key.'_mail}'."\n\n";
 		
 		return $mail_body;
 		
 	} // mailMailTemplate
 	
 	
 	/**
 	 * generate mail template for address input
 	 * @param $key
 	 * @param $form_field
 	 * @return address mail template
 	 */
 	public function addressMailTemplate($key, $form_field){
 		
 		$mail_body = '【'.$form_field['field_labels1'].'】 {$pd.'.$key.'_pcode_1} - {$pd.'.$key.'_pcode_2}'."\n";
 		$mail_body .= '【'.$form_field['field_labels2'].'】 {$pd.'.$key.'_pref|pref}'."\n";
 		$mail_body .= '【'.$form_field['field_labels3'].'】 {$pd.'.$key.'_address_a}'."\n";
 		$mail_body .= '【'.$form_field['field_labels4'].'】 {$pd.'.$key.'_address_b}'."\n\n";
 		
 		return $mail_body;
 		
 		
 	} // addressMailTemplate
 	
 	
 	
 	/**
 	 * generate mail template for birthday input
 	 * @param $key
 	 * @param $form_field
 	 * @return birthday mail template
 	 */
 	public function birthdayMailTemplate($key, $form_field){
 		
 		$year_type = $this->data_class->yearType();
 		$this->smarty->assign('year_type',$year_type);
 		
 		
 		$mail_body .= '【'.$form_field['label'].'】 {foreach from=$year_type key=id item=val }{if $pd.'.$key.'_year_type == $id }{$val}{/if}{/foreach} ';
 		$mail_body .= '{$pd.'.$key.'_year}'.$form_field['field_labels1'].' ';
 		$mail_body .= '{$pd.'.$key.'_month}'.$form_field['field_labels2'].' ';
 		$mail_body .= '{$pd.'.$key.'_day}'.$form_field['field_labels3']."\n\n";
 		return $mail_body;
 		
 	} // birthdayMailTemplate
 	
 	
 	/**
 	 * generate mail template for tel input
 	 * @param $key
 	 * @param $form_field
 	 * @return tel mail template
 	 */
 	public function telMailTemplate($key, $form_field){
 		
 		$year_type = $this->data_class->yearType();
 		$this->smarty->assign('year_type',$year_type);
 		
 		$mail_body .= '【'.$form_field['label'].'】 {$pd.'.$key.'_1} - {$pd.'.$key.'_2} - {$pd.'.$key.'_3}'."\n\n";
 		
 		return $mail_body;
 		
 		
 	} // telMailTemplate
 	
 	
 	
 	/**
 	 * generate mail template for ynradio input
 	 * @param $key
 	 * @param $form_field
 	 * @return ynradio mail template
 	 */
 	public function ynradioMailTemplate($key, $form_field){
 		
 		$mail_body .= '【'.$form_field['label'].'】 {if $pd.'.$key.' == 1}'.$form_field['field_labels1'].'{/if}{if $pd.'.$key.' == 2}'.$form_field['field_labels2'].'{/if}'."\n\n";
 		
 		return $mail_body;
 		
 	} // ynradioMailTemplate
 	
 	
 	/**
 	 * generate mail template for password input
 	 * @param $key
 	 * @param $form_field
 	 * @return password mail template
 	 */
 	public function passwordMailTemplate($key, $form_field){
 		
 		$mail_body .= '【'.$form_field['label'].'】 {$pd.'.$key.'_pass}'."\n\n";
 		
 		return $mail_body;
 		
 	} // passwordMailTemplate
 	
 	
 	
 
 } // HtmlFormClass
 
 
 ?>