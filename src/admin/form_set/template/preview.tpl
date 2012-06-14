<!doctype html>
<html xml:lang="ja" xmlns:og="http://ogp.me/ns#">
<head>
<meta charset="utf-8" />
<title>Sample Form</title>
<link rel="stylesheet" href="{$wpcms_path}/wpform/wpcms/common/static/css/import.css" />
<link rel="stylesheet" href="{$wpcms_path}/wpform/wpcms/common/static/css/contact.css" />
<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/static/scripts/jsloader.js"></script>
<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/static/scripts/jquery.js"></script>
<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/static/scripts/func.common.js"></script>
<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/static/scripts/func.contact.js"></script>
<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/scripts/ajaxzip2/ajaxzip2.js"></script>
<!--<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/static/scripts/kanaText.js"></script>-->
<!--<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/static/scripts/jform.js"></script>-->
</head>
<body class="contact">
<div id="document">
<div id="contents">

<div id="main" class="clearfix">
<div class="wrapper">

<div class="article">



<!-- section -->

<div class="section">

<h3>{$form_title}</h3> 

<!-- お問い合わせフォームエリア -->
<div class="contactMain">


<form id="wpfForm" name="wpfForm" method="post" action="#">

{$form_html}


{if $form_style == 2}
<div class="wpfAgree">
{if $page> 1}
<input type="button" name="backPage" value="先へ" onClick="window.location='{$self}/preview/form_id/{$form_id|make_id}/page/{($page-1)|make_id}';"/>
{/if}

{if $page && $last_page != 'last'}
<input type="button" name="backPage" value="次へ" onClick="window.location='{$self}/preview/form_id/{$form_id|make_id}/page/{($page+1)|make_id}';"/>
{/if}
</div>
{elseif $form_style == 1}
<div class="wpfAgree">
<p>
<input type="submit" name="wpfAgreeBtn" id="wpfAgreeBtn" value="入力内容を確認する" />
<noscript><input type="submit" name="wpfAgreeBtn" id="wpfAgreeBtnNoscrpt" value="入力内容を確認する" /></noscript>
</p>
</div>
{/if}
</form>

</div>
<!-- /お問い合わせフォームエリア -->

</div>

<!-- /section -->

</div><!-- /article -->

</div>
</div>

</div><!-- /#main -->

</div><!-- /#contents -->
</div><!-- /#document -->
</body>
</html>