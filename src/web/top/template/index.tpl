

<!-- section -->
<div class="section">

<h3>CMS Form サンプル</h3> 

<!-- お問い合わせフォームエリア -->
<div class="contactMain">

<ul class="wpfErrorList">
<li>未記入の項目、または入力に誤りがあります。<span class="icoError">マーク</span>の表示されている項目をご確認ください。</li>
</ul>

<form id="wpfForm" name="wpfForm" method="post" action="#">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle">

<tr>
<th width="100" scope="row" class="wpfMustBox"><div class="wpfErrorBox">1行テキスト</div></th>
<td>
<p class="wpfErrorMsg">エラーメッセージ</p>
<div class="wpfDescription">説明分テキスト</div>
<div class="clearfix">
<dl class="wpfInlineListL">
<dt><span class="wpfRbox"><input name="" type="text" class="wpfWideL wpfInputMust" id="wpf_text_1" value="" onBlur="RemoveErrroClass(this.id);" /></span></dt>
<dd><div class="wpfSpace">例：サンプルテキスト</div></dd>
</dl>
</div>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>

<tr>
<th scope="row"><div>テキストエリア</div></th>
<td>
<div class="wpfDescription">説明分テキスト</div>
<div class="clearfix">
<dl class="wpfInlineListL">
<dt><div class="wpfRbox"><textarea name="#" id="wpf_textarea_1" cols="45" rows="8" class="wpfTxtarea"></textarea></div></dt>
<dd><div class="wpfSpace">例：サンプルテキスト</div></dd>
</dl>
</div>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>

<tr>
<th scope="row"><div>プルダウン</div></th>
<td>
<div class="wpfDescription">説明分テキスト</div>
<select name="#" id="wpf_pulldown_1">
<option value="0" selected="selected">セレクト１</option>
<option value="1" >セレクト２</option>
</select>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>

<tr>
<th scope="row" class="wpfMustBox"><div>ラジオ</div></th>
<td>
<div class="wpfDescription">説明分テキスト</div>
<ul id="wpf_radio_1" class="wpfInlineList">
<li><label class="wpfCheckImg"><input name="#" type="radio" value="1"  /> 項目１</label></li>
<li><label class="wpfCheckImg"><input name="#" type="radio" value="2"  /> 項目２</label></li>
</ul>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>

<tr>
<th scope="row" class="wpfMustBox"><div>チェックボックス</div></th>
<td>
<div class="wpfDescription">説明分テキスト</div>
<ul id="wpf_checkbox_1" class="wpfInlineList">
<li><label class="wpfCheckImg"><input name="#" type="checkbox" value="1"  /> 項目１</label></li>
<li><label class="wpfCheckImg"><input name="#" type="checkbox" value="2"  /> 項目２</label></li>
</ul>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>

<tr>
<th scope="row" class="wpfMustBox"><div>アップローダー</div></th>
<td>
<div class="wpfDescription">説明分テキスト</div>
<ul id="wpf_upload_1" class="wpfInlineList">
<li><label class="wpfCheckImg"><input name="#" type="file" value="1"  /></label></li>
</ul>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>

<tr>
<th scope="row" class="wpfMustBox"><div>名前</div></th>
<td>
<div class="wpfDescription">説明分テキスト</div>
<div class="clearfix">
<dl class="wpfInlineListName">
<dt><span class="wpfWide2em">姓</span><span class="wpfRbox"><input name="#" type="text" class="wpfWideM wpfInputMust" id="wpf_entry_name_1" value="" onBlur="changeValue(this.id);" /></span></dt>
<dd><div class="wpfSpace">例：サンプルテキスト</div></dd>
</dl>
<dl class="wpfInlineListName">
<dt><span class="wpfWide2em">名</span><span class="wpfRbox"><input name="#" type="text" class="wpfWideM wpfInputMust" id="wpf_entry_name_2" value="" onBlur="changeValue(this.id);" /></span></dt>
<dd><div class="wpfSpace">例：サンプルテキスト</div></dd>
</dl>
<div class="wpfFormat">全角</div>
</div>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>
<tr>
<th scope="row" class="wpfMustBox"><div>フリガナ</div></th>
<td>
<div class="wpfDescription">説明分テキスト</div>
<div class="clearfix">
<dl class="wpfInlineListName">
<dt><span class="wpfWide2em">セイ</span><span class="wpfRbox"><input name="#" type="text" class="wpfWideM wpfInputMust" id="wpf_entry_kana_name_1" value="" onBlur="changeValue(this.id);" /></span></dt>
<dd><div class="wpfSpace">例：サンプルテキスト</div></dd>
</dl>
<dl class="wpfInlineListName">
<dt><span class="wpfWide2em">メイ</span><span class="wpfRbox"><input name="#" type="text" class="wpfWideM wpfInputMust" id="wpf_entry_kana_name_2" value="" onBlur="changeValue(this.id);" /></span></dt>
<dd><div class="wpfSpace">例：サンプルテキスト</div></dd>
</dl>
<div class="wpfFormat">全角カナ</div>
</div>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>

