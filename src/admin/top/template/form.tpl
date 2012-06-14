<div id="pageTtl">
<h2>{$page_title} &gt;　変更
</h2>
</div>

<div class="formBox01">

<ul class="errorList">
{foreach from=$err item=val}
	<li>{$val}</li>
{/foreach}
</ul>

<form name="frm" method="post" action="{$self}/save/admin_id/{$admin_id|make_id}" enctype="multipart/form-data">

 <div class="form_l"><label>ユーザー名：<span class="red">※</span></label></div>
 <div class="form_r">{$pd.name}</div>   
 
 <div class="form_l"><label>パスワード：<span class="red">※</span></label></div>
 <div class="form_r">
 	<input name="pd[pass]" id="pd[pass]" type="password" value="{$pd.pass}" class="pass detectCapsLock" />
	<p id="capsLockNotation" class="red hidden">Capslockがonになっています。</p>
 </div>                                               

<ul class="btnList">
<li><input class="save btnGreenB" type="submit" value="保 存" /></li>
</ul>
							
</form>

</div><!-- /formBox01 -->