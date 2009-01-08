{include file="top.tpl"}
<center>
<table width="100%" cellspacing="0" border="0">
<tr bgcolor="#cccccc">
  <td colspan="2">
  <font size="+1"><b>{$jax.info.title}</b></font><br />
  {$jax.info.description}
  </td>
</tr>
<tr>
{foreach item=form from=$jax.forms}
  <td valign="top" width="50%">

<table>
<tr>
  <td valign="top"><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/Settings.gif" border="0"></td>
  <td>
<a href="{if strlen($form.url)}{$form.url}{else}{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module={$jax.module}/form={$form.form}{/if}"><font size="+1"><b>{$form.title}</b></font></a><br />
{$form.desc}
  </td>
</tr>
</table>
<!--  <li>{$form.title}</li> -->

  </td>
  {cycle values=",</tr><tr>"}
{/foreach}
</tr>
</table>
</center>
{include file="bot.tpl"}
