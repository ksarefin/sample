<div id="pageTtl">
<h2>{$page_title} &gt; フォームメール一覧 &gt; 受信メール一覧</h2>
</div>

{literal}
<script>
//<!CDATA[
	function page_limit_change(val){
		window.location = '{/literal}{$self}{literal}/{/literal}{$action}{literal}/form_id/{/literal}{$form_id|make_id}{literal}/limit/'+val+'/page/{/literal}{$page_no}{literal}'; 	
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
</tr>
</table>

<table class="stgTblType03">
<tr>
<td><a href="{$self}" class="btnMgrList"><span>フォーム一覧</span></a></td>
<td><input type="button" onClick="window.location='{$self}/csvDown/form_id/{$form_id|make_id}';" class="btnMgrList" value="CSV"></td>
</tr>
</table>

<div class="formBox05">
<div id="pageSubTtl">
<h3>受信メール一覧</h3>
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
<li><a href="{$self}/{$action}/form_id/{$form_id|make_id}/limit/{$limit}/page/{$prev_pn}">&lt;&lt;</a></li>
{else}
<li><span class="disabled">&lt;&lt;</span></li>
{/if}
{$paging}
{if $next}
<li><a href="{$self}/{$action}/form_id/{$form_id|make_id}/limit/{$limit}/page/{$next_pn}">&gt;&gt;</a></li>
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
<th nowrap="nowrap">日付時刻</th>
<th nowrap="nowrap">受信メール詳細を見る</th>
</tr>
</thead>
<tbody>
{foreach from=$list key=id item=val}
<tr class="{if $id%2 != 0} odd {else} even {/if}" id="row{$val.id}" nowrap="nowrap">
<th class="center" nowrap="nowrap">{$number+$id+1}</th>
<td class="center" nowrap="nowrap">{$val.id}</td>
<td class="left" nowrap="nowrap">{$val.entry_date|date_format:"%Y年%m月%d日 %H:%M:%S"}</td>
<td class="btnCell"><a href="{$self}/mailDetail/form_id/{$val.form_id|make_id}/mail_id/{$val.id|make_id}" class="btnPrev"><span>受信メール詳細を見る</span></a></td>
</tr>
{/foreach}
	
</tbody>
</table>

<div class="formBox03">
<ul class="listNum">
{if $prev}
<li><a href="{$self}/{$action}/form_id/{$form_id|make_id}/limit/{$limit}/page/{$prev_pn}">&lt;&lt;</a></li>
{else}
<li><span class="disabled">&lt;&lt;</span></li>
{/if}
{$paging}
{if $next}
<li><a href="{$self}/{$action}/form_id/{$form_id|make_id}/limit/{$limit}/page/{$next_pn}">&gt;&gt;</a></li>
{else}
<li><span class="disabled">&gt;&gt;</span></li>
{/if}
</ul>
</div><!-- /formBox03 -->

</div>
