<?php

  /**
  * JxHbox Class
  *
  * A simple horizontal box class, similar to GTK+'s hbox widget. Basically it
  * takes a list of components and lists them in a single table horizontally.
  * 
  * @author Joe Stump <joe@joestump.net>
  * @package HtmlForm
  */
  class JxHbox extends JxObjectDraw
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
    */
    var $name;

    /**
    * JxHbox Constructor
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $name
    * @return void;
    */
    function JxHbox($name='')
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
    * @return string $hbox
    */
    function render()
    {
      $hbox  = '<table class="JxHbox'.$this->name.'">'."\n";
      $hbox .= '<tr>'."\n"; 

      for($i = 0 ; $i < count($this->components) ; ++$i)
      {
        $hbox .= '<td class="JxHbox'.$this->name.'td" valign="top">'."\n";
        
        if(is_object($this->components[$i]) && 
           method_exists($this->components[$i],'render'))
        {
          $hbox .= $this->components[$i]->render();
        }

        $hbox .= '</td>'."\n";
      }

      $hbox .= '</tr>'."\n";
      $hbox .= '</table>'."\n";
      
      return $hbox;
    }
  }


?>
