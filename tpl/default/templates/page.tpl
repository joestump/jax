<html>
<head>
<title>{$jxTitle}</title>
{foreach item=file from=$jxCssFiles}
  <link rel="stylesheet" type="text/css" href="{$file}" />
{/foreach}
{foreach item=file from=$jxJsFiles}
  <script src="{$file}" type="text/javascript" language="javascript"></script>
{/foreach}
</head>
<body bgcolor="white">
<script language="JavaScript" src="{$smarty.const.JX_URI_PATH}/tpl/javascript/JxForm.js"></script>


<center>
<table width="80%" cellpadding="3">
<tr bgcolor="#66ccff">
  <td colspan="3">
<h1>{$smarty.server.SERVER_NAME}</h1>
  </td>
</tr>
<tr>
  <td width="25%" valign="top" bgcolor="#eeeeee">
{if $user->userID != 0}
<p>
<font size="-1">
Welcome back {$user->email}! Not {$user->email}? Click <a href="{$smarty.server.SCRIPT_NAME}/users/logout?pg={$smarty.server.SCRIPT_NAME}/users/login/eventHandler=logUserIn">here</a>.
</font>
</p>
{/if}

{menu type="standard"}
  </td>
  <td width="75%" valign="top">
{$module}
  </td>
</tr>
<tr>
  <td>
<font size="-2">{$totalTime}</font>
  </td>
</tr>
</table>
</center>

</body>
</html>
