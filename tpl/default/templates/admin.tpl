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
<table width="90%">
<tr>
  <td>
{$adminForm}
  </td>
</tr>
{if strlen($childTable)}
<tr>
  <td>
    &nbsp;
    &nbsp;
    &nbsp;
    <font color="red">*</font>
    A required field
  </td>
</tr>
  <!--
{/if}
<tr>
  <td>

<table>
<tr>
  <td>
    <img src="/tpl/images/delete2.gif">
  </td>
  <td>
    Delete Record
  </td>
  <td>
    <img src="/tpl/images/open.gif">
  </td>
  <td>
    Edit Record
  </td>
  <td>
    <font color="red">*</font>
  </td>
  <td>
    A required field
  </td>
</tr>
</table>

<table class="jxListing" cellspacing="0" width="100%">
<tr bgcolor="#ccffff">
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
    <td>{$val|truncate:50|strip_slashes}</td>
    {/if}
  {/foreach}
  <td width="10%"> <a href="javascript: do_delete('{$smarty.server.SCRIPT_NAME}/jax/module={$jaxModule}/delete={$rowKey}/form={$jaxHandler}/eventHandler=admin','Are you sure you wish to delete this record?');" title="Delete Record"><img src="/tpl/images/delete2.gif" border="0"></a>  
  <a href="{$smarty.server.SCRIPT_NAME}/jax/module={$jaxModule}/form={$jaxHandler}/update={$rowKey}/eventHandler=admin" title="Edit Record"><img src="/tpl/images/open.gif" border="0"></a> 

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
{if strlen($childTable)}
-->
{/if}

</table>
</center>
