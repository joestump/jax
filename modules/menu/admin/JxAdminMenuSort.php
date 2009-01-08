<?php

  class JxAdminMenuSort extends JxObjectDb
  {
    function JxAdminMenuSort()
    {
      $this->JxObjectDb();
    }

    function render()
    {
      $sql = "SELECT *
              FROM menu_categories
              ORDER BY sort";

      $result = $this->db->query($sql);
      if(!DB::isError($result) && $result->numRows())
      {
        $cat_sort = 0;
        while($row = $result->fetchRow())
        {
          $sql = "UPDATE menu_categories
                  SET sort='".$cat_sort."'
                  WHERE contentID='".$row['contentID']."'";

          ++$cat_sort;

          $link_sort = 0;

          $sql = "SELECT *
                  FROM menu_links
                  WHERE categoryID='".$row['contentID']."'
                  ORDER BY sort";

          $lresult = $this->db->query($sql);
          if(!DB::isError($lresult) && $lresult->numRows())
          {
            while($lrow = $lresult->fetchRow())
            {
              $sql = "UPDATE menu_links
                      SET sort='".$link_sort."'
                      WHERE contentID='".$lrow['contentID']."'";

              $this->db->query($sql);

              ++$link_sort;
            }
          }

          $this->db->query($sql);
        }
      }

      if(strlen($_GET['categoryID']) &&
         !strlen($_GET['linkID']) &&
         strlen($_GET['new']) &&
         strlen($_GET['old']))
      {
        $sql   = array();
        $sql[] = "UPDATE menu_categories
                  SET sort='".$_GET['old']."'
                  WHERE sort='".$_GET['new']."'";

        $sql[] = "UPDATE menu_categories
                  SET sort='".$_GET['new']."'
                  WHERE contentID='".$_GET['categoryID']."'";

        for($i = 0 ; $i < count($sql) ; ++$i)
        {
          // echo '<pre>'.$sql[$i].'</pre>';
          $this->db->query($sql[$i]);
        }
      }

      if(strlen($_GET['categoryID']) &&
         strlen($_GET['linkID']) &&
         strlen($_GET['new']) &&
         strlen($_GET['old']))
      {
        $sql   = array();
        $sql[] = "UPDATE menu_links
                  SET sort='".$_GET['old']."'
                  WHERE sort='".$_GET['new']."' AND
                        categoryID='".$_GET['categoryID']."'";

        $sql[] = "UPDATE menu_links
                  SET sort='".$_GET['new']."'
                  WHERE contentID='".$_GET['linkID']."' AND
                        categoryID='".$_GET['categoryID']."'";

        for($i = 0 ; $i < count($sql) ; ++$i)
        {
          // echo '<pre>'.$sql[$i].'</pre>';
          $this->db->query($sql[$i]);
        }
      }

      $template = & new JxTemplate(JX_MODULE_PATH.'/menu/tpl');
      $template->assign('module',JxModule::getModule($_GET['module']));

      $sql = "SELECT *
              FROM menu_categories
              ORDER BY sort";
      $result = $this->db->query($sql);
      if(!DB::isError($result) && $result->numRows())
      {
        $menu = array();
        $i = 0;
        while($row = $result->fetchRow())
        {
          if($i == 0)
          {
            $row['up'] = ($result->numRows() - 1);
          }
          else
          {
            $row['up'] = ($row['sort'] - 1);
          }

          if(($i + 1) == $result->numRows())
          {
            $row['down'] = 0;
          }
          else
          {
            $row['down'] = $row['sort'] + 1;
          }

          $row['links'] = array();

          $sql = "SELECT *
                  FROM menu_links
                  WHERE categoryID='".$row['contentID']."'
                  ORDER BY sort";

          $lresult = $this->db->query($sql);
          if(!DB::isError($lresult) && $lresult->numRows())
          {
            $n = 0;
            while($lrow = $lresult->fetchRow())
            {
              if($n == 0)
              {
                $lrow['up'] = ($lresult->numRows() - 1);
              }
              else
              {
                $lrow['up'] = ($lrow['sort'] - 1);
              }
              if(($n + 1) == $lresult->numRows())
              {
                $lrow['down'] = 0;
              }
              else
              {
                $lrow['down'] = $lrow['sort'] + 1;
              }

              $row['links'][] = $lrow;

              ++$n;
            }
          }

          $menu[] = $row;
          ++$i;
        }

        $template->assign('menu',$menu);

      }

      return $template->fetch('adminMenuSort.tpl');
    }

    function _JxAdminMenuSort()
    {
      $this->_JxObjectDb();
    }
  }

?>
