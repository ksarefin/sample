<div id="pageTtl">
<h2>{$page_title} &gt; 確認</h2>
</div>

<div class="formBox01">

<p>以下の内容で保存します</p>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblAdm">
{$conf_html}
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblAdm">
{$thanks_html}
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblAdm">
{$customer_mail_html}
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblAdm">
{$admin_mail_html}
</table>

<ul class="btnList">
<li><input type="button" name="back" id="back" class="btnWhiteB" value="戻る" onClick="window.location='{$back}';" /></li>
<li><input type="button" name="save" id="save" class="btnGreenB" value="保存" onClick="window.location='{$self}/save';" /></li>
</ul>
							
</div><!-- /formBox01 -->
