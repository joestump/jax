<?php

  class JxAdminModulesPermissions extends JxObjectDb
  {
    function JxAdminModulesPermissions()
    {
      $this->JxObjectDb();
    }

    function render()
    {
      $user = & JxSingleton::factory('user');

      $template = & new JxTemplate(JX_MODULE_PATH.'/system/tpl');
      $templateFile = 'JxAdminModulesPermissions.tpl';

      if((int)$_GET['moduleID'] > 0)
      {
        if(is_array($_POST['perms']))
        {
          $groups = $_POST['groups'];
          $perms  = $_POST['perms'];
          for($i = 0 ; $i < count($groups) ; ++$i)
          {
            if(is_array($perms[$groups[$i]]) && count($perms[$groups[$i]]))
            {
              $math = $perms[$groups[$i]];
              $newPerms = (($math['r'] + $math['w'] + $math['x']) * 100);

            }
            else
            {
              $newPerms = 0;
            }

            $sql = "REPLACE INTO modules_groups
                    SET permissions='$newPerms',
                        groupID='".$groups[$i]."',
                        moduleID='".$_GET['moduleID']."'";

            $result = $this->db->query($sql);
          }
        }

        $sql = "SELECT * FROM groups";
        $result = $this->db->query($sql);
        if(!DB::isError($result) && $result->numRows())
        {
          while($row = $result->fetchRow())
          {
            $sql = "SELECT R.permissions,
                   (CONV(R.permissions,8,10) & CONV(".JX_USER_R.",8,2)) AS r,
                   (CONV(R.permissions,8,10) & CONV(".JX_USER_W.",8,2)) AS w,
                   (CONV(R.permissions,8,10) & CONV(".JX_USER_X.",8,2)) AS x
                    FROM modules_groups AS R
                    WHERE R.groupID='".$row['groupID']."' AND
                          R.moduleID='".$_GET['moduleID']."'";

            $Presult = $this->db->query($sql);
            if(!DB::isError($Presult) && $Presult->numRows())
            {
              $Prow = $Presult->fetchRow();
              $perms = array('r' => $Prow['r'],
                             'w' => $Prow['w'],
                             'x' => $Prow['x']);
            }
            else
            {
              $perms = array('r' => 0,'w' => 0,'x' => 0);
            }

            $perms['name'] = $row['name'];
            $out[$row['groupID']] = $perms;
          }

          $template->assign('perms',$out);
        }
      }

      return $template->fetch($templateFile);
    }

    function _JxAdminModulesPermissions()
    {
      $this->_JxObjectDb();
    }

  }


?>
