<?php

  class JxPresenter_smarty extends JxPresenter
  {
    var $template     = null;

    function JxPresenter_smarty()
    {
      $this->JxPresenter();
    }

    function render(&$module)
    {
      $user = & JxSingleton::factory('user');
      $page = & JxSingleton::factory('page');

      if (PEAR::isError($page)) {
          $this->log->log($page->getMessage());
          die($page->getMessage());
      }


      $this->template = & JxSingleton::factory('page');
      $this->template->addCssFile(JX_PG_TPL_PATH.'/css/JxForm.css');
      $this->template->addCssFile(JX_PG_TPL_PATH.'/css/JxModule.css');
      $this->template->addJsFile(JX_PG_TPL_PATH.'/javascript/JAX.js');


      $module->template->assign('user',$user);
      $module->template->assign('page',$page);

      $moduleContent = $module->template->fetch($module->templateFile);
      if (!$module->displayPage) {
          $templateFile = 'nopage.tpl';
      } else {
          $templateFile = $page->templateFile;
      }

      if (!PEAR::isError($this->template)) {
          $this->template->render();
          $this->template->assign($module->name,$module->data);
          $this->template->assign('module',$moduleContent);
          $this->template->assign('user',$user);
          $this->template->display($templateFile);
      }
    }

    function _JxPresenter_smarty()
    {
      $this->_JxPresenter();
    }
  }


?>
