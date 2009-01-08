<?php


  /**
  * JxFieldCheckbox
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  */
  class JxFieldCheckbox extends JxField
  {
    var $list;
    var $break;

    function JxFIeldCheckbox($name,$list,$value='',$break=3)
    {
      $this->JxField($name,$value);
      $this->list  = $list; 
      $this->break = $break;
    }

    function getElement()
    {
      $ret  = '<table class="'.$this->name.'" width="100%" border="0">'."\n";
      $ret .= '<tr>'."\n";
      while(list($key,$val) = each($this->list))
      {
        if((is_array($this->value) && in_array($key,$this->value)) || 
           ($this->value == $key))
        {
          $checked = ' checked';
        }
        else
        {
          $checked = '';
        }

        $ret .= '<td>
                   <input type="checkbox" name="'.$this->name.'" '.
                'value="'.$key.'" '.$checked.'> </td><td>'.$val.' 
                 </td>'."\n";
                  
        if(++$i % $this->break == 0)
        {
          $ret .= '</tr><tr>'."\n";
        }  
      }
      $ret .= '</tr>'."\n";
      $ret .= '</table>';

      return $ret;
    }

    function _JxFIeldCheckbox()
    {
      $this->_JxField();
    }
  }


?>
