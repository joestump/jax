<?php 

  class welcome extends JxAuthNo 
  {
      function welcome()
      {
          $this->JxAuthNo();


//          if (JX_PATH_MODE === JX_PATH_MODE_HOSTED) {
//              $this->displayPage = false;
//              $this->presenter = 'blank';
//          }
      }


      function __default()
      {
          JxPlugin::doHook('welcome',&$this);
      }

      function _welcome()
      {
          $this->_JxAuthNo();
      }
  }

?>
