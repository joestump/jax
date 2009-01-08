<?php

  class JxAdminContentPermissions extends JxObjectDb
  {
    function JxAdminContentPermissions()
    {
      $this->JxObjectDb();
    }

    function render()
    {
      $user = & JxSingleton::factory('user');

      $template = & new JxTemplate(JX_MODULE_PATH.'/content/tpl');
      $templateFile = 'JxAdminContentPermissions.tpl';

      if((int)$_GET['contentID'] > 0)
      {
        $content = & new JxContent();

        $sql = "SELECT *
                FROM content 
                WHERE contentID='".$_GET['contentID']."'";

        $record = $this->db->getRow($sql);
        if(DB::isError($record))
        {
          $this->templateFile = 'noperms.tpl'; return false;
        }

        if($record['w'] || ($user->userID == $record['userID']))
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

                $sql = "REPLACE INTO content_groups
                        SET permissions='$newPerms',
                            groupID='".$groups[$i]."',
                            contentID='".$_GET['contentID']."'";

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
                      FROM content_groups AS R
                      WHERE R.groupID='".$row['groupID']."' AND
                            R.contentID='".$_GET['contentID']."'";

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
        else
        {
          $templateFile = 'noperms.tpl';
        }
      }

      return $template->fetch($templateFile);
    }

    function _JxAdminContentPermissions()
    {
      $this->_JxObjectDb();
    }

  }


?>
