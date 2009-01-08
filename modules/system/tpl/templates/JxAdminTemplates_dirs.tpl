{include file="JxAdminTemplates_top.tpl"}

<ul class="templates">
  <li class="tpl-header site"> Site Templates </li>
  <ul class="templates"> 
     
{foreach key=name item=dir from=$siteDirs}
    <li class="tpl-directory"> <a href="{$smarty.server.REQUEST_URI}?dir={$dir}&name={$name}">{$name}</a> </li>
{/foreach}
  </ul>

  <li class="tpl-header modules"> Module Templates </li>
  <ul class="templates"> 
{foreach key=name item=dir from=$moduleDirs}
    <li class="tpl-directory"> <a href="{$smarty.server.REQUEST_URI}?dir={$dir}&name={$name}">{$name}</a> </li>
{/foreach}
  </ul>
</ul>

