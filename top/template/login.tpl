<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-style-type" content="text/css" />
<meta name="keywords" content="" />
<meta name="description" content="" />

<title>login</title>
<link rel="stylesheet" type="text/css" href="/cms/common/css/import.css" media="all" />
<link rel="stylesheet" type="text/css" href="/cms/common/css/print.css" media="print" />

<script type="text/javascript" src="/cms/common/scripts/jquery/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="/cms/common/scripts/jquery/capslock.js"></script>

<script type="text/javascript" src="/cms/common/scripts/jsloader.js"></script>


</head>
<body id="wide">
<div id="document">




<div id="gnav" class="clearfix">
<h1><img src="/cms/common/images/head_logo.gif" width="145" height="32" alt="Clipboard" /></h1>
</div><!-- /#gnav -->




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

<form class="login" action="{$self}/loginConf/user_id/{$user_id|make_id}" method="post">

<dl>
<dt>Password：</dt>
<dd><input name="pd[password]" id="pd[password]" type="password" value="{$pd.pass}" class="pass" />
</dl>


<p><label>Remember Me&nbsp;
<input name="pd[memorize]" type="checkbox" id="memorize" value="1" checked="checked" />
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
