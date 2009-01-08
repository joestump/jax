<table width="100%">
<tr>
  <td align="center">

{$form}

  </td>
</tr>
<tr>
  <td>

{if is_array($admins) && count($admins)}

<table width="100%" border="0">
<tr>
{foreach item=admin from=$admins}
<td align="center" width="33%" valign="top">

<table width="100%" cellspacing="0" cellpadding="0" bgcolor="black">
<tr>
  <td>

<table width="100%" cellspacing="1" cellpadding="2">
<tr bgcolor="#eeeeee">
  <td colspan="2"><b>{$admin.email}</b></td>
</tr>
<tr bgcolor="#ffffff">
  <td align="center">

<table width="100%">
<tr>
  <td width="25%">
    <img src="{$smarty.const.JX_URI_PATH}/modules/system/tpl/images/admins.gif" border="0"><br />
  </td>
  <td width="75%">
  {$admin.fname} {$admin.lname} <br />
  <a title="Revoke {$admin.email}'s Admin Privileges" href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=system/form=JxAdminAdmins/delete={$admin.userID}"><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/delete.gif" border="0"></a>
  <a title="Send Email to {$admin.email}" href="mailto: {$admin.email}"><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/envelope.gif" border="0"></a>
  </td>
</tr>
</table>

  </td>
</table>

  </td>
</tr>
</table>

</td>
{cycle values=",,</tr><tr>"}
{/foreach}  
</tr>
</table>
{/if}

  </td>
</tr>
<tr>
  <td>

<table>
<tr>
  <td><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/delete.gif" border="0"</td>
  <td>Revoke Admin Privileges</td>
<!--
  <td><img src="/modules/messaging/tpl/images/sendmessage.gif" border="0"</td>
  <td>Send Site Message</td>
-->
  <td><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/envelope.gif" border="0"</td>
  <td>Send Email</td>
</tr>
</table>


  </td>
</tr>
</table>
