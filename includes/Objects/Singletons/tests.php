<?php

  /**
  * JxSingleton_tests
  *
  * @author Joe Stump <joe@joestump.net>
  * @package JAX
  * @subpackage Singletons
  * @filesource
  */

  require_once(JX_BASE_PATH.'/includes/Objects/Singletons/db_common.php');

  /**
  * JxSingleton_tests
  *
  * @author Joe Stump <joe@joestump.net>
  * @package JAX
  * @subpackage Singletons
  */
  class JxSingleton_tests extends JxSingleton_db_common
  {
      var $name = 'tests';
      var $dsn = 'mysql://root@192.168.10.10/tests';
    
      function __construct()
      {
          parent::__construct();
      }

      function JxSingleton_tests()
      {
          $this->__construct();
      }

      function __destruct()
      {
          parent::__destruct();
      }
  }

?>
