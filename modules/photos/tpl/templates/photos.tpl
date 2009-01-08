<ol>
{foreach item=row from=$photos.albums}
  <li> <a href="{$smarty.server.SCRIPT_NAME}/photos/albums/{$row.albumID}">{$row.title}</a> <br />{$row.description|stripslashes}<br /></li>
{/foreach}
</ol>
