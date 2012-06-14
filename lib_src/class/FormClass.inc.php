<?php
/**
 * FormClass.inc.php
 * 
 * @created on 2011/07/15
 * @package	   Form	    
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2011/07/15-14:00:29 fabien 
 * 
 *File content
     FormClass.inc.php
 *     
 */


 class FormClass{
 	
 	
 	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	
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
 	 * 
 	 * build form html from form data
 	 * @param $form_array
 	 * @param $form_name
 	 * @return $form_html
 	 */
 	public function form($form_array, $form_name, $type='form', $option_count=null, $request_from=null){
 		
 		//print $form_name."<br><br>";
 		//print_r($form_array);print "<br><br>";
 		
 		if (empty($form_array))
 			if (empty($form_id) || !is_numeric($form_id))
	 		setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: from array if empty");
 		
 		global $smarty;
 		$smarty->assign('checked','');
 		
 		$data_class = new DataClass();
 			
 		if ($type != 'recursive')
 			$html = "";
 			
 		foreach ($form_array as $key=>$val){
 			
 			$form_field = $form_array[$key];
 			
 			switch ($form_field['type']){
 				
 				case 'text':
 						$html .= '<tr';
 						if ($form_field['divClass'])
 							$html .= ' class="'.$form_field['divClass'].'" ';
 							
 						if ($form_field['divId']){
 							if ($form_field['divId'] == 'other_size_id' || $form_field['divId'] == 'other_maxlength_id'){
 								$html .= ' id="'.$key.'" ';
 							}else {
 								$html .= ' id="'.$form_field['divId'].'" ';
 							}
 						}
 						$html .= '>'."\n".'<th width="200" scope="row"';
 						if ($form_field['required'] == 1)
 							$html .= ' class="wpfMustBox"';
 						$html .= '>'.$form_field['label'];
  	 						if ($form_field['required'] == 1)
  						$html .= '<span class="red">※</span>';
 						$html .= '</th>'."\n";
 						$html .= '<td><input type="'.$form_field['type'].'" name="pd['.$key.']" value="';
 						if ($form_field['value'] && $type == 'form'){
 							switch ($form_field['value']){
 								case 'date':
 									$date = $data_class->dateValue();
 									$html .= $date;
 								break;
 								default:
 									$html .= $form_field['value'];
 								break;	
 							}
 						}else {
 							$html .='{$pd.'.$key.'}';
 						}
 						$html .='" size="'.$form_field['size'].'" class="'.$form_field['class'].'"'; 
 						
 						if ($form_field['id'])
 							$html .= ' id="'.$form_field['id'].'"';
 						
 						$html .=' maxlength="'.$form_field['maxlength'].'" /> ';
 						
 						// 例の表示
 						if ($form_field['exemple'])
 						$html .='<br />'.$form_field['exemple'];
 						
 						// 補足説明の表示
 						if ($form_field['description'])
 						$html .='<br />'.$form_field['description'];
 						
 						$html .='</td>'."\n".'</tr>'."\n\n";
 					break;

 				case 'textarea':
 						$html .= '<tr';
 						if ($form_field['divClass'])
 							$html .= ' class="'.$form_field['divClass'].'" ';
 						if ($form_field['divId'])
 							$html .= ' id="'.$form_field['divId'].'" ';
 						$html .= '>'."\n".'<th width="200" scope="row"';
 						if ($form_field['required'] == 1)
 							$html .= ' class="wpfMustBox"';
 						$html .= '>'.$form_field['label'];
  	 						if ($form_field['required'] == 1)
  						$html .= '<span class="red">※</span>';
 						$html .= '</th>'."\n";
 							
						$html .= '<td><textarea name="pd['.$key.']" ';
						
						if ($form_field['id'])
 							$html .= ' id="'.$form_field['id'].'" ';
						
 						if ($form_field['class'])
 							$html .= ' class="'.$form_field['class'].'" ';
 							
						$html .='rows="'.$form_field['rows'].'" cols="'.$form_field['cols'].'" />{$pd.'.$key.'}</textarea>';
						
 						// 例の表示
						if ($form_field['exemple'])
 						$html .='<br />'.$form_field['exemple'];
 						
 						// 補足説明の表示
 						if ($form_field['description'])
 						$html .='<br />'.$form_field['description'];
 						
						$html .= '</td>'."\n".'</tr>'."\n\n";
 					break;
 					
 				case 'select':
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
 							$list = $data_class->$form_field['data']();
 						}
 						$smarty->assign($form_field['data'],$list);
 						
 						$selected = array();
 						if ($form_field['selected'] && $type != 'conf'){
 							$selected = $form_field['selected'];
 							$smarty->assign('selected_'.$key,$selected);	
 						}
 						
 						if (empty($form_field['selected_name'])){
 							$form_field['selected_name'] = '選択してください';
 						}

 						$html .= '<tr';
 						if ($form_field['divClass'])
 							$html .= ' class="'.$form_field['divClass'].'" ';
 							
 						if ($form_field['divId'])
 							$html .= ' id="'.$form_field['divId'].'" ';
 						$html .= '>'."\n".'<th width="200" scope="row"';
 						if ($form_field['required'] == 1)
 							$html .= ' class="wpfMustBox"';
 						$html .= '>'.$form_field['label'];
  	 						if ($form_field['required'] == 1)
  						$html .= '<span class="red">※</span>';
 						$html .= '</th>'."\n".'<td>
								<select name="pd['.$key.']';
								if ($form_field['other'])
 									$html .= '[]';
								$html .= '" ';
								
 								if ($form_field['id'])
 									$html .= ' id="'.$form_field['id'].'"';
 									
 								$html .=' class="'.$form_field['class'].'">
								  	<option value="">'.$form_field['selected_name'].'</option>
								　{foreach key=id item=val from=$'.$form_field['data'].'}
								  	<option ';
								  	
									if ($form_field['opt_val']=='value')
										$html .= 'value="{$val}" {if $pd.'.$key.' == $val} selected {/if}';
								  	else
										$html .= 'value="{$id}" {if $pd.'.$key.' == $id} selected {/if}';
										
									$html .= 'value="{$id}" {if $selected_'.$key.' == $id} selected {/if}';
										
								  	$html .= ' >{$val}</option>
								  {/foreach}
								</select>';
								  	
 						// 例の表示
						if ($form_field['exemple'])
 							$html .='<br />'.$form_field['exemple'];
 						
 						// 補足説明の表示
 						if ($form_field['description'])
 							$html .='<br />'.$form_field['description'];
 						
 						if ($form_field['other']){
 							$expl = explode('::', $form_field['other']);
 							$size = $expl[0] != "" ? $expl[0] : 60;
 							$maxlength = $expl[1] !="" ? $expl[1] : 50;
 							$html .= '<br />{$pd.'.$key.'.other}<input type="text" name="pd.'.$key.'.other" value="{$pd.'.$key.'.other}" size="'.$size.'" class="wFull" maxlength="'.$maxlength.'" />';
 						}
 						
						$html .= '</td>'."\n".'</tr>';
 					break;

 					case 'radio':
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
 							$list = $data_class->$form_field['data']();
 						}
 						$smarty->assign($form_field['data'],$list);

 						$checked = "";
 						if ($form_field['checked'] && $type != 'conf'){
 							$checked = $form_field['checked'];
 							$smarty->assign('checked_'.$key,$checked);	
 						}


 						$html .= '<tr';
 						if ($form_field['divClass']){
 							$html .= ' class="'.$form_field['divClass'].'" ';
 							if ($form_field['divClass'] == 'other_div_class'){
 								$html .= ' id="'.$key.'" ';
 							}
 							if ($request_from == 'yes_no_ajax'){
 								$html .= ' onClick="getOtherDivId(this.id)" ' ;
 							}
 						}
 						if ($form_field['divId'] && $form_field['divClass'] != 'other_div_class'){
 							if ($form_field['divId'] == 'other_check_id'){
 								$html .= 'id="'.$key.'" ';
 							}else {
 								$html .= 'id="'.$form_field['divId'].'" ';
 							}
 						}
 						$html .= '>'."\n".'<th width="200" scope="row"';
 						if ($form_field['required'] == 1)
 							$html .= ' class="wpfMustBox"';
 						$html .= '>'.$form_field['label'];
  	 						if ($form_field['required'] == 1)
  						$html .= '<span class="red">※</span>';
 						$html .= '</th>'."\n".'<td>'."\n";
								$html .= '<ul class="inlineList">';
								$html .= '{foreach from=$'.$form_field['data'].' key=id item=val }';
								$html .= '<li><label class="radio"><input type="radio"';
								if ($form_field['id'])
 									$html .= ' id="'.$form_field['id'].'"';
 								$html .= ' name="pd['.$key.']';
 								if ($form_field['other'])
 									$html .= '[]';
 									
 								$html .= '" value="{$id}"{if $pd.'.$key.'}';
 									
 								if ($form_field['other']){
 									$html .= '" {if $id==$pd.'.$key.'.0';
 								}else {
 									$html .= '{if $id==$pd.'.$key.'}checked{/if}{else}{if $id==$checked_'.$key;
 								}
 								
 								$html .='} checked {/if}{/if}/>{$val}</label></li>'."\n";
 								$html .= '{/foreach}</ul>';
 								
 						// 例の表示
 						if ($form_field['exemple'])
 							$html .='<br />'.$form_field['exemple'];
 						
 						// 補足説明の表示
 						if ($form_field['description'])
 							$html .='<br />'.$form_field['description'];
 							
 						if ($form_field['other']){
 							$expl = explode('::', $form_field['other']);
 							$size = $expl[0] != "" ? $expl[0] : 60;
 							$maxlength = $expl[1] !="" ? $expl[1] : 50;
 							$html .= '<input type="text" name="pd['.$key.'][other]" value="{$pd.'.$key.'.1}" size="'.$size.'" class="wFull" maxlength="'.$maxlength.'" />';
 						}
						$html .= '</td>'."\n".'</tr>'."\n";
 					break;
 					
 					
 					case 'checkbox':
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
 							$list = $data_class->$form_field['data']();
 						}
 						$smarty->assign($form_field['data'],$list);
 						
 						if ($form_field['checked'] && $type != 'conf'){
 							$check_list = explode('::', $form_field['checked']);
 							$smarty->assign('checked',$check_list);	
 						}

 						$html .= '<tr';
 						if ($form_field['divClass'])
 							$html .= ' class="'.$form_field['divClass'].'" ';
 						if ($form_field['divId'])
 							$html .= ' id="'.$form_field['divId'].'" ';
 						$html .= '>'."\n".'<th width="200" scope="row"';
 						if ($form_field['required'] == 1)
 							$html .= ' class="wpfMustBox"';
 						$html .= '>'.$form_field['label'];
  	 						if ($form_field['required'] == 1)
  						$html .= '<span class="red">※</span>';
 						$html .= '</th>'."\n".'<td>';
								$html .= '{foreach from=$'.$form_field['data'].' key=id item=val }';
								$html .= '<input type="checkbox"';
								if ($form_field['id'])
 									$html .= ' id="'.$form_field['id'].'"';
								$html .=' name="pd['.$key.'][]" value="{$id}" {if $id==$pd.'.$key.'} checked ';
		 						$html .= ' {elseif $checked} {if in_array($id , $checked)} checked {/if} ';
		 						$html .= ' {elseif $pd.'.$key.'} {if in_array($id , $pd.'.$key.')} checked {/if} {/if}'; 
		 						$html .= '  /> {$val}'."\n";
								$html .= '{/foreach}';
							
 						// 例の表示
 						if ($form_field['exemple'])
 							$html .='<br />'.$form_field['exemple'];
 						
 						// 補足説明の表示
 						if ($form_field['description'])
 							$html .='<br />'.$form_field['description'];
 							
 						if ($form_field['other']){
 							$expl = explode('::', $form_field['other']);
 							$size = $expl[0] != "" ? $expl[0] : 60;
 							$maxlength = $expl[1] !="" ? $expl[1] : 50;
 							$html .= '<input type="text" name="pd['.$key.'][other]" value="{$pd.'.$key.'.other}" size="'.$size.'" class="wFull" maxlength="'.$maxlength.'" />';
 						}

						$html .= '</td>'."\n".'</tr>';
 					break;

					case 'options':
 						$html .= '<tr>'."\n".'<th>'.$form_field['label'];
 						if ($form_field['required'] == 1)
 							$html .= '<span class="red">※</span>';
 						$html .= '</th>'."\n";
 						$html .= '<td>'."\n";

 						if ($form_field['divClass'] || $form_field['divId'])
 							$html .= '<div';
 						if ($form_field['divClass'])
 							$html .= ' class="'.$form_field['divClass'].'" ';

 						if (preg_match('/^ynradio/', $form_name)){
 							if ($form_field['divId'])
	 							$html .= ' id="'.$form_field['divId'].'_'.$option_count.'" ';
 						}

 						if ($form_field['divClass'] || $form_field['divId'])
 							$html .= '>'."\n";

 						if (preg_match('/^ynradio/', $form_name)){
		 						$html .= '{foreach from=$pd.'.$key.' key=id item=val}';
			  					$html .= '<div class="option{$id+1}_'.$form_field['for'].'_'.$option_count.'" id="option{$id+1}_'.$form_field['for'].'_'.$option_count.'_id" >';
			 					$html .= '<input type="text" name="pd['.$form_field['for'].'_'.$option_count.'_options][]" value="{$val|htmlspecialchars}" size="60" class="wFull" id="option{$id+1}_id" maxlength="50" />';
			  					$html .= '</div>'."\n";
		 						$html .= '{/foreach}';
		 						$html .= '</div>'."\n";

								$html .='<div id="add_remove_'.$form_field['for'].'_'.$option_count.'">';
								$html .='<input type="button" name="'.$form_field['for'].'_'.$option_count.'" value="　＋　" id=\'addButton_'.$option_count.'\' onClick="optionAdd(\'addButton_'.$option_count.'_{($pd.'.$key.'|count)+1}:\');" />';
								$html .='<input type="button" name="'.$form_field['for'].'_'.$option_count.'" value="　－　" id=\'removeButton_'.$option_count.'\' onclick="optionRemove(\'removeButton_'.$option_count.'_{($pd.'.$key.'|count)}:\')" />';
	 						$html .= '</div>'."\n";
 						}else {
 							$html .= '<div';
	 							if ($form_field['divId'])
	 							$html .= ' id="'.$form_field['divId'].'" ';
 							$html .= '>';
 							$html .= '{foreach from=$pd.'.$key.' key=id item=val}';
		  					$html .= '<div class="option{$id+1}_'.$form_field['for'].'" id="option{$id+1}_'.$form_field['for'].'_id" >';
							$html .= '<input type="text" name="pd[options][]" value="{$val|htmlspecialchars}" size="60" class="wFull" id="option{$id+1}_id" maxlength="50" />';
							$html .= '</div>'."\n";
	 						$html .= '{/foreach}';
	 						$html .= '</div>';
	 						
	 						
							$html .='<input type="button" name="'.$form_field['for'].'" value="　＋　" id=\'addButton\' />';
							$html .='<input type="button" name="'.$form_field['for'].'" value="　－　" id=\'removeButton\'/>';
							
 						}
						
						
						$html .= '<br />';
 						
 						// 例の表示
 						if ($form_field['exemple'])
 							$html .='<br />'.$form_field['exemple'];
 						
 						// 補足説明の表示
 						if ($form_field['description'])
 							$html .='<br />'.$form_field['description'];
 						
 						$html .= "\n".'</td>'."\n".'</tr>'."\n\n";
 					
 					break;
 					
 				case 'ajax_zip':
 						
 						$pref_list = $data_class->prefecture();
 						$smarty->assign('pref_list',$pref_list);
 						
 						$html .= '
 						<tr><th width="200" scope="row">郵便番号 <span class="require">※</span></th>
							<td>
								<input type="text" name="pd[post_code1]" value="{$pd.post_code1}" id="pd[post_code1]" size="3" maxlength="3" class="w100" />-
								<input type="text" name="pd[post_code2]" value="{$pd.post_code2}" id="pd[post_code2]" size="4" maxlength="4" class="w100"
								 onKeyUp="AjaxZip2.zip2addr(\'pd[post_code1]\',\'pd[pref_id]\',\'pd[city_name]\',\'pd[post_code2]\',null,\'pd[area1]\');" />
							</td></tr>
						
							<tr>
							<th width="200" scope="row">都道府県 <span class="require">※</span></th>
							<td>
								<select name="pd[pref_id]" id="pd[pref_id]" class="dropdown">
								  <option value="">選択してください</option>
								  {foreach from=$pref_list key=id item=val }
								  	<option value="{$id}" {if $pd.pref_id == $id } selected {/if}>{$val}</option>
								  {/foreach}
								</select>
							</td>
							</tr>
							
							<tr>
							<th width="200" scope="row">市区町村 <span class="require">※</span></th>
							<td><input type="text" name="pd[city_name]" id="pd[city_name]" value="{$pd.city_name}" size="10" readonly class="wFull"></td>
							</tr>
							
							<tr>
							<th width="200" scope="row">番地 <span class="require">※</span></th>
							<td><input type="text" name="pd[area1]" id="pd[area1]" value="{$pd.area1}" size="50" class="wFull" /></td>
							</tr>

							<tr>
							<th width="200" scope="row">建物名</th>
							<td><input type="text" name="pd[area2]" value="{$pd.area2}" size="50" class="wFull" /></td>
							</tr>';
 						
 						
 					break;
 					
 				case 'privacy':
 						
 						$html .='
 						<div class="confirmBox01">';
 						
 						if ($form_field['pp_detail_ex'])
 							$html .= $form_field['pp_detail_ex'];
 						
 						$html .= '<br /><br />
 						';
 						
 						if ($form_field['url_txt'] && $form_field['url'])
 							$html .= '<p><a href="'.$form_field['url'].'" class="file">'.$form_field['url_txt'].'</a> <span class="red fontS">※</span></p>';
 						
 						if ($form_field['pp_detail'])
 							$html .= '<p>'.$form_field['pp_detail'].'</p>';
 								
 						$html .= '</div>';
 				
 					break;
 					
 				case 'name':
 						
 						$html .= '<tr>';
 						$html .= '<th width="200" scope="row"';
 						if ($form_field['required'] == 1)
 							$html .= ' class="wpfMustBox"';
 						$html .= '>';
 						$html .= '<div>'.$form_field['field_labels1'].'</div></th>
						<td>
							<span class="w2em">'.$form_field['field_labels3'].'</span><span class="radiusBox"><input name="pd[name]" type="text" class="w130 txtTypeMust" id="entry_name_1" value="" onBlur="changeValue(this.id);" /></span>
							<span class="w2em">'.$form_field['field_labels4'].'</span><span class="radiusBox"><input name="pd[name2]" type="text" class="w130 txtTypeMust" id="entry_name_2" value="" onBlur="changeValue(this.id);" /></span>
							<span class="blue">全角</span><br />';
							
 							if ($form_field['exemple'] || $form_field['description']){
	 							$html .= '
								<span class="quote">';
								
		 						// 例の表示
	 							if ($form_field['exemple'])
	 								$html .='<br />'.$form_field['exemple'];
	 						
		 						// 補足説明の表示
	 							if ($form_field['description'])
	 								$html .='<br />'.$form_field['description'];
	 								
								$html .= '</span>';
 							}
 							
							$html .= '
							</td>
							</tr>

							<tr>';
	 						$html .= '<th width="200" scope="row"';
	 						if ($form_field['required'] == 1)
	 							$html .= ' class="wpfMustBox"';
	 						$html .= '>';
	 						$html .= '<div>'.$form_field['field_labels2'].'</div></th>
							<td>
							<span class="w2em">'.$form_field['field_labels5'].'</span><span class="radiusBox"><input name="pd[kana]" type="text" class="w130 txtTypeMust" id="entry_kana_name_1" value="" onBlur="changeValue(this.id);" /></span>
							<span class="w2em">'.$form_field['field_labels6'].'</span><span class="radiusBox"><input name="pd[kana2]" type="text" class="w130 txtTypeMust" id="entry_kana_name_2" value="" onBlur="changeValue(this.id);" /></span>
							<span class="blue">全角カナ</span>
							';
 							
							if ($form_field['exemple1'] || $form_field['description1']){
	 							$html .= '
								<span class="quote">';
								
		 						// 例の表示
	 							if ($form_field['exemple1'])
	 								$html .='<br />'.$form_field['exemple1'];
	 						
		 						// 補足説明の表示
	 							if ($form_field['description1'])
	 								$html .='<br />'.$form_field['description1'];
	 								
								$html .= '</span>';
 							}
 							
							$html .= '
							</td>
						</tr>';
 					break;
 					
 				case 'address':
 					
 						$pref_list = $data_class->prefecture();
 						$smarty->assign('pref_list',$pref_list);
 						
 						$html .= '
 							<tr>
 							<th width="200" scope="row"';
	 						if ($form_field['required'] == 1)
	 							$html .= ' class="wpfMustBox"';
	 						$html .= '>';
 						$html .= $form_field['field_labels1'].'</th>
							<td>
								<input type="text" name="pd[post_code1]" value="{$pd.post_code1}" id="pd[post_code1]" size="3" maxlength="3" class="w100" />-
								<input type="text" name="pd[post_code2]" value="{$pd.post_code2}" id="pd[post_code2]" size="4" maxlength="4" class="w100"
								 onKeyUp="AjaxZip2.zip2addr(\'pd[post_code1]\',\'pd[pref_id]\',\'pd[city_name]\',\'pd[post_code2]\',null,\'pd[area1]\');" />
							</td>
							</tr>
						
							<tr>';
	 						$html .= '<th width="200" scope="row"';
	 						if ($form_field['required'] == 1)
	 							$html .= ' class="wpfMustBox"';
	 						$html .= '>'.$form_field['field_labels2'].'</th>
							<td>
								<select name="pd[pref_id]" id="pd[pref_id]" class="dropdown">
								  <option value="">選択してください</option>
								  {foreach from=$pref_list key=id item=val }
								  	<option value="{$id}" {if $pd.pref_id == $id } selected {/if}>{$val}</option>
								  {/foreach}
								</select>
							</td>
							</tr>
							
							<tr>';
	 						$html .= '<th width="200" scope="row"';
	 						if ($form_field['required'] == 1)
	 							$html .= ' class="wpfMustBox"';
	 						$html .= '>'.$form_field['field_labels3'].'</th>
							<td><input type="text" name="pd[city_name]" id="pd[city_name]" value="{$pd.city_name}" size="60" class="wFull"></td>
							</tr>
							
							<tr>';
	 						$html .= '<th width="200" scope="row"';
	 						if ($form_field['required'] == 1)
	 							$html .= ' class="wpfMustBox"';
	 						$html .= '>'.$form_field['field_labels4'].'</th>
							<td><input type="text" name="pd[area1]" id="pd[area1]" value="{$pd.area1}" size="50" class="wFull" /></td>
							</tr>
						';
 						
 						
 					break;
 					
 				case 'mail':
 						$html .= '<tr>
						<th scope="row"';
	 						if ($form_field['required'] == 1)
	 							$html .= ' class="wpfMustBox"';
	 						$html .= '><div>'.$form_field['field_labels1'].'</div></th>
						<td>
						<div class="mb10"><span class="radiusBox"><input name="pd[mailaddr]" type="text" class="w370 txtTypeMust" id="pd_mailaddr" value="" onBlur="changeValue(this.id);" /></span></div>
						<div class="mb10">確認のため、もう一度ご入力ください。</div>
						<div><span class="radiusBox"><input name="pd[mail_confirm]" type="text" class="w370 txtTypeMust" id="pd_mail_confirm" value="" onBlur="changeValue(this.id);" /></span></div>
						</td>
						</tr>';
 					break;
 					
 				case 'birthday':
 						$year_type = $data_class->yearType();
 						$smarty->assign('year_type',$year_type);
 						
 						$html .= '<tr>
						<th scope="row"';
	 						if ($form_field['required'] == 1)
	 							$html .= ' class="wpfMustBox"';
	 						$html .= '>'.$form_field['label'].'</th>
						<td>
						<div class="clearfix">
						<dl class="wpfInlineListBirth">
						<dt><span class="wpfNbox"><select name="pd[year_type]" id="pd_year_type" class="dropdown">
							<option value="">選択してください</option>
							{foreach from=$year_type key=id item=val }
								<option value="{$id}" {if $pd.year_type == $id } selected {/if}>{$val}</option>
							{/foreach}
						</select></span></dt>
						<dd></dd>
						</dl>
						<dl class="wpfInlineListBirth">
						<dt><span class="wpfRbox"><input name="pd[birth_year]" type="text" size="4" maxlength="4" class="w100" id="pd_birth_year" value="{$pd.birth_year}" onBlur="RemoveErrroClass(this.id);" /></span><span class="wpfWide1em">'.$form_field['field_labels1'].'</span></dt>
						<dd><div class="wpfSpace">例：53</div></dd>
						</dl>
						<dl class="wpfInlineListBirth">
						<dt><span class="wpfRbox"><input name="pd[birth_month]" type="text" size="4" maxlength="2" class="w100" id="pd_birth_month" value="{$pd.birth_month}" onBlur="RemoveErrroClass(this.id);" /></span><span class="wpfWide1em">'.$form_field['field_labels2'].'</span></dt>
						<dd><div class="wpfSpace">例：12</div></dd>
						</dl>
						<dl class="wpfInlineListBirth">
						<dt><span class="wpfRbox"><input name="pd[birth_day]" type="text" size="4" maxlength="2" class="w100" id="pd_birth_day" value="{$pd.birth_day}" onBlur="RemoveErrroClass(this.id);" /></span><span class="wpfWide1em">'.$form_field['field_labels3'].'</span></dt>
						<dd><div class="wpfSpace">例：25</div></dd>
						</dl>
						</div>
						</td>
						</tr>';
 					break;
 					
 				case 'tel':
 						$html .= '<tr>
						<th scope="row"';
	 						if ($form_field['required'] == 1)
	 							$html .= ' class="wpfMustBox"';
	 						$html .= '>'.$form_field['label'].'</th>
						<td>
						<div class="clearfix">
						<dl class="wpfInlineListTel">
						<dt><span class="radiusBox"><input name="pd[tel]" type="text" maxlength="4" class="w100" id="pd_tel" value="" onBlur="changeValue(this.id);" /></span> −</dt>
						<dd>';
 							if (!empty($form_field['exemple']))
								$html .= '例：'.$form_field['exemple'];
						$html .= '</dd>
						</dl>
						<dl class="wpfInlineListTel">
						<dt><span class="radiusBox"><input name="pd[tel2]" type="text" maxlength="4" class="w100" id="pd_tel_2" value="" onBlur="changeValue(this.id);" /></span> −</dt>
						<dd>';
 							if (!empty($form_field['exemple1']))
								$html .= '例：'.$form_field['exemple1'];
						$html .= '</dd>
						</dl>
						<dl class="wpfInlineListTel">
						<dt><span class="radiusBox"><input name="pd[tel3]" type="text" maxlength="4" class="w100" id="pd_tel_3" value="" onBlur="changeValue(this.id);" /></span></dt>
						<dd>';
 							if (!empty($form_field['exemple2']))
								$html .= '例：'.$form_field['exemple2'];
						$html .= '</dd>
						</dl>
						</div>
						</td>
						</tr>';
 					break;
 					

 				case 'ynSelect':
 						$list = $data_class->$form_field['data']();
 						$smarty->assign($form_field['data'],$list);
 						
 						$html .= '</table>'."\n".'<div id="add_yn_field_html"></div>'."\n".'<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblAdm"><tr>'."\n".
 						'<th width="200" scope="row">'.$form_field['label'].'</th>'."\n".
 						'<td>'."\n".
						'<select name="pd['.$key.']" id="ynSelect" class="dropdown">'."\n".
							'<option value="">選択してください</option>'."\n".
							'{foreach from=$'.$form_field['data'].' key=id item=val }
								<option value="{$id|make_id}" {if $pd.'.$key.' == $id } selected {/if}>{$val}</option>
							{/foreach}'."\n".
						'</select>'."\n".
						'<input type="button" name="yn_field_add" id="add_yn_field" value="追加">'."\n".
						'</td>'."\n".
						'</tr>'."\n";
 					break;

 				case 'file':
 						
 						$html .= '<tr><th width="200" scope="row" >'.$form_field['label'];
 						
 						if ($form_field['required'] == 1)
 							$html .= '<span class="red">※</span>';
 							
 						$html .= '</th>'."\n".'<td>';
						$html .= '<input type="file" name="'.$key.'" ';
						
						if ($form_field['id'])
 							$html .= ' id="'.$form_field['id'].'"';
						
						$html .=' />
							{if $pd.'.$key.'}
				 				<img src="'.$GLOBALS['gl_wpcms_Info']['wpcms_path'].'/wpform/file/imageDisplay/module/{$module}/image_name/{$pd.'.$key.'}" >
				 				<input type="hidden" name="pd['.$key.']" value="{$pd.'.$key.'}">
				 				<input type="button" name="image_delete" value="Delete" onClick="window.location = \'{$self}/imageDelete/{$module}_id/{$pd.id|make_id}/image_name/{$pd.'.$key.'}\'">
				 			{/if}
						</td>';
						$html .= "\n".'</tr>';
					
 					break;
 			
 			}
 		}
 		
 		$cache_dir = HOME_DIR."/cache";
 		
 		$file = $cache_dir."/".$form_name.".tpl";
 		
 		$fp = fopen($file, 'w');
 		fwrite($fp, $html);
 		fclose($fp);
 		
 		
 		global $smarty;
 		
 		$fetch_html = $smarty->fetch($file);

 		return $fetch_html;
 		
 			
 	} // form
 	
 	
 	
 	
 	
 	/**
 	 * build confirm html from form data
 	 * @param $form_array
 	 * @param $conf_name
 	 * @return $conf_html
 	 */
 	public function conf($form_array, $conf_name){
 		
 		
 		if (empty($form_array))
 			$this->setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg:  from array is empty ");
 		
 		
 		$data_class = new DataClass();
 			
 		$html = "";
 			
 		foreach ($form_array as $key=>$val){
 			
 			$form_field = $form_array[$key];
 			
 			switch ($form_field['type']){
 				
 				case 'text':
						
 						$html .= '<tr';
 					
 						if ($form_field['divClass'])
 							$html .= ' class="'.$form_field['divClass'].'" ';
 							
 						if ($form_field['divId'])
 							$html .= ' id="'.$form_field['divId'].'" ';
 						
 						$html .= '>';		
 						
 							
 						$html .= '<th scope="row">'.$form_field['label'];
 						
 						if ($form_field['required'] == 1)
 							$html .= '<span class="require">※</span>';
 						
 						$html .= '</th>
						<td>{$pd.'.$key.'|htmlspecialchars}';
 						
 						// 例の表示
 						if ($form_field['exemple'])
 							$html .='<br />'.$form_field['exemple'];
 						
 						// 補足説明の表示
 						if ($form_field['description'])
 							$html .='<br />'.$form_field['description'];
 						
						$html .= '</td>
							</tr>
						';
 							
 					break;

 				case 'textarea':

 						$html .= '<tr';
 					
 						if ($form_field['divClass'])
 							$html .= ' class="'.$form_field['divClass'].'" ';
 							
 						if ($form_field['divId'])
 							$html .= ' id="'.$form_field['divId'].'" ';
 						
 						$html .= '>';
 						
 						
 						$html .= '
 						<th width="200" scope="row">'.$form_field['label'];
 						
 						if ($form_field['required'] == 1)
 							$html .= '<span class="require">※</span>';
 							
 						$html .= '</th>
						<td>{$pd.'.$key.'|nl2br}';
 						
 						// 例の表示
 						if ($form_field['exemple'])
 							$html .='<br />'.$form_field['exemple'];
 						
 						// 補足説明の表示
 						if ($form_field['description'])
 							$html .='<br />'.$form_field['description'];
 						
						$html .= '</td>
							</tr>
						';
							
 					break;
 				
 				case 'select':

 						global $smarty;
 						
 						$list = $data_class->$form_field['data']();
 						$smarty->assign($form_field['data'],$list);

 						$html .= '<tr';
 					
 						if ($form_field['divClass'])
 							$html .= ' class="'.$form_field['divClass'].'" ';
 							
 						if ($form_field['divId'])
 							$html .= ' id="'.$form_field['divId'].'" ';
 						
 						$html .= '>';	
 						
 												
 						$html .= '
 						<th width="200" scope="row">'.$form_field['label'];
 						
 						if ($form_field['required'] == 1)
 							$html .= '<span class="require">※</span>';
 						
 						$html .= '</th>
							<td ';
 						
							if ($form_field['id'])
 									$html .= ' id="'.$form_field['id'].'"';
								
								$html .=' >{foreach key=id item=val from=$'.$form_field['data']."}";if ($form_field['opt_val'] == 'value')$html .= '{if $pd.'.$key.' == $val}{$val}{/if}';elseif ($form_field['opt_val'] == 'id' || $form_field['opt_val'] == '')$html .= '{if $pd.'.$key.' == $id}{$val}{/if} ';$html .= '{/foreach}';
								
	 						// 例の表示
							if ($form_field['exemple'])
	 							$html .='<br />'.$form_field['exemple'];
	 						
	 						// 補足説明の表示
	 						if ($form_field['description'])
	 							$html .='<br />'.$form_field['description'];
	 						
						$html .= '</td>
							</tr>
							';	
 					 
 					break;
 				
 				case 'radio':

 						global $smarty;
 						
 						$list = $data_class->$form_field['data']();
 						$smarty->assign($form_field['data'],$list);

 						$html .= '<tr';
 					
 						if ($form_field['divClass'])
 							$html .= ' class="'.$form_field['divClass'].'" ';
 							
 						if ($form_field['divId'])
 							$html .= ' id="'.$form_field['divId'].'" ';
 						
 						$html .= '>';	
 						
 						$html .= '
 						<th width="200" scope="row">'.$form_field['label'];
 						
 						if ($form_field['required'] == 1)
 							$html .= '<span class="require">※</span>';
 						
 						$html .= '</th>
							<td>
								{foreach from=$'.$form_field['data'].' key=id item=val }
									{if $id == $pd.'.$key.'} {$val} {/if}
								{/foreach}';
 						
 						// 例の表示
 						if ($form_field['exemple'])
 							$html .='<br />'.$form_field['exemple'];
 						
 						// 補足説明の表示
 						if ($form_field['description'])
 							$html .='<br />'.$form_field['description'];
 						
						$html .= '</td>
							</tr>
							';
 							
 					break;
 					
 					case 'checkbox':

 						global $smarty;
 						
 						$list = $data_class->$form_field['data']();
 						$smarty->assign($form_field['data'],$list);	
 						
 						$html .= '<tr';
 					
 						if ($form_field['divClass'])
 							$html .= ' class="'.$form_field['divClass'].'" ';
 							
 						if ($form_field['divId'])
 							$html .= ' id="'.$form_field['divId'].'" ';
 						
 						$html .= '>';	
 						
 						$html .= '
 						<th width="200" scope="row">'.$form_field['label'];
 						
 						if ($form_field['required'] == 1)
 							$html .= '<span class="require">※</span>';
 						
 						$html .= '</th>
							<td>
								{foreach from=$'.$form_field['data'].' key=id item=val }
									{if $id == $pd.'.$key.'} {$val} {/if} <br />
								{/foreach}';
 						
 						// 例の表示
 						if ($form_field['exemple'])
 							$html .='<br />'.$form_field['exemple'];
 						
 						// 補足説明の表示
 						if ($form_field['description'])
 							$html .='<br />'.$form_field['description'];
 						
						$html .= '</td>
							</tr>
						';
 							
 							
 					break;

 				case 'ajax_zip':
 						
 						global $smarty;
 						$pref_list = $data_class->prefecture();
 						$smarty->assign('pref_list',$pref_list);
 						
 						$html .= '<tr>
 						<th width="200" scope="row">郵便番号 <span class="require">※</span></th>
						<td>{$pd.post_code1|htmlspecialchars}-{$pd.post_code2|htmlspecialchars}</td>
						</tr>

						<tr>
						<th width="200" scope="row">都道府県 <span class="require">※</span></th>
						<td>
						  {foreach from=$pref_list key=id item=val }
						  	{if $pd.pref_id == $id } {$val} {/if}
						  {/foreach}
						</select>
						</td>
						</tr>
							
							<tr>
							<th width="200" scope="row">市区町村 <span class="require">※</span></th>
							<td>{$pd.city_name|htmlspecialchars}</td>
							</tr>
							
							<tr>
							<th width="200" scope="row">番地 <span class="require">※</span></th>
							<td>{$pd.area1|htmlspecialchars}</td>
							</tr>

							<tr>
							<th width="200" scope="row">建物名</th>
							<td>{$pd.area2|htmlspecialchars}</td>
							</tr>';
 						
 					break;
 					
 				case 'file':
 						
 						$html .= '<tr><th width="200" scope="row">'.$form_field['label'];
 						
 						if ($form_field['required'] == 1)
 							$html .= '<span class="red">※</span>';
 							
 						$html .= '</th>';
						$html .= '<td>{if $pd.'.$key.'}<img src="'.$GLOBALS['gl_wpcms_Info']['wpcms_path'].'/wpform/file/imageDisplay/module/{$module}/image_name/{$pd.'.$key.'}" >{/if}</td></tr> 
						';
						
					break;
 			}
 	
 		}
 		
 		$cache_dir = HOME_DIR."/cache";
 		
 		$file = $cache_dir."/".$conf_name.".tpl";
 		
 		$fp = fopen($file, 'w');
 		fwrite($fp, $html);
 		fclose($fp);
 		
 		
 		global $smarty;
 		
 		$fetch_html = $smarty->fetch($file);

 		return $fetch_html;
 	
 	} // conf
 	
 	
 	
 	
 	/**
 	 * error check of enty from
 	 * @param $form_array
 	 * @param $post
 	 * @return error msg list
 	 */
 	public function errorCheck($form_array, $post){
 		/*
 		print_r($form_array);
 		print "<br><br>";
 		print_r($post);*/
 		
 		
 		$err_msg = array(
 			'text' 		=> "を入力してください。",
 			'textarea'	=> "を入力してください。",
 			'options'	=> "を入力してください。",
 			'select'	=> "を選択してください。",
 			'checkbox'	=> "を選択してください。",
 			'radio'		=> "を選択してください。",
 			'numeric'	=> "は半角数字で入力してください。",
 			'kana'		=> "フリガナは全角カタカナで入力してください。",
 			'url'		=> "URLは正しい出羽ありません。",
 			'email'		=> "E-mailは正しい出羽ありません。"
 		);
 		
 		$msg = array();
 		
 		foreach ($form_array as $key => $val){
 			
 			if ($val['required'] == 1){
 				//print $key."<br>";
 				//print_r($val);print "<br>";
 				
	 			if ( empty($post[$key])){
 					
 					$msg[$key] = $val['label'].$err_msg[$val['type']];
 				}
 				
 				
 				if (is_array($post[$key])){
 					
 					foreach ($post[$key] as $row){
 						
 						if (empty($row)){
 							$error = true;
 						}else{ 	
 							$error = false;
 							break;
 						}
 						
 					} // foreach ($post[$key] as $row){
 					
 					if ($error === true){
 						$msg[$key] = $val['label'].$err_msg[$val['type']];
 					}
 					
 				} // if (is_array($post[$key])){
 			
 			} // if ($val['required'] == 1){
 			
 				
 			if ($post[$key] && $val['check']){
 					
 				$check_function = $val['check'].Chk;
 				$check_msg = $this->$check_function($key,$post[$key]);
 				
 				if (!empty($check_msg))
					$msg = array_merge($msg, $check_msg);
 				
 				
 			} // if ($post[$key] && $val['check']){
 			
 		} // foreach ($form_array as $key => $val){
 		
 		//print_r($msg);exit;
 		
 		return $msg;
 		
 	} // errorCheck
 	
 	
 	
 	/**
 	 * 
 	 * set error to error template
 	 * @param $msg
 	 */
 	private function setErrMsg($msg){
 		
 		$err_class = new ErrorClass();
 		
 		if ($msg){
 			
 			$err_class->setErr($msg,true);
 			return false;
 		}
 		
 	} // setErrMsg
 	
 	
 	
 	/**
 	 * katakana check
 	 * @param $key
 	 * @param $val
 	 * @return message
 	 */
 	
 	public function kanaChk($key, $val){
 		
 		if (!mb_ereg("^[ア-ンｱ-ﾝ]+$", $val))
			$msg[$key] = $key.'をフリガナ入力してください。';
 		
		if ($msg)
			return $msg;
 		
 	} // kanaChk
 	
 	
 	/**
	 * email address check
	 * @param $key
	 * @param $email 
	 * @return message
	*/
	function emailChk($key, $email) {
    	// First, we check that there's one @ symbol, and that the lengths are right
    	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
        	// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        	$msg[$key] = $key.'をフリガナ入力してください。';
    	}
    
    	// Split it into sections to make life easier
    	$email_array = explode("@", $email);
    	$local_array = explode(".", $email_array[0]);
    	for ($i = 0; $i < sizeof($local_array); $i++) {
        	 if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
            	$msg[$key] = $key.'をフリガナ入力してください。';
        	}
    	}    
    
    	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
        	$domain_array = explode(".", $email_array[1]);
        	if (sizeof($domain_array) < 2) {
                $msg[$key] = $key.'をフリガナ入力してください。';
        	}
        	
        	for ($i = 0; $i < sizeof($domain_array); $i++) {
            	if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
                	$msg[$key] = $key.'をフリガナ入力してください。';
                	return $msg;
            	}
        	}
    	}
    	
    	
 	} // emailChk
 	
 	
 	
 
 
 } // FormClass
  
 
 ?>