<?php

  /**
  * JxFieldHidden
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  */
  class JxFieldHidden extends JxField
  {
    function JxFieldHidden($name,$value)
    {
      $this->JxFIeld($name,$value);
    }

    function getElement()
    {
      return '<input type="hidden" name="'.$this->name.'" value="'.
              $this->value.'">'."\n";
    }

    function render()
    {
      return $this->getElement();
    }
  }

?>
