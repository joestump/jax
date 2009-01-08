<?php

  /**
  * JxPageTemplate Class
  *
  * A special template class that holds css and javascript files for modules.
  * It's also a singleton class, which allows you to grab it via the generic
  * JxSingleton factory with JxSingleton::factory('page');
  * 
  * @author Joe Stump <joe@joestump.net>
  * @package JxPage 
  */
  class JxPageTemplate extends JxTemplate
  {
    /**
    * $title
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @var string $title
    */
    var $title;

    /**
    * $cssFiles
    *
    * @author Joe Stump <joe@joestump.net>
    * @var mixed $cssFiles
    */
    var $cssFiles;

    /**
    * $jsFiles
    *
    * @author Joe Stump <joe@joestump.net>
    * @var mixed $jsFiles
    */
    var $jsFiles;

    /**
    */
    var $templateFile;

    /**
    * JxPageTemplate
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return void
    */
    function JxPageTemplate()
    {
        if (JX_PATH_MODE === JX_PATH_MODE_DEFAULT) {
            $tplPath = JX_BASE_PATH.'/tpl/'.JX_TEMPLATE;
        } else {
            $tplPath = JX_HOSTED_PATH.'/tpl/'.JX_TEMPLATE;
        }

        $this->JxTemplate($tplPath);
        $this->cssFiles = array();
        $this->jsFiles = array();
        $this->templateFile = 'page.tpl';
    }

    /**
    * addCssFile
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return void
    */
    function addCssFile($file)
    {
      if(!in_array($file,$this->cssFiles))
      {
        $this->cssFiles[] = $file;
      }
    }    

    /**
    * addJsFile
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return void
    */
    function addJsFile($file)
    {
      if(!in_array($file,$this->jsFiles))
      {
        $this->jsFiles[] = $file;
      }
    }

    /**
    * render
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return void
    */
    function render()
    {
      $this->assign('jxTitle',$this->title);
      $this->assign('jxCssFiles',$this->cssFiles);
      $this->assign('jxJsFiles',$this->jsFiles); 
    }
  }

  /**
  * JxSingletonPage
  *
  * Singleton wrapper for the JxPageTemplate class. 
  *
  * @author Joe Stump <joe@joestump.net>
  * @package JxPage
  */
  class JxSingletonPage extends JxSingleton
  {
    /**
    * JxSingletonPage
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return void
    */
    function JxSingletonPage()
    {
      $this->JxSingleton();
      $GLOBALS[$this->name] = & new JxPageTemplate();      
    }
  }

?>
