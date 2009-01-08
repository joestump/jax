<?php

  /**
  * JxFieldPhone
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  * @see JxField
  */
  class JxFieldPhone extends JxField
  {
    var $phone;
    var $formName;

    function JxFieldPhone($name,$value='',$formName='')
    {
      $this->JxField($name,$value);

      $this->phone = array();
      $this->formName = $formName;
      if(strlen($value))
      {
        $this->phone = explode('-',$value);
      }
      elseif(count($_POST))
      {
        $this->phone = $_POST['jxphone'][$this->name];
      }
    }


    function getElement()
    {
      $ret  = '<table class="'.$this->name.'">'."\n";
 
/*
      $ret .= <<< EOT
      <tr>
                        (<input type="text" size="3" MAXLENGTH="3" name="jxphone[{$this->name}][]" value="{$this->phone[0]}" OnKeyUp="javascript: if(this.value.length==3){document.{$this->formName}.txtDayNumFirst.focus()}">)
                          <input type="text" size="3" MAXLENGTH="3" name="jxphone[{$this->name}][]" value="{$this->phone[1]}" OnKeyUp="javascript: if(this.value.length==3){document.{$this->formName}.txtDayNumSecond.focus()}"> -
                          <input type="text" size="4" MAXLENGTH="4" name="jxphone[{$this->name}][]" value="{$this->phone[2]}" OnKeyUp="javascript: if(this.value.length==4){document.{$this->formName}.txtDayExt.focus()}">
                          </td>

    </tr>
EOT;
*/

      $ret .= <<< EOT
      <tr>
        <td>
                        (<input type="text" size="3" maxlength="3" name="jxphone[{$this->name}][]" value="{$this->phone[0]}">)
                          <input type="text" size="3" maxlength="3" name="jxphone[{$this->name}][]" value="{$this->phone[1]}"> -
                          <input type="text" size="4" maxlength="4" name="jxphone[{$this->name}][]" value="{$this->phone[2]}">
                          </td>

    </tr>
EOT;

      $ret .= '</table>';

      return $ret;
    }

    function isValid()
    {
      if($this->required)
      {
        return (strlen($this->phone[0]) == 3 &&
                strlen($this->phone[1]) == 3 &&
                strlen($this->phone[2]) == 4);
      }
    }

    function getData()
    {
      if(strlen($this->phone[0]) == 3 &&
         strlen($this->phone[1]) == 3 &&
         strlen($this->phone[2]) == 4)
      {
        return implode('-',$this->phone);
      }

      return null;
    }

    function _JxFieldPhone()
    {
      $this->_JxField();
    }
  }

?>
