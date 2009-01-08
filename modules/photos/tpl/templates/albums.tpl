<table width="100%">
<tr>
{foreach item=image from=$photos.images}
  <td>{$image.imageID}</td>
  {counter start=0 assign="i"}
  {if $i % 3 == 0}
</tr><tr>
  {/if}
{/foreach}
</tr>
</table>
