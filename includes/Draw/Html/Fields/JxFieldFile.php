<?php

  /**
  * JxFieldFile
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  */
  class JxFieldFile extends JxField
  {
    var $maxFileSize;

    function JxFieldFile($name,$value,$maxFileSize='3000000')
    {
      $this->JxField($name,'');
      $this->maxFileSize = $maxFileSize;
    }

    function getElement()
    {
      $field = <<< EOT

      <input type="hidden" name="MAX_FILE_SIZE" value="{$this->maxFileSize}">
      <input name="{$this->name}" type="file">

EOT;

      return $field;
    }

    function isValid()
    {
      if($this->required)
      {
        if(!strlen($_FILES[$this->name]['name']))
        {
          $this->errors[] = 'You must upload a file!';
        }
        elseif($_FILES[$this->name]['size'] > $this->maxFileSize)
        {
          $this->errors[] = 'File is too big to upload! ('.$_FILES[$this->name]['size'].' > '.$this->maxFileSize.')';
        }  
      }

      return true;
    }

    function getData()
    {
      return $_FILES[$this->name];
    }
  }

?>
