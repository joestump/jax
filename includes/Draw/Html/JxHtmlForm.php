<?php

  /**
  * JxHtmlForm Class
  *
  * Controller class used to build modules from JxVbox, JxHbox, 
  * JxHtmlFormContainter, and JxField*. 
  *
  * @author Joe Stump <joe@joestump.net>
  * @package HtmlForm
  */
  class JxHtmlForm extends JxObjectDraw
  {
    var $name;
    var $action;
    var $method;
    var $errors;
    var $data;
    var $exemptData;

    function JxHtmlForm($name='')
    {
      $this->JxObjectDraw();
      $this->name = $name;
      $this->method = 'post';
      $this->action = $_SERVER['REQUEST_URI'];
      $this->errors = array();
      $this->data = array();
      $this->exemptData = array();
    }

    function getForm()
    {
      $ret =  '<table class="jxHtmlForm" cellspacing="0" cellpadding="0">'."\n";
      $ret .= '<form enctype="multipart/form-data" '.
              'method="'.$this->method.'" '.
              'action="'.$this->action.'" '.
              'name="'.$this->name.'">'."\n";

      $ret .= '<tr><td>'."\n";

      if(is_array($this->errors) && count($this->errors))
      {
        $container = & new JxHtmlFormContainer('formError');
        $container->label = 'Error!';

        $errorMessage = '<table width="100%">';
        while(list($name,$err) = each($this->errors))
        {
          $errorMessage .= '
                           <tr>
                             <td class="JxFormErrorField" nowrap>'.$name.':</td>
                             <td class="JxFormErrorMessage">'.$err.'</td>
                           </tr>'."\n";

        }
        $errorMessage .= '</table>'."\n";

        $field = & new JxFieldHTML($errorMessage);
        $container->addComponent($field);

        array_unshift($this->components,$container);
      }

      for($i = 0 ; $i < count($this->components) ; ++$i)
      {
        $ret .= $this->components[$i]->render();
      }

      $ret .= '  </td></tr>'."\n";
      $ret .= '</form>'."\n";
      $ret .= '</table>'."\n";

      return $ret;
    }

    function isValid()
    {
      if(($this->method == 'post' && count($_POST)) ||
         ($this->method == 'get' && count($_GET) > 1)) 
      {
        for($i = 0 ; $i < count($this->components) ; ++$i)
        {
          if(JxObjectDraw::validComponent($this->components[$i])) 
          {
             $this->components[$i]->isValid();
          }
        }

        $this->errors = $this->getErrors();
        if(!count($this->errors))
        {
          return true;
        }
      }

      return false;
    }

    function throwError($componentName,$errorMessage)
    {
      $component = & $this->getComponent($componentName);

      if(strlen($errorMessage))
      {
        if(!PEAR::isError($component) && is_a($component,'JxField'))
        {
          $this->errors[$component->getTextLabel()] = $errorMessage;
        }
      }
    }

    function getErrors($components=array()) 
    {
      if(!count($components))
      {
        $components = $this->components;
      }

      for($i = 0 ; $i < count($components) ; ++$i)
      {
        if(is_array($components[$i]->errors) && count($components[$i]->errors))
        {
          for($x = 0 ; $x < count($components[$i]->errors) ; ++$x)
          {
            if(strlen($components[$i]->errors[$x]))
            {
              $this->errors[$components[$i]->getTextLabel()] = $components[$i]->errors[$x];
            }
          }
        }

        if(is_array($components[$i]->components) && 
           count($components[$i]->components))
        {
          $this->getErrors($components[$i]->components);
        }
      }

      return $this->errors;
    }

    function getData($components=array()) 
    {
      if(!count($components))
      {
        $components = $this->components;
      }

      for($i = 0 ; $i < count($components) ; ++$i)
      {
        if(method_exists($components[$i],'getData'))
        {
          if(!in_array($components[$i]->name,$this->exemptData))
          {
            if($components[$i]->saveAs !== null)
            {
              $this->data[$components[$i]->saveAs] = $components[$i]->getData();
            }
            else
            {
              $this->data[$components[$i]->name] = $components[$i]->getData();
            }
          }
        }

        if(is_array($components[$i]->components) && 
           count($components[$i]->components))
        {
          $this->getData($components[$i]->components);
        }
      }

      return $this->data;
    }

    function resetFormData($components=array())
    {
      if(!count($components))
      {
        $components = $this->components;
      }

      for($i = 0 ; $i < count($components) ; ++$i)
      {
        if(is_a($components[$i],'JxField'))
        {
          $components[$i]->resetData();
        }

        if(is_array($components[$i]->components) && 
           count($components[$i]->components))
        {
          $this->resetFormData($components[$i]->components);
        }
      }
    }
  }

?>
