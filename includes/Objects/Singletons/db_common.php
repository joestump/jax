<?php

  /**
  * JxSingleton_db_common
  *
  * @author Joe Stump <joe@joestump.net>
  * @package JAX
  * @subpackage Singletons
  * @filesource
  */

  /**
   * JxSingleton_db_common
   *
   * @author Joe Stump <joe@joestump.net>
   * @package JAX
   * @subpackage Singletons
   */
  class JxSingleton_db_common extends JxSingleton_common
  {
      var $name = null;
      var $dsn = null;
    
      function __construct()
      {
          parent::__construct();
      }

      function JxSingleton_db_common()
      {
          $this->__construct();
      }

      function &singleton()
      {
          static $db = array();
          if (is_string($this->name) && 
              is_string($this->dsn) && 
              !isset($db[$this->name])) {
              $db[$this->name] = DB::connect($this->dsn);
              if (!PEAR::isError($db[$this->name])) {
                  $db[$this->name]->setFetchMode(DB_FETCHMODE_ASSOC);
                  $db[$this->name]->_default_error_mode = PEAR_ERROR_CALLBACK;
                  $db[$this->name]->_default_error_options = 'JxLogDbError';
              } else {
                  die($db[$this->name]->getMessage());
              }

          }

          return $db[$this->name];
      }

      function __destruct()
      {
          parent::__destruct();
      }
  }

  // {{{ JxLogDbError()
  /**
  * JxLogDbError
  *
  * PEAR callback function to log bad SQL queries.
  *
  * @author Joe Stump <joe@joestump.net>
  * @param mixed $error
  */
  function JxLogDbError($error) {
      $log = & JxSingleton::factory('log');
      if (!PEAR::isError($log) && PEAR::isError($error)) {
          $message = trim(str_replace("\n",'',$error->userinfo));
          $message = ereg_replace('[ ]+',' ',$message);
          $log->log($message);
      }
  }
  // }}}

?>
