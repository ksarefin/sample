
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
					<p class="fontS"><p><p>test</p></p></p>
			</div>
			</table><form id="wpfForm" name="wpfForm" method="post" action="{$self}/conf/form_id/{$form_id|make_id}" enctype="multipart/form-data"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle"><tr>
			<th scope="row" class="wpfMustBox"><div {if $err.text_4}class="wpfErrorBox" id="text_4_err"{/if}>test</div></th>
			<td>
			{if $err.text_4}<p class="wpfErrorMsg" id="text_4_err_msg">{$err.text_4}</p>{/if}
			<div class="clearfix">
			<dl class="wpfInlineListL">
			<dt><span class="wpfRbox"><input type="text" name="pd[text_4]" value="{if $pd.text_4}{$pd.text_4}{elseif $initial_val_text_4}{$initial_val_text_4}{/if}" size="30" maxlength="50" class="RemoveErrroMsg  wpfWideL  wpfInputMust " id="text_4" /> </span></dt></dl></div></td>
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
					 	
		