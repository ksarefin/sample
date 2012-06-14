<div id="pageTtl">
<h2>CSS編集 &gt; 編集</h2>
</div>

<div class="listTable">

{if !empty($err)}
<ul class="errorList">
{foreach from=$err item=val}
<li>{$val}</li>
{/foreach}
</ul>
{/if}

<form name="frm" method="post" action="{$self}/cssSave/css_id/{$css_id|make_id}" enctype="multipart/form-data">

<table class="admTblType01">
<colgroup class="first"></colgroup>
<thead>
<tr>
<th class="left">編集ファイル：{$pd.template_path}</th>
</tr>
</thead>
<tbody>
<tr>
<th class="center"><textarea rows="20" cols="100" name="pd[contents]" class="wFull">{$pd.contents|escape}</textarea></th>
</tr>
</tbody>
</table>

<ul class="btnList">
<li><input type="button" name="back" id="back" class="back btnWhiteB" value="戻る" onClick="window.location='{$wpcms_path}/{$access_name}/form_css'" /></li>
<li><input type="submit" name="save" id="save" class="save btnGreenB" value="保存" /></li>
</ul>

</form>

</div><!-- /formBox01 -->



