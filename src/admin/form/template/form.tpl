<div id="pageTtl">
<h2>{$page_title} &gt; ページ{if !empty($pd.id)}
ID:{$pd.id} &gt; 編集
{else}
追加
{/if}</h2>
</div>

<div class="formBox01">

{if !empty($err)}
<ul class="errorList">
{foreach from=$err item=val}
<li>{$val}</li>
{/foreach}
</ul>
{/if}


<form name="frm" method="post" action="{$self}/formConf" enctype="multipart/form-data">
<input type="hidden" name='pd[id]' value="{$pd.id}" />

{if !empty($pd.id)}
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblAdm">
<tr>
<th width="200" scope="row">ID</th>
<td>{$pd.id}</td>
</tr>
<tr>
<th scope="row">フォームURL</th>
<td>{$http}{$wpcms_path}/wpform/top/newEntry/form_id/93565{$pd.id}87451</td>
</tr>
</table>
{/if}

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblAdm">
{$form_html}
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
<li><input type="button" name="back" id="back" class="btnWhiteB" value="戻る"　  onClick="window.location='{$list_page_url}';" /></li>
<li><input type="submit" name="login" id="login" class="btnGreenB" value="確認" /></li>
</ul>
							
</form>

</div><!-- /formBox01 -->
