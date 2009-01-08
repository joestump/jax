<?php

  /**
  * JxHtmlFormContainer
  *
  * @author Joe Stump <joe@joestump.net>
  * @package HtmlForm
  */
  class JxHtmlFormContainer extends JxObjectDraw
  {
    var $name;
    var $label;

    function JxHtmlFormContainer($name)
    {
      $this->JxObjectDraw();
      $this->name = $name;
    }

    function render()
    {
      $cont .= '<fieldset>'."\n";
      if(strlen($this->label))
      {
        $cont .= '<legend>'.$this->label.'</legend>'."\n";
      }

      $cont .= '<table class="jxHtmlFormContainer" cellspacing="0">'."\n";
      $cont .= '<tr><td>'."\n";      
 
      for($i = 0 ; $i < count($this->components) ; ++$i)
      {
        $cont .= $this->components[$i]->render();
      }

      $cont .= '</td></tr>'."\n";      
      $cont .= '</table>'."\n";
      $cont .= '</fieldset>'."\n";

      return $cont;
    }
  }

?>
