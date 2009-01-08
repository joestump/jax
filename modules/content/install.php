<?php 

  $module['moduleID'] = JxCreateID('modules','moduleID',100,999);
  $module['name'] = 'content';
  $module['title'] = 'Content';
  $module['description'] = 'Manage your content from a single location';
  $module['posted'] = time();
  $module['available'] = 1;
  $module['groups'] = array(1 => '700',
                            2 => '500',
                            3 => '400');

?>
