<?php

  class JxPresenter_debug extends JxPresenter
  {
    function JxPresenter_debug()
    {
      $this->JxPresenter();
    }

    function render($module)
    {
      echo '<html><head><title>JAX - debug</title></head>'."\n";
      echo '<body bgcolor="white">'."\n";

      $showVars = array('path','templateFile','displayPage',
                        'pref','canWrite','canExec','canRead',
                        'forceSSL','presenter','name');

      $this->_debug($module,'JxModule',$showVars);
      $this->_debug($GLOBALS['jx_error_stack'],'Error Stack');

      $exclude = array('db','log','groups','_debug','_default_error_mode',
                       '_default_error_options','_default_error_handler',
                       '_error_class','_expected_errors');

      $this->_debug(JxSingleton::factory('User'),'User',array(),$exclude);
      $this->_debug($module->data,'Module Data');
      $this->_debug($module->template,'Module Template');

      $this->_debug($_POST,'$_POST');
      $this->_debug($_GET,'$_GET');

      $foo = $_SERVER;
      $foo['HTTP_ACCEPT'] = explode(',',$foo['HTTP_ACCEPT']);
      $this->_debug($foo,'$_SERVER');

      $this->_debug($_SESSION,'$_SESSION');
      $this->_debug($_FILES,'$_SESSION');

      $this->_debug(JxSingleton::factory('page'),'Page Template');
      $this->_debug(JxSingleton::factory('db'),'DB');
      $this->_debug(JxSingleton::factory('log'),'Log');
    }

    function _debug($variable,$title,$showVars=array(),$exclude=array())
    {
      echo '<center>'."\n";
      echo '<table width="90%" cellspacing="0" cellpadding="3" border="0">';
      echo '<tr>
              <td><h1>'.$title.'</h1></td>
            </tr>'."\n";
      echo '<tr><td>';

      echo '<table width="100%" cellspacing="0" cellpadding="0" bgcolor="black">';
      echo '<tr><td>';

      echo '<table width="100%" cellspacing="1" cellpadding="3">';
      echo '<tr bgcolor="#696969">'."\n";
      echo '<td><b>Variable</b></td>';
      echo '<td><b>Value</b></td>';
      echo '</tr>'."\n";
      $bg = 0;
      while(list($key,$var) = each($variable))
      {
        $show = false;


        if(count($showVars))
        {
          if(in_array($key,$showVars))
          {
            $show = true;
          }
        }
        else
        {
          $show = true;
        }

        if(count($exclude))
        {
          if(in_array($key,$exclude))
          {
            $show = false;
          }
        }

        if($show)
        {
          echo '<tr bgcolor="'.((++$bg % 2 == 0) ? '#cccccc' : '#fffff').'">'."\n";
          echo '<td width="30%" valign="top" bgcolor="#FFBC2B"><b>'.$key.'</b></td>'."\n";
          echo '<td width="70%" valign="top">'.$this->_varToText($var).'</td>'."\n";
          echo '</tr>'."\n";
        }
      }

      echo '</table>';
      echo '</tr></td></table>';

      echo '</tr></td></table>';
      echo '<br /></center>';
     
    }

    function _varToText($val)
    {
      if(is_object($val) || is_array($val))
      {
        ob_start();
        print_r($val);
        $ret = ob_get_contents();
        ob_end_clean();

        return '<pre>'.$ret.'</pre>';
      }
      elseif(is_null($val))
      {
        return '[null]';
      }
      elseif(is_resource($val))
      {
        return '[file resource]';
      }
      elseif(is_bool($val))
      {
        return ($val) ? '[true]' : '[false]';
      }
      else
      {
        return $val;
      }
    }

    function _JxPresenter_debug()
    {
      $this->_JxPresenter();
    }
  }

?>
