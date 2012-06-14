<div id="pageTtl">
<h2>{$page_title} &gt; コンバージョンチェック</h2>
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
<td><a href="{$self}/surveyReport">アンケート集計</a></td>
<td><a href="/{$access_name}/form_mail">フォームメール一覧</a></td>
<td><a href="{$self}" class="current">コンバージョンチェック</a></td>
</table>
<div class="formBox05">
<div id="pageSubTtl">
<h3>コンバージョンチェック</h3>
</div>
</div>

<div class="formBox05">
<ul class="sortList">
<li class="itemStatus">公開中{$num_rows}件 / 全{$total_rows}件</li>
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
<th>フォーム名称</th>
<th nowrap="nowrap">公開状況</th>
<th nowrap="nowrap">フォームPV</th>
<th colspan="2">確認画面PV／%</th>
<th colspan="2" nowrap="nowrap">コンタクト／%</th>
<th nowrap="nowrap">月別推移を見る</th>
</tr>
</thead>
<tbody>
{foreach from=$list key=id item=val}
<tr class="{if $id%2 != 0} odd {else} even {/if}" id="row{$val.id}" nowrap="nowrap">
<th class="center" nowrap="nowrap">{$number+$id+1}</th>
<td class="center" nowrap="nowrap">{$val.form_id}</td>
<td class="left" nowrap="nowrap">{$val.title}</td>
<td class="center">{if $val.form_tab_display_flg==1}<span class="publish">公開中</span>{else}<span class="nonpublish">非公開</span>{/if}</td>
<td class="right">{if $val.form_view>0}{$val.form_view}{else}0{/if}</td>
<td class="right">{if $val.conf_view>0}{$val.conf_view}{else}0{/if}</td>
<td class="right">{if $val.conf_view>0}{(($val.conf_view*100)/$val.form_view)|string_format:"%.1f"}{else}0.0{/if}</td>
<td class="right">{if $val.send_view>0}{$val.send_view}{else}0{/if}</td>
<td class="right">{if $val.send_view>0}{(($val.send_view*100)/$val.form_view)|string_format:"%.1f"}{else}0.0{/if}</td>
<td class="btnCell"><a href="{$self}/monthlyReport/form_id/{$val.form_id|make_id}" class="btnPrev"><span>月別推移を見る</span></a></td>
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
