<?php

  require_once('../JxConfig.php');

  $moduleName = $argv[1];
  $hostName   = $argv[2];

  $path = '.';
  if (strlen($hostName)) {
      $path = $GLOBALS['jax']['JAX_Config']['JX_HOSTED_PATH'];
      $path = sprintf($path,$hostName).'/modules';
      echo "Hosted path: $path \n";
  }

  $db = & JxSingleton::factory('db');

  $sql = "SELECT * 
          FROM modules
          WHERE name='$moduleName'";

  $oldModuleID = 0;
  $result = $db->query($sql);
  if (!DB::isError($result) && $result->numRows()) {
      $row = $result->fetchRow();
      $oldModuleID = $row['moduleID'];
      echo "Replacing existing module: ".$moduleName." ($oldModuleID)\n";

      $sql   = array();
      $sql[] = "DELETE 
                FROM modules
                WHERE moduleID='$oldModuleID'";

      $sql[] = "DELETE 
                FROM modules_groups
                WHERE moduleID='$oldModuleID'";

      for ($i = 0 ; $i < count($sql) ; ++$i) {
        $result = $db->query($sql[$i]);
      }
  }

  if (file_exists($path.'/'.$moduleName) && is_dir($path.'/'.$moduleName)) {
      if (@include($path.'/'.$moduleName.'/install.php')) {
          echo "Attempting to install module: ".$moduleName."\n";

          if (is_array($module) && count($module)) {
              if ($oldModuleID) {
                  $module['moduleID'] = $oldModuleID;
              }

              $sql   = array();
              $sql[] = "INSERT INTO modules
                        SET moduleID='".$module['moduleID']."',
                            name='".$module['name']."',
                            title='".$module['title']."',
                            description='".$module['description']."',
                            posted='".$module['posted']."',
                            available='".$module['available']."'";

              if (is_array($module['groups']) && count($module['groups'])) {
                  while (list($groupID,$perms) = each($module['groups'])) {
                      $sql[] = "INSERT INTO modules_groups
                                SET moduleID='".$module['moduleID']."',
                                    groupID='$groupID',
                                    permissions='$perms'";
                  }

                  while (list(,$run) = each($sql)) {
                      $result = $db->query($run);
                      if (DB::isError($result)) {
                          die($result->getMessage()."\n");  
                      }
                  }

                  chmod($path.'/'.$moduleName.'/tpl/templates_c',0777);
                  chmod($path.'/'.$moduleName.'/tpl/cache',0777);

                  echo "Module $moduleName has been successfully installed!\n";
              } else {
                  $msg = 'Error reading install file: Bad $module'.
                         '[\'groups\'] array';
                  die($msg."\n");
              }
          } else {
              die('Error reading install file: Bad $module array'."\n");
          }
      } else {
          die("Invalid module install file: ./$moduleName/install.php\n");
      }
  } else {
      die("Invalid module: $moduleName\n");
  }

?>
