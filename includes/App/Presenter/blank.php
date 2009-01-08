<?php

  class JxPresenter_blank extends JxPresenter
  {
    var $template     = null;

    function JxPresenter_blank()
    {
      $this->JxPresenter();
    }

    function render(&$module)
    {
      $user = JxSingleton::factory('user');
      $page = JxSingleton::factory('page');

      $module->template->assign('user',$user);
      $module->template->assign('page',$page);
      $module->template->display($module->templateFile);
    }

    function _JxPresenter_blank()
    {
      $this->_JxPresenter();
    }
  }

?>
