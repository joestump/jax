<?php 

  $module['moduleID'] = JxCreateID('modules','moduleID',100,999);
  $module['name'] = 'menu';
  $module['title'] = 'Site Menu';
  $module['description'] = 'Organize, sort, categorize and share your site menu links';
  $module['posted'] = time();
  $module['available'] = 1;
  $module['groups'] = array(1 => '700',
                            2 => '500',
                            3 => '400');

?>
