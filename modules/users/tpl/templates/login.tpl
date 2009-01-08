<table width="100%" cellspacing="3">
{if strlen($smarty.get.pg)}
<tr>
  <td bgcolor="red" colspan="2" align="center">
<table width="80%">
<tr>
  <td align="center">
    <font color="white" size="+1"><b>
The feature or module you have requested requires that you first log into our site!
    </b>
  </td>
</tr>
</table>
  </td>
</tr>
{/if}
<tr>
  <td width="50%" valign="top">
<p>
In order to access some of our website we require that you first create an account. If you already have an account you may log in now or request your account information.
</p>
<p>
<ul>
  <li> <a href="{$smarty.server.SCRIPT_NAME}/users/register">Create an Account</a></li>
  <li> <a href="javascript: popUp('{$smarty.server.SCRIPT_NAME}/users/password/eventHandler=lost','350','200');">Forgot my Password</a></li>
</ul>
</p>
  </td>
  <td width="50%" valign="top">
    {$users.loginForm}
  </td>
</tr>
</table>

