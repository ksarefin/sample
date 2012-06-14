<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-style-type" content="text/css" />
<meta name="keywords" content="" />
<meta name="description" content="" />

<title>Error</title>
<link rel="stylesheet" type="text/css" href="{$wpcms_path}/wpform/wpcms/common/css/import.css" media="all" />

<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/scripts/jquery/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="{$wpcms_path}/wpform/wpcms/common/scripts/jquery/capslock.js"></script>

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


<div class="errorBox">


<dl>
<dt>ERROR：</dt>
<dd>
{foreach from=$err item=val}
{$val}<br />
{/foreach}
</dd>
</dl>



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
