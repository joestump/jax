<?php

  /**
  * JxPlugin File
  * 
  * @link http://www.jcssolutions.com
  * @author Joe Stump <joe@joestump.net>
  * @copyright Joe Stump <joe@joestump.net>
  * @filesource
  * @package JAX
  */

  /**
  * JxPlugin Class
  *
  * JAX offers an extremely flexible plugin interface, which allows you
  * to define events in your modules and applications. When your application
  * fires off an event (also called a hook) the plugin interface takes over
  * and calls plugins that have registered with that hook. For instance you
  * could define a hook in your application called 'signup_bottom', which
  * runs at the bottom of your signup event. 
  *
  * The plugin controller would then run any classes that have registered to
  * be ran when that event is fired. All plugins in $JX_PLUGINS (defined in
  * JxConfig.php) are initialized by index.php. Below is an example of how
  * you could define a hook.
  *
  * <code>
  * class foo
  * {
  *   ...
  *
  *   function myEvent()
  *   {
  *     JxPlugin::doHook('my_hook');
  *   }
  * }
  * </code>
  *
  * @author Joe Stump <joe@joestump.net>
  * @package App
  * @see JxConfig.php, JX_PLUGINS
  */  
  class JxPlugin extends JxObjectDb
  {
    // {{{ properties
    /**
    * $name
    *
    * The name of your plugin class. This cannot contain any spaces or funky
    * characters. 
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @var string $name
    */
    var $name;

    /**
    * $title
    *
    * A short title describing your plugin.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @var string $title
    */
    var $title;

    /**
    * $user
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var mixed $user
    */
    var $user;
    // }}}
    // {{{ JxPlugin()
    /**
    * JxPlugin
    * 
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return void
    */
    function JxPlugin()
    {
      $this->JxObjectDb();

      if(!isset($GLOBALS['jax_plugins']) || !is_array($GLOBALS['jax_plugins']))
      {
        $GLOBALS['jax_plugins'] = array();
      }

      $GLOBALS['jax_plugins'][] = get_class($this);
      $this->user = & JxSingleton::factory('user');
    }
    // }}}
    // {{{ registerHook()
    /**
    * registerHook
    *
    * Registers the given $method to be ran during $hookName. A reference to
    * your plugin class is passed along with the method to be ran. This allows
    * you to collect information at one hook and then manipulate/display
    * the data at a later hook.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $hookName
    * @param string $method
    * @return void 
    */
    function registerHook($hookName,$method)
    {
      if (!isset($GLOBALS['jax_hooks']) || !is_array($GLOBALS['jax_hooks'])) {
          $GLOBALS['jax_hooks'] = array();
      }

      if (!isset($GLOBALS['jax_hooks'][$hookName]) || 
          !is_array($GLOBALS['jax_hooks'][$hookName])) {
          $GLOBALS['jax_hooks'][$hookName] = array();
      }

      array_push($GLOBALS['jax_hooks'][$hookName],array(&$this,$method));
    }
    // }}}
    // {{{ doHook()
    /**
    * doHook
    *
    * NOTE: THIS FUNCTION IS ALWAYS RAN STATICALLY. Place this function within
    * your modules to enable plugins wherever you want. By running a hooke you
    * allow arbitrary code to be ran within your application. Some may wonder
    * the possible performance hit this creates; a simple function call and
    * an is_array() at worst.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $hookName
    * @param mixed $classReference
    * @return void
    */
    function doHook($hookName,&$classReference)
    {
      if(isset($GLOBALS['jax_hooks']) && 
         is_array($GLOBALS['jax_hooks'][$hookName]) &&
         count($GLOBALS['jax_hooks'][$hookName]))
      {
        if(!PEAR::isError($classReference))
        {
          $hooksToRun = $GLOBALS['jax_hooks'][$hookName];

          while(list(,$pluginInfo) = each($hooksToRun))
          {
            list($pluginClass,$method) = $pluginInfo;
            $pluginClass->$method($classReference,$hookName);
          }
        }
      }
    }
    // }}}
    // {{{ initializePlugins()
    /**
    * initializePlugins
    *
    * This function is ran statically from the controller file before your
    * module is initialized. THERE IS NO REASON TO RUN THIS FROM YOUR 
    * APPLICATION!
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param mixed $pluginList
    * @return void 
    */
    function initializePlugins()
    {
      $plugins = & DB_DataObject::factory('plugins');
      $log = & JxSingleton::factory('log');
      if(!PEAR::isError($plugins))
      {
        if($plugins->find())
        {
          while($plugins->fetch())
          {

            $pluginFile = JX_HOSTED_PATH.'/modules/'.$plugins->module.
                          '/plugins/'.$plugins->name.'.php';

            // Override if a module specific does not exist
            if (!file_exists($pluginFile)) {
                $pluginFile = JX_CORE_PATH.'/modules/'.$plugins->module.
                              '/plugins/'.$plugins->name.'.php';
            } 

            if (file_exists($pluginFile)) {
                if(!$plugins->available) {
                    continue;
                }

                include_once($pluginFile);
                $class = $plugins->name;  
                if (class_exists($class)) {
                    $instance = & new $class();
                } else {
                    $log->log('Plugin file exists, but no plugin is there!');
                }
            } else {
                $log->log('Plugin file no longer exists, plugin deleted!');
                $plugins->delete();
            }
          }
        }
      }
    }
    // }}}
    // {{{ isValid()
    /**
    * isValid
    *
    * Called statically to tell whether or not a given plugin is valid. This
    * basically means the plugin file exists.
    * 
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $pluginName
    * @return bool
    */
    function isValid($pluginName)
    {
      return (class_exists($pluginName));
    }
    // }}}
    // {{{ _JxPlugin()
    /**
    * _JxPlugin
    *
    * @author Joe Stump <joe@joestump.net>
    * @access private
    * @return void 
    */
    function _JxPlugin()
    {
      $this->_JxObjectDb();
    }
    // }}}
  }

?>
