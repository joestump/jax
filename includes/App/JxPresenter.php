<?php


  class JxPresenter extends JxObject
  {
    function JxPresenter()
    {
      $this->JxObject();
    }  

    function factory($type)
    {
      $file = JX_CORE_PATH.'/includes/App/Presenter/'.$type.'.php';
      if(include($file))
      {
        $class = 'JxPresenter_'.$type;
        if(class_exists($class))
        {
          return new $class();
        }
      }

      return new PEAR_Error('Invalid presenter');
    }

    function _JxPresenter()
    {
      $this->_JxObject();
    }  
  }

?>
