<?php

  class JxAdminContent extends JxObjectDb
  {
    function JxAdminContent()
    {
      $this->JxObjectDb();
    }

    function render()
    {
      $user = & JxSingleton::factory('user');
      $template = & new JxTemplate(JX_BASE_PATH.'/modules/content/tpl');
      $templateFile = 'JxAdminContent.tpl';

      $sql = "SELECT C.*,U.email,
                 SUM((CONV(R.permissions,8,10) & CONV(".JX_USER_R.",8,2))) AS r,
                 SUM((CONV(R.permissions,8,10) & CONV(".JX_USER_W.",8,2))) AS w,
                 SUM((CONV(R.permissions,8,10) & CONV(".JX_USER_X.",8,2))) AS x
              FROM content AS C, content_groups AS R, users AS U
              WHERE C.contentID=R.contentID AND
                C.userID=U.userID AND
                (R.groupID IN (".implode(',',$user->groupIds).") OR
                 C.userID='".$user->userID."') AND
                (CONV(R.permissions,8,10) & CONV(".JX_USER_W.",8,2)) > 0 ";

      if(strlen($_GET['mime']))
      {
        $sql .= " AND C.mime='".$_GET['mime']."' ";
      }

      if(strlen($_POST['q']))
      {
        $sql .= " AND MATCH (C.title) AGAINST ('".$_POST['q']."') ";
      }
      $sql .= "GROUP BY C.contentID
               ORDER BY C.posted DESC";

      $result = $this->db->query($sql);
      if (!DB::isError($result) && $result->numRows()) {
          $total = $result->numRows();
          $result->free();
      }

      $start = ($_GET['start'] > 0) ? $_GET['start'] : 0;
      $limit = 30;

      $sql .= " \n LIMIT $start,$limit"; 

      $template->assign('start',$start);
      $template->assign('limit',$limit);
      $template->assign('total',$total);

      $result = $this->db->query($sql);
      $content = array();
      if(!DB::isError($result) && $result->numRows())
      {
        while($row = $result->fetchRow())
        {
          $iconFile = '/modules/'.$row['module'].'/tpl/images/'.
                      $row['mime'].'_icon.gif';
          if(file_exists(JX_BASE_PATH.$iconFile))
          {
            $row['icon'] = JX_URI_PATH.$iconFile;
          }
          else
          {
            $row['icon'] = JX_URI_PATH.'/modules/jax/tpl/images/unknown.gif';
          }

          $content[] = $row;
        }
      }

      $template->assign('content',$content);

      return $template->fetch($templateFile);
    }

    function _JxAdminContent()
    {
      $this->_JxObjectDb();
    }
  }

?>
