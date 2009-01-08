{literal}
<style type="text/css">
  body, td, a {
      font-family: Verdana, Arial;  
      font-size: 11px;
  }

a:link, a:visited {
  text-decoration:none;
/*  font-weight:bold; */
  color: #FF4000;
}

a:hover {
  color: #FF4000;
}

#topnav {
  margin:0;
  padding: 0 0 0 12px;
  }
  
#topnav UL {
  list-style: none;
  margin: 0;
  padding: 0;
  border: none;
  } 

#topnav LI {
  display: block;
  margin: 0;
  padding: 0;
  float:left;
  width:auto;
  }
  
#topnav A {
  color:#444;
  display:block;
  width:auto;
  text-decoration:none;
  background: #B0C4DE;
  margin:0;
  font-weight: bold;
  padding: 2px 10px;
  border-left: 1px solid #fff;
  border-top: 1px solid #fff;
  border-right: 1px solid #aaa;
}
  
#topnav A:hover, #topnav A:active {
  background: #BBBBBB;
  }

#topnav A.here:link, #topnav A.here:visited {
  position:relative;
  z-index:102;
  background: #BBBBBB;
  font-weight:bold;
  }

#subnav {
  position:relative;
  top:-1px;
  z-index:101;
  margin:0;
  padding: 0px 0 3px 0;
  background: #BBBBBB;
  border-top:1px solid #fff;
  border-bottom:1px solid #aaa;
  }
  
#subnav UL {
  list-style: none;
  margin: 1px 0 0px 13px;
  padding: 0px;
  border-right: 1px solid #fff;
  border-left: 1px solid #aaa;
  } 

#subnav LI {
  position:relative;
  z-index:102;
  display: block;
  margin: 0;
  padding: 0;
  float:left;
  width:auto;
  }
  
#subnav A {
  color:#fff;
  display:block;
  width:auto;
  text-decoration:none;
  margin:0;
  padding: 2px 10px 2px 0px;
}

#subnav p {
  color: #ffffff;
  padding: 2px 10px 2px 5px;
  font-weight: bold;
  margin:0;
}
  
#subnav A:hover, #subnav A:active {
  color:#444;
  }

#subnav A.here:link, #subnav A.here:visited {
  color:#444;
  font-weight: bold;
  }
  
#subnav BR, #topnav BR {
  clear:both;
}

#copy P {
  color:#444;
  font-weight: bold;
  background: #BBBBBB;
  border-bottom:1px solid #fff;
  border-top:1px solid #aaa;
  padding: 3px;
}

#copy A {
  color:#444;
}

</style>
{/literal}

<center>
<table width="90%">
<tr>
  <td align="right">
<p class="login">
Logged in as: {$user->email} | <a href="{$smarty.server.SCRIPT_NAME}/users/logout">Logout</a> | <a href="{$smarty.const.JX_URI_PATH}">Home</a>
</p>
  </td>
</tr>
<tr>
  <td>

<div id="topnav">
<ul>
{if !strlen($jax.module)}
  {assign var="class" value=" class=\"here\""}
{else}
  {assign var="class" value=""}
{/if}
<li> <a href="{$smarty.server.SCRIPT_NAME}/jax"{$class}>Home</a></li>
{foreach item=module from=$jax.modules}
  {if $module.name == $jax.module}
    {assign var="class" value=" class=\"here\""}
  {else}
    {assign var="class" value=""}
  {/if}
<li> <a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=module/module={$module.name}"{$class}>{$module.title}</a></li>
{/foreach}

</ul><br />
</div>
<div id="subnav">
<ul>
{foreach item=form from=$jax.forms}
  {if $form.form == $jax.form}
    {assign var="class" value=" class=\"here\""}
  {else}
    {assign var="class" value=""}
  {/if}
  <li><a href="{$smarty.server.SCRIPT_NAME}/jax/eventHandler=admin/module={$jax.module}/form={$form.form}"{$class}>{$form.title}</a></li>
{/foreach}
</ul><br />
</div>
  </td>
</tr>
<tr>
  <td>

