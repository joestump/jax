<?php


  /**
  * JxFieldSelect
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  * @see JxField
  */
  class JxFieldSelect extends JxField
  {
    var $size;
    var $multiple;
    var $list;
    var $listError;
    var $edit;

    function JxFieldSelect($name,$list,$value='',$size=1,$multiple=0)
    {
      $this->JxField($name,$value);
      $this->size = $size;
      $this->multiple = $multiple;
      $this->list = $list;
      $this->listError = 'Invalid List';
      $this->edit = null;
    } 

    function getElement()
    {
      $name = ($this->multiple) ? $this->name.'[]' : $this->name;

      if(is_array($this->list) && count($this->list))
      {
        $field = '<select name="'.$name.'" size="'.$this->size.'" ';
        $field .= 'class="b4FieldSelect" ';
        if($this->multiple)
        {
          $field .= 'multiple';
        }
        $field .= '>'."\n";
  
        while(list($key,$value) = each($this->list))
        {
          $field .= '<option value="'.$key.'" ';
          if(is_array($this->value) && count($this->value))
          {
            if(in_array($key,$this->value))
            {
              $field .= 'selected';
            }
          }
          else
          {
            if($key == $this->value)
            {
              $field .= 'selected';
            }
          }
          $field .= '>'.$value.'</option>'."\n";
        }
        
        $field .= '</select>'."\n";
      }
      else
      {
        $field = '<b>'.$this->listError.'</b>';
      }

      if($this->edit !== null)
      {
        $field .= '&nbsp;&nbsp;<a href="'.$this->edit.'">edit</a>';
      }
  
      return $field;
    }

    function isValid()
    {
      if(!$this->required)
      {
        return true;
      }
      else
      {
        if($this->multiple)
        {
          if(is_array($this->value) && count($this->value))
          {
            return true;
          }
        }
        else
        {
          if(strlen($this->value))
          {
            return true;
          }
        }
      }

      return false;
    }
  }

?>
