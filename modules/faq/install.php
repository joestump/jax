<?php

  $module['moduleID']    = JxCreateID('modules','moduleID',100,999);
  $module['name']        = 'faq';
  $module['title']       = 'FAQ';
  $module['description'] = 'A simple Frequently Asked Questions database';
  $module['posted']      = time();
  $module['available']   = 1;
  $module['groups']      = array(1 => 700,
                                 2 => 500,
                                 3 => 400);

?>
