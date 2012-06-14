

<!-- section -->
<div class="section">

<h3>CMS Form 一覧</h3> 
<div class="contactMain">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wpfTblStyle">
<tr>
<th width="100" scope="row">フォーム一覧</th>
<td>
<dl class="wpfInlineListL">
{foreach from=$list item=val}
<dd><div class="wpfSpace"><a href="/wpform/top/newEntry/form_id/{$val.id|make_id}">{$val.title}</a></div></dd>
{/foreach}
</dl>
</td>
</tr>
</table>

<img src="http://kiwamiapp.com/wpform/top/topPageView" heigth="1" width="1">

</div>

</div>
<!-- /section -->