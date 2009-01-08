<?php

  /**
  * JxFieldStatic
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  * @see JxField
  */
  class JxFieldStatic extends JxField
  {
    var $title;

    function JxFieldStatic($name,$value)
    {
      $this->JxField($name,$value);
      $title = null;
    }

    function getElement()
    {
      $show = ($this->title !== null) ? $this->title : $this->value;

      return '<b>'.$show.'</b> <input type="hidden" name="'.$this->name.'" '.
             'value="'.$this->value.'">'."\n";
    }

    function _JxFieldStatic($name,$value)
    {
      $this->_JxField($name,$value);
    }
  }

?>
