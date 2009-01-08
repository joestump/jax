<?php

  /**
  * JxFieldString
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  * @see JxFieldText, JxField
  */
  class JxFieldString extends JxFieldText
  {
    var $min = null;
    var $max = null;
    var $mustMatch = null;
    var $mustNotMatch = null;

    function JxFieldString($name,$value='',$size=25,$maxLength=255)
    {
      $this->JxFieldText($name,$value,$size,$maxLength);
    }

    function isValid()
    {
      if($this->min !== null && strlen($this->value) < $this->min)
      {
        $this->errors[] = 'Value must be at least '.$this->min.' '.
                          'characters long.';

        return false;
      }

      if($this->max !== null && strlen($this->value) > $this->max)
      {
        $this->errors[] = 'Value must be no more than '.$this->min.' '.
                          'characters long.';

        return false;
      }
     
      if($this->mustMatch !== null && !eregi($this->mustMatch,$this->value))
      {
        $this->errors[] = 'Value appears to be invalid';

        return false;
      }

      if($this->mustNotMatch !== null && eregi($this->mustNotMatch,$this->value))
      {
        $this->errors[] = 'Value appears to be invalid';

        return false;
      }

      return true;
    }

    function _JxFieldString()
    {
      $this->_JxFieldText();
    }
  }

?>
