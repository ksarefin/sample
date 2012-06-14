<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT">
<meta name="keywords" content="" />
<meta name="description" content="" />
<title>Admin | WebPR CMS From {$title}</title>
<link rel="stylesheet" type="text/css" href="{$wpcms_path}/wpform/wpcms/common/css/import.css" media="all" />
<link rel="stylesheet" type="text/css" href="{$wpcms_path}/wpform/wpcms/common/css/cmsform.css" media="all" />
{foreach from=$css item=val}
<link rel="stylesheet" type="text/css" href="{$val}" media="screen" />
{/foreach}
{if $module == "top"}
<link rel="stylesheet" type="text/css" href="{$wpcms_path}/wpform/wpcms/common/dashboard/dashboard.css" media="all" />
{/if}

<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/scripts/lightbox/js/prototype.js"></script>
<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/scripts/lightbox/js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/scripts/lightbox/js/lightbox.js"></script>

<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/scripts/jquery/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/scripts/jquery/noConflict.js"></script>

<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/scripts/jsloader.js"></script>
<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/scripts/active_ir.js"></script>
<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/scripts/jquery/mgrTblFadeIn.js"></script>


{foreach from=$js item=val}
<script type="text/javascript" src="{$val}"></script>
{/foreach}

</head>
<body>
<div id="document">
<!-- header -->
<div id="header">
<div class="headerInner">
<h1><img src="{$wpcms_path}/wpform/wpcms/common/images/logo.gif" alt="" /></h1>
  <ul id="headerNav">
	<li id="userName">{$admin_info.name}様</li>
	<li id="logout"><a class="logout" href="{$wpcms_path}/wpform/{$access_name}/top/logout">ログアウト</a></li>
	<li id="siteView"><a href="{$http}" class="ext">サイトを表示する</a></li>
	<li id="passwd"><a href="{$wpcms_path}/wpform/{$access_name}/top/passChange/admin_id/{$admin_info.id|make_id}">パスワード変更</a></li>
  </ul>
</div>

</div>
<!-- /header -->


<!-- contents -->
<div id="contents">

<!-- menu -->

{$menu}

<!-- /menu -->

<div id="mainArea">
<!-- main -->
<div id="main">
<div class="mainInner">

{$content}

<p id="pagetop"><a href="#document">このページのトップへ</a></p>
</div>
</div>
<!-- /main -->

</div>
</div>
<!-- /contents -->

</div>
</body>
</html>
