
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
					<p class="fontS"><p><p><span style="font-size: medium;"><strong>Active IRへのご質問・ご相談について、こちらから承ります。</strong></span><br /><span style="font-size: medium;"><strong>デモサイトをご利用希望の方は、デモサイトの利用を「希望する」を選択の上、</strong></span><br /><span style="font-size: medium;"><strong>必要事項にご入力ください。（原則としてご利用はIRご担当者様に限ります）</strong></span><br /><span style="font-size: medium;"><strong>デモは共用のダミーサイトではなく、各企業様毎の<span style="color: #ff0000;">実際の数値</span>でお試しいただけます。</strong></span></p></p></p>
			</div>
			</table><form id="wpfForm" name="wpfForm" method="post" action="{$self}/conf/form_id/{$form_id|make_id}" enctype="multipart/form-data"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle"><tr>
			<th scope="row" class="wpfMustBox"><div {if $err.text_2}class="wpfErrorBox" id="text_2_err"{/if}>会社名</div></th>
			<td>
			{if $err.text_2}<p class="wpfErrorMsg" id="text_2_err_msg">{$err.text_2}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><span class="wpfRbox"><input type="text" name="pd[text_2]" value="{if $pd.text_2}{$pd.text_2}{elseif $initial_val_text_2}{$initial_val_text_2}{/if}" size="40" maxlength="40" class="RemoveErrroMsg  wpfWideL  wpfInputMust " id="text_2" /> </span></dt><dd><div class="wpfSpace">例：株式会社キワミ</div></dd></dl></div><ul class="wpfNotes"><li>※個人の方の場合は「個人」とご記入下さい。</li></ul></td>
			</tr>
 		<tr id="name_2_tr" class="nameTr">
			<th scope="row"  class="wpfMustBox"><div {if $err.name_2}class="wpfErrorBox" id="name_2_err"{/if}>ご担当者名</div></th>
 			<td>
 			{if $err.name_2}<p class="wpfErrorMsg" id="name_2_err_msg">{$err.name_2}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListName">
			<dt><span class="wpfWide2em">姓</span><span class="wpfRbox"><input name="pd[name_2_1]" type="text" class="wpfWideM wpfInputMust RemoveErrroMsg" id="name_2_1" value="{$pd.name_2_1}" /></span></dt>
			</dl>
			<dl class="wpfInlineListName">
			<dt><span class="wpfWide2em">名</span><span class="wpfRbox"><input name="pd[name_2_2]" type="text" class="wpfWideM wpfInputMust RemoveErrroMsg" id="name_2_2" value="{$pd.name_2_2}"/></span></dt>
			</dl>
			<div class="wpfFormat">全角</div>
			</div></td>
			</tr>
			<tr class="kanaTr">
			<th scope="row"  class="wpfMustBox"><div {if $err.name_2_kana}class="wpfErrorBox" id="name_2_kana_err"{/if}>フリガナ</div></th>
 			<td>
 			{if $err.name_2_kana}<p class="wpfErrorMsg" id="name_2_kana_err_msg">{$err.name_2_kana}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListName">
			<dt><span class="wpfWide2em">セイ</span><span class="wpfRbox"><input name="pd[name_2_kana_1]" type="text" class="wpfWideM wpfInputMust RemoveErrroMsg" id="name_2_kana_1" value="{$pd.name_2_kana_1}"/></span></dt>
			</dl>
			<dl class="wpfInlineListName">
			<dt><span class="wpfWide2em">メイ</span><span class="wpfRbox"><input name="pd[name_2_kana_2]" type="text" class="wpfWideM wpfInputMust RemoveErrroMsg" id="name_2_kana_2" value="{$pd.name_2_kana_2}"/></span></dt>
			</dl>
			<div class="wpfFormat">全角カナ</div>
			</div>
			</td>
			</tr><tr>
			<th scope="row" class="wpfMustBox"><div {if $err.text_3}class="wpfErrorBox" id="text_3_err"{/if}>部署・役職</div></th>
			<td>
			{if $err.text_3}<p class="wpfErrorMsg" id="text_3_err_msg">{$err.text_3}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><span class="wpfRbox"><input type="text" name="pd[text_3]" value="{if $pd.text_3}{$pd.text_3}{elseif $initial_val_text_3}{$initial_val_text_3}{/if}" size="40" maxlength="40" class="RemoveErrroMsg  wpfWideL  wpfInputMust " id="text_3" /> </span></dt></dl></div></td>
			</tr><tr>
			<th scope="row"  class="wpfMustBox"><div {if $err.mail_2}class="wpfErrorBox" id="mail_2_err"{/if}>メールアドレス</div></th>
 			<td>
 			{if $err.mail_2}<p class="wpfErrorMsg" id="mail_2_err_msg">{$err.mail_2}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><div class="mb10"><span class="wpfRbox"><input name="pd[mail_2_mail]" type="text" class="wpfWideL RemoveErrroMsg wpfInputMust" id="mail_2_mail" value="{$pd.mail_2_mail}"/></span></div>
			<div class="mb10">確認のため、もう一度ご入力ください。</div>
			<div><span class="wpfRbox"><input name="pd[mail_2_mail_conf]" type="text" class="wpfWideL RemoveErrroMsg wpfInputMust" id="mail_2_mail_conf" value="{$pd.mail_2_mail_conf}"/></span></div>
			</dt><dd><div class="wpfSpace">例：info@kiwami.com</div></dd>
			</dl>
			</div></td>
			</tr><tr class="telTr">
			<th scope="row"  class="wpfMustBox"><div {if $err.tel_2}class="wpfErrorBox" id="tel_2_err"{/if}>電話番号</div></th>
 			<td>
 			{if $err.tel_2}<p class="wpfErrorMsg" id="tel_2_err_msg">{$err.tel_2}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd[tel_2_1]" type="text" maxlength="2" class="wpfWideS RemoveErrroMsg wpfInputMust" id="tel_2_1" value="{$pd.tel_2_1}"/></span>−</dt><dd><div class="wpfSpace">例：03</div></dd>
			</dl>
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd[tel_2_2]" type="text" maxlength="4" class="wpfWideS RemoveErrroMsg wpfInputMust" id="tel_2_2" value="{$pd.tel_2_2}"/></span>−</dt><dd><div class="wpfSpace">例：1234</div></dd>
			</dl>
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd[tel_2_3]" type="text" maxlength="4" class="wpfWideS RemoveErrroMsg wpfInputMust" id="tel_2_3" value="{$pd.tel_2_3}"/></span></dt><dd><div class="wpfSpace">例：5678</div></dd>
			</dl>
			</div></td>
			</tr><tr class="addressTr">
			<th scope="row" ><div {if $err.address_2_pcode}class="wpfErrorBox" id="address_2_pcode_err"{/if}>郵便番号</div></th>
 			<td>
 			{if $err.address_2_pcode}<p class="wpfErrorMsg" id="address_2_pcode_err_msg">{$err.address_2_pcode}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd[address_2_pcode_1]" type="text" maxlength="3" class="wpfWideS RemoveErrroMsg " id="address_2_pcode_1" value="{$pd.address_2_pcode_1}"/></span>−</dt><dd><div class="wpfSpace">例：101</div></dd>
			</dl>
			<dl class="wpfInlineListS">
			<dt><span class="wpfRbox"><input name="pd[address_2_pcode_2]" type="text" maxlength="4" class="wpfWideS RemoveErrroMsg " id="address_2_pcode_2" value="{$pd.address_2_pcode_2}" 
			 onKeyUp="AjaxZip2.zip2addr('pd[address_2_pcode_1]','pd[address_2_pref]','pd[address_2_address_a]','pd[address_2_pcode_2]',null,null);"
			/></span></dt><dd><div class="wpfSpace">例：0001</div></dd>
			</dl>
			</div></td>
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
			<dt><span class="wpfRbox"><input name="pd[address_2_address_a]" type="text" class="wpfWideL RemoveErrroMsg " id="address_2_address_a" value="{$pd.address_2_address_a}" /></span></dt>
			</dl>
			</div></td>
			</tr>
			<tr>
			<th scope="row">ビル・建物名</th>
			<td>
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><span class="wpfRbox"><input name="pd[address_2_address_b]" type="text" class="wpfWideL" id="address_2_address_b" value="{$pd.address_2_address_b}" /></span></dt></dl>
			</div>
			</td>
			</tr><tr>
			<th scope="row"  class="wpfMustBox"><div {if $err.ynradio_2}class="wpfErrorBox" id="ynradio_2_err"{/if}>デモサイトの利用</div></th>
			<td>
			{if $err.ynradio_2}<p class="wpfErrorMsg" id="ynradio_2_err_msg">{$err.ynradio_2}</p>{/if}
			<div class="clearfix">
			<ul id="ynradio_2_ul" class="wpfInlineList yesNoUl">
			<li><label class="checkImg"><input name="pd[ynradio_2]" type="radio" class="RemoveErrroMsg" id="ynradio_2" value="1" {if $pd.ynradio_2 == 1}checked{/if}/> 希望する</label></li>
			<li><label class="checkImg"><input name="pd[ynradio_2]" type="radio" class="RemoveErrroMsg" id="ynradio_2" value="2" {if $pd.ynradio_2 == 2}checked{/if}/> 希望しない</label></li>
			</ul>
			</div></td>
			</tr><tr class="ynradio_2_display dspNone">
			<th scope="row"><div {if $err.ynradio_2_text_2}class="wpfErrorBox" id="ynradio_2_text_2_err"{/if}>IRサイトURL</div></th>
			<td>
			{if $err.ynradio_2_text_2}<p class="wpfErrorMsg" id="ynradio_2_text_2_err_msg">{$err.ynradio_2_text_2}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><span class="wpfRbox"><input type="text" name="pd[ynradio_2_text_2]" value="{if $pd.ynradio_2_text_2}{$pd.ynradio_2_text_2}{elseif $initial_val_ynradio_2_text_2}{$initial_val_ynradio_2_text_2}{/if}" size="40" maxlength="40" class="RemoveErrroMsg  wpfWideL " id="ynradio_2_text_2" /> </span></dt></dl></div><ul class="wpfNotes"><li>お客様IRサイトのURLをご入力ください。</li></ul></td>
			</tr><tr>
			<th scope="row" ><div {if $err.textarea_3}class="wpfErrorBox" id="textarea_3_err"{/if}>ご質問・ご意見</div></th>
			<td>
			{if $err.textarea_3}<p class="wpfErrorMsg" id="textarea_3_err_msg">{$err.textarea_3}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><div class="wpfRbox">
			<textarea name="pd[textarea_3]" id="textarea_3"class="RemoveErrroMsg  wpfTxtarea " rows="3" cols="40" />{$pd.textarea_3}</textarea>
			</div></dt>
			</dl>
			</div></td>
			</tr>
	 			<script type="text/javascript" src="/wpform/wpcms/common/static/scripts/prototype.js"></script>
	 			<script type="text/javascript" src="/wpform/wpcms/common/static/scripts/autoKana.js"></script>
	 			
	 			{literal}
	 			<script type="text/javascript" > 
		 			
	 				var name_2 = new AutoKana('name_2_1', 'name_2_kana_1', {katakana:true, toggle:false});
	 				var name_2 = new AutoKana('name_2_2', 'name_2_kana_2', {katakana:true, toggle:false});
				</script>
				{/literal}
				
			</table><table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle"><tr>
			<th scope="row" ><div {if $err.svid_6_fid_5_sid_15}class="wpfErrorBox" id="svid_6_fid_5_sid_15_err"{/if}>当製品をどこで知りましたか？</div></th>
			<td>
			{if $err.svid_6_fid_5_sid_15}<p class="wpfErrorMsg" id="svid_6_fid_5_sid_15_err_msg">{$err.svid_6_fid_5_sid_15}</p>{/if}
			<ul id="svid_6_fid_5_sid_15_ul" class="wpfInlineList">
			{foreach from=$svid_6_fid_5_sid_15_options key=id item=val }
			<li><label class="wpfCheckImg"><input type="checkbox" class="RemoveErrroMsg"  id ="svid_6_fid_5_sid_15"  name="pd[svid_6_fid_5_sid_15][]" value="{$id}" 
 			{if $pd.svid_6_fid_5_sid_15}
 				{if is_array($pd.svid_6_fid_5_sid_15.0)}
 					{if in_array($id , $pd.svid_6_fid_5_sid_15.0)}checked{/if}
 				{elseif $id==$pd.svid_6_fid_5_sid_15.0}checked
 				{/if}
 			{elseif $checked_list_svid_6_fid_5_sid_15}
 				{if in_array($id , $checked_list_svid_6_fid_5_sid_15)}checked{/if}
 			{/if}/>{$val}</label></li>
 			{/foreach}{*$pd.svid_6_fid_5_sid_15|print_r*}
			</ul><div class="otherBox">その他 <input type="text" name="pd[svid_6_fid_5_sid_15][other]" id="svid_6_fid_5_sid_15_other" value="{$pd.svid_6_fid_5_sid_15.1}" size="10" class="text wpfWideM" maxlength="10"  /></div><ul class="wpfNotes"><li>（複数選択可能）</li></ul></td>
			</tr></table><table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle"><div class="wpfConfirmBox"><p><a href="http://www.active-ir.com/policy/" class="ext">ご提供いただく個人情報のお取り扱いについて</a></p><p class="fontS"><p>上記、個人情報取扱に関する事項およびデモサイトの利用規約に同意の上、確認ボタンを押してください。<br />当サイトでは、プライバシー保護のため、個人情報の送信時にSSL暗号化通信を採用しています。</p></p><p>
				<label for="wpfAgreeCheck" class="wpfCheckImg">
				<input name="wpfAgreeCheck" type="checkbox" id="wpfAgreeCheck" value="1" />
				同意する</label>
				</p>
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
					 	
		