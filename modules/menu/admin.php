<?php

  $ADMIN   = array();

  $ADMIN[0]['title'] = 'Categories';
  $ADMIN[0]['form']  = 'JxAdminMenuCategories';
  $ADMIN[0]['desc']  = <<< EOT

Create categories and for your site menu. Once you have created categories in
your menu you can then add links to each category.



EOT;


  $ADMIN[1]['title'] = 'Links';
  $ADMIN[1]['form']  = 'JxAdminMenuLinks';
  $ADMIN[1]['desc']  = <<< EOT

Add links to each category and modify permissions on each link to control 
which users see which links. The menu module will then track the amount of 
clicks each link receives.

EOT;

  $ADMIN[2]['title'] = 'Sort';
  $ADMIN[2]['form']  = 'JxAdminMenuSort';
  $ADMIN[2]['desc']  = <<< EOT

Sort the order of your menu. Change the order in which categories and links are
ordered within your menu.

EOT;


?>
