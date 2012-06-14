<div id="pageTtl">
<h2>フォーム編集 &gt; {$page_title}一覧</h2>
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

<div class="formBox03">
<p class="actionBtn">
<a href="/{$access_name}/form" class="btnMgrList"><span>ページ一覧</span></a>
<a href="{$self}/newForm/" class="btnNewData"><span>アンケート追加</span></a>
</p>
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

<table class="stgTblType01">
<colgroup width="20"></colgroup>
<colgroup width="20"></colgroup>
<colgroup></colgroup>
<colgroup></colgroup>
<colgroup width="100"></colgroup>
<colgroup></colgroup>
<colgroup></colgroup>
<colgroup></colgroup>
<colgroup></colgroup>
<thead>
<tr>
<th nowrap="nowrap">No.</th>
<th nowrap="nowrap">アンケートID</th>
<th>&nbsp;</th>
<th nowrap="nowrap">アンケートタイトル</th>
<th nowrap="nowrap">種類</th>
<th>編集</th>
<th colspan="2">公開／非公開／削除設定</th>
</tr>
</thead>
<tbody>
{foreach from=$list key=id item=val}
<tr class="{if $id%2 != 0} odd {else} even {/if}" id="row{$val.id}" nowrap="nowrap">
<th class="center" nowrap="nowrap">{$number+$id+1}</th>
<td class="center" nowrap="nowrap">{$val.id}</td>
<td class="elvCell">
<ul class="dspBlock">
<li class="{if $val.order_num!=$last_order}elvUp{else}elvUpEnd{/if}"><a class="{if $val.order_num!=$last_order}noConfirm{else}elvBtn{/if}" href="{$self}/displayOrder/survey_id/{$val.id|make_id}/order/up"><span>上</span></a></li>
<li class="{if $val.order_num!=$first_order}elvDown{else}elvDownEnd{/if}"><a class="{if $val.order_num!=$frist_order}noConfirm{else}elvBtn{/if}" href="{$self}/displayOrder/survey_id/{$val.id|make_id}/order/down"><span>下</span></a></li>
</ul>
</td>
<td class="left">{$val.name}</td>
<td class="center"><p class="{$val.type}Type"><span>{$val.type}</span></p></td>
<td class="editCell"><a class="btnEdit" href="{$self}/editForm/survey_id/{$val.id|make_id}"><span>編集</span></a></td>
{if $val.display_flg==1}
<td class="btnCell"><a class="close btnWhite" href="{$self}/nonDisplay/survey_id/{$val.id|make_id}"><span>非公開</span></a></td>
<td class="btnCell">&nbsp;</td>
{else}
<td class="btnCell"><a class="open btnGreen" href="{$self}/display/survey_id/{$val.id|make_id}"><span>公開</span></a></td>
<td class="btnCell"><a class="delete btnWhite" href="{$self}/delete/survey_id/{$val.id|make_id}"><span>削除</span></a></td>
{/if}	
</tr>
{/foreach}
	
</tbody>
</table>

<div class="formBox03">
<ul class="listNum">
{if $prev}
<li><a href="{$self}/{$action}/page/{$prev_pn}">&lt;&lt;</a></li>
{else}
<li><span class="disabled">&lt;&lt;</span></li>
{/if}
{$paging}
{if $next}
<li><a href="{$self}/{$action}/page/{$next_pn}">&gt;&gt;</a></li>
{else}
<li><span class="disabled">&gt;&gt;</span></li>
{/if}
</ul>
</div><!-- /formBox03 -->

</div>
