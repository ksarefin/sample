<div id="pageTtl">
<h2>{$page_title}&gt; 確認</h2>
</div>

<div class="formBox01">

<div class="clearfix">
{$conf_html}
</div>

<ul class="btnList">
<li><input type="button" name="save" id="save" class="btnGreenB" value="保存" onClick="window.location='{$self}/save/form_id/{$form_id|make_id}/set_id/{$set_id|make_id}';" /></li>
<li><input type="button" name="back" id="back" class="btnWhiteB" value="戻る" onClick="window.location='{$self}/backForm/form_id/{$form_id|make_id}/set_id/{$set_id|make_id}';" /></li>
</ul>
							
</div><!-- /formBox01 -->
