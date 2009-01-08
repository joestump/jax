<?php 

  $module['moduleID'] = JxCreateID('modules','moduleID',100,999);
  $module['name'] = 'photos';
  $module['title'] = 'Photo Galleries';
  $module['description'] = 'A way to organize and manage your photos';
  $module['posted'] = time();
  $module['available'] = 1;
  $module['groups'] = array(1 => '700',
                            2 => '500',
                            3 => '400');

?>
