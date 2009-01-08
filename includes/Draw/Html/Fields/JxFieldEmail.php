<?php

  require_once('Validate.php');

  /**
  * JxFieldEmail
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  */
  class JxFieldEmail extends JxFieldText
  {
    function JxFieldEmail($name,$value='')
    {
      $this->JxFieldText($name,$value);
      $this->label = 'E&mail';
    }

    function isValid()
    {
        if (strlen($this->value)) {
            if (Validate::email($this->value)) {
                return true;
            }
    
            $this->errors[] = 'Email '.$this->value.' appears to be invalid!';
            return false;
        } else {
            if ($this->required) {
                $this->errors[] = 'Email is a required field!';
                return false;
            }
        }
  
        return true;
    }
  }

?>
