<div id="pageTtl">
<h2>{$page_title} &gt; フォームメール一覧</h2>
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

<div class="listTable">

<table class="stgTblType02">
<tr>
<td><a href="/{$access_name}/form_report/surveyReport">アンケート集計</a></td>
<td><a href="/{$access_name}/form_mail" class="current">フォームメール一覧</a></td>
<td><a href="/{$access_name}/form_report">コンバージョンチェック</a></td>
</table>
<div class="formBox05">
<div id="pageSubTtl">
<h3>フォームメール一覧</h3>
</div>
</div>

<div class="formBox03">
<ul class="sortList">
<li>
<select name="line" onChange="page_limit_change(this.value)" >
<option value="5"   {if $limit == 5}   selected {/if} >5件ずつ表示</option>
<option value="10"  {if $limit == 10}  selected {/if} >10件ずつ表示</option>
<option value="25"  {if $limit == 25}  selected {/if} >25件ずつ表示</option>
<option value="50"  {if $limit == 50}  selected {/if} >50件ずつ表示</option>
<option value="100" {if $limit == 100} selected {/if} >100件ずつ表示</option>
<option value="all" {if $limit == all} selected {/if} >すべて表示</option>
</select>
</li>
</ul>

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

{$calender}

<table class="stgTblType01">
<thead>
<tr>
<th nowrap="nowrap">No.</th>
<th nowrap="nowrap">ID</th>
<th nowrap="nowrap">フォーム名称</th>
<th nowrap="nowrap">公開状況</th>
<th nowrap="nowrap">メールの数</th>
<th nowrap="nowrap">受信メール一覧を見る</th>
</tr>
</thead>
<tbody>
{foreach from=$list key=id item=val}
<tr class="{if $id%2 != 0} odd {else} even {/if}" id="row{$val.id}" nowrap="nowrap">
<th class="center" nowrap="nowrap">{$number+$id+1}</th>
<td class="center" nowrap="nowrap">{$val.id}</td>
<td class="left" nowrap="nowrap">{$val.title}</td>
<td class="center" nowrap="nowrap">{if $val.display_flg==1}<span class="publish">公開中</span>{else}<span class="nonpublish">非公開</span>{/if}</td>
<td class="center" nowrap="nowrap">{if $val.mail_count>0}{$val.mail_count}{else}0{/if}</td>
<td class="btnCell"><a href="{$self}/mailReport/form_id/{$val.id|make_id}/" class="btnPrev"><span>受信メール一覧を見る</span></a></td>
</tr>
{/foreach}	
</tbody>
</table>

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
