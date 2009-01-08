<?php

  /**
  * JxSingleton_enotes
  *
  * @author Joe Stump <joe@joestump.net>
  * @package JAX
  * @subpackage Singletons
  * @filesource
  */

  require_once(JX_BASE_PATH.'/includes/Objects/Singletons/db_common.php');

  /**
  * JxSingleton_enotes
  *
  * @author Joe Stump <joe@joestump.net>
  * @package JAX
  * @subpackage Singletons
  */
  class JxSingleton_enotes extends JxSingleton_db_common
  {
      var $name = 'enotes';
      var $dsn = 'mysql://root@192.168.10.10/enotes_com';
    
      function __construct()
      {
          parent::__construct();
      }

      function JxSingleton_enotes()
      {
          $this->__construct();
      }

      function __destruct()
      {
          parent::__destruct();
      }
  }

?>
