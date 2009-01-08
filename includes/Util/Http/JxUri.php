<?php

  /**
  * URI Class
  *
  * @link http://www.jcssolutions.com
  * @author Joe Stump <joe@joestump.net>
  * @copyright Joe Stump <joe@joestump.net> 
  * @package JAX
  * @filesource
  */

  /**
  * URI Class
  *
  * A basic class for manipulating and extracting data from the URI. PLEASE
  * NOTE THAT ALL FUNCTIONS ARE CALLED STATICALLY!
  *
  * @author Joe Stump <joe@joestump.net>
  * @package Http
  */
  class JxUri
  {
    /**
    * getModule
    *
    * Return the module that we need to run. If the defined module is invalid
    * an error will be thrown. If no module is defined the default module will
    * be ran.
    *
    * @author Joe Stump <joe@joestump.net>
    * @return string 
    */
    function getModule()
    {
      if(isset($_SERVER['PATH_INFO']))
      {
        $parts = explode('/',$_SERVER['PATH_INFO']);  
        return $parts[1];
      }
    } 

    /**
    * getClass
    *
    * If you would like to use something besides $jxModule.'.php' as your class
    * then type /modules/submodule to use a different class include.
    *
    * @author Joe Stump <joe@joestump.net>
    * @return string
    */
    function getClass()
    {
      $parts = explode('/',$_SERVER['PATH_INFO']);
      if(isset($parts[2]) && !ereg('=',$parts[2]))
      {
        return $parts[2];
      }
    }

    /**
    * getHandler
    *
    * You can define an alternate handler to run for a given module. For 
    * instance if your module "foo" has a default handler of "run", but you
    * wish to run the handler "bar" the controller script will run the 
    * function "bar" in your class "foo". eventHandler is passed via the URI.
    *
    * @author Joe Stump <joe@joestump.net>
    * @return string 
    * @see URI::parseURI()
    */
    function getHandler()
    {
      if(isset($_GET['eventHandler']) && !empty($_GET['eventHandler']))
      {
        return $_GET['eventHandler'];
      }
    }

    /**
    * parseURI
    *
    * Parses the URI for $_GET arguments and adds them to the global $_GET
    * variable. Valid variable/value paris would look like the following:
    * http://example.com/index.php/module/variable=value. If the variable
    * is already defined in $_GET it WILL NOT BE OVERWRITTEN!
    *
    * @author Joe Stump <joe@joestump.net>
    * @return void
    */
    function parseURI()
    {
      $parts = explode('/',$_SERVER['PATH_INFO']);
      if(is_array($parts) && count($parts))
      {
        for($i = 2 ; $i < count($parts) ; ++$i)
        {
          if(ereg('=',$parts[$i]))
          {
            list($var,$val) = explode('=',$parts[$i]);
            if(!isset($_GET[$var]))
            {
              $_GET[$var] = urldecode($val);
            }
          }
        }
      }
    }
  }

?>
