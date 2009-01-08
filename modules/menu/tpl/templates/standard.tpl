<table width="100%">
{foreach item=category from=$menu}
<tr bgcolor="#cccccc">
  <td>
    {if strlen(trim($category.url))}
      <a href="{$smarty.server.SCRIPT_NAME}/menu/go/categoryID={$category.contentID}">{$category.name}</a>
    {else}
      {$category.name}
    {/if}
  </td>
</tr>
{if is_array($category.links) && count($category.links)}
  {foreach item=link from=$category.links}
<tr>
  <td>
    <a href="{$smarty.server.SCRIPT_NAME}/menu/go/linkID={$link.contentID}">{$link.name}</a>
  </td>
</tr>
  {/foreach}
{/if}
{/foreach}
</table>

