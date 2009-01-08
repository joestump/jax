{if count($plugins)}

<table width="100%" cellspacing="0">
<tr>
  <td colspan="4" align="right">

<table>
<tr>
  <td><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/play.gif"></td><td>Enabled</td>
  <td><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/pause.gif"></td><td>Disabled</td>
</tr>
</table>

  </td>
</tr>
<tr bgcolor="lightsteelblue">
  <td width="15%"><b>Plugin Name</b></td>
  <td><b>Module</b></td>
  <td><b>Title</b></td>
  <td width="8%" align="center"><b>Status</b></td>
</tr>
{foreach item=plugin from=$plugins}
<tr bgcolor="{cycle values="#ffffff,#cccccc"}">
  <td>{$plugin.name}</td>
  <td>{$plugin.module}</td>
  <td>{$plugin.title}</td>
  <td align="center">
    {if $plugin.available > 0}
      <a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=system/form=JxAdminPlugins/pluginName={$plugin.name}/enable=0"><img border="0" src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/play.gif"/></a>
    {else}
      <a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=system/form=JxAdminPlugins/pluginName={$plugin.name}/enable=1"><img border="0" src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/pause.gif"/></a>
    {/if}
  </td>
</tr>
{/foreach}
</table>

{else}
There are currently no plugins installed!
{/if}
