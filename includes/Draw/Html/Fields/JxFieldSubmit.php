<?php
  /**
  * JxFieldSubmit Class File
  *
  * @author Joe Stump <joe@joestump.net>
  * @package JAX
  * @version 1.0
  * @filesource
  */

  /**
  * JxFieldSubmit Class
  *
  * The JxField class for a simple HTML submit button.
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  * @version 1.0
  */
  class JxFieldSubmit extends JxField
  {
    /**
    * JxFieldSubmit Constructor
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $name
    * @param string $label
    * @return void
    * @see JxField, JxField::JxField()
    */
    function JxFieldSubmit($name,$label)
    {
      $this->JxField($name,$label);
      $this->label = $label;
    }

    /**
    * getElement
    *
    * Simply return the HTML for the input
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return string
    * @see JxField::$label, JxField::$type, JxField::$name 
    */
    function getElement()
    {
      return '<input type="submit" name="'.$this->name.'" '.
             'value="'.$this->label.'" class="'.$this->type.'">'."\n";
    }

    /**
    * render
    *
    * Override the default render since submit buttons don't have labels
    * and are usually presented differently. If you'd like to make your
    * own submit button you could extend this class and override default values
    * for a most customized button.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return void
    * @see JxField::render()
    */
    function render()
    {
      $ret .= '<tr>
                 <td colspan="2" class="'.$this->type.'">'.
                 $this->getElement().'</td>
               </tr>'."\n";

      return $ret;
    }
  }

?>
