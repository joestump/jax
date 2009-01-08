<?php 

  $module['moduleID'] = JxCreateID('modules','moduleID',100,999);
  $module['name'] = 'welcome';
  $module['title'] = 'Welcome';
  $module['description'] = 'The main homepage module';
  $module['posted'] = time();
  $module['available'] = 1;
  $module['groups'] = array(1 => '700',
                            2 => '500',
                            3 => '400');

?>
