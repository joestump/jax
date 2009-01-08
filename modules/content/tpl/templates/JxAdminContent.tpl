{literal}
<style type="text/css">
  td.heading {
    background: lightsteelblue;
    font-weight: bold;
  }
</style>
{/literal}
<a name="top">
<center>
<table width="100%" cellspacing="0" border="0" cellpadding="3">
<tr>
  <td colspan="7">

<table width="100%" cellspacing="0">
<tr>
  <td nowrap>
{if $total > $limit}
    {navigate start=$start limit=$limit total=$total}
{/if}
  </td>
  <td>
&nbsp;
  </td>
  <td align="right">

<table>
<tr>
  <td><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/play.gif"></td><td>Enabled</td>
  <td><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/pause.gif"></td><td>Disabled</td>
  <td><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/delete.gif"></td><td>Delete</td>
</tr>
</table>

  </td>
</tr>
</table>

  </td>
</tr>
<tr>
  <td align="center" class="heading">
    Type
  </td>
  <td class="heading">
    Author
  </td>
  <td class="heading">
    Title
  </td>
  <td class="heading">
    Posted
  </td>
  <td class="heading" align="center">
    Status
  </td>
  <td class="heading" align="center">
    Delete?
  </td>
  <td class="heading" align="center">
    Share?
  </td>

</tr>
{foreach item=item from=$content}
<tr bgcolor="{cycle values="#eeeeee,#ffffff"}">
  <td align="center">
    <a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=content/mime={$item.mime}" title="{$item.mime}" class="img"><img src="{$item.icon}" border="0"></a>
  </td>
  <td>
    {$item.email}
  </td>
  <td>
    <a class="title" href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module={$item.module}/form={$item.mime}/update={$item.contentID}">{$item.title|truncate:50}</a>
  </td>
  <td>
    {$item.posted|date_format:"%Y-%m-%d %H:%M"}
  </td>
  <td align="center">
    {if $item.available == 1}
      <a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=content/form=JxAdminStatus/contentID={$item.contentID}/available=0" class="img"><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/play.gif" border="0"></a>
    {else}
      <a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=content/form=JxAdminStatus/contentID={$item.contentID}/available=1" class="img"><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/pause.gif" border="0"></a>
    {/if}
  </td>
  <td align="center">
    <a href="javascript:do_delete('{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=content/dmodule={$item.module}/form=JxAdminDelete/dform={$item.mime}/id={$item.contentID}','Are you sure you wish to delete this record?');" class="img"><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/delete.gif" border="0"></a>
  </td>
  <td align="center">
    <a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=content/form=JxAdminContentPermissions/contentID={$item.contentID}" class="img"><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/permissions.gif" border="0"></a>
  </td>

</tr>
{foreachelse}
<tr>
  <td align="center">
    <b>No content to display</b>
  </td>
</tr>
{/foreach}
<tr>
  <td align="center" class="heading">
    Type
  </td>
  <td class="heading">
    Author
  </td>
  <td class="heading">
    Title
  </td>
  <td class="heading">
    Posted
  </td>
  <td class="heading" align="center">
    Status
  </td>
  <td class="heading" align="center">
    Delete?
  </td>
  <td class="heading" align="center">
    Share?
  </td>

</tr>

<tr>
  <td colspan="7" align="right">
    <img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/up.gif" border="0"><a href="#top">Top</a>
  </td>
</tr>
</table>
</center>
