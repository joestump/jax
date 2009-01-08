<?php

  /**
  * JxFieldCalendar
  *
  * @author Joe Stump <joe@joestump.net>
  * @copyright Joe Stump <joe@joestump.net>
  * @filesource
  * @link http://www.jcssolutions.com
  * @link http://www.jerum.com
  * @package JAX
  */

  /**
  * JxFieldCalendar
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  */
  class JxFieldCalendar extends JxField
  {
    var $month;
    var $day;
    var $year;

    function JxFieldCalendar($name,$value='')
    {
      $this->JxField($name,$value);

      $page = & JxSingleton::factory('page');
      $page->addCssFile('/tpl/css/dynCalendar.css');
      $page->addJsFile('/tpl/javascript/browserSniffer.js');
      $page->addJsFile('/tpl/javascript/dynCalendar.js');

      if(strlen($this->value))
      {
        list($this->year,$this->month,$this->day) = explode('-',$value);
      }
      else
      {
        list($this->year,$this->month,$this->day) = explode('-',$_POST[$this->name]);
      }
    }

    function getElement()
    {
      global $JX_DATE_MONTHS, $JX_DATE_DAYS;

      $ret = <<<EOT

  <script type="text/javascript">
  <!--
    // Calendar callback. When a date is clicked on the calendar
    // this function is called so you can do as you want with it.
    // One for each calendar field because JavaScript doesn't handle
    // dynamic names.
    function {$this->name}calendarCallback(date, month, year)
    {
      if(month < 10)
      {
        month = '0' + month;
      }

      if(date < 10)
      {
        date = '0' + date;
      }

      date = year + '-' + month + '-' + date;
      document.forms[0].{$this->name}.value = date;
    }
  // -->
  </script>
  <table>
  <tr>
    <td>
      <input type="text" size="10" maxlength="10" name="{$this->name}">
    </td>
    <td>
    <script language="JavaScript" type="text/javascript">
    <!--
      {$this->name}Calendar = new dynCalendar('{$this->name}Calendar', '{$this->name}calendarCallback', '/tpl/images/');
    //-->
    </script>
  </tr>
  </table>
EOT;

      return $ret;
    }

    function isValid()
    {
      if($this->required)
      {
        if(strlen($this->year) && 
           checkdate($this->month,$this->day,$this->year))
        {
          return true;
        }
        
        $this->errors[] = 'The date you entered "'.$this->month.'-'.$this->day.'-'.$this->year.'" appears invalid!';
        return false;
      }

      return true;
    }

    function getData()
    {
      return $this->year.'-'.$this->month.'-'.$this->day; 
    }
  }

?>
