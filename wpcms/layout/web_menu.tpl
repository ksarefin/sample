<ul>
<li><a href="{$wpcms_path}/wpform/" class="current">CMS Form 一覧</a></li>
{foreach from=$list item=val}
<li><a href="{$wpcms_path}/wpform/top/newEntry/form_id/{$val.id|make_id}">{$val.title}</a></li>
{/foreach}
</ul>