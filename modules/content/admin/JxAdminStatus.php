<?php

  class JxAdminStatus extends JxObjectDb
  {
    function JxAdminStatus()
    {
      $this->JxObjectDb();
    }

    function render()
    {
      $user = & JxSingleton::factory('user');

      $template = & new JxTemplate(JX_BASE_PATH.'/modules/content/tpl');
      $templateFile = 'JxAdminStatus.tpl';
  
      if((int)$_GET['contentID'] > 0)
      {
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
          $sql = "UPDATE content
                  SET available='".$_GET['available']."'
                  WHERE contentID='".$_GET['contentID']."'";

          $result = $this->db->query($sql);
          if(!DB::isError($result))
          {
            $template->assign('msg','Status has been updated!');
          }
          else
          {
            $template->assign('msg','ERROR: status has not been updated!');
          }
        }
        else
        {
          $template->assign('msg','ERROR: you have no perms!');
        }
      }       

      return $template->fetch($templateFile);
    }

    function _JxAdminStatus()
    {
      $this->_JxObjectDb();
    }
  }

?>
