<center>
<table width="100%" border="0">
<tr>
  <td width="60%" valign="top">

The JAX system allows you to change who is able to access specific 
modules on your website. Permissions are broken down by group into three 
different categories: Read, Write and Exec. 

<ul>
  <li><b>Read</b> Allows a user to view the module. This does not mean they will be able to view all content in the module.</li>
  <li><b>Write</b> Allows a user to administer the module via the JAX Control Panel.</li>
  <li><b>Exec</b> Some modules use this to determine if the user is allowed to post or manipulate the module on the frontend.</li>
</ul> 

  </td>
  <td width="40%" align="right">

<table class="perms" cellspacing="0" cellpadding="5" bgcolor="#B0C4DE">
<form method="post" action="{$smarty.server.REQUEST_URI}">
<tr>
  <td class="permsheader">Group</td>
  <td class="permsheader">Read</td>
  <td class="permsheader">Write</td>
  <td class="permsheader">Exec</td>
</tr>
{foreach key=groupID item=item from=$perms}

{if $item.r > 0}
  {assign var="rcheck" value=" checked"}
{else}
  {assign var="rcheck" value=""}
{/if}

{if $item.w > 0}
  {assign var="wcheck" value=" checked"}
{else}
  {assign var="wcheck" value=""}
{/if}

{if $item.x > 0}
  {assign var="xcheck" value=" checked"}
{else}
  {assign var="xcheck" value=""}
{/if}

<tr>
  <input type="hidden" name="groups[]" value="{$groupID}">
  <td>{$item.name}</td>
  <td><input type="checkbox" value="4" name="perms[{$groupID}][r]"{$rcheck}></td>
  <td><input type="checkbox" value="2" name="perms[{$groupID}][w]"{$wcheck}></td>
  <td><input type="checkbox" value="1" name="perms[{$groupID}][x]"{$xcheck}></td>
</tr>
{/foreach}
<tr>
  <td colspan="4" align="center">
    <input type="submit" value="Update">
{if count($smarty.post.perms)}
  {assign var="button" value="Done"}
{else}
  {assign var="button" value="Cancel"}
{/if}
    <input type="button" value="{$button}" onClick="javascript: window.location='{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=system/form=JxAdminModules';">
  </td>
</tr>
</form>
</table>

  </td>
</tr>
</table>
