<?php

  $ADMIN = array();
  $ADMIN[1]['title']  = 'Content';
  $ADMIN[1]['form']   = 'JxAdminContent';
  $ADMIN[1]['module'] = 'content';
  $ADMIN[1]['desc']   = <<< EOT

Manage all of your content from a single control panel. Change permissions,
status and delete content. Please note that deleting some content (ie. Categories) may result in the deletion of content related to it.

EOT;

  $ADMIN[2]['title'] = 'Webpages';
  $ADMIN[2]['form']  = 'JxAdminHtml';
  $ADMIN[2]['module'] = 'html';
  $ADMIN[2]['desc']  = <<< EOT

Easily create static <abbr title="Hyper Text Markup Language">HTML</abbr> webpages with our <abbr title="What You See Is What You Get">WYSIWYG</abbr> editor. Once you have created a page you can then link to it from other pages or your site's menu.

EOT;


?>
