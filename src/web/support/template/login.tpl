<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-style-type" content="text/css" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<title>Login</title>
<link rel="stylesheet" type="text/css" href="{$wpcms_path}/wpform/wpcms/common/css/import.css" media="all" />
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
<div class="mainInner">


<div class="loginBox">

<ul class="errorList">
{foreach from=$err item=val}
	<li>{$val}</li>
{/foreach}
</ul>

<form class="login" action="{$self}/loginConf" method="post">

<dl>
<dt>お客様番号：</dt>
<dd><input name="pd[user_id]" type="text" value="{$pd.user_id}"/></dd>
<dt>ドメイン名：</dt>
<dd><input name="pd[domain]" type="text" value="{$pd.domain}"/></dd>
<dt>シリアルナンバー：</dt>
<dd><input name="pd[serial]" type="text" value="{$pd.serial}" />
</dl>

<p><label>ログイン情報を記憶する&nbsp;
<input name="pd[memorise]" type="checkbox" id="memorise" value="1" checked="checked" />
</label></p>

<ul class="btnList">
<li><input type="submit" name="login" id="login" class="btnGreenB" value="Login" /></li>
</ul>

</form>



</div>

</div>
</div>
<!-- /main -->

</div>

</div>
<!-- /contents -->

</div>
</body>
</html>
