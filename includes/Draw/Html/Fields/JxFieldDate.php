<?php

  /**
  * JxFieldDate
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  */
  class JxFieldDate extends JxField
  {
    var $month;
    var $day;
    var $year;

    function JxFieldDate($name,$value='')
    {
        $this->JxField($name,$value);
  
        if (strlen($this->value)) {
            if (is_numeric($this->value)) {
                $value = $this->value = date("Y-m-d",$this->value);
            }
  
            list($this->year,$this->month,$this->day) = explode('-',$value);
        } elseif(count($_POST)) {
          $this->month = $_POST['jxdate'][$this->name]['month'];
          $this->day   = $_POST['jxdate'][$this->name]['day'];
          $this->year  = $_POST['jxdate'][$this->name]['year'];
        } else {
          $this->month = date("m");
          $this->day   = date("d");
          $this->year  = date("Y");
        }
    }

    function getElement()
    {
      global $JX_DATE_MONTHS, $JX_DATE_DAYS;

      $ret .= '<table><tr>';
      $field = & new JxFieldSelect('jxdate['.$this->name.'][month]',
                                   $JX_DATE_MONTHS,$this->month);
      $field->label='';
      $ret .= '<td>'.$field->getElement().'</td>';

      $field = & new JxFieldSelect('jxdate['.$this->name.'][day]',
                                   $JX_DATE_DAYS,$this->day);
      $field->label='';
      $ret .= '<td>'.$field->getElement().'</td>';

      $field = & new JxFieldText('jxdate['.$this->name.'][year]',$this->year,4,4);
      $field->label='';
      $ret .= '<td>'.$field->getElement().'</td><td><i>YYYY</i></td>';

      return $ret.'</tr></table>';
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
      if(strlen($this->year) && strlen($this->month) && strlen($this->day))
      {
        return $this->year.'-'.$this->month.'-'.$this->day; 
      }

      return null;
    }
  }

?>
