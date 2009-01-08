<?php

  class JxAdminDelete extends JxAdmin
  {
    function JxAdminDelete()
    {
      $this->JxAdmin();
    }

    function render()
    {
      $include = JX_MODULE_PATH.'/'.$_GET['dmodule'].'/admin/'.
                 $_GET['dform'].'.php';

      $template = & new JxTemplate(JX_MODULE_PATH.'/content/tpl');
      $templateFile = 'JxAdminDelete.tpl';
      if(@include($include))
      {
        $class = & new $_GET['dform']();
        if($class->deleteRecord($_GET['id']))
        {
          $template->assign('msg','Your content has been successfully deleted');
        }
        else
        {
          $template->assign('msg','Error deleting content');
        }
      } else {
        $template->assign('msg','Error deleting content');
      }

      return $template->fetch($templateFile);
    }

    function _JxAdminDelete()
    {
      $this->_JxAdmin();
    }
  }

?>
