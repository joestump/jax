<?php 

  $module['moduleID'] = JxCreateID('modules','moduleID',100,999);
  $module['name'] = 'news';
  $module['title'] = 'News';
  $module['description'] = 'A site news and announcement system';
  $module['posted'] = time();
  $module['available'] = 1;
  $module['groups'] = array(1 => 700,
                            2 => 500,
                            3 => 400);

?>
