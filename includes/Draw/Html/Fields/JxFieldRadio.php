<?php


  /**
  * JxFieldRadio
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  */
  class JxFieldRadio extends JxField
  {
    /**
    * $list
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var mixed $list
    */
    var $list;

    var $listError;

    /**
    * $break
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var int $break
    */
    var $break;

    function JxFieldRadio($name,$list,$value='',$break=3)
    {
      $this->JxField($name,$value);
      $this->list  = $list; 
      $this->break = $break;
      $this->listError = 'Invalid List';
    }

    function getElement()
    {
      if(is_array($this->list) && count($this->list))
      {
        
        $ret  = '<table class="'.$this->name.'">'."\n";
        $ret .= '<tr>'."\n";
        while(list($key,$val) = each($this->list))
        {
          $ret .= '<td valign="top">
                     <input type="radio" name="'.$this->name.'" '.
                  'value="'.$key.'"';
  
          if($this->value == $key)
          {
            $ret .= ' checked';
          } 
  
          $ret .= ' /></td><td valign="top">'.$val.'</td>'."\n";
                    
          if(++$i % $this->break == 0)
          {
            $ret .= '</tr><tr>'."\n";
          }  
        }
        $ret .= '</tr>'."\n";
        $ret .= '</table>';
      }
      else
      {
        $ret = '<b>'.$this->listError.'</b>';
      }

      return $ret;
    }

    function _JxFieldRadio()
    {
      $this->_JxField();
    }
  }


?>
