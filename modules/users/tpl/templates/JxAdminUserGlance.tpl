<table width="100%" border="0" cellspacing="0">
<tr>
  <td width="50%">

<h3>User Demographics</h3>
<table width="100%" cellspacing="0">
<tr bgcolor="{cycle values="#cccccc,#ffffff"}">
  <td width="50%"><b>Total # of Users:</b></td>
  <td>{$totalUsers}</td> 
</tr>
<tr bgcolor="{cycle values="#cccccc,#ffffff"}">
  <td><b>Total # of Active Users:</b></td>
  <td>{$totalActiveUsers}</td> 
</tr>
<tr bgcolor="{cycle values="#cccccc,#ffffff"}">
  <td><b>Total # of Inactive Users:</b></td>
  <td>{$totalInactiveUsers}</td> 
</tr>
<tr bgcolor="{cycle values="#cccccc,#ffffff"}">
  <td><b># of New Accounts (24 hours):</b></td>
  <td>{$totalLast24}</td> 
</tr>

</table>

  </td>
  <td width="50%" valign="top">
<h3>Users by Group</h3>
<table width="100%" cellspacing="0">
{foreach item=group from=$groups}
<tr bgcolor="{cycle values="#cccccc,#ffffff"}">
  <td>{$group.name}</td>
  <td>{$group.total}</td>
</tr>
{/foreach}
</table>
  </td>  
</tr>
</table>
<br />
<h3>Accounts Created in the Last 24 Hours</h3>
<table width="100%" cellspacing="0">
<tr bgcolor="#b0c4de">
  <td><b>Email</b></td>  
  <td><b>Last Name</b></td>
  <td><b>First Name</b></td>
  <td><b>Create At</b></td>
</tr>
{foreach item=user from=$last24}
<tr bgcolor="{cycle values="#cccccc,#ffffff"}">
  <td>{$user.email}</td>
  <td>{$user.lname}</td>
  <td>{$user.fname}</td>
  <td>{$user.posted|date_format:"%Y-%m-%d at %H:%M %Z"}</td>
</tr>
{/foreach}
</table>
