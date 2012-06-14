
<script type="text/javascript">
j$(function(){
     j$(".clickMenu .clickMenuList").css("display", "none");
     j$(".btnPlus").each(function(i){
         j$(this).click(function(){
             j$(this).toggleClass("close");
             j$(".clickMenu > .clickMenuList").eq(i).toggle();
         });
     });
 });
</script>

<div id="pageTtl">
<h2>フォーム編集 &gt; ページ &gt; {$page_title}編集</h2>
</div>

{literal}
<script>
//<!CDATA[
	function page_limit_change(val){
		window.location = '{/literal}{$self}{literal}/{/literal}{$action}{literal}/form_id/{/literal}{$form_id|make_id}{literal}/limit/'+val+'/page/{/literal}{$page_no}{literal}'; 	
	}

	function entryAdd(val){

		if (val.match('free')){
			window.location = '/{/literal}{$access_name}{literal}/form_entry/newForm/form_id/{/literal}{$form_id|make_id}{literal}/set_id/{/literal}{$val.id|make_id}{literal}';
		}else{
			//window.location = '/{/literal}{$access_name}{literal}/form_entry/optionAdd/form_id/{/literal}{$form_id|make_id}{literal}/set_id/'+val;
			window.location = '/{/literal}{$access_name}{literal}/form_entry/newForm/form_id/{/literal}{$form_id|make_id}{literal}/set_id/'+val;
		}
		
	}

	function surveyAdd(val){

		window.location = '/{/literal}{$access_name}{literal}/form_entry/surveyAdd/form_id/{/literal}{$form_id|make_id}{literal}/set_id/'+val;
	}

	
//]]>
</script>
{/literal}	

<div class="listTable">


<div class="formBox03">
<p class="actionBtn"><a href="/{$access_name}/form" class="btnMgrList"><span>ページ一覧</span></a></p>
<p class="passiveBtn"><a href="{$self}/preview/form_id/{$form_id|make_id}" class="btnPreview ext"><span>プレビュー</span></a></p>
</div>

<div class="formBox03">
<div id="pageSubTtl">
<h3>{$val}</h3>
<ul class="nav">
<li><a href="{$self}/newForm/type/enrty_set" class="btnNewData"><span>フォームセット</span></a></li>
<li><a href="{$self}/newForm/type/survey_set" class="btnNewData"><span>アンケートセット</span></a></li>
</ul>
</div>
</div>

<table class="stgTblType01">
{foreach from=$list key=id item=val}
<thead>
<tr>
<th class="elvCell" style="background:#668BAD;">
<ul class="dspBlock">
<li class="{if $val.order_num==$first_order}elvUpEnd{else}elvUp{/if}"><a class="{if $val.order_num==$first_order}noConfirm{else}elvBtn{/if}" href="{$self}/displayOrder/form_id/{$form_id|make_id}/set_id/{$val.id|make_id}/order/up"><span>上</span></a></li>
<li class="{if $val.order_num==$last_order}elvDownEnd{else}elvDown{/if}"><a class="{if $val.order_num==$last_order}noConfirm{else}elvBtn{/if}" href="{$self}/displayOrder/form_id/{$form_id|make_id}/set_id/{$val.id|make_id}/order/down"><span>下</span></a></li>
</ul>
</td>
<th colspan="2" class="left"><a class="btnSetlistEdit" href="{$self}/editForm/form_id/{$form_id|make_id}/set_id/{$val.id|make_id}/type/{$val.set_type}"><span>{$val.title}</span></a></th>
<th nowrap="nowrap">タイプ</th>
<th nowrap="nowrap">必須項目</th>
<th nowrap="nowrap">表示/非表示</th>
<th nowrap="nowrap">編集</th>
<th nowrap="nowrap" colspan="2">表示/非表示/削除設定</th>
{if $val.display_flg==1}
<th class="btnCell"><a class="close btnWhite" href="{$self}/nonDisplay/form_id/{$form_id|make_id}/set_id/{$val.id|make_id}"><span>非公開</span></a></th>
<th class="btnCell">&nbsp;</th>
{else}
<th class="btnCell"><a class="open btnGreen" href="{$self}/display/form_id/{$form_id|make_id}/set_id/{$val.id|make_id}"><span>公開</span></a></th>
<th class="btnCell"><a class="delete btnWhite" href="{$self}/delete/form_id/{$form_id|make_id}/set_id/{$val.id|make_id}"><span>削除</span></a></th>
{/if}
<th class="btnCell">
<div class="clickMenu">
	<p class="btnPlus"><span>項目の追加</span></p>
	<div class="clickMenuList">
		{if $val.set_type=='enrty_set'}
			<ul>
			{foreach from=$entry_type key=id item=entry}
			<li><a href="#" onclick="entryAdd('{$val.id|make_id}/type/{$id|make_id}');return false;">{$entry}</a></li>
			{/foreach}
			</ul>
		{elseif $val.set_type=='survey_set'}
			<ul>
			{foreach from=$survey_list item=survey}
			<li><a href="#" onclick="surveyAdd('{$val.id|make_id}/survey_id/{$survey.id}');return false;">{$survey.name}</a></li>
			{/foreach}
			</ul>
		{/if}
	</div>
