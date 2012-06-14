<!-- section -->

<div class="section">

<h3>{$page_title}</h3>

<p>送信内容を確認後、送信するボタンを押して下さい。</p>

<table class="wpfTblStyle">
{$conf_html}
</table>

<table class="submitControl">
<tr>
{if $form_style == 'paging'}
<td class="leftCell"><input type="button" name="wpfBackBtn" id="wpfBackBtn" value="入力をやり直す" onclick="window.location='{$self}/backForm/form_id/{$form_id|make_id}/page/{$page|make_id}';" /></td>
{elseif $form_style == 'consul'}
<td class="leftCell"><input type="button" name="wpfBackBtn" id="wpfBackBtn" value="入力をやり直す" onclick="window.location='{$self}/backForm/form_id/{$form_id|make_id}';" /></td>
{/if}
<td class="rightCell"><input type="button" name="wpfSendBtn" id="wpfSendBtn" value="入力内容を送信する" onclick="window.location='{$self}/save/form_id/{$form_id|make_id}';" /></td>
</tr>
</table>

</div>

<!-- /section -->
