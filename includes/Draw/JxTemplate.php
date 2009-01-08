<?php

  require_once(SMARTY_DIR.'Smarty.class.php');

  /**
  * JxTemplate
  *
  * JxTemplate is a simple wrapper for the Smarty class that allows you to
  * quickly create instances of Smarty templates with differing paths. Modules
  * create an instance with one path and then feed into a page template with
  * another instance with a different path. 
  *
  * @author Joe Stump <joe@joestump.net>
  * @package Draw
  */
  class JxTemplate extends Smarty
  {
    /**
    * templatePath
    *
    * Root path that should be used for the template. JxTemplate::JxTemplate()
    * will automatically set up the various Smarty template directories.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access private
    */
    var $templatePath;

    /**
    * JxTemplate Constructor
    *
    * Sets up the Smarty template engine's various directories. If you would
    * like to make sitewide changes to the Smarty template engine this is the
    * place to do it. 
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $templatePath
    * @return void
    */
    function JxTemplate($templatePath)
    {
      if (is_dir($templatePath)) {
        $this->Smarty();    
        $this->template_dir = $templatePath.'/templates';
        $this->compile_dir = $templatePath.'/templates_c';
        $this->config_dir = $templatePath.'/config';
        $this->cache_dir = $templatePath.'/cache';
        $this->templatePath = $templatePath;
      } else {
        $log = & JxSingleton::factory('log');
        $log->log('Invalid template directory: '.$templatePath);
      }
    }
  }

?>