</div>
</th>
</tr>
</thead>
<tbody>
{foreach from=$entry_list key=foreach_id item=foreach_val}
{if $val.id == $foreach_id}
{foreach from=$foreach_val.list key=entry_id item=entry_val}
<tr id="row{$entry_val.id}">
<th class="center" nowrap="nowrap">{$number+$entry_id+1}</th>
<td class="elvCell">
	<ul class="dspBlock">
	<li class="{if $entry_val.order_num == $foreach_val.first_order}elvUpEnd{else}elvUp{/if}"><a class="{if $entry_val.order_num == $foreach_val.frist_order}noConfirm{else}elvBtn{/if}" href="/{$access_name}/form_entry/displayOrder/form_id/{$form_id|make_id}/set_id/{$foreach_id|make_id}/form_entry_id/{$entry_val.id|make_id}/order/up"><span>上</span></a></li>
	<li class="{if $entry_val.order_num == $foreach_val.last_order}elvDownEnd{else}elvDown{/if}"><a class="{if $entry_val.order_num == $foreach_val.last_order}noConfirm{else}elvBtn{/if}" href="/{$access_name}/form_entry/displayOrder/form_id/{$form_id|make_id}/set_id/{$foreach_id|make_id}/form_entry_id/{$entry_val.id|make_id}/order/down"><span>下</span></a></li>
	</ul>
</td>
<td class="title">{$entry_val.label}</td>
<td class="center" nowrap="nowrap"><p class="{$entry_val.type}Type"><span>{$entry_val.type}</span></p></td>

{if $entry_val.required==1}
<td class="btnCell"><a class="btnRequired" href="/{$access_name}/form_entry/notRequire/form_id/{$form_id|make_id}/set_id/{$foreach_id|make_id}/form_entry_id/{$entry_val.id|make_id}"><span>任意</span></a></td>
{else}
<td class="btnCell"><a class="btnNonRequired" href="/{$access_name}/form_entry/require/form_id/{$form_id|make_id}/set_id/{$foreach_id|make_id}/form_entry_id/{$entry_val.id|make_id}"><span>必須</span></a></td>
{/if}
<td class="center" nowrap="nowrap">{if $entry_val.display_flg==1}<span class="publish">表示</span>{else}<span class="nonpublish">非表示</span>{/if}</td>
{if $val.set_type=='enrty_set'}
<td class="editCell"><a class="btnEdit" href="/{$access_name}/form_entry/editForm/form_id/{$form_id|make_id}/set_id/{$foreach_id|make_id}/form_entry_id/{$entry_val.id|make_id}/type/{$entry_val.entry_type|make_id}"><span>編集</span></a></td>
{else}
<td class="editCell">&nbsp;</td>
{/if}

{if $entry_val.display_flg==1}
<td class="btnCell"><a class="close btnWhite" href="/{$access_name}/form_entry/nonDisplay/form_id/{$form_id|make_id}/set_id/{$foreach_id|make_id}/form_entry_id/{$entry_val.id|make_id}"><span>非表示</span></a></td>
<td class="btnCell">&nbsp;</td>
{else}
<td class="btnCell" nowrap="nowrap"><a class="open btnGreen" href="/{$access_name}/form_entry/display/form_id/{$form_id|make_id}/set_id/{$foreach_id|make_id}/form_entry_id/{$entry_val.id|make_id}"><span>表示</span></a></td>
<td class="btnCell" nowrap="nowrap"><a class="delete btnWhite" href="/{$access_name}/form_entry/delete/form_id/{$form_id|make_id}/set_id/{$foreach_id|make_id}/form_entry_id/{$entry_val.id|make_id}"><span>削除</span></a>
</td>
{/if}
<td class="btnCell" colspan="3"></td>
</tr>
{/foreach}
{/if}
{/foreach}

</tbody>
{/foreach}
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

<div class="formBox03">
<ul class="btnList">
<li><a href="/{$access_name}/form" class="btnMgrList"><span>一覧へ戻る</span></a></li>
<li><a href="{$self}/preview/form_id/{$form_id|make_id}" class="ext btnPreview"><span>プレビュー</span></a></li>
<li><a href="{$self}/publish/form_id/{$form_id|make_id}" class="btnGreenB"><span>公開</span></a></li>
</ul>
</div>


</div>
