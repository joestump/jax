<?php

  /**
  * JxFieldPassword
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  */
  class JxFieldPassword extends JxField
  {
    var $maxLength;
    var $size;

    function JxFieldPassword($name,$value='',$size=15,$maxLength=15)
    {
      $this->JxField($name,$value);
      $this->size      = $size;
      $this->maxLength = $maxLength;      
    }

    function getElement()
    {
      $field = '<input type="password" size="'.$this->size.'" maxlength="'.
               $this->maxLength.'" name="'.$this->name.'" '.
               'accesskey="'.$this->accessKey.'" class="JxFieldPassword"';
       
      if(strlen($this->value))
      {
        $field .= ' value="'.$this->value.'"';
      }

      $field .= '>'."\n";

      return $field;
    }
  }

?>
