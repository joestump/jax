<?php

  /**
  * JxVbox Class
  *
  * Similar to GTK+'s vbox. Simply takes its list of components, renders them,
  * and then returns the rendered box.
  *
  * @author Joe Stump <joe@joestump.net>
  * @package HtmlForm
  */
  class JxVbox extends JxObjectDraw
  {
    /**
    * name
    *
    * Name referenced in CSS for the specific JxHbox. Leave blank if you'd
    * like all Hbox's to have the same CSS styles. You can change the specific
    * style of this hbox by referencing table.JxHbox$name and td.JxHbox$name.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @see JxVbox::JxVbox()
    */
    var $name;

    /**
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $name
    * @return void
    * @see $name
    */
    function JxVbox($name='')
    {
      $this->JxObjectDraw();
      $this->name = $name;
    }

    /**
    * render
    *
    * Renders all of the child components and then returns the data.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return string $vbox
    */
    function render()
    {
      $vbox  = '<table class="JxVbox'.$this->name.'">'."\n";

      for($i = 0 ; $i < count($this->components) ; ++$i)
      {
        $vbox .= '<tr>'."\n"; 
        $vbox .= '<td class="JxVbox'.$this->name.'td">'."\n";
        
        if(is_object($this->components[$i]) && 
           method_exists($this->components[$i],'render'))
        {
          $vbox .= $this->components[$i]->render();
        }

        $vbox .= '</td>'."\n";
        $vbox .= '</tr>'."\n";
      }

      $vbox .= '</table>'."\n";
      
      return $vbox;
    }
  }


?>
