<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-style-type" content="text/css" />
<meta name="keywords" content="" />
<meta name="description" content="" />

<title>login</title>
<link rel="stylesheet" type="text/css" href="{$wpcms_path}/wpform/wpcms/common/css/import.css" media="all" />
<link rel="stylesheet" type="text/css" href="{$wpcms_path}/wpform/wpcms/common/css/print.css" media="print" />

<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/scripts/jquery/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="/wpform/wpcms/common/scripts/jquery/noConflict.js"></script>
<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/scripts/jquery/capslock.js"></script>

<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/scripts/jsloader.js"></script>


</head>
<body id="wide">
<div id="document">




<!-- header -->
<div id="header">
<div class="headerInner">
    <h1><img src="{$wpcms_path}/wpform/wpcms/common/images/logo.gif" alt="" /></h1>
</div>

</div>
<!-- /header -->





<!-- contents -->
<div id="contents">

<div id="mainArea">
<!-- main -->
<div id="main">


<div class="loginBox">

<ul class="errorList">
{foreach from=$err item=val}
	<li>{$val}</li>
{/foreach}
</ul>

<form class="login" action="{$self}/loginConf" method="post">

<dl>
<dt>ユーザー名：</dt>
<dd><input name="pd[name]" id="pd[name]" type="text" value="{$pd.name}" class="user detectCapsLock" /></dd>
<dt>パスワード：</dt>
<dd><input name="pd[pass]" id="pd[pass]" type="password" value="{$pd.pass}" class="pass detectCapsLock" />
<p id="capsLockNotation" class="red hidden">Capslockがonになっています。</p></dd>
</dl>


<p><label>ログイン情報を記憶する&nbsp;
<input name="pd[memorise]" type="checkbox" id="memorise" value="1" checked="checked" />
</label></p>


<ul class="btnList">
<li><input type="submit" name="login" id="login" class="btnGreenB" value="ログイン" /></li>
</ul>

</form>



</div>

</div>
<!-- /main -->

</div>

</div>
<!-- /contents -->

</div>
</body>
</html>
