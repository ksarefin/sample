<div id="pageTtl">
<h2>{$page_title} &gt; フォームメール一覧 &gt; 受信メール &gt; 詳細</h2>
</div>

<div class="listTable">

<table class="stgTblType02">
<tr>
<td><a href="/{$access_name}/form_report/surveyReport">アンケート集計</a></td>
<td><a href="/{$access_name}/form_mail" class="current">フォームメール一覧</a></td>
<td><a href="/{$access_name}/form_report">コンバージョンチェック</a></td>
</tr>
</table>

<table class="stgTblType03">
<tr>
<td><a href="{$self}/mailReport/form_id/{$form_id|make_id}/" class="btnMgrList"><span>メール一覧</span></a></td>
</tr>
</table>

<div class="formBox05">
<div id="pageSubTtl">
<h3>受信メール詳細</h3>
</div>
</div>

<div class="formBox03">
<table class="wpfTblAdm">
<colgroup width="120"></colgroup>
<colgroup></colgroup>
<tr>
<th nowrap="nowrap">メール件名</th>
<td class="left">{$mail_info.mail_subject}</td>
</tr>
<tr>
<th nowrap="nowrap">メールの詳細</th>
<td class="left">{$mail_info.mail_body|nl2br}</td>
</tr>
</table>
</div>

</div>
