{literal}
<style type="text/css">

  table.jxListing {
    border: solid;
    border-width: 1px;
    border-color: black;
  }

  table.jxHtmlForm {
    width: 100%;
    padding: 0px;
    margin: 0px;
  }

</style>
{/literal}
<center>
<table width="100%">
<tr>
  <td>
{$adminForm}
  </td>
</tr>
<tr>
  <td>

<table>
<tr>
  <td>
    <img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/delete2.gif">
  </td>
  <td>
    Delete Record
  </td>
  <td>
    <img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/open.gif">
  </td>
  <td>
    Edit Record
  </td>
  {if strlen($childTable)}
  <td>
    <img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/permissions.gif">
  </td>
  <td>
    Edit Permissions
  </td> 
  {/if}

  <td>
    <font color="red">*</font>
  </td>
  <td>
    A required field
  </td>
</tr>
</table>

<!-- Pagination -->
<!--
{if count($pages) > 1}
<p style="text-align: center">
<a href="{$url}/start={$prev}">&laquo;</a>
{foreach key=page item=start from=$pages}
[ <a href="{$url}/start={$start}">{$page}</a> ] 
{/foreach}
<a href="{$url}/start={$next}">&raquo</a>
</p>
{/if}
-->
<!-- Pagination -->
{if $total > $limit}
  {navigate start=$start limit=$limit total=$total}
{/if}

<table class="jxListing" cellspacing="0" width="100%">
<tr bgcolor="lightsteelblue">
{foreach item=title from=$adminTitles}
  <td><b>{$title}</b></td>
{/foreach}
  <td><b>Action</b></td>
</tr>
{foreach item=item from=$adminTable}
<tr bgcolor="{cycle values="#eeeeee,#cccccc"}">
  {foreach key=key item=val from=$item}
    {counter start=0 print=false assign=tds}
    {if $key == $primaryKey}
      {assign var="rowKey" value=$val}
    {/if}

    {if in_array($key,$showFields) }
      {if $key == "posted"}
        <td>{$val|date_format:"%D %H:%M:%S"}</td>
      {else}
        <td>{$val|strip_slashes}</td>
      {/if}
    {/if}
  {/foreach}
  <td width="10%"> <a href="javascript: do_delete('{$url}?{$item.deleteURL}&start={$start}','Are you sure you wish to delete this record?');" title="Delete Record"><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/delete2.gif" border="0"></a>  
  {if $options.disableEdit == 1}
    {* do nothing *}
  {else}
  <a href="{$url}?{$item.updateURL}&start={$start}" title="Edit Record"><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/open.gif" border="0"></a> 
  {/if}
  {if strlen($childTable)}
    <a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module=content/form=JxAdminContentPermissions/contentID={$rowKey}" title="Edit Permissions"><img src="{$smarty.const.JX_URI_PATH}/modules/jax/tpl/images/permissions.gif" border="0"></a>
  {/if}

</td>
</tr>
{foreachelse}
<tr>
  <td><b>NO RECORDS!</b></td>
</tr>
{/foreach}
</table>


  </td>
</tr>
</table>

<!-- Pagination -->
<!--
{if count($pages) > 1}
<p style="text-align: center">
<a href="{$url}">&laquo;</a>
{foreach key=page item=start from=$pages}
[ <a href="{$url}/start={$start}">{$page}</a> ] 
{/foreach}
<a href="{$url}/start={$next}">&raquo</a>
</p>
{/if}
-->
<!-- Pagination -->

</center>
