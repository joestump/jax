<?php

  /**
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  */
  class JxField 
  {
    var $name;
    var $type;
    var $value;
    var $required;
    var $label;
    var $toolTip;
    var $help;
    var $accessKey;
    var $errors;
    var $errorMessage;
    var $saveAs;

    function JxField($name,$value)
    {
      $this->name = $name;
      $this->value = $value;
      $this->type = get_class($this);
      $this->required = 0;
      $this->label = strtoupper($this->name);

      $this->errors = array();
      $this->errorMessage = null;
      $this->toolTip = $this->help = '';
      $this->saveAs = null;
    }

    function render()
    {
      $ret = '<table width="100%" border="0">
              <tr>      
                 <td class="JxLabel" valign="top" align="right">';

      if(strlen($this->toolTip))
      {
        $ret .= '<p onMouseOver="javascript: popup(\''.
                str_replace("\n",' ',$this->toolTip). // will this work?
                '\',\'lightyellow\');" onMouseOut="javascript: kill();">'.
                $this->getLabel().'</p>';
      }
      else
      {
        $ret .= $this->getLabel();
      }

      $ret .= '</td>
                 <td class="Jx'.$this->type.'input">'.$this->getElement().'</td>
                 <td>'.$this->help.'&nbsp;</td>
               </tr>
               </table>'."\n";

      return $ret;
    }

    /**
    * getLabel
    *
    * @author Joe Stump <joe@joestump.net>
    * @access private
    */
    function getLabel()
    {
      if(ereg('&',$this->label))
      {
        list($begin,$end) = explode('&',$this->label);  
        $this->accessKey = strtoupper(substr($end,0,1));
        $label = $begin.'<u>'.substr($end,0,1).'</u>'.substr($end,1);
      }
      else
      {
        $label = $this->label;
      }

      if($this->required)
      {
        $label .= '<font color="red">*</font>';
      } 

      return $label;
    }

    function getTextLabel()
    {
      return str_replace('&','',$this->label);
    }

    function isValid()
    {
      if($this->required && !strlen($this->value))
      {
        if(!is_null($this->errorMessage))
        {
          $errorMessage = $this->errorMessage;
        }
        else
        {
          $errorMessage = str_replace('&','',$this->label).
                          ' is a required field';
        }

        $this->errors[] = $errorMessage;

        return false;
      }

      return true;
    }

    function &factory($type,$info)
    {
      if(class_exists($type))
      {
        $class = & new $type($info['name'],$info['value']);
        while(list($key,$val) = each($info))
        {
          $class->$key = $val;
        }

        return $class;
      }

      return new PEAR_Error('Invalid form class');
    }

    function getData()
    {
      return $this->value;
    }

    function resetData()
    {
      $this->value = '';  
    }
  }

  require_once(JX_CORE_PATH.'/includes/Draw/Html/Fields/JxFieldCheckbox.php');
  require_once(JX_CORE_PATH.'/includes/Draw/Html/Fields/JxFieldFile.php');
  require_once(JX_CORE_PATH.'/includes/Draw/Html/Fields/JxFieldHidden.php');
  require_once(JX_CORE_PATH.'/includes/Draw/Html/Fields/JxFieldHtml.php');
  require_once(JX_CORE_PATH.'/includes/Draw/Html/Fields/JxFieldImage.php');
  require_once(JX_CORE_PATH.'/includes/Draw/Html/Fields/JxFieldPassword.php');
  require_once(JX_CORE_PATH.'/includes/Draw/Html/Fields/JxFieldRadio.php');
  require_once(JX_CORE_PATH.'/includes/Draw/Html/Fields/JxFieldSelect.php');
  require_once(JX_CORE_PATH.'/includes/Draw/Html/Fields/JxFieldSubmit.php');
  require_once(JX_CORE_PATH.'/includes/Draw/Html/Fields/JxFieldText.php');
  require_once(JX_CORE_PATH.'/includes/Draw/Html/Fields/JxFieldTextarea.php');

  $dir = dir(JX_CORE_PATH.'/includes/Draw/Html/Fields');
  while (false !== ($entry = $dir->read())) {
      if (!in_array($entry,array('.','..')) && ereg('^JxField',$entry)) {
          require_once(JX_CORE_PATH.'/includes/Draw/Html/Fields/'.$entry);
      }
  }

?>
