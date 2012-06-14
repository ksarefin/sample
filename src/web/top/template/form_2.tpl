
 			<!-- section -->

			<div class="section">
			
			<h3>{$page_title}</h3> 
			
			<!-- お問い合わせフォームエリア -->
			<div class="contactMain">
			
			{if $err}
			<ul class="wpfErrorList">
			<li>未記入の項目、または入力に誤りがあります。<span class="icoError">マーク</span>の表示されている項目をご確認ください。</li>
			</ul>
			{/if}
			
 		
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle">
				<div class="wpfConfirmBox">
					<p class="fontS"><p><p>全部入りのサンプル</p></p></p>
			</div>
			</table><form id="wpfForm" name="wpfForm" method="post" action="{$self}/conf/form_id/{$form_id|make_id}" enctype="multipart/form-data"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle"><tr>
			<th scope="row" class="wpfMustBox"><div {if $err.text_1}class="wpfErrorBox" id="text_1_err"{/if}>１行テキストサンプル</div></th>
			<td>
			{if $err.text_1}<p class="wpfErrorMsg" id="text_1_err_msg">{$err.text_1}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><span class="wpfRbox"><input type="text" name="pd[text_1]" value="{if $pd.text_1}{$pd.text_1}{elseif $initial_val_text_1}{$initial_val_text_1}{/if}" size="30" maxlength="50" class="RemoveErrroMsg  wpfWideL  wpfInputMust " id="text_1" /> </span></dt></dl></div></td>
			</tr><tr>
			<th scope="row" ><div {if $err.textarea_1}class="wpfErrorBox" id="textarea_1_err"{/if}>テキストエリアサンプル</div></th>
			<td>
			{if $err.textarea_1}<p class="wpfErrorMsg" id="textarea_1_err_msg">{$err.textarea_1}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><div class="wpfRbox">
			<textarea name="pd[textarea_1]" id="textarea_1"class="RemoveErrroMsg  wpfTxtarea " rows="3" cols="30" />{$pd.textarea_1}</textarea>
			</div></dt><dd><div class="wpfSpace">aa</div></dd>
			</dl>
			</div></td>
			</tr><tr>
			<th scope="row" ><div {if $err.select_2}class="wpfErrorBox" id="select_2_err"{/if}>プルダウンメニューサンプル</div></th>
			<td>
			{if $err.select_2}<p class="wpfErrorMsg" id="select_2_err_msg">{$err.select_2}</p>{/if}
			<select name="pd[select_2]" id="select_2" class=" RemoveErrroMsg ">
			<option value="">選択してください</option>
			{foreach key=id item=val from=$select_2_options}
			<option value="{$id}"  {if $pd.select_2} {if $pd.select_2 == $val || $pd.select_2 == $id} selected {/if} {elseif $selected_select_2} {if $selected_select_2 == $id} selected {/if}{/if}>{$val}</option>
			{/foreach}
			</select></td>
			</tr><tr>
			<th scope="row" ><div {if $err.radio_2}class="wpfErrorBox" id="radio_2_err"{/if}>ラジオボタンサンプル</div></th>
			<td>
			{if $err.radio_2}<p class="wpfErrorMsg" id="radio_2_err_msg">{$err.radio_2}</p>{/if}
			<ul class="wpfInlineList">
			{foreach from=$radio_2_options key=id item=val }
			<li><label class="wpfCheckImg"><input type="radio" class="RemoveErrroMsg" id="radio_2"  name="pd[radio_2][]" value="{$id}" {if $pd.radio_2}{if $id==$pd.radio_2.0}checked{/if}{elseif $id==$checked_radio_2}checked{/if} />{$val}</label></li>
			{/foreach}
			</ul><div class="otherBox">その他 <input type="text" name="pd[radio_2][other]" id="radio_2_other" value="{$pd.radio_2.1}" size="20" class="text wpfWideM" maxlength="50"  /></div></td>
			</tr><tr>
			<th scope="row" ><div {if $err.checkbox_1}class="wpfErrorBox" id="checkbox_1_err"{/if}>チェックボックスサンプル</div></th>
			<td>
			{if $err.checkbox_1}<p class="wpfErrorMsg" id="checkbox_1_err_msg">{$err.checkbox_1}</p>{/if}
			<ul id="checkbox_1_ul" class="wpfInlineList">
			{foreach from=$checkbox_1_options key=id item=val }
			<li><label class="wpfCheckImg"><input type="checkbox" class="RemoveErrroMsg"  id ="checkbox_1"  name="pd[checkbox_1][]" value="{$id}" 
 			{if $pd.checkbox_1}
 				{if is_array($pd.checkbox_1)}
 					{if in_array($id , $pd.checkbox_1)}checked{/if}
 				{elseif $id==$pd.checkbox_1}checked
 				{/if}
 			{elseif $checked_list_checkbox_1}
 				{if in_array($id , $checked_list_checkbox_1)}checked{/if}
 			{/if}/>{$val}</label></li>
 			{/foreach}{*$pd.checkbox_1|print_r*}
			</ul></td>
			</tr><tr>
			<th scope="row" ><div {if $err.image_3}class="wpfErrorBox" id="image_3_err"{/if}>イメージアップローダー</div></th>
			<td>
			{if $err.image_3}<p class="wpfErrorMsg" id="image_3_err_msg">{$err.image_3}</p>{/if}<div class="wpfDescription">jpg,gif,png 形式のファイルを選択してください。</div><ul id="image_3" class="wpfInlineList">
 			<li><label class="wpfCheckImg"><input name="image_3" type="file"/></label></li>
 			{if $pd.image_3}
 				<li><img src="/wpform/file/imageDisplay/image_name/{$pd.image_3}" ></li>
 				<input type="hidden" name="pd[image_3]" value="{$pd.image_3}">
 			{/if} 
 			</ul><ul class="wpfNotes"><li>補足説明</li></ul></td>
			</tr><tr>
			<th scope="row" ><div {if $err.pdf_3}class="wpfErrorBox" id="pdf_3_err"{/if}>PDFアップローダー</div></th>
			<td>
			{if $err.pdf_3}<p class="wpfErrorMsg" id="pdf_3_err_msg">{$err.pdf_3}</p>{/if}
			<div class="wpfDescription">PDFファイルを選択してください。</div>
			<ul id="pdf_3" class="wpfInlineList">
 			<li><label class="wpfCheckImg"><input name="pdf_3" type="file"/></label></li> 
 			{if $pd.pdf_3}
	 			<li><span class="confPdf"><a href="/wpform/file/pdfDisplay/pdf_name/{$pd.pdf_3}" >{$pd.pdf_3}</a></span></li>
	 			<input type="hidden" name="pd[pdf_3]" value="{$pd.pdf_3}">
 			{/if}
 			</ul><ul class="wpfNotes"><li>補足説明</li></ul></td>
			</tr>
 		<tr id="name_3_tr" class="nameTr">
			<th scope="row" ><div {if $err.name_3}class="wpfErrorBox" id="name_3_err"{/if}>ご担当者名</div></th>
 			<td>
 			{if $err.name_3}<p class="wpfErrorMsg" id="name_3_err_msg">{$err.name_3}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListName">
			<dt><span class="wpfWide2em">姓</span><span class="wpfRbox"><input name="pd[name_3_1]" type="text" class="wpfWideM  RemoveErrroMsg" id="name_3_1" value="{$pd.name_3_1}" /></span></dt><dd><div class="wpfSpace">入力例（姓）</div></dd>
			</dl>
			<dl class="wpfInlineListName">
			<dt><span class="wpfWide2em">名</span><span class="wpfRbox"><input name="pd[name_3_2]" type="text" class="wpfWideM  RemoveErrroMsg" id="name_3_2" value="{$pd.name_3_2}"/></span></dt><dd><div class="wpfSpace">入力例（名）</div></dd>
			</dl>
			<div class="wpfFormat">全角</div>
			</div><ul class="wpfNotes"><li>補足説明（担当者名）</li></ul></td>
			</tr>
			<tr class="kanaTr">
			<th scope="row" ><div {if $err.name_3_kana}class="wpfErrorBox" id="name_3_kana_err"{/if}>フリガナ</div></th>
 			<td>
 			{if $err.name_3_kana}<p class="wpfErrorMsg" id="name_3_kana_err_msg">{$err.name_3_kana}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListName">
			<dt><span class="wpfWide2em">セイ</span><span class="wpfRbox"><input name="pd[name_3_kana_1]" type="text" class="wpfWideM  RemoveErrroMsg" id="name_3_kana_1" value="{$pd.name_3_kana_1}"/></span></dt><dd><div class="wpfSpace">入力例（セイ）</div></dd>
			</dl>
			<dl class="wpfInlineListName">
			<dt><span class="wpfWide2em">メイ</span><span class="wpfRbox"><input name="pd[name_3_kana_2]" type="text" class="wpfWideM  RemoveErrroMsg" id="name_3_kana_2" value="{$pd.name_3_kana_2}"/></span></dt><dd><div class="wpfSpace">入力例（メイ）</div></dd>
			</dl>
			<div class="wpfFormat">全角カナ</div>
			</div>
			<ul class="wpfNotes"><li>補足説明（フリガナ）</li></ul></td>
			</tr><tr class="addressTr">
			<th scope="row" ><div {if $err.address_2_pcode}class="wpfErrorBox" id="address_2_pcode_err"{/if}>郵便番号</div></th>
 			<td>
 			{if $err.address_2_pcode}<p class="wpfErrorMsg" id="address_2_pcode_err_msg">{$err.address_2_pcode}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd[address_2_pcode_1]" type="text" maxlength="3" class="wpfWideS RemoveErrroMsg " id="address_2_pcode_1" value="{$pd.address_2_pcode_1}"/></span>−</dt><dd><div class="wpfSpace">101</div></dd>
			</dl>
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd[address_2_pcode_2]" type="text" maxlength="4" class="wpfWideS RemoveErrroMsg " id="address_2_pcode_2" value="{$pd.address_2_pcode_2}" 
			 onKeyUp="AjaxZip2.zip2addr('pd[address_2_pcode_1]','pd[address_2_pref]','pd[address_2_address_a]','pd[address_2_pcode_2]',null,null);"
			/></span></dt><dd><div class="wpfSpace">0001</div></dd>
			</dl>
			</div><ul class="wpfNotes"><li>補足説明（郵便番号）</li></ul></td>
			</tr>
			<tr>
			<th scope="row" ><div {if $err.address_2_pref}class="wpfErrorBox" id="address_2_pref_err"{/if}>都道府県</div></th>
 			<td>
			{if $err.address_2_pref}<p class="wpfErrorMsg" id="address_2_pref_err_msg">{$err.address_2_pref}</p>{/if}
 			<select name="pd[address_2_pref]" id="address_2_pref" class="RemoveErrroMsg">
			<option value="">選択してください</option>
			{foreach from=$pref_list key=id item=val }
			<option value="{$id}" {if $pd.address_2_pref == $id } selected {/if}>{$val}</option>
			{/foreach}
			</select>
			</td>
			</tr>
			<tr>
			<th scope="row" ><div {if $err.address_2_address_a}class="wpfErrorBox" id="address_2_address_err"{/if}>住所</div></th>
 			<td>
 			{if $err.address_2_address_a}<p class="wpfErrorMsg" id="address_2_address_err_msg">{$err.address_2_address_a}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><span class="wpfRbox"><input name="pd[address_2_address_a]" type="text" class="wpfWideL RemoveErrroMsg " id="address_2_address_a" value="{$pd.address_2_address_a}" /></span></dt><dd><div class="wpfSpace">入力例（住所）</div></dd>
			</dl>
			</div><ul class="wpfNotes"><li>補足説明（住所）</li></ul></td>
			</tr>
			<tr>
			<th scope="row">ビル・建物名</th>
			<td>
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><span class="wpfRbox"><input name="pd[address_2_address_b]" type="text" class="wpfWideL" id="address_2_address_b" value="{$pd.address_2_address_b}" /></span></dt><dd><div class="wpfSpace">入力例（ビル・建物名）</div></dd></dl>
			</div>
			<ul class="wpfNotes"><li>補足説明（ビル・建物名）</li></ul></td>
			</tr><tr>
			<th scope="row" ><div {if $err.mail_4}class="wpfErrorBox" id="mail_4_err"{/if}>メールアドレス</div></th>
 			<td>
 			{if $err.mail_4}<p class="wpfErrorMsg" id="mail_4_err_msg">{$err.mail_4}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><div class="mb10"><span class="wpfRbox"><input name="pd[mail_4_mail]" type="text" class="wpfWideL RemoveErrroMsg " id="mail_4_mail" value="{$pd.mail_4_mail}"/></span></div>
			<div class="mb10">確認のため、もう一度ご入力ください。</div>
			<div><span class="wpfRbox"><input name="pd[mail_4_mail_conf]" type="text" class="wpfWideL RemoveErrroMsg " id="mail_4_mail_conf" value="{$pd.mail_4_mail_conf}"/></span></div>
			</dt><dd><div class="wpfSpace">info@kiwami.com</div></dd>
			</dl>
			</div><ul class="wpfNotes"><li>補足説明</li></ul></td>
			</tr><tr class="birthdayTr">
			<th scope="row" ><div {if $err.birthday_2}class="wpfErrorBox" id="birthday_2_err"{/if}>生年月日</div></th>
 			<td>
 			{if $err.birthday_2}<p class="wpfErrorMsg" id="birthday_2_err_msg">{$err.birthday_2}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListS">
			<dt><span class="wpfNbox">
			<select name="pd[birthday_2_year_type]" id="birthday_2_year_type" class="dropdown">
			{foreach from=$year_type key=id item=val }
			<option value="{$id}" {if $pd.birthday_2_year_type == $id } selected {/if}{if empty($pd.birthday_2_year_type) && $id==3}selected{/if}>{$val}</option>
			{/foreach}
			</select>
			</span></dt>
			<dd></dd>
			</dl>
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd[birthday_2_year]" type="text" maxlength="4" class="wpfWideS RemoveErrroMsg " id="birthday_2_year" value="{$pd.birthday_2_year}"/></span><span class="wpfWide1em">年</span></dt><dd><div class="wpfSpace">入力例（年）</div></dd>
			</dl>
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd[birthday_2_month]" type="text" maxlength="4" class="wpfWideS RemoveErrroMsg " id="birthday_2_month" value="{$pd.birthday_2_month}"/></span><span class="wpfWide1em">月</span></dt><dd><div class="wpfSpace">入力例（月）</div></dd></dl>
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd[birthday_2_day]" type="text" maxlength="4" class="wpfWideS RemoveErrroMsg " id="birthday_2_day" value="{$pd.birthday_2_day}"/></span><span class="wpfWide1em">日</span></dt><dd><div class="wpfSpace">入力例（日）</div></dd>
			</dl>
			</div><ul class="wpfNotes"><li>補足説明</li></ul></td>
			</tr><tr class="telTr">
			<th scope="row" ><div {if $err.tel_2}class="wpfErrorBox" id="tel_2_err"{/if}>電話番号</div></th>
 			<td>
 			{if $err.tel_2}<p class="wpfErrorMsg" id="tel_2_err_msg">{$err.tel_2}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd[tel_2_1]" type="text" maxlength="2" class="wpfWideS RemoveErrroMsg " id="tel_2_1" value="{$pd.tel_2_1}"/></span>−</dt><dd><div class="wpfSpace">03</div></dd>
			</dl>
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd[tel_2_2]" type="text" maxlength="4" class="wpfWideS RemoveErrroMsg " id="tel_2_2" value="{$pd.tel_2_2}"/></span>−</dt><dd><div class="wpfSpace">1234</div></dd>
			</dl>
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd[tel_2_3]" type="text" maxlength="4" class="wpfWideS RemoveErrroMsg " id="tel_2_3" value="{$pd.tel_2_3}"/></span></dt><dd><div class="wpfSpace">5678</div></dd>
			</dl>
			</div><ul class="wpfNotes"><li>補足説明</li></ul></td>
			</tr><tr>
			<th scope="row"  class="wpfMustBox"><div {if $err.ynradio_1}class="wpfErrorBox" id="ynradio_1_err"{/if}>Yes／Noラジオボタン</div></th>
			<td>
			{if $err.ynradio_1}<p class="wpfErrorMsg" id="ynradio_1_err_msg">{$err.ynradio_1}</p>{/if}
			<div class="clearfix">
			<ul id="ynradio_1_ul" class="wpfInlineList yesNoUl">
			<li><label class="checkImg"><input name="pd[ynradio_1]" type="radio" class="RemoveErrroMsg" id="ynradio_1" value="1" {if $pd.ynradio_1 == 1}checked{/if}/> YESオプション名</label></li>
			<li><label class="checkImg"><input name="pd[ynradio_1]" type="radio" class="RemoveErrroMsg" id="ynradio_1" value="2" {if $pd.ynradio_1 == 2}checked{/if}/> NOオプション名</label></li>
			</ul>
			</div></td>
			</tr><tr class="ynradio_1_display dspNone">
			<th scope="row" class="wpfMustBox"><div {if $err.ynradio_1_text_2}class="wpfErrorBox" id="ynradio_1_text_2_err"{/if}>テキストフィールド</div></th>
			<td>
			{if $err.ynradio_1_text_2}<p class="wpfErrorMsg" id="ynradio_1_text_2_err_msg">{$err.ynradio_1_text_2}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><span class="wpfRbox"><input type="text" name="pd[ynradio_1_text_2]" value="{if $pd.ynradio_1_text_2}{$pd.ynradio_1_text_2}{elseif $initial_val_ynradio_1_text_2}{$initial_val_ynradio_1_text_2}{/if}" size="30" maxlength="50" class="RemoveErrroMsg  wpfWideL  wpfInputMust " id="ynradio_1_text_2" /> </span></dt></dl></div></td>
			</tr><tr class="ynradio_1_display dspNone">
			<th scope="row"  class="wpfMustBox"><div {if $err.ynradio_1_textarea_3}class="wpfErrorBox" id="ynradio_1_textarea_3_err"{/if}>テキストエリア</div></th>
			<td>
			{if $err.ynradio_1_textarea_3}<p class="wpfErrorMsg" id="ynradio_1_textarea_3_err_msg">{$err.ynradio_1_textarea_3}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><div class="wpfRbox">
			<textarea name="pd[ynradio_1_textarea_3]" id="ynradio_1_textarea_3"class="RemoveErrroMsg  wpfTxtarea " rows="3" cols="30" />{$pd.ynradio_1_textarea_3}</textarea>
			</div></dt>
			</dl>
			</div></td>
			</tr><tr class="ynradio_1_display dspNone">
			<th scope="row"  class="wpfMustBox"><div {if $err.ynradio_1_select_4}class="wpfErrorBox" id="ynradio_1_select_4_err"{/if}>プルダウン</div></th>
			<td>
			{if $err.ynradio_1_select_4}<p class="wpfErrorMsg" id="ynradio_1_select_4_err_msg">{$err.ynradio_1_select_4}</p>{/if}
			<select name="pd[ynradio_1_select_4]" id="ynradio_1_select_4" class=" RemoveErrroMsg ">
			<option value="">選択してください</option>
			{foreach key=id item=val from=$ynradio_1_select_4_options}
			<option value="{$id}"  {if $pd.ynradio_1_select_4} {if $pd.ynradio_1_select_4 == $val || $pd.ynradio_1_select_4 == $id} selected {/if} {elseif $selected_ynradio_1_select_4} {if $selected_ynradio_1_select_4 == $id} selected {/if}{/if}>{$val}</option>
			{/foreach}
			</select></td>
			</tr><tr class="ynradio_1_display dspNone">
			<th scope="row"  class="wpfMustBox"><div {if $err.ynradio_1_radio_5}class="wpfErrorBox" id="ynradio_1_radio_5_err"{/if}>ラジオの項目名称</div></th>
			<td>
			{if $err.ynradio_1_radio_5}<p class="wpfErrorMsg" id="ynradio_1_radio_5_err_msg">{$err.ynradio_1_radio_5}</p>{/if}
			<ul class="wpfInlineList">
			{foreach from=$ynradio_1_radio_5_options key=id item=val }
			<li><label class="wpfCheckImg"><input type="radio" class="RemoveErrroMsg" id="ynradio_1_radio_5"  name="pd[ynradio_1_radio_5][]" value="{$id}" {if $pd.ynradio_1_radio_5}{if $id==$pd.ynradio_1_radio_5.0}checked{/if}{elseif $id==$checked_ynradio_1_radio_5}checked{/if} />{$val}</label></li>
			{/foreach}
			</ul><div class="otherBox">その他 <input type="text" name="pd[ynradio_1_radio_5][other]" id="ynradio_1_radio_5_other" value="{$pd.ynradio_1_radio_5.1}" size="60" class="text wpfWideM" maxlength="50"  /></div></td>
			</tr><tr class="ynradio_1_display dspNone">
			<th scope="row"  class="wpfMustBox"><div {if $err.ynradio_1_checkbox_6}class="wpfErrorBox" id="ynradio_1_checkbox_6_err"{/if}>チェックボックス</div></th>
			<td>
			{if $err.ynradio_1_checkbox_6}<p class="wpfErrorMsg" id="ynradio_1_checkbox_6_err_msg">{$err.ynradio_1_checkbox_6}</p>{/if}
			<ul id="ynradio_1_checkbox_6_ul" class="wpfInlineList">
			{foreach from=$ynradio_1_checkbox_6_options key=id item=val }
			<li><label class="wpfCheckImg"><input type="checkbox" class="RemoveErrroMsg"  id ="ynradio_1_checkbox_6"  name="pd[ynradio_1_checkbox_6][]" value="{$id}" 
 			{if $pd.ynradio_1_checkbox_6}
 				{if is_array($pd.ynradio_1_checkbox_6.0)}
 					{if in_array($id , $pd.ynradio_1_checkbox_6.0)}checked{/if}
 				{elseif $id==$pd.ynradio_1_checkbox_6.0}checked
 				{/if}
 			{elseif $checked_list_ynradio_1_checkbox_6}
 				{if in_array($id , $checked_list_ynradio_1_checkbox_6)}checked{/if}
 			{/if}/>{$val}</label></li>
 			{/foreach}{*$pd.ynradio_1_checkbox_6|print_r*}
			</ul><div class="otherBox">その他 <input type="text" name="pd[ynradio_1_checkbox_6][other]" id="ynradio_1_checkbox_6_other" value="{$pd.ynradio_1_checkbox_6.1}" size="60" class="text wpfWideM" maxlength="50"  /></div></td>
			</tr><tr class="ynradio_1_display dspNone">
			<th scope="row" ><div {if $err.ynradio_1_image_7}class="wpfErrorBox" id="ynradio_1_image_7_err"{/if}>イメージフィールド</div></th>
			<td>
			{if $err.ynradio_1_image_7}<p class="wpfErrorMsg" id="ynradio_1_image_7_err_msg">{$err.ynradio_1_image_7}</p>{/if}<div class="wpfDescription">jpg,jpeg 形式のファイルを選択してください。</div><ul id="ynradio_1_image_7" class="wpfInlineList">
 			<li><label class="wpfCheckImg"><input name="ynradio_1_image_7" type="file"/></label></li>
 			{if $pd.ynradio_1_image_7}
 				<li><img src="/wpform/file/imageDisplay/image_name/{$pd.ynradio_1_image_7}" ></li>
 				<input type="hidden" name="pd[ynradio_1_image_7]" value="{$pd.ynradio_1_image_7}">
 			{/if} 
 			</ul></td>
			</tr><tr class="ynradio_1_display dspNone">
			<th scope="row" ><div {if $err.ynradio_1_pdf_8}class="wpfErrorBox" id="ynradio_1_pdf_8_err"{/if}>PDFフィールド</div></th>
			<td>
			{if $err.ynradio_1_pdf_8}<p class="wpfErrorMsg" id="ynradio_1_pdf_8_err_msg">{$err.ynradio_1_pdf_8}</p>{/if}
			<div class="wpfDescription">PDFファイルを選択してください。</div>
			<ul id="ynradio_1_pdf_8" class="wpfInlineList">
 			<li><label class="wpfCheckImg"><input name="ynradio_1_pdf_8" type="file"/></label></li> 
 			{if $pd.ynradio_1_pdf_8}
	 			<li><span class="confPdf"><a href="/wpform/file/pdfDisplay/pdf_name/{$pd.ynradio_1_pdf_8}" >{$pd.ynradio_1_pdf_8}</a></span></li>
	 			<input type="hidden" name="pd[ynradio_1_pdf_8]" value="{$pd.ynradio_1_pdf_8}">
 			{/if}
 			</ul></td>
			</tr><tr>
			<th scope="row" ><div {if $err.password_1}class="wpfErrorBox" id="password_1_err"{/if}>パスワード</div></th>
			<td>
			{if $err.password_1}<p class="wpfErrorMsg" id="password_1_err_msg">{$err.password_1}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><div class="mb10"><span class="wpfRbox"><input name="pd[password_1_pass]" type="password" class="wpfWideL RemoveErrroMsg " id="password_1_pass" value="{$pd.password_1_pass}"/></span></div>
			<div class="mb10">確認のため、もう一度ご入力ください。</div>
			<div><span class="wpfRbox"><input name="pd[password_1_pass_conf]" type="password" class="wpfWideL RemoveErrroMsg " id="password_1_pass_conf" value="{$pd.password_1_pass_conf}"/></span></div>
			</dt>
			<dd></dd>
			</dl>
			</div>
			</td>
			</tr><tr>
			<th scope="row"  class="wpfMustBox"><div {if $err.ynradio_3}class="wpfErrorBox" id="ynradio_3_err"{/if}>http:://</div></th>
			<td>
			{if $err.ynradio_3}<p class="wpfErrorMsg" id="ynradio_3_err_msg">{$err.ynradio_3}</p>{/if}
			<div class="clearfix">
			<ul id="ynradio_3_ul" class="wpfInlineList yesNoUl">
			<li><label class="checkImg"><input name="pd[ynradio_3]" type="radio" class="RemoveErrroMsg" id="ynradio_3" value="1" {if $pd.ynradio_3 == 1}checked{/if}/> http:://</label></li>
			<li><label class="checkImg"><input name="pd[ynradio_3]" type="radio" class="RemoveErrroMsg" id="ynradio_3" value="2" {if $pd.ynradio_3 == 2}checked{/if}/> http:://</label></li>
			</ul>
			</div><ul class="wpfNotes"><li>http:://</li></ul></td>
			</tr><tr class="ynradio_3_display dspNone">
			<th scope="row" class="wpfMustBox"><div {if $err.ynradio_3_text_2}class="wpfErrorBox" id="ynradio_3_text_2_err"{/if}>http:://</div></th>
			<td>
			{if $err.ynradio_3_text_2}<p class="wpfErrorMsg" id="ynradio_3_text_2_err_msg">{$err.ynradio_3_text_2}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><span class="wpfRbox"><input type="text" name="pd[ynradio_3_text_2]" value="{if $pd.ynradio_3_text_2}{$pd.ynradio_3_text_2}{elseif $initial_val_ynradio_3_text_2}{$initial_val_ynradio_3_text_2}{/if}" size="30" maxlength="50" class="RemoveErrroMsg  wpfWideL  wpfInputMust " id="ynradio_3_text_2" /> </span></dt><dd><div class="wpfSpace">http:://</div></dd></dl></div><ul class="wpfNotes"><li>http:://</li></ul></td>
			</tr>
	 			<script type="text/javascript" src="/wpform/wpcms/common/static/scripts/prototype.js"></script>
	 			<script type="text/javascript" src="/wpform/wpcms/common/static/scripts/autoKana.js"></script>
	 			
	 			{literal}
	 			<script type="text/javascript" > 
		 			
	 				var name_3 = new AutoKana('name_3_1', 'name_3_kana_1', {katakana:true, toggle:false});
	 				var name_3 = new AutoKana('name_3_2', 'name_3_kana_2', {katakana:true, toggle:false});
				</script>
				{/literal}
				
			</table><table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle"><tr>
			<th scope="row" ><div {if $err.svid_2_fid_2_sid_2}class="wpfErrorBox" id="svid_2_fid_2_sid_2_err"{/if}>ラジオボタンのアンケート</div></th>
			<td>
			{if $err.svid_2_fid_2_sid_2}<p class="wpfErrorMsg" id="svid_2_fid_2_sid_2_err_msg">{$err.svid_2_fid_2_sid_2}</p>{/if}
			<ul class="wpfInlineList">
			{foreach from=$svid_2_fid_2_sid_2_options key=id item=val }
			<li><label class="wpfCheckImg"><input type="radio" class="RemoveErrroMsg" id="svid_2_fid_2_sid_2"  name="pd[svid_2_fid_2_sid_2]" value="{$id}" {if $pd.svid_2_fid_2_sid_2}{if $id==$pd.svid_2_fid_2_sid_2}checked{/if}{elseif $id==$checked_svid_2_fid_2_sid_2}checked{/if} />{$val}</label></li>
			{/foreach}
			</ul><ul class="wpfNotes"><li>タイトル長い場合のサンプル。</li></ul></td>
			</tr><tr>
			<th scope="row" ><div {if $err.svid_6_fid_2_sid_2}class="wpfErrorBox" id="svid_6_fid_2_sid_2_err"{/if}>当製品をどこで知りましたか？</div></th>
			<td>
			{if $err.svid_6_fid_2_sid_2}<p class="wpfErrorMsg" id="svid_6_fid_2_sid_2_err_msg">{$err.svid_6_fid_2_sid_2}</p>{/if}
			<ul id="svid_6_fid_2_sid_2_ul" class="wpfInlineList">
			{foreach from=$svid_6_fid_2_sid_2_options key=id item=val }
			<li><label class="wpfCheckImg"><input type="checkbox" class="RemoveErrroMsg"  id ="svid_6_fid_2_sid_2"  name="pd[svid_6_fid_2_sid_2][]" value="{$id}" 
 			{if $pd.svid_6_fid_2_sid_2}
 				{if is_array($pd.svid_6_fid_2_sid_2.0)}
 					{if in_array($id , $pd.svid_6_fid_2_sid_2.0)}checked{/if}
 				{elseif $id==$pd.svid_6_fid_2_sid_2.0}checked
 				{/if}
 			{elseif $checked_list_svid_6_fid_2_sid_2}
 				{if in_array($id , $checked_list_svid_6_fid_2_sid_2)}checked{/if}
 			{/if}/>{$val}</label></li>
 			{/foreach}{*$pd.svid_6_fid_2_sid_2|print_r*}
			</ul><div class="otherBox">その他 <input type="text" name="pd[svid_6_fid_2_sid_2][other]" id="svid_6_fid_2_sid_2_other" value="{$pd.svid_6_fid_2_sid_2.1}" size="10" class="text wpfWideM" maxlength="10"  /></div><ul class="wpfNotes"><li>（複数選択可能）</li></ul></td>
			</tr></table><table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle"><div class="wpfConfirmBox"><p class="fontS"><p>ポリシー本文</p></p><p class="fontS"><p>説明分</p></p>
			</div>
			</table>
			 	<div class="wpfAgree">
			<p>
			<input type="submit" name="wpfAgreeBtn" id="wpfAgreeBtn" value="入力内容を確認する" />
			<noscript><input type="submit" name="wpfAgreeBtn" id="wpfAgreeBtnNoscrpt" value="入力内容を確認する" /></noscript>
			</p>
			</div>
			
			</form>
			
			</div>
			<!-- /お問い合わせフォームエリア -->
				
			</div>
				
			<!-- /section -->
					 	
		