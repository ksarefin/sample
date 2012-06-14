<div id="pageTtl">
<h2>{$page_title} &gt; 一覧</h2>
</div>

<div id="survey_list">

<form name="frm" method="post" action="{$self}/addSurvey/form_id/{$form_id|make_id}/set_id/{$set_id|make_id}">

<div class="form_l">アンケート</div>
{foreach from=$list key=id item=val}
<div class="form_l"></div>
<div class="form_r"><input type="radio" name="pd[survey]" value="{$val.id}"/>{$val.name}|{$val.type}</div>
{/foreach}

<ul class="btnList">
<li><input type="submit" name="login" id="login" class="btnGreenB" value="確認" /></li>
<li><input type="button" name="back" id="back" class="btnWhiteB" value="戻る"　  onClick="window.location='{$back}';" /></li>
</ul>
							
</form>

</div>
