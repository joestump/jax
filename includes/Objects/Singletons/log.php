<?php

  /**
  * JxSingleton_log 
  *
  * @author Joe Stump <joe@joestump.net>
  * @package JAX
  * @subpackage Singletons
  * @filesource 
  */

  /**
  * JxSingleton_log 
  *
  * @author Joe Stump <joe@joestump.net>
  * @package JAX
  * @subpackage Singletons
  */
  class JxSingleton_log extends JxSingleton_common
  {
      var $name = 'log';

      function __construct()
      {
          parent::__construct();
      }

      /**
      * JxSingleton_log
      *
      * @author Joe Stump <joe@joestump.net>
      * @access public
      * @return void
      */
      function JxSingleton_log()
      {
          $this->__construct();
      }

      function &singleton()
      {
          static $log = null;
          if (is_null($log)) {
              $log = &  Log::singleton('file',JX_BASE_LOG,'JAX');
          }

          return $log;
      }

      function __destruct()
      {
          parent::__destruct();
      }
  }

?>
