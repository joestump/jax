{if $smarty.const.JX_PATH_MODE == $smarty.const.JX_PATH_MODE_HOSTED}
  {assign var="path" value="/jax/modules/system/tpl/images"}
{else}
  {assign var="path" value="/modules/system/tpl/images"}
{/if}
{literal}
<style type="text/css">
  ul.templates {
      list-style: none;
      padding: 0px;
      margin-left: 10px;
  }

  #good-post {
      background: #94CEF3;
      border: dotted 1px #004F81;
      margin-top: 10px;
      margin-bottom: 10px;
  }

  #good-post h2 {
      font-size: 14px;
      color: #004F81;
      margin: 0px;
      margin-left: 5px;
      margin-top: 5px;
      padding: 0px;
      padding-left: 25px;
      padding-bottom: 10px;
      {/literal}background: url('{$path}/icons/info.gif') no-repeat;{literal}
  }

  #good-post p {
      margin: 0px;
      padding: 0px;
      margin-left: 5px;
      font-size: 10px;
  }


  #error {
      margin-top: 10px;
      margin-bottom: 10px;
      padding: 5px;
      background: #FEFFBF;
      border: dotted 1px #C20400;
  }

  #error code {
      color: black;
  }

  #error h2 {
      font-size: 14px;
      color: #C20400;
      margin: 0px;
      margin-left: 5px;
      margin-top: 5px;
      padding: 0px;
      padding-left: 25px;
      {/literal}background: url('{$path}/icons/alert.gif') no-repeat;{literal}
  }

  #error ul {
      padding: 0px;
      margin: 0px;
      padding-left: 30px;
  }

  #error li {
      padding: 0px;
      margin: 0px;
      font-size: 10px;
  }

  #error p {
      margin: 0px;
      padding: 0px;
      margin-left: 5px;
      font-size: 10px;
  }

  code {
      margin-top: 5px;
      color: #cccccc;
  }

  .menu-templates {
      {/literal}background: url('{$path}/icons/folder_open.gif') no-repeat;{literal}
      background-position: 0px, 0px;
      padding-left: 20px;
      padding-top: 2px;
      line-height: 20px;
      margin-bottom: 2px;
      padding-bottom: 2px;
  }

  .menu-directory {
      {/literal}background: url('{$path}/icons/folder_open.gif') no-repeat;{literal}
      background-position: 0px, 3px;
      padding-left: 20px;
  }

  .menu-file {
      {/literal}background: url('{$path}/icons/templates.gif') no-repeat;{literal}
      background-position: 0px, 3px;
      padding-left: 20px;
      line-height: 20px;
      margin-bottom: 2px;
      padding-bottom: 2px;

  }

  .site {
      {/literal}background: url('{$path}/icons/home.gif') no-repeat;{literal}
      background-position: 0px, 3px;
  }

  .modules {
      {/literal}background: url('{$path}/icons/device.gif') no-repeat;{literal}
      background-position: 0px, 3px;
  }

  li.tpl-header {
      font-size: 12px;
      font-weight: bold;
      padding-bottom: 5px;
      padding-top: 5px;
      padding-left: 20px;
  }

  li.tpl-directory {
      padding-bottom: 3px;
      {/literal}background: url('{$path}/icons/folder.gif') no-repeat;{literal}
      padding-left: 20px;
      margin-left: 5px;
  }

  li.new-template {
      padding-bottom: 3px;
      {/literal}background: url('{$path}/icons/new_file.gif') no-repeat;{literal}
      padding-left: 20px;
      margin-left: 5px;
      margin-top: 10px;
  }

  li.tpl-file {
      padding-bottom: 3px;
      {/literal}background: url('{$path}/icons/templates.gif') no-repeat;{literal}
      padding-left: 20px;
      margin-left: 5px;
  }

</style>
{/literal}

