<?php

  $ADMIN = array();
  $ADMIN[0]['title'] = 'Users';
  $ADMIN[0]['form']  = 'JxAdminUsersView';
  $ADMIN[0]['desc']  = <<< EOT

Update and disable user accounts from this form. Remember that accounts are not
ever deleted, but rather disabled for technical reasons.

EOT;

  $ADMIN[1]['title'] = 'At-A-Glance';
  $ADMIN[1]['form']  = 'JxAdminUserGlance';
  $ADMIN[1]['desc']  = <<< EOT

An all-in-one dashboard that tells you numerous statistics about the status
of your user base. Stats include total number of accounts, total number of
new accounts in the last 24 hours, etc.

EOT;

?>
