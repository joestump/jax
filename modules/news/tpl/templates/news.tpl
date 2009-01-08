{foreach item=entry from=$news.entries}
<p class="news">
  <a href="{$smarty.server.SCRIPT_NAME}/news/eventHandler=view/contentID={$entry.contentID}"><b>{$entry.title}</b></a><br />
  <i>Posted on {$entry.posted|date_format:"%A, %B %e, %Y"}</i><br />
  {$entry.teaser} 
  {if strlen($entry.story)}
    &nbsp;<a href="{$smarty.server.SCRIPT_NAME}/news/eventHandler=view/contentID={$entry.contentID}">read more ...</a><br />
  {/if}
</p>
{foreachelse}
  This user has not posted any news entries!
{/foreach}

