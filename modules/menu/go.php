<?php

  class go extends JxAuthNo
  {
    function go()
    {
      $this->JxAuthNo();

      if((int)$_GET['linkID'] > 0)
      {
        $sql = "SELECT *
                FROM menu_links
                WHERE contentID='".$_GET['linkID']."'";

        $result = $this->db->query($sql);
        if(!DB::isError($result) && $result->numRows())
        {
          $row = $result->fetchRow();
           
          $sql = "UPDATE menu_links
                  SET hits=(hits + 1)
                  WHERE contentID='".$_GET['linkID']."'";

          $result = $this->db->query($sql);
          $go = $row['url'];          
        }
      }
      elseif((int)$_GET['categoryID'] > 0)
      {
        $sql = "SELECT *
                FROM menu_categories
                WHERE contentID='".$_GET['linkID']."'";

        $result = $this->db->query($sql);
        if(!DB::isError($result) && $result->numRows())
        {
          $row = $result->fetchRow();
           
          $sql = "UPDATE menu_categories
                  SET hits=(hits + 1)
                  WHERE contentID='".$_GET['linkID']."'";

          $result = $this->db->query($sql);
          $go = $row['url'];          
        }
      }

      if(!eregi('^http',$go))
      {
        $go = $_SERVER['SCRIPT_NAME'].$go;
      }

      header("Location: $go");
      exit();

    }

    function _go()
    {
      $this->_JxAuthNo();
    }
  }

?>
