<?php

  $module['moduleID']    = JxCreateID('modules','moduleID',100,999);
  $module['name']        = 'jax';
  $module['title']       = 'System';
  $module['description'] = 'The system control panel for JAX';
  $module['posted']      = time();
  $module['available']   = 1;
  $module['groups']      = array(1 => 700,
                                 2 => 500,
                                 3 => 500);

?>
