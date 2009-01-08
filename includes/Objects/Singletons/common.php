<?php


  class JxSingleton_common 
  {
      var $name = null;

      function __construct()
      {
          
      }      

      function JxSingleton_common()
      {
          $this->__construct();
      }

      function &singleton()
      {
          return PEAR::raiseError('Singleton not implemented');
      }

      function __destruct()
      {

      }
  }

?>
