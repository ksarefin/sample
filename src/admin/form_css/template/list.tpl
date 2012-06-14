<div id="pageTtl">
<h2>{$page_title}編集 &gt; 一覧</h2>
</div>


<div class="listTable">

<div class="formBox03">
<p class="actionBtn"><a href="{$wpcms_path}/{$access_name}/form" class="btnMgrList"><span>フォーム編集</span></a></p>
</div>

<table class="stgTblType01">
<colgroup width="100"></colgroup>
<colgroup></colgroup>
<colgroup width="100"></colgroup>
<thead>
<thead>
<tr>
<th nowrap="nowrap">No.</th>
<th nowrap="nowrap">CSS</th>
<th>編集</th>
</tr>
</thead>
<tbody>
{foreach from=$list key=id item=val}
<tr class="{if $id%2 != 0} odd {else} even {/if}" id="row{$val.id}" nowrap="nowrap">
<th class="center" nowrap="nowrap">{$id+1}</th>
<td class="left">{$val.name}</td>
<td class="editCell"><a class="btnEdit" href="{$self}/cssEdit/css_id/{$val.css_id|make_id}"><span>編集</span></a></td>
</tr>
{/foreach}
	
</tbody>
</table>

</div>
