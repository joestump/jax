<?php

  class JxAdminModules extends JxObjectDb
  {
    function JxAdminModules()
    {
      $this->JxObjectDb();
    }

    function render()
    {
      $template = & new JxTemplate(JX_MODULE_PATH.'/system/tpl');    
      $templateFile = 'JxAdminModules.tpl';

      if(isset($_GET['moduleID']) && isset($_GET['enable']))
      {
        $module = & DB_DataObject::factory('modules');
        if(!PEAR::isError($module))
        {
          $module->moduleID = $_GET['moduleID'];
          $module->available = $_GET['enable'];
          if($module->update())
          {

          }
        }
      }

      $sql = "SELECT *
              FROM modules
              ORDER BY title";
       
      $result = $this->db->query($sql);
      if(!DB::isError($result) && $result->numRows())
      {
        $modules = array();
        while($row = $result->fetchRow())
        {
          $modules[] = $row;
        }

        $template->assign('modules',$modules);
      }

      return $template->fetch($templateFile);
    }

    function _JxAdminModules()
    {
      $this->_JxObjectDb();
    }
  }

?>
