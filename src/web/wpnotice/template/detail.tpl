<div id="pageTtl">
<h2>ダッシュボード &gt; {$page_title} &gt; 詳細</h2>
</div>

<div class="formBox01">

<div class="dbSection">
<table class="dbTblInfo">
<colgroup width="150"></colgroup>
<colgroup width="100"></colgroup>
<caption>お知らせ</caption>
<tbody>
<tr>
<td>
<div class="infoDetail">

<p class="icoInfo info0{$notice_detail.label}"><span>［{$notice_detail.label_name}］</span></p>
<h2>{$notice_detail.title}</h2>

<div class="infoText">{$notice_detail.detail|nl2br}</div>

{if $notice_detail.url}
<div class="infoLink">
<a href="{$notice_detail.url}" class="ext">詳しくはこちら</a>
</div>
{/if}

{if $notice_detail.image}
<div class="infoImg">
<p><img src="/air_upload/image/notice/{$notice_detail.image}" alt="" /></p>
</div>
{/if}

</div>
</td>
</tr>
</tbody>
</table>
<p class="btnMore"><a href="/admin/notice/index/office_id/64428652624"><img src="/common/dashboard/images/btn_info.gif" alt="More Information" /></a></p>
</div>

<ul class="btnList">
<li><input type="button" name="back" id="back" class="btnWhiteB" value="戻る" onClick="window.location='{$back}';" /></li>
</ul>
							
</div><!-- /formBox01 -->
