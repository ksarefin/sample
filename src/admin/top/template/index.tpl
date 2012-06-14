<div id="pageTtl">
<h2>{$page_title}</h2>
</div>

<div class="formBox01">

<div id="information">
<div class="headBox">
<h3>
Version - {$version}
{if $current_vresion}Current Version - {$current_vresion}{/if}
</h3>
{if $current_vresion}<p class="more"><a href="/{$wpcms_path}{$access_name}/top/update/">UPDATE</a></p>{/if}
</div>

</div>

<div id="information">
<div class="headBox">
<h3>お知らせ</h3>
<p class="more"><a href="http://kiwamiapp.com/wpform/wpnotice/list"><img src="{$wpcms_path}/wpform/wpcms/common/dashboard/images/btn_info.gif" alt="More Information" /></a></p>
</div>
<table class="dbTblInfo">
<colgroup width="160"></colgroup>
<colgroup width="100"></colgroup>
<colgroup></colgroup>
<tbody>
{foreach from=$list key=id item=val}
<tr>
<td>{$val.postDate}</td>
<td><p class="icoInfo info0{$val.label}"><span>［{$val.label_name}］</span></p></td>
<td><a href="{$val.link}">{$val.title}</a>{$val.postDate|new_ico}</td>
</tr>
{/foreach}
</tbody>
</table>
</div>

<div id="introduction" class="clearfix">
<h3>機能について</h3>

<div class="clearfix">

<div class="boxL">
<p><img src="{$wpcms_path}/wpform/wpcms/common/dashboard/images/ttl_edit.gif" /></p>
<div class="headBox">
<h4 class="iconFormedit">フォーム編集</h4>
<p class="more"><a href="#" class="arw">フォーム管理へ</a></p>
</div>
<div class="section">
<p>フォームやアンケートの作成や編集を行います。</p>
</div>
</div>

<div class="boxR">
<p><img src="{$wpcms_path}/wpform/wpcms/common/dashboard/images/ttl_analytics.gif" /></p>
<div class="headBox">
<h4 class="iconAnalytics">フォーム集計</h4>
<p class="more"><a href="#" class="arw">フォーム管理へ</a></p>
</div>
<div class="section">
<p>アンケートの集計管理やお問い合わせの履歴、コンバージョンチェック等を行います。</p>
</div>
</div>

</div>

<div class="clearfix">

<div class="boxL">
<h3>操作マニュアル</h3>
<div class="section">
<p>最新の操作マニュアルをダウンロードすることができます。</p>
<p><a href="#" class="arw">WebPR CMSフォーム 操作マニュアル</a>（2012年2月1日改訂）</p>
</div>
</div>

<div class="boxR">
<h3>FAQ</h3>
<div class="section">
<p>WebPR CMSフォームのFAQを見ることができます。（サポートライセンスの取得が必要です）</p>
<p><a href="#" class="arw" onClick="window.open('http://kiwamiapp.com/wpform/support/index/type/faq/domain/{$host}');">WebPR CMSフォーム FAQ</a></p>
</div>
</div>

</div>

<div class="clearfix">

<div class="boxL">
<h3>アプリケーションダウンロード</h3>
<div class="section">
<p>WebPR CMSフォームの最新アプリケーションをダウンロードすることができます。<br />
（サポートライセンスの取得が必要です）</p>
<p><a href="#" class="arw" onClick="window.open('http://kiwamiapp.com/wpform/support/index/type/faq/domain/{$host}');">アプリケーションダウンロード</a>（Version1.05 2012年3月12日改）</p>
</div>
</div>

<div class="boxR">
<h3>製品へのお問い合わせ</h3>
<div class="section">
<p>WebPR CMSフォームについてのご質問を承ります。（サポートライセンスの取得が必要です）</p>
<p><a href="#" class="arw" onClick="window.open('http://kiwamiapp.com/wpform/support/index/type/faq/domain/{$host}');">WebPR CMSフォーム お問い合わせ窓口</a>（担当代理店：株式会社キワミ）</p>
</div>
</div>

</div>

</div>

</div>

