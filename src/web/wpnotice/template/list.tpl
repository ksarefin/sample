<div id="pageTtl">
<h2>ダッシュボード &gt; {$page_title} &gt; 一覧</h2>
</div>

{literal}
<script>
//<!CDATA[
	function page_limit_change(val){
		window.location = '{/literal}{$self}{literal}/{/literal}{$action}{literal}/limit/'+val+'/page/{/literal}{$page_no}{literal}'; 	
	}
//]]>
</script>
{/literal}	

<div class="formBox01">

<div class="dbSection">
<table class="dbTblInfo">
<colgroup width="150"></colgroup>
<colgroup width="100"></colgroup>
<caption>お知らせ</caption>

<tbody>
{foreach from=$list key=id item=val}
<tr>
<td>{$val.update_date}</td>
<td><p class="icoInfo info0{$val.label}"><span>［{$val.label_name}］</span></p></td>
<td><a href="{$self}/detail/notice_id/{$val.id|make_id}">{$val.title}</a>{$val.update_date|new_ico}</td>
</tr>
{/foreach}
</tbody>

</table>
</div>


<div class="formBox03">
<ul class="listNum">
{if $prev}
<li><a href="{$self}/{$action}/limit/{$limit}/page/{$prev_pn}">&lt;&lt;</a></li>
{else}
<li><span class="disabled">&lt;&lt;</span></li>
{/if}
{$paging}
{if $next}
<li><a href="{$self}/{$action}/limit/{$limit}/page/{$next_pn}">&gt;&gt;</a></li>
{else}
<li><span class="disabled">&gt;&gt;</span></li>
{/if}
</ul>
</div><!-- /formBox03 -->


</div>