<tr>
<th scope="row"><div>郵便番号</div>
</th>
<td>
<div class="wpfDescription">説明分テキスト</div>
<div class="clearfix">
<dl class="wpfInlineListS">
<dt><span class="wpfRbox"><input name="#" type="text" maxlength="3" class="wpfWideS" id="wpf_pcode" value="" onBlur="changeValue(this.id);" /></span>−</dt>
<dd><div class="wpfSpace">例：101</div></dd>
</dl>
<dl class="wpfInlineListS">
<dt><span class="wpfRbox"><input name="#" type="text" maxlength="4" class="wpfWideS" id="wpf_pcode_2" value="" onBlur="changeValue(this.id);" 
 onKeyUp="AjaxZip2.zip2addr('wpf[pcode]','wpf[prefecture]','wpf[addressA]','wpf[pcode2]',null,'wpf[addressB]');"
/></span></dt>
<dd><div class="wpfSpace">例：0001</div></dd>
</dl>
</div>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>
<tr>
<th scope="row">都道府県</th>
<td>
<div class="wpfDescription">説明分テキスト</div>
<select name="#" id="wpf_prefecture">
<option value="0" selected="selected">選択してください</option>
<option value="1" >北海道</option>
<option value="2" >青森県</option>
<option value="3" >岩手県</option>
<option value="4" >宮城県</option>
<option value="5" >秋田県</option>
<option value="6" >山形県</option>
<option value="7" >福島県</option>
<option value="8" >茨城県</option>
<option value="9" >栃木県</option>
<option value="10" >群馬県</option>
<option value="11" >埼玉県</option>
<option value="12" >千葉県</option>
<option value="13" >東京都</option>
<option value="14" >神奈川県</option>
<option value="15" >新潟県</option>
<option value="16" >富山県</option>
<option value="17" >石川県</option>
<option value="18" >福井県</option>
<option value="19" >山梨県</option>
<option value="20" >長野県</option>
<option value="21" >岐阜県</option>
<option value="22" >静岡県</option>
<option value="23" >愛知県</option>
<option value="24" >三重県</option>
<option value="25" >滋賀県</option>
<option value="26" >京都府</option>
<option value="27" >大阪府</option>
<option value="28" >兵庫県</option>
<option value="29" >奈良県</option>
<option value="30" >和歌山県</option>
<option value="31" >鳥取県</option>
<option value="32" >島根県</option>
<option value="33" >岡山県</option>
<option value="34" >広島県</option>
<option value="35" >山口県</option>
<option value="36" >徳島県</option>
<option value="37" >香川県</option>
<option value="38" >愛媛県</option>
<option value="39" >高知県</option>
<option value="40" >福岡県</option>
<option value="41" >佐賀県</option>
<option value="42" >長崎県</option>
<option value="43" >熊本県</option>
<option value="44" >大分県</option>
<option value="45" >宮崎県</option>
<option value="46" >鹿児島県</option>
<option value="47" >沖縄県</option>
</select>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>
<tr>
<th scope="row">住所</th>
<td>
<div class="wpfDescription">説明分テキスト</div>
<div class="clearfix">
<dl class="wpfInlineListL">
<dt><span class="wpfRbox"><input name="#" type="text" class="wpfWideL" id="wpf_address_a" value="" /></span></dt>
<dd><div class="wpfSpace">例：サンプルテキスト</div></dd>
</dl>
</div>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>
<tr>
<th scope="row">ビル・建物名</th>
<td>
<div class="wpfDescription">説明分テキスト</div>
<div class="clearfix">
<dl class="wpfInlineListL">
<dt><span class="wpfRbox"><input name="#" type="text" class="wpfWideL" id="wpf_address_b" value="" /></span></dt>
<dd><div class="wpfSpace">例：サンプルテキスト</div></dd>
</dl>
</div>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>

<tr>
<th scope="row" class="wpfMustBox"><div>メールアドレス</div></th>
<td>
<div class="wpfDescription">説明分テキスト</div>
<div class="clearfix">
<dl class="wpfInlineListL">
<dt><div class="mb10"><span class="wpfRbox"><input name="#" type="text" class="wpfWideL wpfInputMust" id="wpf_mailaddr" value="" onBlur="changeValue(this.id);" /></span></div>
<div class="mb10">確認のため、もう一度ご入力ください。</div>
<div><span class="wpfRbox"><input name="#" type="text" class="wpfWideL wpfInputMust" id="wpf_mail_confirm" value="" onBlur="changeValue(this.id);" /></span></div>
</dt>
<dd></dd>
</dl>
</div>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>

