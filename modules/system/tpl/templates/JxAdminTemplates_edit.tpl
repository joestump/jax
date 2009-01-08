{include file="JxAdminTemplates_top.tpl"}

<div id="menu">
<a class="menu-templates" href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=system/form=JxAdminTemplates">Templates</a> &raquo;
<a class="menu-directory" href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=system/form=JxAdminTemplates?dir={$dir}&name={$name}">{$name}</a> &raquo;
<span class="menu-file">{$file}</span>
<br />
<code>{$path}{$dir}{if $file != 'new'}/{$file}{/if}</code>
</div>

{if count($error)}
<div id="error">
  <h2>The following errors occurred:</h2>

  <ol>
  {foreach item=err from=$error}
    <li> {$err->getMessage()} </li>
  {/foreach}
  </ol>
</div>
{else}
  {if strlen($form)}
    {$form}
  {else}
<div id="good-post">
<h2>Template has successfully been updated</h2>
<p>
The template file has been successfully updated. If you do not notice your 
changes or you are having difficulties making the desired changes to your
templates please contact support.
</p>
</div>

  {/if}
{/if}
