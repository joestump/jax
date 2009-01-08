<?php

  class JxAdminUserGlance extends JxObjectDb
  {
    function JxAdminUserGlance()
    {
      $this->JxObjectDb();
    }

    function render()
    {
      $template = & new JxTemplate(JX_HOSTED_PATH.'/modules/users/tpl');
      $templateFile = 'JxAdminUserGlance.tpl';

      $sql = "SELECT *
              FROM users
              WHERE posted >= ".(time() - (60 * 60 * 24));

      $result = $this->db->query($sql);
      if(!DB::isError($result) && $result->numRows())
      {
        $last24 = array();
        while($row = $result->fetchRow())
        {
          $last24[] = $row;
        }

        $template->assign('last24',$last24);
        $template->assign('totalLast24',$result->numRows());
      }

      $sql = "SELECT G.name,COUNT(*) AS total 
              FROM groups AS G, groups_users AS R 
              WHERE G.groupID=R.groupID 
              GROUP BY G.groupID
              ORDER BY G.name";

      $result = $this->db->query($sql);
      if(!DB::isError($result) && $result->numRows())
      {
        $groups = array();
        while($row = $result->fetchRow())
        {
          $groups[] = $row;
        }  

        $template->assign('groups',$groups);
      }

      $sql = "SELECT COUNT(*) AS total
              FROM users";
             
      $result = $this->db->getOne($sql);
      if(!DB::isError($result))
      {
        $totalUsers = $result;
        $template->assign('totalUsers',$totalUsers);
      }

      $sql = "SELECT COUNT(*) AS total
              FROM users
              WHERE available > 0";

      $result = $this->db->getOne($sql);
      if(!DB::isError($result))
      {
        $totalActiveUsers = $result;
        $template->assign('totalActiveUsers',$totalActiveUsers);
        $template->assign('totalInactiveUsers',($totalUsers - $totalActiveUsers));
      }

      return $template->fetch($templateFile);
    }

    function _JxAdminUserGlance()
    {
      $this->_JxObjectDb();
    }
  }

?>
