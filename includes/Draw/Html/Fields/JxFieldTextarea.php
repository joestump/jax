<?php

  /**
  * JxFieldTextarea
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  * @see JxField
  */
  class JxFieldTextarea extends JxField
  {
    var $cols;
    var $rows;

    function JxFieldTextarea($name,$value='',$cols=35,$rows=7)
    {
      $this->JxField($name,$value);
      $this->cols = $cols;
      $this->rows = $rows;    
    }

    function getElement()
    {
      $field = '<textarea class="b4FieldTextarea" name="'.$this->name.'" '.
               'accesskey="'.$this->accessKey.'" cols="'.$this->cols.'" '.
               'rows="'.$this->rows.'">'."\n";

      $field .= $this->value;

      $field .= '</textarea>'."\n";

      return $field;
    }
  }

?>
