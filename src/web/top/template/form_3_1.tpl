
 			<!-- section -->

			<div class="section">
			
			<h3>{$page_title}</h3> 
			
			<!-- お問い合わせフォームエリア -->
			<div class="contactMain"><span>Step : {$page}/{$total_page}</span>
			
			{if $err}
			<ul class="wpfErrorList">
			<li>未記入の項目、または入力に誤りがあります。<span class="icoError">マーク</span>の表示されている項目をご確認ください。</li>
			</ul>
			{/if}
			
 		
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle">
				<div class="wpfConfirmBox">
					<p class="fontS"><p><p>ページングページングページングページングページングページング</p>
<p>ページングページングページングページングページングページングページングページング</p>
<p>ページングページングページングページングページングページングページングページングページングページングページング</p></p></p>
			</div>
			</table><form id="wpfForm" name="wpfForm" method="post" action="{$self}/conf/form_id/{$form_id|make_id}/page/{$page|make_id}" enctype="multipart/form-data"><input type="hidden" name="pd[page_no]" value="{$page|make_id}" /><table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle"><tr>
			<th scope="row" class="wpfMustBox"><div {if $err.text_5}class="wpfErrorBox" id="text_5_err"{/if}>テキスト</div></th>
			<td>
			{if $err.text_5}<p class="wpfErrorMsg" id="text_5_err_msg">{$err.text_5}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><span class="wpfRbox"><input type="text" name="pd[text_5]" value="{if $pd.text_5}{$pd.text_5}{elseif $initial_val_text_5}{$initial_val_text_5}{/if}" size="30" maxlength="50" class="RemoveErrroMsg  wpfWideL  wpfInputMust " id="text_5" /> </span></dt></dl></div></td>
			</tr><tr>
			<th scope="row"  class="wpfMustBox"><div {if $err.mail_3}class="wpfErrorBox" id="mail_3_err"{/if}>メールアドレス</div></th>
 			<td>
 			{if $err.mail_3}<p class="wpfErrorMsg" id="mail_3_err_msg">{$err.mail_3}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><div class="mb10"><span class="wpfRbox"><input name="pd[mail_3_mail]" type="text" class="wpfWideL RemoveErrroMsg wpfInputMust" id="mail_3_mail" value="{$pd.mail_3_mail}"/></span></div>
			<div class="mb10">確認のため、もう一度ご入力ください。</div>
			<div><span class="wpfRbox"><input name="pd[mail_3_mail_conf]" type="text" class="wpfWideL RemoveErrroMsg wpfInputMust" id="mail_3_mail_conf" value="{$pd.mail_3_mail_conf}"/></span></div>
			</dt><dd><div class="wpfSpace">info@kiwami.com</div></dd>
			</dl>
			</div></td>
			</tr></table>
			 	<div class="wpfAgree">
			 	{if $page> 1}
				<input type="button" name="backPage" value="先へ" onClick="window.location='{$self}/backForm/form_id/{$form_id|make_id}/page/{($page-1)|make_id}';"/>
				{/if}
				
				{if $page && $last_page != 'last'}
				<input type="button" name="backPage" value="次へ" onClick="window.location='{$self}/backForm/form_id/{$form_id|make_id}/page/{($page+1)|make_id}';"/>
				{/if}
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
					 	
		