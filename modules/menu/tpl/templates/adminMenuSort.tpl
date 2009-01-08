<table width="100%" cellspacing="0" border="0">
<tr>
  <td>

<table cellspacing="0" width="100%" cellpadding="4">
<tr>
  <td>&nbsp;</td>
  <td align="center"><b>Move Up</b></td>
  <td align="center"><b>Move Down</b></td>
  <td align="center"><b>Share</b></td>
</tr>

{foreach item=cat from=$menu}
<tr bgcolor="#cccccc">
  <td>{$cat.name}</td>
  <td align="center">
    <a href="{$smarty.server.SCRIPT_NAME}/jax/v2/eventHandler=admin/module=menu/form=JxAdminMenuSort/categoryID={$cat.contentID}/old={$cat.sort}/new={$cat.up}"><img src="{$smarty.const.JX_URI_PATH}/modules/menu/tpl/images/up.gif" border="0" /></a>
  </td>
  <td align="center">
    <a href="{$smarty.server.SCRIPT_NAME}/jax/v2/eventHandler=admin/module=menu/form=JxAdminMenuSort/categoryID={$cat.contentID}/old={$cat.sort}/new={$cat.down}"><img src="{$smarty.const.JX_URI_PATH}/modules/menu/tpl/images/down.gif" border="0" /></a>
  </td>
  <td align="center">
    <a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=content/form=JxAdminContentPermissions/contentID={$cat.contentID}"><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/permissions.gif" border="0"></a>
  </td>
</tr>
  {if is_array($cat.links) && count($cat.links)}
    {foreach item=link from=$cat.links}
    <tr>
      <td>{$link.name}</td>
      <td align="center">
<a href="{$smarty.server.SCRIPT_NAME}/jax/v2/eventHandler=admin/module=menu/form=JxAdminMenuSort/categoryID={$cat.contentID}/old={$link.sort}/new={$link.up}/linkID={$link.contentID}"><img src="{$smarty.const.JX_URI_PATH}/modules/menu/tpl/images/cat_up.gif" border="0" /></a>
      </td>
      <td align="center">
<a href="{$smarty.server.SCRIPT_NAME}/jax/v2/eventHandler=admin/module=menu/form=JxAdminMenuSort/categoryID={$cat.contentID}/old={$link.sort}/new={$link.down}/linkID={$link.contentID}"><img src="{$smarty.const.JX_URI_PATH}/modules/menu/tpl/images/cat_down.gif" border="0" /></a>
      </td>
      <td align="center">
        <a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=content/form=JxAdminContentPermissions/contentID={$cat.contentID}"><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/permissions.gif" border="0"></a>
      </td>
    </tr>
    {/foreach}
  {/if}
{/foreach}
</table>

  </td>
</tr>
</table>
