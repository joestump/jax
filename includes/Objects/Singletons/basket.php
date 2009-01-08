<?php

  class JxSingleton_basket extends JxSingleton_common
  {
      var $db;
      var $user;

      function __construct()
      {
          parent::__construct();
        
          $this->db   = & JxSingleton::factory('db');
          $this->user = & JxSingleton::factory('user');
      }

      function JxSingleton_basket()
      {
          $this->__construct();
      }

      function &singleton()
      {
          static $baskets;

          if (isset($_COOKIE['basketID']) && is_numeric($_COOKIE['basketID'])) {
              $sql = "SELECT COUNT(*) AS total
                      FROM basket
                      WHERE basketID=".$_COOKIE['basketID'];

              $result = $this->db->getOne($sql);
              if (!PEAR::isError($result) && is_numeric($result) && 
                  $result > 0) {
                  $basketID = $_COOKIE['basketID'];
                  if (isset($baskets[$basketID]) &&
                      is_object($baskets[$basketID])) {
                      // Do nothing - the basket already exists    
                  } else {
                      $baskets[$basketID] = & new JxBasket($basketID);  
                  }
              } else {
                  $basketID = 0;
              }
          }

          if ($basketID == 0) {
              $basketID = JxCreateId('basket','basketID');
              $userID   = $user->userID;
              $posted   = time();
              $type     = 0;

              if ((int)$basketID > 0) {
                  $sql = "INSERT INTO basket
                          SET basketID='".(int)$basketID."',
                              userID='".$userID."',
                              posted='".$posted."',
                              type='".$type."'";

                  $result = $this->db->query($sql);
                  if (PEAR::isError($result)) {
                      return PEAR::raiseError('Unable to create basket');
                  } else {
                      JxHttp::setCookie('basketID',$basketID);
                  }
              }

              $baskets[$basketID] = & new JxBasket($basketID);
          }

          return $baskets[$basketID];
      }

      function __destruct()
      {
          parent::__destruct();
      }
  }


?>
