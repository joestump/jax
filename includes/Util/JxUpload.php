<?php

  class JxUpload extends JxObject
  {
      var $sourceFile = null;
      var $destFile = null;

      function JxUpload()
      {
          $this->JxObject();
      }

      function &factory($class)
      {
          $file = JX_CORE_PATH.'/includes/Util/Upload/'.$class.'.php';
          if (include_once($file)) {
              $class = 'JxUpload_'.$class;
              if (class_exists($class)) {
                  return new $class(); 
              }
          }

          return PEAR::raiseError('Invalid upload class: '.$class);
      }

      function upload()
      {
          $result = $this->_prepareUpload();
          if (!PEAR::isError($result)) {
              if (is_uploaded_file($this->sourceFile)) {
                  $baseDir = dirname($this->destFile);
                  if ($this->_isValidUploadDir($baseDir)) {
                      $s = $this->sourceFile;
                      $d = $this->destFile;
                      if (move_uploaded_file($s,$d)) {
                          return true;
                      }
                  } else {
                      return PEAR::raiseError('Invalid dir or lack of permissions on destination directory: '.$baseDir);
                  }
              } else {
                  return PEAR::raiseError('Invalid upload file: '.$this->sourceFile);
              }
          } else {
              return $result;
          }
      }

      function _prepare()
      {
          return PEAR::raiseError('_prepareUpload() not implemented');
      }

      function _isValidUploadDir($dir)
      {
          return (is_dir($dir) && is_writable($dir));
      }

      function _JxUpload()
      {
          $this->_JxObject();
      }
  }

?>
