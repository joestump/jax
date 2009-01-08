<?php

  /**
  * JxFieldNumber
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  * @see JxFieldText, JxField
  */
  class JxFieldNumber extends JxFieldText
  {
    var $range = array(); // Number must be in a certain range (inclusive)
    var $type  = null;    // Typecast the value in getData()
    var $max   = null;    // Number must be less than or equal to
    var $min   = null;    // Number must be greater than or equal to

    function JxFieldNumber($name,$value='',$size=25,$maxLength=255)
    {
      $value = eregi_replace('[\$,]','',$value); // Remove dollar signs 
      $this->JxFieldText($name,$value,$size,$maxLength);
    }

    function getData()
    {
      switch($this->type)
      {
        case 'float':
          return (float)$this->value;
          break;
        case 'int':
          return (int)$this->value;
        default:
          return $this->value;
      }
    }

    function isValid()
    {
      if(!is_numeric($this->value))
      {
        $this->errors[] = 'Must be a numeric value';
        return false;
      }
      else
      {
        if(count($this->range) == 2)
        {
          if(($this->value >= $this->range[0]) && 
             ($this->value <= $this->range[1]))
          {
            // do nothing - we might have more checking to do
          }
          else
          {
            $this->errors[] = 'Number is out of range ('.$this->range[0].' '.
                              'to '.$this->range[1].')';

            return false;
          }
        }

        if(($this->min !== null) && 
           ($this->value < $this->min))
        {
          $this->errors[] = 'Number must be at least '.$this->min;
          return false;
        }

        if(($this->max !== null) && 
           ($this->value > $this->max))
        {
          $this->errors[] = 'Number must be less than '.$this->max;
          return false;
        }
      }

      return true;
    }

    function _JxFieldNumber()
    {
      $this->_JxFieldText();
    }
  }

?>
