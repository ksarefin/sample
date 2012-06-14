<div id="pageTtl">
<h2>{$page_title} &gt; ページ一覧</h2>
</div>

{literal}
<script>
//<!CDATA[
	function page_limit_change(val){
		var location = '{/literal}{$self}{literal}/{/literal}{$action}{literal}/limit/'+val+'/page/{/literal}{$page_no}{literal}';
		//alert(location);
		window.location = location; 	
	}
//]]>
</script>
{/literal}	

<div class="listTable">

<div class="formBox03">
<a href="{$self}/newForm/" class="btnNewData"><span>ページ追加</span></a>
<a href="{$wpcms_path}/{$access_name}/survey" class="btnWhiteB"><span>アンケート一覧</span></a>
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
<colgroup width="100"></colgroup>
<colgroup width="100"></colgroup>
<colgroup></colgroup>
<colgroup></colgroup>
<colgroup></colgroup>
<thead>
<tr>
<th nowrap="nowrap">No.</th>
<th nowrap="nowrap">ページID</th>
<th>&nbsp;</th>
<th nowrap="nowrap">ページタイトル</th>
<th>フォーム構築</th>
<th>HTML編集</th>
<th>設定</th>
<th>公開状況</th>
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
<li class="{if $val.order_num!=$last_order}elvUp{else}elvUpEnd{/if}"><a class="{if $val.order_num!=$last_order}noConfirm{else}elvBtn{/if}" href="{$self}/displayOrder/form_id/{$val.id|make_id}/order/up"><span>上</span></a></li>
<li class="{if $val.order_num!=$first_order}elvDown{else}elvDownEnd{/if}"><a class="{if $val.order_num!=$frist_order}noConfirm{else}elvBtn{/if}" href="{$self}/displayOrder/form_id/{$val.id|make_id}/order/down"><span>下</span></a></li>
</ul>
</td>
<td class="title">{$val.title}</td>
<td class="center"><a class="btnSetting" href="{$wpcms_path}/{$access_name}/form_set/index/form_id/{$val.id|make_id}"><span>編集</span></a></td>
<td class="center"><a class="btnHtml" href="{$wpcms_path}/{$access_name}/form_html/index/form_id/{$val.id|make_id}"><span>HTML/CSS編集</span></a></td>
<td class="center"><a class="btnEdit" href="{$self}/editForm/form_id/{$val.id|make_id}"><span>セッティング</span></a></td>
<td class="center">{if $val.display_flg==1}<span class="publish">表示</span>{else}<span class="nonpublish">非表示</span>{/if}</td>
{if $val.display_flg==1}
<td class="btnCell"><a class="close btnWhite" href="{$self}/nonDisplay/form_id/{$val.id|make_id}"><span>非公開</span></a></td>
<td class="btnCell">&nbsp;</td>
{else}
<td class="btnCell"><a class="btnGreen" href="{$self}/display/form_id/{$val.id|make_id}"><span>公開</span></a></td>
<td class="btnCell"><a class="btnWhite" href="{$self}/delete/form_id/{$val.id|make_id}"><span>削除</span></a></td>
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

<div class="formBox04">
<ul class="btnList">
<li><input type="button" class="btnNewData" value="CSS編集" onClick="window.location='{$wpcms_path}/{$access_name}/form_css';" /></li>
</ul>
</div>


</div>
