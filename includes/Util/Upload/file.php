<?php

  class JxUpload_file extends JxUpload
  {
      function JxUpload_file() 
      {
          $this->JxUpload();
      }

      function _prepareUpload()
      {
          return true;
      }

      function _JxUpload_file() 
      {
          $this->_JxUpload();
      }
  }

?>
