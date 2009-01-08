<?php

  class JxNewsWelcome extends JxPlugin
  {
      function JxNewsWelcome()
      {
          $this->JxPlugin();

          $this->registerHook('welcome','welcome');
      }

      function welcome(&$module) 
      {
          $content = & new JxContent('news');
          $userID = JxModuleConfig::get('blog','BLOG_DEFAULT_USER');
          if ($userID !== false) {
              $content->userID = $userID;
          }

          $content->orderBy('content.posted DESC');
          if ($content->find()) {
              $news = array();
              while($content->fetch()) {
                  $content->getLinks();
                  $news[] = $content->toArray();
              }

              $tplPath = JX_HOSTED_PATH.'/modules/news/tpl';
              $module->template = & new JxTemplate($tplPath);
              if (!PEAR::isError($module->template)) {
                  $module->templateFile = 'news.tpl';
              } 
          }

          $entries = array('entries' => $news);
          $module->template->assign('news',$entries);
      }

      function _JxNewsWelcome()
      {
          $this->_JxPlugin();
      }
  }

?>
