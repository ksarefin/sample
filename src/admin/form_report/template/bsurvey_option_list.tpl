<div id="pageTtl">
<h2>{$page_title} &gt; 一覧</h2>
</div>

{literal}
<script>
//<!CDATA[
	function page_limit_change(val){
		window.location = '{/literal}{$self}{literal}/{/literal}{$action}{literal}/form_id/{/literal}{$form_id|make_id}{literal}/set_id/{/literal}{$set_id|make_id}{literal}/limit/'+val+'/page/{/literal}{$page_no}{literal}'; 	
	}

	j$(document).ready(function(){
		alert("DDDDDDDDDDDD");
		j$( "#startDate" ).click(function(){
			j$( "#startDate" ).datepicker({
				onSelect: function() { 
					var theDate = new Date(Date.parse($(this).datepicker('getDate')));
					var dateFormatted = $.datepicker.formatDate('yy/mm/dd', theDate);
					alert(dateFormatted);
					j$('#inputStartDate').val(dateFormatted);
				}
			});
		});

		j$( "#endDate" ).datepicker({
			onSelect: function() { 
				//alert(dateText);
				var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('yy/mm/dd', theDate);
				$('#inputEndDate').val(dateFormatted);
			}
		});
		
	});
	
//]]>
</script>
{/literal}	

<div class="listTable">

<div class="formBox03">
<a href="{$self}/surveyReport" class="btnData"><span>アンケート集計</span></a>
<a href="/{$access_name}/form_mail" class="btnData"><span>フォームメール一覧</span></a>
<a href="{$self}" class="btnData"><span>コンバージョンチェック</span></a>
</div>

<div class="formBox03">
<form action="">
<input type="radio" name="pd[report_type]" value="1" {if $pd.report_type == 1 || $pd.report_type=='' }checked{/if}>全期間
<input type="radio" name="pd[report_type]" value="1" {if $pd.report_type == 1}checked{/if}>の期間
<input type="text" name="pd[start]" value="{$pd.start}" size="15" id="inputStartDate"><input type="image" id="startDate" src="/wpcms/wpcms/common/images/calendar.gif">~
<input type="text" name="pd[end]" value="{$pd.end}" size="15" id="inputEndDate"><input type="image" id="endDate" src="/wpcms/wpcms/common/images/calendar.gif">
<input type="submit" name="Submit" Value="検索">
</form>
<a href="{$self}/surveyReportCsv" class="btnData"><span>CSV</span></a>
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
<th nowrap="nowrap">fa</th>
<th nowrap="nowrap">vbn</th>
</tr>
</thead>
<tbody>
{foreach from=$list key=id item=val}
<tr class="{if $id%2 != 0} odd {else} even {/if}" id="row{$val.id}" nowrap="nowrap">
<th class="center" nowrap="nowrap">{$number+$id+1}</th>
<td class="left" nowrap="nowrap">{$val.name}</td>
<td class="center" nowrap="nowrap">
	<table>
		<tr>
		{foreach from=$val.option item=opt_val}
		  <td>	
			<table>
				<tr>
					<td>{$opt_val.name}</td>
				</tr>
				<tr>
					<td>{$opt_val.count}</td>
					<td>{($opt_val.count*100)/$val.total_count|string_format:"%.1f"}</td>
				</tr>
			 </table>
		  </td>
		{/foreach}
		</tr>
	</table>
</td>
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
