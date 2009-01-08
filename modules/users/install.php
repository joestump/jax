<?php 

  $module['moduleID'] = JxCreateID('modules','moduleID',100,999);
  $module['name'] = 'users';
  $module['title'] = 'Users';
  $module['description'] = 'A user management module.';
  $module['posted'] = time();
  $module['available'] = 1;
  $module['groups'] = array(1 => 700,
                            2 => 500,
                            3 => 400);

?>