<tr>
<th scope="row" class="wpfMustBox"><div>生年月日</div></th>
<td>
<div class="wpfDescription">説明分テキスト</div>
<div class="clearfix">
<dl class="wpfInlineListS">
<dt><span class="wpfNbox"><select name="#" id="wpf_pulldown_1">
<option value="0">明治</option>
<option value="1">大正</option>
<option value="2" selected="selected">昭和</option>
<option value="3">平成</option>
</select></span></dt>
<dd></dd>
</dl>
<dl class="wpfInlineListS">
<dt><span class="wpfRbox"><input name="#" type="text" maxlength="4" class="wpfWideS wpfInputMust" id="wpf_tel" value="" onBlur="changeValue(this.id);" /></span><span class="wpfWide1em">年</span></dt>
<dd><div class="wpfSpace">例：53</div></dd>
</dl>
<dl class="wpfInlineListS">
<dt><span class="wpfRbox"><input name="#" type="text" maxlength="4" class="wpfWideS wpfInputMust" id="wpf_tel_2" value="" onBlur="changeValue(this.id);" /></span><span class="wpfWide1em">月</span></dt>
<dd><div class="wpfSpace">例：12</div></dd>
</dl>
<dl class="wpfInlineListS">
<dt><span class="wpfRbox"><input name="#" type="text" maxlength="4" class="wpfWideS wpfInputMust" id="wpf_tel_3" value="" onBlur="changeValue(this.id);" /></span><span class="wpfWide1em">日</span></dt>
<dd><div class="wpfSpace">例：25</div></dd>
</dl>
</div>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>

<tr>
<th scope="row" class="wpfMustBox"><div>電話番号</div></th>
<td>
<div class="wpfDescription">説明分テキスト</div>
<div class="clearfix">
<dl class="wpfInlineListS">
<dt><span class="wpfRbox"><input name="wpf[tel]" type="text" maxlength="4" class="wpfWideS wpfInputMust" id="wpf_tel" value="" onBlur="changeValue(this.id);" /></span>−</dt>
<dd><div class="wpfSpace">例：03</div></dd>
</dl>
<dl class="wpfInlineListS">
<dt><span class="wpfRbox"><input name="wpf[tel2]" type="text" maxlength="4" class="wpfWideS wpfInputMust" id="wpf_tel_2" value="" onBlur="changeValue(this.id);" /></span>−</dt>
<dd><div class="wpfSpace">例：1234</div></dd>
</dl>
<dl class="wpfInlineListS">
<dt><span class="wpfRbox"><input name="wpf[tel3]" type="text" maxlength="4" class="wpfWideS wpfInputMust" id="wpf_tel_3" value="" onBlur="changeValue(this.id);" /></span></dt>
<dd><div class="wpfSpace">例：5678</div></dd>
</dl>
</div>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>

<tr>
<th scope="row" class="wpfMustBox"><div>Yes / No</div></th>
<td>
<div class="wpfDescription">説明分テキスト</div>
<div class="clearfix">
<ul id="wpf_yesno_1" class="wpfInlineList">
<li><label class="checkImg"><input name="wpf[demosite]" type="radio" value="1"  /> 希望する</label></li>
<li><label class="checkImg"><input name="wpf[demosite]" type="radio" value="2"  /> 希望しない</label></li>
</ul>
</div>
<ul class="wpfNotes">
<li>※注意文テキスト</li>
</ul>
</td>
</tr>

<tr class="dspNone" id="wpf_yesno_display_1">
<th scope="row"><div>IRサイトURL</div>
</th>
<td>
<div class="mb10">お客様IRサイトのURLをご入力ください。</div>
<span class="wpfRbox"><input name="wpf[url]" type="text" class="wpfWideL" id="wpf_url" value="" onBlur="RemoveErrroClass(this.id);"/></span>
</td>
</tr>

</table>

<div class="wpfConfirmBox">
<p><a href="http://www.active-ir.com/policy/" class="ext">ご提供いただく個人情報のお取り扱いについて</a><br />
<a href="http://www.active-ir.com/policy/demosite" class="ext">デモサイトの利用規約</a></p>
<p class="fontS">上記、個人情報取扱に関する事項およびデモサイトの利用規約に同意の上、確認ボタンを押してください。<br />
<span>当サイトでは、プライバシー保護のため、個人情報の送信時にSSL暗号化通信を採用しています。</span></p>
<p>
<label for="wpfAgreeCheck" class="wpfCheckImg">
<input name="wpfAgreeCheck" type="checkbox" id="wpfAgreeCheck" value="1" />
同意する</label>
</p>
</div>

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