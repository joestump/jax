<p class="newsTeaser">
  <a href="{$smarty.server.SCRIPT_NAME}/news/eventHandler=view/contentID={$news.entry.contentID}"><b>{$news.entry.title}</b></a><br />
  <i>Posted on {$news.entry.posted|date_format:"%A, %B %e, %Y"} by <a href="{$smarty.server.SCRIPT_NAME}/messaging/send/msgTo={$news.author.username}">{$news.author.username}</a></i><br />
  {$news.entry.teaser}
</p>
{if strlen($news.entry.story)}
<p class="newsEntry">
  {$news.entry.story}  
</p>
{/if}

