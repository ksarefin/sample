
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
					<p class="fontS"><p><p>テスト</p></p></p>
			</div>
			</table><form id="wpfForm" name="wpfForm" method="post" action="{$self}/conf/form_id/{$form_id|make_id}" enctype="multipart/form-data"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle"><tr>
			<th scope="row"><div {if $err.text_7}class="wpfErrorBox" id="text_7_err"{/if}>１行テキストのサンプル</div></th>
			<td>
			{if $err.text_7}<p class="wpfErrorMsg" id="text_7_err_msg">{$err.text_7}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><span class="wpfRbox"><input type="text" name="pd[text_7]" value="{if $pd.text_7}{$pd.text_7}{elseif $initial_val_text_7}{$initial_val_text_7}{/if}" size="30" maxlength="50" class="RemoveErrroMsg  wpfWideL " id="text_7" /> </span></dt></dl></div></td>
			</tr><tr>
			<th scope="row"  class="wpfMustBox"><div {if $err.mail_4}class="wpfErrorBox" id="mail_4_err"{/if}>メールアドレス</div></th>
 			<td>
 			{if $err.mail_4}<p class="wpfErrorMsg" id="mail_4_err_msg">{$err.mail_4}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><div class="mb10"><span class="wpfRbox"><input name="pd[mail_4_mail]" type="text" class="wpfWideL RemoveErrroMsg wpfInputMust" id="mail_4_mail" value="{$pd.mail_4_mail}"/></span></div>
			<div class="mb10">確認のため、もう一度ご入力ください。</div>
			<div><span class="wpfRbox"><input name="pd[mail_4_mail_conf]" type="text" class="wpfWideL RemoveErrroMsg wpfInputMust" id="mail_4_mail_conf" value="{$pd.mail_4_mail_conf}"/></span></div>
			</dt><dd><div class="wpfSpace">info@kiwami.com</div></dd>
			</dl>
			</div></td>
			</tr></table>
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
					 	
		