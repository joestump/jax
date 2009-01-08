<?php

  class logout extends JxAuthUser
  {
      function logout()
      {
          $this->JxAuthUser();
      }

      function __default()
      {
          $session = new JxSession();
          if(!JxSession::isError($session))
          {
              $session->destroy();
              JxHttp::redirect();
          }
      }

      function _logout()
      {
          $this->_JxAuthUser();
      }
  }

?>
