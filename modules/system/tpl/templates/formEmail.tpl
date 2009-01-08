
{foreach item=value key=var from=$data}
--------------------------------------------------------------------------------
Variable: {$var}
--------------------------------------------------------------------------------
  {if is_array($value)}
    {foreach item=v key=k from=$value}
{$k} = {$v}
    {/foreach}
  {else}
    {$value}
  {/if}

{/foreach}

