<?php

  /**
  * JxFieldText
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  * @see JxField
  */
  class JxFieldText extends JxField
  {
    /**
    * $deleteOnFocus
    *
    * If this is set to text (ie. 'Search Site') and $value is null then 
    * the field's value will be set to 'Search Site' and erased when the field
    * is clicked.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    */
    var $deleteOnFocus;

    /**
    * $size
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    */
    var $size;

    /**
    * $maxLength
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    */
    var $maxLength;

    function JxFieldText($name,$value='',$size=25,$maxLength=255)
    {
      $this->JxField($name,$value);
      $this->size      = $size;
      $this->maxLength = $maxLength;      
      $this->deleteOnFocus = null;
    }

    function getElement()
    {
      $field = '<input type="text" size="'.$this->size.'" maxlength="'.
               $this->maxLength.'" name="'.$this->name.'" '.
               'accesskey="'.$this->accessKey.'" class="JxFieldText"';
       
      if(strlen($this->value))
      {
        $field .= ' value="'.$this->value.'"';
      }
      else
      {
        if($this->deleteOnFocus !== null)
        {
          $field .= 'value="'.$this->deleteOnFocus.'" onFocus="'.
                    "if (this.value=='".addslashes($this->deleteOnFocus)."') ".
                    "this.value='';".'"';
        }
      }
      

      $field .= '>'.'&nbsp;'.$this->help."\n";
      $this->help = null;

      return $field;
    }

    function setDeleteOnFocus($text)
    {
      if($this->value == $text)
      {
        $this->value = '';
      }

      $this->deleteOnFocus = $text;
    }
  }

?>
