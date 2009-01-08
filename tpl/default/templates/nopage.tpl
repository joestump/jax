<html>
<head>
{foreach item=file from=$jxCssFiles}
  <link rel="stylesheet" type="text/css" href="{$file}">
{/foreach}
{foreach item=file from=$jxJsFiles}
 <script src="{$file}" type="text/javascript" language="javascript"></script>
{/foreach}
  <title>{$jxTitle}</title>
</head>
<body>
<script language="JavaScript" src="{$smarty.const.JX_URI_PATH}/tpl/javascript/JxForm.js"></script>

{$module}
</body>
</html>
