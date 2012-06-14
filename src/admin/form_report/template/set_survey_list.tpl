<div id="pageTtl">
<h2>{$page_title} &gt; アンケート集計 &gt; 集計結果</h2>
</div>

{literal}
<script>
//<!CDATA[
	function page_limit_change(val){
		window.location = '{/literal}{$self}{literal}/{/literal}{$action}{literal}/form_id/{/literal}{$form_id|make_id}{literal}/set_id/{/literal}{$set_id|make_id}{literal}/limit/'+val+'/page/{/literal}{$page_no}{literal}'; 	
	}

	$(document).ready(function(){

	/*
			$( "#startDate" ).datepicker({
				onSelect: function() { 
					var theDate = new Date(Date.parse($(this).datepicker('getDate')));
					var dateFormatted = $.datepicker.formatDate('yy/mm/dd', theDate);
					$('#inputStartDate').val(dateFormatted);
					$('#startDate').val('');
				}
			});
		
		$( "#endDate" ).datepicker({
			onSelect: function() { 
				//alert(dateText);
				var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('yy/mm/dd', theDate);
				$('#inputEndDate').val(dateFormatted);
				$('#endDate').val('');
			}
		});
    */
	$("#inputStartDate").datepicker({dateFormat: 'yy/mm/dd'});
    $("#inputEndDate").datepicker({dateFormat: 'yy/mm/dd'});

	});
	
//]]>
</script>
{/literal}	

<div class="listTable">

<table class="stgTblType02">
<tr>
<td><a href="{$self}/surveyReport" class="current">アンケート集計</a></td>
<td><a href="/{$access_name}/form_mail">フォームメール一覧</a></td>
<td><a href="{$self}">コンバージョンチェック</a></td>
</table>

<table class="stgTblType03">
<tr>
<td><a href="{$self}/surveyReport" class="btnMgrList"><span>一覧へ戻る</span></a></td>
<td align="right">
<form action="{$self}/SetSurveyReport/form_id/{$form_id|make_id}/set_id/{$set_id|make_id}/" method="post">
<label><input type="radio" name="pd[report_type]" value="1" {if $pd.report_type == 1 || $pd.report_type=='' }checked{/if}>全期間</label>
　<label><input type="radio" name="pd[report_type]" value="2" {if $pd.report_type == 2}checked{/if}>任意の期間</label>
<input type="text" name="pd[start]" value="{$pd.start}" size="15" id="inputStartDate"><!--<input type="button" id="startDate" class="calenderButton">-->
〜
<input type="text" name="pd[end]" value="{$pd.end}" size="15" id="inputEndDate"><!--<input type="button" id="endDate" class="calenderButton" >-->
<input type="submit" name="Submit" value="検索" class="btnWhite">
　<input type="button" name="csvDownload" value="CSV" onClick="window.location = '{$self}/surveyReportCsv/form_id/{$form_id|make_id}/set_id/{$set_id|make_id}/';" class="btnDl">
</form>

</td>
</table>

<div class="formBox05">
<div id="pageSubTtl">
<h3>集計結果</h3>
</div>
</div>


<div class="formBox03">
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
<li><a href="{$self}/{$action}/form_id/{$form_id|make_id}/set_id/{$set_id|make_id}/limit/{$limit}/page/{$prev_pn}">&lt;&lt;</a></li>
{else}
<li><span class="disabled">&lt;&lt;</span></li>
{/if}
{$paging}
{if $next}
<li><a href="{$self}/{$action}/form_id/{$form_id|make_id}/set_id/{$set_id|make_id}/limit/{$limit}/page/{$next_pn}">&gt;&gt;</a></li>
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
<th nowrap="nowrap">設問</th>
<th nowrap="nowrap" colspan="{foreach from=$list key=id item=val name=myloop}{/foreach}{count($val.option)*2}">解答</th>
</tr>
</thead>
<tbody>
{foreach from=$list key=id item=val}
<tr class="{if $id%2 != 0} odd {else} even {/if}" id="row{$val.id}" nowrap="nowrap">
<th class="center" nowrap="nowrap" rowspan="2">{$number+$id+1}</th>
<td class="left" nowrap="nowrap" rowspan="2">{$val.name}</td>
	{foreach from=$val.option item=opt_val}
	<th class="center" colspan="2">{$opt_val.name}</th>
	{/foreach}
</tr>
<tr class="{if $id%2 != 0} odd {else} even {/if}">
	{foreach from=$val.option item=opt_val}
	<td class="center">{$opt_val.count}</td>
	<td class="center">{if $opt_val.count>0}{(($opt_val.count*100)/$val.total_count)|string_format:"%.2f"}{else}0{/if}％</td>
	{/foreach}
</tr>
{/foreach}
	
</tbody>
</table>

<div class="formBox03">
<ul class="listNum">
{if $prev}
<li><a href="{$self}/{$action}/form_id/{$form_id|make_id}/set_id/{$set_id|make_id}/limit/{$limit}/page/{$prev_pn}">&lt;&lt;</a></li>
{else}
<li><span class="disabled">&lt;&lt;</span></li>
{/if}
{$paging}
{if $next}
<li><a href="{$self}/{$action}/form_id/{$form_id|make_id}/set_id/{$set_id|make_id}/limit/{$limit}/page/{$next_pn}">&gt;&gt;</a></li>
{else}
<li><span class="disabled">&gt;&gt;</span></li>
{/if}
</ul>
</div><!-- /formBox03 -->

</div>
