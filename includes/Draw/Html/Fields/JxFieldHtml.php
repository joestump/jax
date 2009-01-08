<?php

  /**
  * JxFieldHtml
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  */
  class JxFieldHtml extends JxField
  {
    var $html;
    var $bgcolor;
    
    function JxFieldHtml($html)
    {
      $this->JxField('html',$html);
      $this->html = $html;
      $this->bgcolor = null;
    }

    function getElement()
    {
      return $this->html;
    }

    function render()
    {
      $ret .= '<table width="100%" cellspacing="0" cellpadding="0">
               <tr>
                 <td ';

      if($this->bgcolor !== null)
      {
        $ret .= 'bgcolor="'.$this->bgcolor.'"';
      }

      $ret .= 'class="JxFieldHtml">'.$this->getElement().'</td>
               </tr></table>'."\n";

      return $ret;
    }
  }

?>
