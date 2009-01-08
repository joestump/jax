<?php

  $ADMIN = array();
  $ADMIN[1]['title']  = 'Entries';
  $ADMIN[1]['form']   = 'JxAdminNews';
  $ADMIN[1]['module'] = 'news';
  $ADMIN[1]['desc']   = <<< EOT

Mange your news entries with our WYSIWYG editor. 

EOT;

  $ADMIN[2]['title'] = 'Categories';
  $ADMIN[2]['form']  = 'JxAdminNewsCategories';
  $ADMIN[2]['module'] = 'news';
  $ADMIN[2]['desc']  = <<< EOT

Before you can create news entries you need to first create categories to put
those entries into. If you change permissions on a category those changes
will cascade to all news entries in that category.

EOT;


?>
