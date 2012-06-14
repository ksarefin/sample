<div id="menu">
<div class="contentsMenu">
<ul id="form">
<li id="dashBoard"{if $module == "top"} class="active" {/if}><a href="/{$access_name}">ダッシュボード</a></li>
<li id="formEdit"{if $module == "form" || $module == "survey" || $module == "form_set" || $module == "form_entry" || $module == "form_css" || $module == "form_html"} class="active" {/if}><a href="/{$access_name}/form">フォーム編集</a></li>
<!--<li id="enquete" {if $module == "survey"} class="active" {/if}><a href="{$wpcms_path}/{$access_name}/survey">アンケート管理</a></li>-->
<li id="analytics"{if $module == "form_report" || $module == "form_mail"} class="active" {/if}><a href="/{$access_name}/form_report/surveyReport">フォーム集計</a></li>
</ul>
</div>
</div>
