<?php

  /**
  * JxSingleton_user 
  *
  * @author Joe Stump <joe@joestump.net>
  * @package JAX
  * @subpackage Singletons
  * @filesource
  */


  /**
  * JxSingleton_user 
  *
  * @author Joe Stump <joe@joestump.net>
  * @package JAX
  * @subpackage Singletons
  */
  class JxSingleton_user extends JxSingleton_common
  {
      var $name = 'user';

      /**
      * __construct
      *
      * Create an instance of the JxUser class based on the value of 
      * $_COOKIE['jax_userID'].
      * 
      * @author Joe Stump <joe@joestump.net> 
      * @access public
      * @return void
      */
      function __construct()
      {
          parent::__construct();
      } 

      /*
      * JxSingleton_user
      *
      * @author Joe Stump <joe@joestump.net> 
      */
      function JxSingleton_user()
      {
          $this->__construct();
      }

      function &singleton()
      {
          static $user = null;
          if ($user === null) {
              if (JxSession::isValid() && 
                  isset($_COOKIE['jax_userID']) && 
                  is_numeric($_COOKIE['jax_userID'])) {
                  $user = & new JxUser((int)$_COOKIE['jax_userID']);
              } else {
                  $user = & new JxUser(0);
              }
          }

          return $user;
      }

      function __destruct()
      {
          parent::__destruct();
      }
  }

?>
