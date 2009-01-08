<?php

  /**
  * JxSingleton_db
  *
  * @author Joe Stump <joe@joestump.net>
  * @package JAX
  * @subpackage Singletons
  * @filesource
  */

  require_once(JX_CORE_PATH.'/includes/Objects/Singletons/db_common.php');

  /**
  * JxSingleton_db
  *
  * @author Joe Stump <joe@joestump.net>
  * @package JAX
  * @subpackage Singletons
  */
  class JxSingleton_db extends JxSingleton_db_common
  {
      var $name = 'db';
    
      function __construct()
      {
          parent::__construct();
          $this->dsn = JX_BASE_DSN;
      }

      function JxSingleton_db()
      {
          $this->__construct();
      }

      function __destruct()
      {
          parent::__destruct();
      }
  }

?>
