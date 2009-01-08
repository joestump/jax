<?php


  class JxSingleton_page extends JxSingleton_common
  {
      var $name = 'page';

      function __construct()
      {
          parent::__construct();
      }

      /**
      * JxSingleton_page
      *
      * @author Joe Stump <joe@joestump.net>
      * @access public
      * @return void
      */
      function JxSingleton_page()
      {
          $this->__construct();
      }

      function &singleton()
      {
          static $page = null;
          if (is_null($page)) {
              $page = & new JxPageTemplate();      
          }

          return $page;
      }

      function __destruct()
      {
          parent::__destruct();
      }
  }


?>
