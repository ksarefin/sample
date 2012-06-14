<div id="pageTtl">
<h2>{$page_title}&gt; 確認</h2>
</div>

<div class="formBox01">

<div class="clearfix">
{$conf_html}
<div class="form_l"><label>アンケート</label></div>
{foreach from=$pd.options key=id item=val}
  	<div class="form_l"><label></label></div>
 	<div class="form_r">{$val|htmlspecialchars}<br /></div>
 {/foreach}
 {if $pd.others}
 	<div class="form_l"></div>
 	<div class="form_r">その他</div>
 </div>
{/if}
</div>
<ul class="btnList">
<li><input type="button" name="save" id="save" class="btnGreenB" value="保存" onClick="window.location='{$self}/save';" /></li>
<li><input type="button" name="back" id="back" class="btnWhiteB" value="戻る" onClick="window.location='{$back}';" /></li>
</ul>
							
</div><!-- /formBox01 -->
