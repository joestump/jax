<?php

  require_once('Image/Transform.php');

  class JxUpload_image extends JxUpload
  {
      var $imageDir = null;
      var $transformDriver = 'IM';
      var $thumbSize = 200;

      function JxUpload_image()
      {
          $this->JxUpload();
      }

      function _prepareUpload()
      {
          if ($this->imageDir !== null && 
              $this->_isValidUploadDir($this->imageDir)) {          

              $dir1 = substr($this->destFile,0,2);
              $dir2 = $dir1.'/'.substr($this->destFile,2,2);

              $dir1 = $this->imageDir.'/'.$dir1;
              $dir2 = $this->imageDir.'/'.$dir2;

              if (!is_dir($dir1)) {
                  if(!mkdir($dir1,0777)) {
                      return PEAR::raiseError('Could not create: '.$dir1);
                  }
              }

              if (!is_dir($dir2)) {
                  if(!mkdir($dir2,0777)) {
                      return PEAR::raiseError('Could not create: '.$dir2);
                  }
              }

              $im = Image_Transform::factory($this->transformDriver);
              if (!PEAR::isError($im)) {
                  $result = $im->load($this->sourceFile);
                  if (!PEAR::isError($result)) {

                      $result = $im->scale($this->thumbSize);
                      if (!PEAR::isError($result)) {
                          $thumb = $dir2.'/t_'.$this->destFile;     
                          $result = $im->save($thumb);
                          if (!PEAR::isError($result)) {
                              $im->free();
                          } else {
                              return $result;
                          }
                      } else {
                          return $result;
                      }
                  } else {
                      return $result;
                  }
              } else {
                  return $im;
              }

              $this->destFile = $dir2.'/'.$this->destFile;

              return true;

          } else {
              return PEAR::raiseError('Invalid image directory: '.$this->imageDir);
          }
      }

      function _JxUpload_image()
      {
          $this->_JxUpload();
      }
  }

?>
