<?php
/**
 * HtmlCodeClass.inc.php
 * 
 * @created on 2012/01/30
 * @package    Form
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2012/01/30-15:02:00 fabien 
 * 
 *File content
     HtmlCodeClass.inc.php
 *     
 */
 

 class HtmlCodeClass{
 	
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
 	 * generate form html code
 	 * @param $form_array
 	 * @param $form_name
 	 * @return $form_html
 	 */
 	public function htmlForm($form_array, $form_name, $type='form', $option_count=null){
 		
 		if (empty($form_array))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: from array if empty");
 		
	 	/**
	 	 * smarty object
	 	 */
 		global $smarty;
 		$this->smarty = $smarty;
 		$this->smarty->assign('checked','');
 		
 		/**
 		 * data class object
 		 */
 		$this->data_class = new DataClass();
 		
 			
 		$form_html 	= "";
 		$target		= "";
 		$form_field = array();
 		
 		
 		foreach ($form_array as $key=>$val){
 			
 			$form_field = $form_array[$key];
 			
 			$method = $form_field['type'].'HtmlCode';
 			
	 		//if (method_exists($this, $method))
	 		$form_html .= $this->$method($key, $form_field, $type, $option_count);
	 		
	 		/**
	 		 * for name set kana target js fiels array
	 		 */
	 		if ($form_field['type'] == 'name'){
		 		
	 			$target .= '
	 				var '.$key.' = new AutoKana(\''.$key.'_1\', \''.$key.'_kana_1\', {katakana:true, toggle:false});';
	 			$target .= '
	 				var '.$key.' = new AutoKana(\''.$key.'_2\', \''.$key.'_kana_2\', {katakana:true, toggle:false});';
		 		
	 		} // if ($form_field['type'] == 'name'){
	 		
 		} // foreach ($form_array as $key=>$val){
 		
 		
 		/**
	 	 * echo kana target js
	 	 */
 		if (!empty($target)){
 			
 			$this->smarty->assign('name_kana', 'kanaTxt');
 			
	 		$kana_target .= '
	 			<script type="text/javascript" src="'.$GLOBALS['gl_wpcms_Info']['wpcms_path'].'/wpform/wpcms/common/static/scripts/prototype.js"></script>
	 			<script type="text/javascript" src="'.$GLOBALS['gl_wpcms_Info']['wpcms_path'].'/wpform/wpcms/common/static/scripts/autoKana.js"></script>
	 			
	 			{literal}
	 			<script type="text/javascript" > 
		 			'.$target.'
				</script>
				{/literal}
				
			';
	 		
	 		$form_html .= $kana_target;
	 		//echo $kana_target;
 		
 		}// if (!empty($target)){
 		

 		
 		$cache_dir = HOME_DIR."/cache";
 		
 		$file = $cache_dir."/".$form_name.".tpl";
 		
 		$fp = fopen($file, 'w');
 		fwrite($fp, $form_html);
 		fclose($fp);
 		
 		$fetch_html = $this->smarty->fetch($file);

 		//return $fetch_html;

 		return $form_html;
 		
 	} // htmlForm
 	
 	
 	
 	/**
 	 * generate confirmation html code
 	 * @param $form_array
 	 * @param $form_name
 	 * @return $conf_html
 	 */
 	public function htmlConf($form_array, $form_name){
 		
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
 		
 			
 		$conf_html = "";
 		$form_field = array();
 		
 		foreach ($form_array as $key=>$val){
 			
 			$form_field = $form_array[$key];
 			
 			if ($form_field['type'] == 'privacy' ) continue;

 			$method = $form_field['type'].'HtmlConf';
 		
	 		//if (method_exists($this, $method))
	 		$conf_html .= $this->$method($key, $form_field);
	 		
 		}

 		
 		$cache_dir = HOME_DIR."/cache";
 		
 		$file = $cache_dir."/".$form_name.".tpl";
 		
 		$fp = fopen($file, 'w');
 		fwrite($fp, $conf_html);
 		fclose($fp);
 		
 		$fetch_html = $this->smarty->fetch($file);

 		return $fetch_html;
 		
 		
 	} // htmlConf
 	
 	
 	
 	
 	/**
 	 * generate text html code
 	 * @param $key
 	 * @param $form_field
 	 * @param $type
 	 * @return text html code
 	 */
 	public function textHtmlCode($key, $form_field, $type){
 		
 		if (!empty($form_field['value'])){
 							
 			switch ($form_field['value']){

 				case 'date':
 					$date = $data_class->dateValue();
 					$initial_val = $date; 								
 				break;
 								
 				default:
 					$initial_val = $form_field['value'];
 				break;	
 			}
 			
 			$this->smarty->assign('initial_val_'.$key, $initial_val);
 							
 		}
 		
 		$html = '<tr>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '<div ';
 					
 		if ($form_field['divClass'])
 			$html .= 'class="'.$form_field['divClass'].'" ';
 							
 		if ($form_field['divId'])
 			$html .= 'id="'.$form_field['divId'].'" ';
 						
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '>';
 							
 		$html .='
			<th scope="row"';

 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
		
		$html .= '><div {if $err.'.$key.'}class="wpfErrorBox" id="'.$key.'_err"{/if}>'.$form_field['label'].'</div></th>
			<td>
			{if $err.'.$key.'}<p class="wpfErrorMsg" id="'.$key.'_err_msg">{$err.'.$key.'}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><span class="wpfRbox"><input type="'.$form_field['type'].'" name="pd['.$key.']" value="';
		
		$html .='{if $pd.'.$key.'}{$pd.'.$key.'}{elseif $initial_val_'.$key.'}{$initial_val_'.$key.'}{/if}'; 						
 		
		$html .='" size="'.$form_field['size'].'" maxlength="'.$form_field['maxlength'].'" ';

 		$html .= 'class="RemoveErrroMsg ';
 		
 		if ($form_field['class'])
 			$html .= $form_field['class'];
 		else 
 			$html .= ' wpfWideL ';
 								
 		if ($form_field['required'] == 1)
			$html .=' wpfInputMust ';
							
 		$html .= '" ';
 						
 		if ($form_field['id'])
 			$html .= ' id="'.$form_field['id'].'"';
 		else 
 			$html .= 'id="'.$key.'"';

 		if ($form_field['txt_check'] && $form_field['txt_check'] > 1)
 			$html .= ' checkVal="'.$form_field['txt_check'].'"';
 						
 		$html .=' /> </span></dt>';
		
		if ($form_field['exemple'])
 			$html .= '<dd><div class="wpfSpace">'.$form_field['exemple'].'</div></dd>';
 						
 		$html .='</dl>';
 		
 		if ($form_field['txt_check'] && $form_field['txt_check'] > 1)
 			$html .= '<div class="wpfFormat">'.$this->data_class->getCheckName($form_field['txt_check']).'</div>';
		
 		$html .= '</div>';
 		
		if ($form_field['description'])
 			$html .= '<ul class="wpfNotes"><li>'.nl2br($form_field['description']).'</li></ul>';
 				
		$html .= '</td>';

 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '</div>
 			';
 							
		$html .= '
			</tr>';
		
		
		//print_r($html);
		
		return $html;
 		
 		
 	} // textHtmlCode
 	
 	
 	
 	
 	
 	/**
 	 * generate textarea html code 
 	 * @param $key
 	 * @param $form_field
 	 * @param $type
 	 * @return textarea html code
 	 */
 	public function textareaHtmlCode($key, $form_field){
 		
 		$html = '<tr>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '<div ';
 					
 		if ($form_field['divClass'])
 			$html .= 'class="'.$form_field['divClass'].'" ';
 							
 		if ($form_field['divId'])
 			$html .= 'id="'.$form_field['divId'].'" ';
 						
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '>';
 		
 		$html .='
			<th scope="row" ';

 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
			
 		$html .= '><div {if $err.'.$key.'}class="wpfErrorBox" id="'.$key.'_err"{/if}>'.$form_field['label'].'</div></th>
			<td>
			{if $err.'.$key.'}<p class="wpfErrorMsg" id="'.$key.'_err_msg">{$err.'.$key.'}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><div class="wpfRbox">';
 		
 		$html .= '
			<textarea name="pd['.$key.']" ';
						
		if ($form_field['id'])
 			$html .= ' id="'.$form_field['id'].'" ';
 		else 
 			$html .= 'id="'.$key.'"';

 		$html .= 'class="RemoveErrroMsg ';
 		
 		if ($form_field['class'])
 			$html .= $form_field['class'];
 		else
 			$html .= ' wpfTxtarea ';	
 							
 		$html .= '" ';
 			
 		$html .='rows="'.$form_field['rows'].'" cols="'.$form_field['cols'].'" />{$pd.'.$key.'}</textarea>
			</div></dt>';
		
		if ($form_field['exemple'])
 			$html .='<dd><div class="wpfSpace">'.$form_field['exemple'].'</div></dd>';
 						
		$html .= '
			</dl>
			</div>';
		
		if ($form_field['description'])
			$html .= '<ul class="wpfNotes"><li>'.nl2br($form_field['description']).'</li></ul>';
		
		$html .= '</td>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '</div>
 			';
 							
		$html .= '
			</tr>';

 		return $html;
 		
 		
 	} // textareaHtmlCode
 	
 	
 	
 	/**
 	 * generate pulldown menu html code
 	 * @param $key
 	 * @param $form_field
 	 * @param $type
 	 * @return select html code
 	 */
 	public function selectHtmlCode($key, $form_field, $type){
 		
 		$list = array();
 		if ($form_field['options']){
 							
 			if (is_array($form_field['options']))
 				$list = $form_field['options'];
 			else if (is_string($form_field['options']))
 				$list = explode('::', $form_field['options']);
							
 			array_unshift($list, 0);
 			unset($list[0]);
 			$form_field['data'] = $key.'_options';
 							
 		}elseif ($form_field['data']){
 			$list = $this->data_class->$form_field['data']();
 		}
 		$this->smarty->assign($form_field['data'],$list);
 		
 		
 		if (is_array($form_field['value'])){

 			if ($form_field['value'][0] == 1){
 				$form_field['selected'] = $form_field['value'][1]; 
 			}elseif ( $form_field['value'][0] == 2){
 				$form_field['selected_name'] = $form_field['value'][1];
 			}
 		}
 						
 		$selected = "";
 		if ($form_field['selected'] && $type != 'conf'){
 			$selected = $form_field['selected'];
 			$this->smarty->assign('selected_'.$key,$selected);	
 		}
 		
 						
 		if (empty($form_field['selected_name'])){
 			$form_field['selected_name'] = '選択してください';
 		}
 						
 		$html = '<tr>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '<div ';
 					
 		if ($form_field['divClass'])
 			$html .= 'class="'.$form_field['divClass'].'" ';
 							
 		if ($form_field['divId'])
 			$html .= 'id="'.$form_field['divId'].'" ';
 						
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '>';
 		
 		$html .='
			<th scope="row" ';
 		
 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
			
 		$html .= '><div {if $err.'.$key.'}class="wpfErrorBox" id="'.$key.'_err"{/if}>'.$form_field['label'].'</div></th>
			<td>
			{if $err.'.$key.'}<p class="wpfErrorMsg" id="'.$key.'_err_msg">{$err.'.$key.'}</p>{/if}
			<select name="pd['.$key.']';
 		
		if ($form_field['other'])
 			$html .= '[]';
		
 		$html .= '" ';
								
 		if ($form_field['id'])
 			$html .= ' id="'.$form_field['id'].'"';
 		else 
 			$html .= 'id="'.$key.'"';
 			
 									
 		$html .=' class="'.$form_field['class'].' RemoveErrroMsg ">
			<option value="">'.$form_field['selected_name'].'</option>
			{foreach key=id item=val from=$'.$form_field['data'].'}
			<option value="{$id}" ';
								  	
		/*if ($form_field['opt_val']=='value')
			$html .= ' {if $pd.'.$key.' == $val} selected {/if}';
		else
			$html .= ' {if $pd.'.$key.' == $id} selected {/if}';
			*/
 		$html .= ' {if $pd.'.$key.'} {if $pd.'.$key;
 		
 		if ($form_field['other'])
 			$html .= '.0';
 		
 		$html .= ' == $val || $pd.'.$key;
 		
 		if ($form_field['other'])
 			$html .= '.0';
 			
 		$html .= ' == $id} selected {/if} {elseif $selected_'.$key.'} {if $selected_'.$key.' == $id} selected {/if}{/if}>{$val}</option>
			{/foreach}
			</select>';
								  	
		if ($form_field['other']){
 			$expl = explode('::', $form_field['other']);
 			$size = $expl[0] != "" ? $expl[0] : 60;
 			$maxlength = $expl[1] !="" ? $expl[1] : 50;
 			$html .= '<div class="otherBox">その他 <input type="text" name="pd['.$key.'][other]" id="'.$key.'_other" value="{$pd.'.$key.'.1}" size="'.$size.'" class="text wpfWideM" maxlength="'.$maxlength.'" ';
 			
 			if ($expl[2] && $expl[2] > 1)
 				$html .= ' checkVal="'.$expl[2].'"';
 			
 			$html .= ' /></div>';
 			
 			if ($expl[2] && $expl[2] > 1)
 				$html .= '<div class="wpfFormat">'.$this->data_class->getCheckName($expl[2]).'</div>';
 		}
 		
 		if ($form_field['description'])
 			$html .='<ul class="wpfNotes"><li>'.nl2br($form_field['description']).'</li></ul>';
 		
 		$html .= '</td>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '</div>
 			';
 							
		$html .= '
			</tr>';
 		
 		//print "<br><br><br>".$html."<br><br><br>";
 		return $html;
 		
 	}// selectHtmlCode
 	
 	
 	
 	
 	/**
 	 * generate radio button html code
 	 * @param $key
 	 * @param $form_field
 	 * @param $type
 	 * @return redio button html code
 	 */
 	public function radioHtmlCode($key, $form_field, $type){
 		
 		$list = array();
 		if ($form_field['options']){
 							
 			if (is_array($form_field['options']))
 				$list = $form_field['options'];
 			else if (is_string($form_field['options']))
 				$list = explode('::', $form_field['options']);
 									
			array_unshift($list, 0); 
			unset($list[0]);
			$form_field['data'] = $key.'_options';
 		}elseif ($form_field['data']){
 			$list = $this->data_class->$form_field['data']();
 		}
 		$this->smarty->assign($form_field['data'],$list);
 		
 		
 		if (is_array($form_field['value'])){
 			if ($form_field['value'][0] == 1){
 				$form_field['checked'] = $form_field['value'][1]; 
 			}
 		}
 		

 		$checked = "";
 		if ($form_field['checked'] && $type != 'conf'){
 			$checked = $form_field['checked'];
 			$this->smarty->assign('checked_'.$key,$checked);	
 		}
 		
 		$html = '<tr>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '<div ';
 					
 		if ($form_field['divClass'])
 			$html .= 'class="'.$form_field['divClass'].'" ';
 							
 		if ($form_field['divId'])
 			$html .= 'id="'.$form_field['divId'].'" ';
 						
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '>';
 		
 		$html .='
			<th scope="row" ';
 		
 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
			
 		$html .= '><div {if $err.'.$key.'}class="wpfErrorBox" id="'.$key.'_err"{/if}>'.$form_field['label'].'</div></th>
			<td>
			{if $err.'.$key.'}<p class="wpfErrorMsg" id="'.$key.'_err_msg">{$err.'.$key.'}</p>{/if}
			<ul class="wpfInlineList">
			{foreach from=$'.$form_field['data'].' key=id item=val }
			<li><label class="wpfCheckImg"><input type="radio" class="RemoveErrroMsg"';
 		
		if ($form_field['id'])
 			$html .= ' id="'.$form_field['id'].'"';
 		else 
 			$html .= ' id="'.$key.'" ';	
 		
 		$html .= ' name="pd['.$key.']';

 		if ($form_field['other'])
 			$html .= '[]';
 		
 		$html .= '" value="{$id}" {if $pd.'.$key.'}{if $id==$pd.'.$key;

 		if ($form_field['other'])
 			$html .= '.0';

 		$html .='}checked{/if}{elseif $id==$checked_'.$key.'}checked{/if} />{$val}</label></li>
			{/foreach}
			</ul>';
 		
 		if ($form_field['other']){
 			$expl = explode('::', $form_field['other']);
 			$size = $expl[0] != "" ? $expl[0] : 60;
 			$maxlength = $expl[1] !="" ? $expl[1] : 50;
 			$html .= '<div class="otherBox">その他 <input type="text" name="pd['.$key.'][other]" id="'.$key.'_other" value="{$pd.'.$key.'.1}" size="'.$size.'" class="text wpfWideM" maxlength="'.$maxlength.'" ';
 			
 			if ($expl[2] && $expl[2] > 1)
 				$html .= ' checkVal="'.$expl[2].'"';
 			
 			$html .= ' /></div>';
 			
 			if ($expl[2] && $expl[2] > 1)
 				$html .= '<div class="wpfFormat">'.$this->data_class->getCheckName($expl[2]).'</div>';
 		}
 		
 		if ($form_field['description'])
 			$html .='<ul class="wpfNotes"><li>'.nl2br($form_field['description']).'</li></ul>';
 		
 		$html .= '</td>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '</div>
 			';
 							
		$html .= '
			</tr>';
 		
 		return $html;
 		
 	} // radioHtmlCode
 	
 	
 	
 	
 	
 	/**
 	 * generate checkbox html code
 	 * @param $key
 	 * @param $form_field
 	 * @param $type
 	 * @return checkbox html code
 	 */
 	public function checkboxHtmlCode($key, $form_field, $type){
 		
 		$list = array();
 		if ($form_field['options']){
 							
 			if (is_array($form_field['options']))
 				$list = $form_field['options'];
 			else if (is_string($form_field['options']))
 				$list = explode('::', $form_field['options']);
 							
			array_unshift($list, 0); 
			unset($list[0]);
			$form_field['data'] = $key.'_options';
 		
 		}elseif ($form_field['data']){
 			$list = $this->data_class->$form_field['data']();
 		}
 		
 		$this->smarty->assign($form_field['data'],$list);
 		
 		if (is_array($form_field['value'])){
 			if ($form_field['value'][0] == 1){
 				$form_field['checked'] = $form_field['value'][1]; 
 			}
 		}

 		$check_list = array();
 		if ($form_field['checked'] && $type != 'conf'){
 			$check_list = explode('::', $form_field['checked']);
 			$this->smarty->assign('checked_list_'.$key,$check_list);	
 		}

 		
 		$html = '<tr>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '<div ';
 					
 		if ($form_field['divClass'])
 			$html .= 'class="'.$form_field['divClass'].'" ';
 							
 		if ($form_field['divId'])
 			$html .= 'id="'.$form_field['divId'].'" ';
 						
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '>';
 		
 		$html .='
			<th scope="row" ';
 		
 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
			
 		$html .= '><div {if $err.'.$key.'}class="wpfErrorBox" id="'.$key.'_err"{/if}>'.$form_field['label'].'</div></th>
			<td>
			{if $err.'.$key.'}<p class="wpfErrorMsg" id="'.$key.'_err_msg">{$err.'.$key.'}</p>{/if}
			<ul id="'.$key.'_ul" class="wpfInlineList">
			{foreach from=$'.$form_field['data'].' key=id item=val }
			<li><label class="wpfCheckImg"><input type="checkbox" class="RemoveErrroMsg" ';
			
 		if ($form_field['id'])
 			$html .= ' id="'.$form_field['id'].'"';
 		else 
 			$html .= ' id ="'.$key.'" ';

 		/*back  '{if $id==$pd.'.$key.'}checked
 			{elseif $checked_list_'.$key.'}
 				{if in_array($id , $checked_list_'.$key.')}checked{/if}
 			{elseif $pd.'.$key.'}
 				{if is_array($pd.'.$key.')}{if in_array($id , $pd.'.$key.')}checked{/if}{/if}
 			{/if}';*/
 		
 		$html .=' name="pd['.$key.'][]" value="{$id}" 
 			{if $pd.'.$key.'}
 				{if is_array($pd.'.$key;
 					if ($form_field['other'])
 						$html .= '.0';
 					$html .= ')}
 					{if in_array($id , $pd.'.$key;
 					if ($form_field['other'])
 						$html .= '.0';
 					$html .= ')}checked{/if}
 				{elseif $id==$pd.'.$key;
 					if ($form_field['other'])
 						$html .= '.0';
 					$html .= '}checked
 				{/if}
 			{elseif $checked_list_'.$key.'}
 				{if in_array($id , $checked_list_'.$key.')}checked{/if}
 			{/if}/>{$val}</label></li>
 			{/foreach}{*$pd.'.$key.'|print_r*}
			</ul>';
 		
 		if ($form_field['other']){
 			$expl = explode('::', $form_field['other']);
 			$size = $expl[0] != "" ? $expl[0] : 60;
 			$maxlength = $expl[1] !="" ? $expl[1] : 50;
 			$html .= '<div class="otherBox">その他 <input type="text" name="pd['.$key.'][other]" id="'.$key.'_other" value="{$pd.'.$key.'.1}" size="'.$size.'" class="text wpfWideM" maxlength="'.$maxlength.'" ';
 			
 			if ($expl[2] && $expl[2] > 1)
 				$html .= ' checkVal="'.$expl[2].'"';
 			
 			$html .= ' /></div>';
 			
 			if ($expl[2] && $expl[2] > 1)
 				$html .= '<div class="wpfFormat">'.$this->data_class->getCheckName($expl[2]).'</div>';
 		}
 		
 		if ($form_field['description'])
 			$html .='<ul class="wpfNotes"><li>'.nl2br($form_field['description']).'</li></ul>';
 		 		
 		$html .= '</td>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '</div>
 			';
 							
		$html .= '
			</tr>';
		
		
		return $html;
 		
 	} // checkboxHtmlCode
 	
 		
 	
 	
 	/**
 	 * generate image field html code
 	 * @param $key
 	 * @param $form_field
 	 * @return image field html code
 	 */
 	public function imageHtmlCode($key, $form_field){
 		
 		$html = '<tr>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '<div ';
 					
 		if ($form_field['divClass'])
 			$html .= 'class="'.$form_field['divClass'].'" ';
 							
 		if ($form_field['divId'])
 			$html .= 'id="'.$form_field['divId'].'" ';
 						
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '>';
 		
 		$html .='
			<th scope="row" ';
 		
 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
			
 		$html .= '><div {if $err.'.$key.'}class="wpfErrorBox" id="'.$key.'_err"{/if}>'.$form_field['label'].'</div></th>
			<td>
			{if $err.'.$key.'}<p class="wpfErrorMsg" id="'.$key.'_err_msg">{$err.'.$key.'}</p>{/if}';
 		
 		if ($form_field['options']){
 			
 			if (is_array($form_field['options'])){
 				$type_name = array();
 				foreach ($form_field['options'] as $type){
 					if (is_numeric($type)){
 						$type_name[] = $this->data_class->getImageTypeName($type);
 					}else 
 						$type_name[] = $type;
 				}
 				$options = join(',', $type_name);
 			}else if (is_string($form_field['options']))
 				$options = str_replace('::', ',', $form_field['options']);
 				
 			$html .= '<div class="wpfDescription">'.$options.' 形式のファイルを選択してください。</div>';	
 		}
 			
 		
 		$html .= '<ul id="'.$key.'" class="wpfInlineList">
 			<li><label class="wpfCheckImg"><input name="'.$key.'" type="file"/></label></li>
 			{if $pd.'.$key.'}
 				<li><img src="'.$GLOBALS['gl_wpcms_Info']['wpcms_path'].'/wpform/file/imageDisplay/image_name/{$pd.'.$key.'}" ></li>
 				<input type="hidden" name="pd['.$key.']" value="{$pd.'.$key.'}">
 			{/if} 
 			</ul>';
 		
 		if ($form_field['description'])
 			$html .='<ul class="wpfNotes"><li>'.nl2br($form_field['description']).'</li></ul>';
 		
 		$html .= '</td>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '</div>
 			';
 							
		$html .= '
			</tr>';
 		
 		
		return $html;
 		 		
 		
 	} // imageHtmlCode
 	
 	
 	
 	
 	/**
 	 * generate pdf field html code
 	 * @param $key
 	 * @param $form_field
 	 * @return pdf field html code
 	 */
 	public function pdfHtmlCode($key, $form_field){
 		
 		$html = '<tr>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '<div ';
 					
 		if ($form_field['divClass'])
 			$html .= 'class="'.$form_field['divClass'].'" ';
 							
 		if ($form_field['divId'])
 			$html .= 'id="'.$form_field['divId'].'" ';
 						
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '>';
 		
 		$html .='
			<th scope="row" ';
 		
 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
			
 		$html .= '><div {if $err.'.$key.'}class="wpfErrorBox" id="'.$key.'_err"{/if}>'.$form_field['label'].'</div></th>
			<td>
			{if $err.'.$key.'}<p class="wpfErrorMsg" id="'.$key.'_err_msg">{$err.'.$key.'}</p>{/if}
			<div class="wpfDescription">PDFファイルを選択してください。</div>
			<ul id="'.$key.'" class="wpfInlineList">
 			<li><label class="wpfCheckImg"><input name="'.$key.'" type="file"/></label></li> 
 			{if $pd.'.$key.'}
	 			<li><span class="confPdf"><a href="'.$GLOBALS['gl_wpcms_Info']['wpcms_path'].'/wpform/file/pdfDisplay/pdf_name/{$pd.'.$key.'}" >{$pd.'.$key.'}</a></span></li>
	 			<input type="hidden" name="pd['.$key.']" value="{$pd.'.$key.'}">
 			{/if}
 			</ul>';
 		
 		if ($form_field['description'])
 			$html .='<ul class="wpfNotes"><li>'.nl2br($form_field['description']).'</li></ul>';
 		
 		$html .= '</td>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '</div>
 			';
 							
		$html .= '
			</tr>';
 		
 		
		return $html;
 		
 	} // pdfHtmlCode
 	
 	
 	
 	
 	
 	/**
 	 * generate privacy policy html code
 	 * @param $key
 	 * @param $form_field
 	 * @return privacy policy html code
 	 */
 	public function privacyHtmlCode($key, $form_field){
 		
 		//print_r($form_field);
 		
 		$html = '<tr>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '<div ';
 					
 		if ($form_field['divClass'])
 			$html .= 'class="'.$form_field['divClass'].'" ';
 							
 		if ($form_field['divId'])
 			$html .= 'id="'.$form_field['divId'].'" ';
 						
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '>';
 		
 		$html = '<div class="wpfConfirmBox">';
 		
 		if ($form_field['url_txt'])
 		$html .= '<p><a href="'.$form_field['url'].'" class="ext">'.$form_field['url_txt'].'</a></p>';
 		
 		if ($form_field['pp_detail'])
 		$html .= '<p class="fontS">'.nl2br($form_field['pp_detail']).'</p>';
 		
 		if ($form_field['pp_detail_ex'])
 		$html .= '<p class="fontS">'.nl2br($form_field['pp_detail_ex']).'</p>';
 		
 		if ($form_field['required'] == 1){

 			$html .= '<p>
				<label for="wpfAgreeCheck" class="wpfCheckImg">
				<input name="wpfAgreeCheck" type="checkbox" id="wpfAgreeCheck" value="1" />
				同意する</label>
				</p>';
 			
 		} // if ($form_field['required'] == 1){
 		
		$html .= '
			</div>
			';
 		
 		return $html;
 		
 	} // privacyHtmlCode
 	
 	
 	
 	
 	/**
 	 * generate name set html code
 	 * @param $key
 	 * @param $form_field
 	 * @return name set html code
 	 */
 	public function nameHtmlCode($key, $form_field){
 		
 		$html = '
 		<tr id="'.$key.'_tr" class="nameTr">';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '<div ';
 					
 		if ($form_field['divClass'])
 			$html .= 'class="'.$form_field['divClass'].'" ';
 							
 		if ($form_field['divId'])
 			$html .= 'id="'.$form_field['divId'].'" ';
 						
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '>';
 		
 		$html .='
			<th scope="row" ';
 		
 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
			
 		$html .= '><div {if $err.'.$key.'}class="wpfErrorBox" id="'.$key.'_err"{/if}>'.$form_field['field_labels1'].'</div></th>
 			<td>
 			{if $err.'.$key.'}<p class="wpfErrorMsg" id="'.$key.'_err_msg">{$err.'.$key.'}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListName">
			<dt><span class="wpfWide2em">'.$form_field['field_labels3'].'</span><span class="wpfRbox"><input name="pd['.$key.'_1]" type="text" class="wpfWideM '; 
 		
 		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 			
 		$html .= ' RemoveErrroMsg" id="'.$key.'_1" value="{$pd.'.$key.'_1}" /></span></dt>';

 		if ($form_field['exemple'])
 			$html .= '<dd><div class="wpfSpace">'.$form_field['exemple'].'</div></dd>';
 			
		$html .= '
			</dl>
			<dl class="wpfInlineListName">
			<dt><span class="wpfWide2em">'.$form_field['field_labels4'].'</span><span class="wpfRbox"><input name="pd['.$key.'_2]" type="text" class="wpfWideM '; 
		
		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 			
		$html .= ' RemoveErrroMsg" id="'.$key.'_2" value="{$pd.'.$key.'_2}"/></span></dt>';
		
 		if ($form_field['exemple1'])
 			$html .= '<dd><div class="wpfSpace">'.$form_field['exemple1'].'</div></dd>';
		
 		$html .= '
			</dl>
			<div class="wpfFormat">全角</div>
			</div>';
 		
		if ($form_field['description'])
 			$html .='<ul class="wpfNotes"><li>'.nl2br($form_field['description']).'</li></ul>';
 				
		$html .= '</td>
			</tr>
			<tr class="kanaTr">
			<th scope="row" ';
 		
 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
			
 		$html .= '><div {if $err.'.$key.'_kana}class="wpfErrorBox" id="'.$key.'_kana_err"{/if}>'.$form_field['field_labels2'].'</div></th>
 			<td>
 			{if $err.'.$key.'_kana}<p class="wpfErrorMsg" id="'.$key.'_kana_err_msg">{$err.'.$key.'_kana}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListName">
			<dt><span class="wpfWide2em">'.$form_field['field_labels5'].'</span><span class="wpfRbox"><input name="pd['.$key.'_kana_1]" type="text" class="wpfWideM '; 
 		
 		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 			
 		$html .= ' RemoveErrroMsg" id="'.$key.'_kana_1" value="{$pd.'.$key.'_kana_1}"/></span></dt>';

 		if ($form_field['exemple2'])
 			$html .= '<dd><div class="wpfSpace">'.$form_field['exemple2'].'</div></dd>';

 		$html .= '
			</dl>
			<dl class="wpfInlineListName">
			<dt><span class="wpfWide2em">'.$form_field['field_labels6'].'</span><span class="wpfRbox"><input name="pd['.$key.'_kana_2]" type="text" class="wpfWideM '; 
 		
 		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 			
 		$html .= ' RemoveErrroMsg" id="'.$key.'_kana_2" value="{$pd.'.$key.'_kana_2}"/></span></dt>';

 		if ($form_field['exemple3'])
 			$html .= '<dd><div class="wpfSpace">'.$form_field['exemple3'].'</div></dd>';

 		$html .= '
			</dl>
			<div class="wpfFormat">全角カナ</div>
			</div>
			';
		
		if ($form_field['description1'])
 			$html .='<ul class="wpfNotes"><li>'.nl2br($form_field['description1']).'</li></ul>';
 		
 		$html .= '</td>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '</div>';
 							
		$html .= '
			</tr>';

		
 		return $html;
 		
 	} // nameHtmlCode
 	
 	
 	
 	
 	/**
 	 * generate address set html code
 	 * @param $key
 	 * @param $form_field
 	 * @return address set html code
 	 */
 	public function addressHtmlCode($key, $form_field){
 		
 		$pref_list = $this->data_class->prefecture();
 		$this->smarty->assign('pref_list',$pref_list);
 		
 		$html = '<tr class="addressTr">';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '<div ';
 					
 		if ($form_field['divClass'])
 			$html .= 'class="'.$form_field['divClass'].'" ';
 							
 		if ($form_field['divId'])
 			$html .= 'id="'.$form_field['divId'].'" ';
 						
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '>';
 		
 		$html .='
			<th scope="row" ';
 		
 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
			
 		$html .= '><div {if $err.'.$key.'_pcode}class="wpfErrorBox" id="'.$key.'_pcode_err"{/if}>'.$form_field['field_labels1'].'</div></th>
 			<td>
 			{if $err.'.$key.'_pcode}<p class="wpfErrorMsg" id="'.$key.'_pcode_err_msg">{$err.'.$key.'_pcode}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd['.$key.'_pcode_1]" type="text" maxlength="3" class="wpfWideS RemoveErrroMsg ';
 		
 		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 		
		$html .= '" id="'.$key.'_pcode_1" value="{$pd.'.$key.'_pcode_1}"/></span>−</dt>';
			
 		if ($form_field['exemple'])
 			$html .= '<dd><div class="wpfSpace">'.$form_field['exemple'].'</div></dd>';
 			
		$html .= '
			</dl>
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd['.$key.'_pcode_2]" type="text" maxlength="4" class="wpfWideS RemoveErrroMsg ';
			
		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 			
		$html .= '" id="'.$key.'_pcode_2" value="{$pd.'.$key.'_pcode_2}" 
			 onKeyUp="AjaxZip2.zip2addr(\'pd['.$key.'_pcode_1]\',\'pd['.$key.'_pref]\',\'pd['.$key.'_address_a]\',\'pd['.$key.'_pcode_2]\',null,null);"
			/></span></dt>';
			
		if ($form_field['exemple1'])
 			$html .= '<dd><div class="wpfSpace">'.$form_field['exemple1'].'</div></dd>';
 				
		$html .= '
			</dl>
			</div>';
			
 		if ($form_field['description'])
 			$html .='<ul class="wpfNotes"><li>'.nl2br($form_field['description']).'</li></ul>';
		
 		$html .= '</td>
			</tr>
			<tr>
			<th scope="row" ';
 		
 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
			
 		$html .= '><div {if $err.'.$key.'_pref}class="wpfErrorBox" id="'.$key.'_pref_err"{/if}>'.$form_field['field_labels2'].'</div></th>
 			<td>
			{if $err.'.$key.'_pref}<p class="wpfErrorMsg" id="'.$key.'_pref_err_msg">{$err.'.$key.'_pref}</p>{/if}
 			<select name="pd['.$key.'_pref]" id="'.$key.'_pref" class="RemoveErrroMsg">
			<option value="">選択してください</option>
			{foreach from=$pref_list key=id item=val }
			<option value="{$id}" {if $pd.'.$key.'_pref == $id } selected {/if}>{$val}</option>
			{/foreach}
			</select>
			</td>
			</tr>
			<tr>
			<th scope="row" ';
 		
 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
			
 		$html .= '><div {if $err.'.$key.'_address_a}class="wpfErrorBox" id="'.$key.'_address_err"{/if}>'.$form_field['field_labels3'].'</div></th>
 			<td>
 			{if $err.'.$key.'_address_a}<p class="wpfErrorMsg" id="'.$key.'_address_err_msg">{$err.'.$key.'_address_a}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><span class="wpfRbox"><input name="pd['.$key.'_address_a]" type="text" class="wpfWideL RemoveErrroMsg ';

 		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 			
		$html .= '" id="'.$key.'_address_a" value="{$pd.'.$key.'_address_a}" /></span></dt>';

 		if ($form_field['exemple2'])
 			$html .= '<dd><div class="wpfSpace">'.$form_field['exemple2'].'</div></dd>';
 			
		$html .= '
			</dl>
			</div>';

 		if ($form_field['description1'])
 			$html .='<ul class="wpfNotes"><li>'.nl2br($form_field['description1']).'</li></ul>';
 			
		$html .= '</td>
			</tr>
			<tr>
			<th scope="row">'.$form_field['field_labels4'].'</th>
			<td>
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><span class="wpfRbox"><input name="pd['.$key.'_address_b]" type="text" class="wpfWideL" id="'.$key.'_address_b" value="{$pd.'.$key.'_address_b}" /></span></dt>';

		if ($form_field['exemple3'])
 			$html .= '<dd><div class="wpfSpace">'.$form_field['exemple3'].'</div></dd>';
 			
		$html .= '</dl>
			</div>
			';
 		
 		if ($form_field['description2'])
 			$html .='<ul class="wpfNotes"><li>'.nl2br($form_field['description2']).'</li></ul>';
 		
 		$html .= '</td>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '</div>';
 							
		$html .= '
			</tr>';
 		
 		return $html;
 		 		
 	} // addressHtmlCode
 	
 	
 	
 	
 	
 	/**
 	 * generate mail address set html code
 	 * @param $key
 	 * @param $form_field
 	 * @return mail address set html code
 	 */
 	public function mailHtmlCode($key, $form_field){
 		
 		$html = '<tr>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '<div ';
 					
 		if ($form_field['divClass'])
 			$html .= 'class="'.$form_field['divClass'].'" ';
 							
 		if ($form_field['divId'])
 			$html .= 'id="'.$form_field['divId'].'" ';
 						
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '>';
 		
 		$html .='
			<th scope="row" ';
 		
 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
			
 		$html .= '><div {if $err.'.$key.'}class="wpfErrorBox" id="'.$key.'_err"{/if}>'.$form_field['label'].'</div></th>
 			<td>
 			{if $err.'.$key.'}<p class="wpfErrorMsg" id="'.$key.'_err_msg">{$err.'.$key.'}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><div class="mb10"><span class="wpfRbox"><input name="pd['.$key.'_mail]" type="text" class="wpfWideL RemoveErrroMsg '; 
 		
 		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 			
 		$html .= '" id="'.$key.'_mail" value="{$pd.'.$key.'_mail}"/></span></div>
			<div class="mb10">確認のため、もう一度ご入力ください。</div>
			<div><span class="wpfRbox"><input name="pd['.$key.'_mail_conf]" type="text" class="wpfWideL RemoveErrroMsg '; 
 		
 		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 			
 		$html .= '" id="'.$key.'_mail_conf" value="{$pd.'.$key.'_mail_conf}"/></span></div>
			</dt>';
 		
		if ($form_field['exemple'])
 			$html .='<dd><div class="wpfSpace">'.$form_field['exemple'].'</div></dd>
			</dl>
			</div>';
			
 		if ($form_field['description'])
 			$html .='<ul class="wpfNotes"><li>'.nl2br($form_field['description']).'</li></ul>';
 		
 		$html .= '</td>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '</div>';
 							
		$html .= '
			</tr>';

		
 		return $html;
 		
 	} // mailHtmlCode
 	
 	
 	
 	
 	/**
 	 * generate birthday set html code
 	 * @param $key
 	 * @param $form_field
 	 * @return birthday set html code
 	 */
 	public function birthdayHtmlCode($key, $form_field){
 		
 		$year_type = $this->data_class->yearType();
 		$this->smarty->assign('year_type',$year_type);
 		
 		$html = '<tr class="birthdayTr">';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '<div ';
 					
 		if ($form_field['divClass'])
 			$html .= 'class="'.$form_field['divClass'].'" ';
 							
 		if ($form_field['divId'])
 			$html .= 'id="'.$form_field['divId'].'" ';
 						
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '>';
 		
 		$html .='
			<th scope="row" ';
 		
 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
			
 		$html .= '><div {if $err.'.$key.'}class="wpfErrorBox" id="'.$key.'_err"{/if}>'.$form_field['label'].'</div></th>
 			<td>
 			{if $err.'.$key.'}<p class="wpfErrorMsg" id="'.$key.'_err_msg">{$err.'.$key.'}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListS">
			<dt><span class="wpfNbox">
			<select name="pd['.$key.'_year_type]" id="'.$key.'_year_type" class="dropdown">
			{foreach from=$year_type key=id item=val }
			<option value="{$id}" {if $pd.'.$key.'_year_type == $id } selected {/if}{if empty($pd.'.$key.'_year_type) && $id==3}selected{/if}>{$val}</option>
			{/foreach}
			</select>
			</span></dt>
			<dd></dd>
			</dl>
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd['.$key.'_year]" type="text" maxlength="4" class="wpfWideS RemoveErrroMsg ';
		
 		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 				
		$html .= '" id="'.$key.'_year" value="{$pd.'.$key.'_year}"/></span><span class="wpfWide1em">'.$form_field['field_labels1'].'</span></dt>';
		
 		if ($form_field['exemple'])
 			$html .= '<dd><div class="wpfSpace">'.$form_field['exemple'].'</div></dd>';
 			
		$html .= '
			</dl>
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd['.$key.'_month]" type="text" maxlength="4" class="wpfWideS RemoveErrroMsg ';
		
		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 			
		$html .='" id="'.$key.'_month" value="{$pd.'.$key.'_month}"/></span><span class="wpfWide1em">'.$form_field['field_labels2'].'</span></dt>';
		
 		if ($form_field['exemple1'])
 			$html .= '<dd><div class="wpfSpace">'.$form_field['exemple1'].'</div></dd>';
 		
		$html .= '</dl>
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd['.$key.'_day]" type="text" maxlength="4" class="wpfWideS RemoveErrroMsg '; 
		
		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 			
		$html .= '" id="'.$key.'_day" value="{$pd.'.$key.'_day}"/></span><span class="wpfWide1em">'.$form_field['field_labels3'].'</span></dt>';
			
		if ($form_field['exemple2'])
 			$html .= '<dd><div class="wpfSpace">'.$form_field['exemple2'].'</div></dd>';
 				
		$html .= '
			</dl>
			</div>';
 		
 		if ($form_field['description'])
 			$html .='<ul class="wpfNotes"><li>'.nl2br($form_field['description']).'</li></ul>';
 		
 		$html .= '</td>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '</div>';
 							
		$html .= '
			</tr>';
 		
 		
 		return $html;
 		
 	} // birthdayHtmlCode
 	
 	
 	
 	/**
 	 * generate tel set html code
 	 * @param $key
 	 * @param $form_field
 	 * @return tel set html code
 	 */
 	public function telHtmlCode($key, $form_field){
 		
 		
 		$html = '<tr class="telTr">';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '<div ';
 					
 		if ($form_field['divClass'])
 			$html .= 'class="'.$form_field['divClass'].'" ';
 							
 		if ($form_field['divId'])
 			$html .= 'id="'.$form_field['divId'].'" ';
 						
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '>';
 		
 		$html .='
			<th scope="row" ';
 		
 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
			
 		$html .= '><div {if $err.'.$key.'}class="wpfErrorBox" id="'.$key.'_err"{/if}>'.$form_field['label'].'</div></th>
 			<td>
 			{if $err.'.$key.'}<p class="wpfErrorMsg" id="'.$key.'_err_msg">{$err.'.$key.'}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd['.$key.'_1]" type="text" maxlength="2" class="wpfWideS RemoveErrroMsg '; 
 		
 		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 			
 		$html .= '" id="'.$key.'_1" value="{$pd.'.$key.'_1}"/></span>−</dt>';

 		if ($form_field['exemple'])
 			$html .= '<dd><div class="wpfSpace">'.$form_field['exemple'].'</div></dd>';
 			
 		$html .= '
			</dl>
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd['.$key.'_2]" type="text" maxlength="4" class="wpfWideS RemoveErrroMsg '; 
 		
 		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 			
 		$html .= '" id="'.$key.'_2" value="{$pd.'.$key.'_2}"/></span>−</dt>';

 		if ($form_field['exemple1'])
 			$html .= '<dd><div class="wpfSpace">'.$form_field['exemple1'].'</div></dd>';
 			
 		$html .= '
			</dl>
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd['.$key.'_3]" type="text" maxlength="4" class="wpfWideS RemoveErrroMsg '; 
 		
 		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 			
 		$html .= '" id="'.$key.'_3" value="{$pd.'.$key.'_3}"/></span></dt>';
 		
 		if ($form_field['exemple2'])
 			$html .= '<dd><div class="wpfSpace">'.$form_field['exemple2'].'</div></dd>';

 		$html .='
			</dl>
			</div>';
 		
 		if ($form_field['description'])
 			$html .='<ul class="wpfNotes"><li>'.nl2br($form_field['description']).'</li></ul>';
 		
 		$html .= '</td>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '</div>';
 							
		$html .= '
			</tr>';
 		
 		
 		return $html;
 		
 		
 	} // telHtmlCode
 	
 	
 	
 	
 	
 	
 	/**
 	 * generate yes no radio set html code
 	 * @param $key
 	 * @param $form_field
 	 * @return yes no radio set html code
 	 */
 	public function ynradioHtmlCode($key, $form_field, $type){
 		
 		$html = '<tr>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '<div ';
 					
 		if ($form_field['divClass'])
 			$html .= 'class="'.$form_field['divClass'].'" ';
 							
 		if ($form_field['divId'])
 			$html .= 'id="'.$form_field['divId'].'" ';
 						
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '>';
 		
 		$html .='
			<th scope="row" ';
 		
 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';

		$html .= '><div {if $err.'.$key.'}class="wpfErrorBox" id="'.$key.'_err"{/if}>'.$form_field['label'].'</div></th>
			<td>
			{if $err.'.$key.'}<p class="wpfErrorMsg" id="'.$key.'_err_msg">{$err.'.$key.'}</p>{/if}
			<div class="clearfix">
			<ul id="'.$key.'_ul" class="wpfInlineList yesNoUl">
			<li><label class="checkImg"><input name="pd['.$key.']" type="radio" class="RemoveErrroMsg" id="'.$key.'" value="1" {if $pd.'.$key.' == 1}checked{/if}/> '.$form_field['field_labels1'].'</label></li>
			<li><label class="checkImg"><input name="pd['.$key.']" type="radio" class="RemoveErrroMsg" id="'.$key.'" value="2" {if $pd.'.$key.' == 2}checked{/if}/> '.$form_field['field_labels2'].'</label></li>
			</ul>
			</div>';
			
		if ($form_field['description'])
 			$html .='<ul class="wpfNotes"><li>'.nl2br($form_field['description']).'</li></ul>';
 			
 		$html .= '</td>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '</div>';
 							
		$html .= '
			</tr>';
		
		//print_r($form_field['ynfields']);
		
		
	 	/**
	 	 * get yes no fields form array
	 	 */
	 	$form_array = $this->makeYesNoFieldsData($key, $form_field);
	 	
	 	if (!empty($form_array))
	 		$yesno_html = $this->htmlForm($form_array, 'yesno_'.$ynfields, $type);
 		
	 	$html .= str_replace('<tr>', '<tr class="'.$key.'_display dspNone">', $yesno_html);
			
		
 		return  $html; 		
 		
 	} // ynradioHtmlCode
 	
 	
 	
 	
 	
 	/**
 	 * make yes no fields form array
 	 * @param $key
 	 * @param $form_field
 	 * @return form array
 	 */
 	public function makeYesNoFieldsData($key,$form_field){
 		
 		/**
	 	 * make yes no fields data
	 	 */
	 	$ynfields 	= array();
	 	
	 	if (!empty($form_field['ynfields'])){
	
	 		$fields = explode('|yn|', $form_field['ynfields']);
	 		
	 		foreach ($fields as $row){

	 			$expl = explode(':=:', $row);
	 			$field_value = $expl[1];
	 			
	 			$field_expl = explode('_', $expl[0]);
	 				
	 			if (preg_match('/;opt;/', $expl[1]))
	 				$field_value = explode(';opt;', $expl[1]);
	 				
	 					
	 			//$ynfields[$field_expl[1]][$expl[0]] = $field_value;
	 			$ynfields[$field_expl[1]][$field_expl[0].'_'.$field_expl[1]][$field_expl[2]] = $field_value;
	 			$ynfields[$field_expl[1]][$field_expl[0].'_'.$field_expl[1]]['type'] = $field_expl[0];
	 				
	 		} // foreach ($expl_fields as $row){
	 			
	 		unset($form_field['ynfields']);
	 			
	 	} // if (!empty($form_entry_data['ynfields'])){
	 		
	 	/**
	 	 * sort yes no field as input sequence
	 	 */
	 	ksort($ynfields);
	 	
	 		
	 	/**
	 	 * merge yes no fields to form field data
	 	 */
	 	$form_array = array();
	 	foreach ($ynfields as $yn_row){
	 		$array_key = array_keys($yn_row);
	 		$array_val = array_values($yn_row);
	 		$form_array[$key.'_'.$array_key[0]] = $array_val[0];
	 	}
	 	//print_r($form_array);
	 	
	 	
	 	return $form_array;
	 	
 	} // makeYesNoFieldsData
 	
 	
 	
 	
 	
 	/**
 	 * generate password set html code
 	 * @param $key
 	 * @param $form_field
 	 * @return password set html code
 	 */
 	public function passwordHtmlCode($key, $form_field){
 		
 		
 		$html = '<tr>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '<div ';
 					
 		if ($form_field['divClass'])
 			$html .= 'class="'.$form_field['divClass'].'" ';
 							
 		if ($form_field['divId'])
 			$html .= 'id="'.$form_field['divId'].'" ';
 						
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '>';
 		
 		$html .='
			<th scope="row" ';
 		
 		if ($form_field['required'] == 1)
			$html .=' class="wpfMustBox"';
			
 		$html .= '><div {if $err.'.$key.'}class="wpfErrorBox" id="'.$key.'_err"{/if}>'.$form_field['label'].'</div></th>
			<td>
			{if $err.'.$key.'}<p class="wpfErrorMsg" id="'.$key.'_err_msg">{$err.'.$key.'}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><div class="mb10"><span class="wpfRbox"><input name="pd['.$key.'_pass]" type="password" class="wpfWideL RemoveErrroMsg ';
 		
 		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 			
 		$html .= '" id="'.$key.'_pass" value="{$pd.'.$key.'_pass}"/></span></div>
			<div class="mb10">確認のため、もう一度ご入力ください。</div>
			<div><span class="wpfRbox"><input name="pd['.$key.'_pass_conf]" type="password" class="wpfWideL RemoveErrroMsg ';
 		
 		if ($form_field['required'] == 1)
 			$html .= 'wpfInputMust';
 			
 		$html .= '" id="'.$key.'_pass_conf" value="{$pd.'.$key.'_pass_conf}"/></span></div>
			</dt>
			<dd></dd>
			</dl>
			</div>
			';

 		if ($form_field['description'])
 			$html .='<ul class="wpfNotes">
 				<li>※パスワードは「'.$form_field['minlength'].'~'.$form_field['maxlength'].'」文字まで入力してください</li>
 				<li>'.nl2br($form_field['description']).'</li></ul>';
 		
 		$html .= '</td>';
 		
 		if ($form_field['divClass'] || $form_field['divId'])
 			$html .= '</div>';
 							
		$html .= '
			</tr>';
		
		
 		return $html;
 		
 		
 	} // passwordHtmlCode
 	
 	
 	/**
 	 * generate confirm html for text input
 	 * @param $key
 	 * @param $form_field
 	 * @return text confirm html
 	 */
 	public function textHtmlConf($key, $form_field){
 		
 		$html = '<tr>
			<th width="160" scope="row">'.$form_field['label'].'</th>
			<td><span class="confTxt">{$pd.'.$key.'}</span></td>
		</tr>';
 		
 		return $html;
 		
 	} // textHtmlConf
 	
 	
 	
 	/**
 	 * generate confirm html for textarea input
 	 * @param $key
 	 * @param $form_field
 	 * @return textarea confirm html
 	 */
 	public function textareaHtmlConf($key, $form_field){
 		
 		$html = '<tr>
			<th width="160" scope="row">'.$form_field['label'].'</th>
			<td><span class="confTxt">{$pd.'.$key.'|nl2br}</span></td>
		</tr>';
 		
 		return $html;
 		
 	} // textareaHtmlConf
 	
 	
 	/**
 	 * generate confirm html for pulldown input
 	 * @param $key
 	 * @param $form_field
 	 * @return pulldown confirm html
 	 */
 	public function selectHtmlConf($key, $form_field){
 		
 		if ($form_field['options']){
 			
 			if (is_array($form_field['options']))
 				$options = $form_field['options'];
 			elseif (preg_match('/::/', $form_field['options']))
 				$options = explode('::', $form_field['options']);
 			
 			array_unshift($options, 0);
 			unset($options[0]);
 			$this->smarty->assign($key.'_options',$options);
 		}
 		
 		$html = '<tr>
			<th width="160" scope="row">'.$form_field['label'].'</th>
			<td><span class="confTxt">
			{foreach from=$'.$key.'_options key=id item=val }
				{if $id == $pd.'.$key; 
 					if ($form_field['other'])
 						$html .= '.0';
 		 			$html .= '}{$val}
 		 		{/if}
			{/foreach}';

 		if ($form_field['other']){
 			$html .= '{$pd.'.$key.'.1}';
 		}
			
		$html .= '</span></td></tr>';
 		
 		return $html;
 		
 	} // selectHtmlConf
 	
 	
 	/**
 	 * generate confirm html for radio input
 	 * @param $key
 	 * @param $form_field
 	 * @return radio confirm html
 	 */
 	public function radioHtmlConf($key, $form_field){
 		
 		if ($form_field['options']){
 			
 			if (is_array($form_field['options']))
 				$options = $form_field['options'];
 			elseif (preg_match('/::/', $form_field['options']))
 				$options = explode('::', $form_field['options']);
 			
 			array_unshift($options, 0);
 			unset($options[0]);
 			$this->smarty->assign($key.'_options',$options);
 		}
 		
 		$html = '<tr>
			<th width="160" scope="row">'.$form_field['label'].'</th>
			<td><span class="confTxt">
			{foreach from=$'.$key.'_options key=id item=val }
				{if $id == $pd.'.$key; 
 					if ($form_field['other'])
 						$html .= '.0';
 		 			$html .= '}{$val}
 		 		{/if}
			{/foreach}';
							
 		if ($form_field['other']){
 			$html .= ' {$pd.'.$key.'.1}';
 		}
			
		$html .= '</span></td></tr>';
 		
 		return $html;
 		
 	} // radioHtmlConf
 	
 	
 	
 	/**
 	 * generate confirm html for checkbox input
 	 * @param $key
 	 * @param $form_field
 	 * @return checkbox confirm html
 	 */
 	public function checkboxHtmlConf($key, $form_field){
 		
 		if ($form_field['options']){
 			
 			if (is_array($form_field['options']))
 				$options = $form_field['options'];
 			elseif (preg_match('/::/', $form_field['options']))
 				$options = explode('::', $form_field['options']);
 			
 			array_unshift($options, 0);
 			unset($options[0]);
 			$this->smarty->assign($key.'_options',$options);
 		}
 		
 		//print_r($form_field);print "<br><br>";
 		
 		$html = '<tr>
			<th width="160" scope="row">'.$form_field['label'].'</th>
			<td><span class="confTxt">
			{foreach from=$'.$key.'_options key=id item=val }
				{if is_array($pd.'.$key; 
 					if ($form_field['other'])
 						$html .= '.0';
 					$html .=')}
 					{if in_array($id , $pd.'.$key;
 					if ($form_field['other'])
 						$html .= '.0';
 					$html .= ')}{$val} {/if}			
				{elseif $id == $pd.'.$key; 
 					if ($form_field['other'])
 						$html .= '.0';
 		 			$html .= '}{$val};
 		 		{/if}
			{/foreach}
			';
 		 			
 		if ($form_field['other']){
 			$html .= ' : {$pd.'.$key.'.1}';
 		}
			
		$html .= '</span></td></tr>';
 		
 		return $html;
 		
 	} // checkboxHtmlConf
 	
 	
 	/**
 	 * generate confirm html for image input
 	 * @param $key
 	 * @param $form_field
 	 * @return image confirm html
 	 */
 	public function imageHtmlConf($key, $form_field){
 		
 		$html = '<tr>
			<th width="160" scope="row">'.$form_field['label'].'</th>
			<td><span class="confImg">{if $pd.'.$key.'}<img src="'.$GLOBALS['gl_wpcms_Info']['wpcms_path'].'/wpform/file/imageDisplay/image_name/{$pd.'.$key.'}" >{/if}</span></td>
		</tr>';
 		
 		return $html;
 		
 	} // imageHtmlConf
 	
 	
 	
 	
 	/**
 	 * generate confirm html for pdf input
 	 * @param $key
 	 * @param $form_field
 	 * @return pdf confirm html
 	 */
 	public function pdfHtmlConf($key, $form_field){
 		
 		$html = '<tr>
			<th width="160" scope="row">'.$form_field['label'].'</th>
			<td><span class="confPdf">{if $pd.'.$key.'}<a href="'.$GLOBALS['gl_wpcms_Info']['wpcms_path'].'/wpform/file/pdfDisplay/pdf_name/{$pd.'.$key.'}" >{$pd.'.$key.'}</a>{/if}</span></td>
		</tr>';
 		
 		return $html;
 		
 	} // pdfHtmlConf
 	
 	
 	/**
 	 * generate confirm html for name input
 	 * @param $key
 	 * @param $form_field
 	 * @return name confirm html
 	 */
 	public function nameHtmlConf($key, $form_field){
 		
 		$html = '<tr>
			<th width="160" scope="row">'.$form_field['field_labels1'].'</th>
			<td><span class="confTxt">{$pd.'.$key.'_1}{$pd.'.$key.'_2}</span></td>
		</tr>
		
		<tr>
			<th width="160" scope="row">'.$form_field['field_labels2'].'</th>
			<td><span class="confTxt">{$pd.'.$key.'_kana_1}{$pd.'.$key.'_kana_2}</span></td>
		</tr>
		
		';
 		
 		return $html;
 		
 	} // nameHtmlConf
 	
 	
 	
 	/**
 	 * generate confirm html for mail input
 	 * @param $key
 	 * @param $form_field
 	 * @return mail confirm html
 	 */
 	public function mailHtmlConf($key, $form_field){
 		
 		$html = '<tr>
			<th width="160" scope="row">'.$form_field['label'].'</th>
			<td><span class="confTxt">{$pd.'.$key.'_mail}</span></td>
		</tr>';
 		
 		return $html;
 		
 	} // mailHtmlConf
 	
 	
 	/**
 	 * generate confirm html for address input
 	 * @param $key
 	 * @param $form_field
 	 * @return address confirm html
 	 */
 	public function addressHtmlConf($key, $form_field){
 		
 		$html = '<tr>
			<th width="160" scope="row">'.$form_field['field_labels1'].'</th>
			<td><span class="confTxt">{$pd.'.$key.'_pcode_1}-{$pd.'.$key.'_pcode_2}</span></td>
		</tr>
		
		<tr>
			<th width="160" scope="row">'.$form_field['field_labels2'].'</th>
			<td><span class="confTxt">{$pd.'.$key.'_pref|pref}</span></td>
		</tr>
		
		<tr>
			<th width="160" scope="row">'.$form_field['field_labels3'].'</th>
			<td><span class="confTxt">{$pd.'.$key.'_address_a}</span></td>
		</tr>
		
		<tr>
			<th width="160" scope="row">'.$form_field['field_labels4'].'</th>
			<td><span class="confTxt">{$pd.'.$key.'_address_b}</span></td>
			
		</tr>
		';
 		
 		return $html;
 		
 	} // addressHtmlConf
 	
 	
 	
 	/**
 	 * generate confirm html for birthday input
 	 * @param $key
 	 * @param $form_field
 	 * @return birthday confirm html
 	 */
 	public function birthdayHtmlConf($key, $form_field){
 		
 		$year_type = $this->data_class->yearType();
 		$this->smarty->assign('year_type',$year_type);
 		
 		$html = '<tr>
			<th width="160" scope="row">'.$form_field['label'].'</th>
			<td>
				<span class="confTxt">{foreach from=$year_type key=id item=val }{if $pd.'.$key.'_year_type == $id }{$val}{/if}{/foreach}</span>&nbsp;
				<span class="confTxt">{$pd.'.$key.'_year}'.$form_field['field_labels1'].'</span>&nbsp;
				<span class="confTxt">{$pd.'.$key.'_month}'.$form_field['field_labels2'].'</span>&nbsp;
				<span class="confTxt">{$pd.'.$key.'_day}'.$form_field['field_labels3'].'</span>
			</td>
		</tr>
		';
 		
 		return $html;
 		
 	} // birthdayHtmlConf
 	
 	
 	/**
 	 * generate confirm html for tel input
 	 * @param $key
 	 * @param $form_field
 	 * @return tel confirm html
 	 */
 	public function telHtmlConf($key, $form_field){
 		
 		$year_type = $this->data_class->yearType();
 		$this->smarty->assign('year_type',$year_type);
 		
 		$html = '<tr>
			<th width="160" scope="row">'.$form_field['label'].'</th>
			<td>
				<span class="confTxt">{$pd.'.$key.'_1}</span>-
				<span class="confTxt">{$pd.'.$key.'_2}</span>-
				<span class="confTxt">{$pd.'.$key.'_3}</span>
			</td>
		</tr>
		';
 		
 		return $html;
 		
 	} // telHtmlConf
 	
 	
 	
 	/**
 	 * generate confirm html for ynradio input
 	 * @param $key
 	 * @param $form_field
 	 * @return ynradio confirm html
 	 */
 	public function ynradioHtmlConf($key, $form_field){
 		
 		$html = '<tr>
			<th width="160" scope="row">'.$form_field['label'].'</th>
			<td><span class="confTxt">
				{if $pd.'.$key.' == 1}'.$form_field['field_labels1'].'{/if}
				{if $pd.'.$key.' == 2}'.$form_field['field_labels2'].'{/if}
			</span></td>
		</tr>';
 		
 		return $html;
 		
 	} // ynradioHtmlConf
 	
 	
 	/**
 	 * generate confirm html for password input
 	 * @param $key
 	 * @param $form_field
 	 * @return password confirm html
 	 */
 	public function passwordHtmlConf($key, $form_field){
 		
 		$html = '<tr>
			<th width="160" scope="row">'.$form_field['label'].'</th>
			<td><span class="confTxt">{$pd.'.$key.'_pass}</span></td>
		</tr>';
 		
 		return $html;
 		
 	} // passwordHtmlConf
 	
 	
 	
 
 } // HtmlFormClass
 
 
 ?>