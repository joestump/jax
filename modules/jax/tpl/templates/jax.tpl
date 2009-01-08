{include file="top.tpl"}
<table width="100%" cellspacing="0" border="0" cellpadding="3">
<tr bgcolor="#cccccc">
  <td colspan="2">
  <font size="+1"><b>JAX Control Panel v{$smarty.const.JX_API_VERSION}</b></font><br />
Taking control of your website
<!--
The JAX Control Panel allows you to control all aspects of your website. The 
control panel is grouped by modules. Each module may have one or more forms 
that you can use to control the behavior of each module.
-->
  </td>
</tr>
<tr>
{foreach item=module from=$jax.modules}
  <td>

<table>
<tr>
  <td valign="top"><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/Settings.gif" border="0"></td>
  <td>
    <a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=module/module={$module.name}"><font size="+1"><b>{$module.title}</b></font></a><br />
{$module.description}
  </td>
</tr>
</table>
  
  </td>

  {cycle values=",</tr><tr>"}

{/foreach}
</tr>
</table>
{include file="bot.tpl"}
