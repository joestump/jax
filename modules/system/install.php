<?php 

  $module['moduleID'] = JxCreateID('modules','moduleID',100,999);
  $module['name'] = 'system';
  $module['title'] = 'System';
  $module['description'] = 'Manage administrators, groups and modules';
  $module['posted'] = time();
  $module['available'] = 1;
  $module['groups'] = array(1 => '700',
                            2 => '000',
                            3 => '000');

?>
