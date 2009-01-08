<table width="100%" cellspacing="0">
<tr>
  <td colspan="5" align="right">

<table>
<tr>
  <td><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/play.gif"></td><td>Enabled</td>
  <td><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/pause.gif"></td><td>Disabled</td>
</tr>
</table>

  </td>
</tr>
<tr bgcolor="lightsteelblue">
  <td width="10%"><b>Name</b></td>
  <td width="15%" nowrap><b>Installed on</b></td>
  <td><b>Title</b></td>
  <td width="8%" align="center"><b>Status</b></td>
  <td width="8%" align="center"><b>Share</b></td>
</tr>
{foreach item=module from=$modules}
<tr bgcolor="{cycle values="#eeeeee,#ffffff"}">
  <td>{$module.name}</td>
  <td>{$module.posted|date_format:"%D %H:%M:%S"}</td>
  <td>{$module.title}</td>
  <td align="center">
    {if $module.available > 0}
      <a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=system/form=JxAdminModules/moduleID={$module.moduleID}/enable=0"><img border="0" src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/play.gif"/></a>
    {else}
      <a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=system/form=JxAdminModules/moduleID={$module.moduleID}/enable=1"><img border="0" src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/pause.gif"/></a>
    {/if}
  </td>
  <td align="center">
    <a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=system/form=JxAdminModulesPermissions/moduleID={$module.moduleID}" class="img"><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/permissions.gif" border="0"></a>
  </td>
</tr>
{/foreach}
<tr bgcolor="lightsteelblue">
  <td width="10%"><b>Name</b></td>
  <td width="15%" nowrap><b>Installed on</b></td>
  <td><b>Title</b></td>
  <td width="8%" align="center"><b>Status</b></td>
  <td width="8%" align="center"><b>Share</b></td>
</tr>
</table>
