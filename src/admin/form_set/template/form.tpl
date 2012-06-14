<div id="pageTtl">
<h2>フォーム編集 &gt; {$page_title}
{if !empty($pd.id)}
編集
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

<form name="frm" method="post" action="{$self}/save/type/{$set_type}/form_id/{$form_id|make_id}" enctype="multipart/form-data">
<input type="hidden" name='pd[id]' value="{$pd.id}" />

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblAdm">
{$form_html}
</table>

<ul class="btnList">
<li><a href="{$list_page_url}" class="btnMgrList"><span>一覧へ戻る</span></a></li>
<li><input type="submit" name="login" id="login" class="btnGreenB" value="保存" /></li>
</ul>
							
</form>

</div><!-- /formBox01 -->
