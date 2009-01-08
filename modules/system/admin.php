<?php

  $ADMIN = array();
  $ADMIN[1]['title'] = 'Admins';
  $ADMIN[1]['form']  = 'JxAdminAdmins';
  $ADMIN[1]['desc']  = <<< EOT

Add and revoke administrative privileges from users. In order to create a site
administratr the person must already be a registered user.

EOT;

  $ADMIN[2]['title'] = 'Groups';
  $ADMIN[2]['form']  = 'JxAdminGroups';
  $ADMIN[2]['desc']  = <<< EOT

Add groups to the system, which will allow you to exert finer control over
who can access what.

EOT;

  $ADMIN[3]['title'] = 'Modules';
  $ADMIN[3]['form']  = 'JxAdminModules';
  $ADMIN[3]['desc']  = <<< EOT

Control modules currently installed in the JAX system. Enable and disable modules.

EOT;

  $ADMIN[4]['title'] = 'System Log';
  $ADMIN[4]['form']  = 'JxAdminLog';
  $ADMIN[4]['desc']  = <<< EOT

View the last 50 entries into the main system log file. If you need to see 
older log entries please contact support.

EOT;

  $ADMIN[5]['title'] = 'Module Config';
  $ADMIN[5]['form']  = 'JxAdminModulesConfig';
  $ADMIN[5]['desc']  = <<< EOT

Set module configuration variables here. These configuration variables apply
to the module as a whole.

EOT;

  $ADMIN[6]['title'] = 'Plugins';
  $ADMIN[6]['form']  = 'JxAdminPlugins';
  $ADMIN[6]['desc']  = <<< EOT

Module plugins are automatically detected by the system. This form allows you
to enable and disable plugins. 

EOT;

?>
