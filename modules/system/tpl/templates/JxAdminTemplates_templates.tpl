{include file="JxAdminTemplates_top.tpl"}

<div id="menu">
<a class="menu-templates" href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=system/form=JxAdminTemplates">Templates</a> &raquo;
<span class="menu-directory">{$name}</span>
<br />
<code>{$path}{$dir}</code>
</div>

<ul class="templates">
{foreach item=template from=$templates}
  <li class="tpl-file"> <a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=system/form=JxAdminTemplates?dir={$dir}&name={$name}&file={$template}">{$template}</a> </li>
{/foreach}
  <li class="new-template"><a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=system/form=JxAdminTemplates?dir={$dir}&file=new&name={$name}">Create new template</a> </li>
</ul>

<br />
