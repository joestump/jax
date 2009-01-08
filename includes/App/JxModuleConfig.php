<?php

  require_once('DB/DataObject.php');

  class JxModuleConfig extends JxObjectDb
  {
    function JxModuleConfig()
    {
      $this->JxObjectDb();
    }

    function set($module,$var,$value)
    {
      $config = & DB_DataObject::factory('modules_config');
      if(!PEAR::isError($config))
      {
        $config->module = $module;
        $config->var    = $var;
        $config->value  = $value;
        if($config->insert())
        {
          return true;
        }
      }

      return false;
    }

    function get($module,$var)
    {
        $config = & DB_DataObject::factory('modules_config');
        if (!PEAR::isError($config)) {
            $config->module = $module;
            $config->var    = $var;
  
            if($config->find(true)) {
                return $config->value;
            } 
        }

        return false;
    }

    function loadDefaults($module,$defaults)
    {
      while(list($key,$val) = each($defaults))
      {
        JxModuleConfig::set($key,$val);        
      }
    }

    function _JxModuleConfig()
    {
      $this->_JxObjectDb();
    }
  } 

?>
