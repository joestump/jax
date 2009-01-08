<?php

  /**
  * JxFieldCreditCard
  *
  * @author Joe Stump <joe@joestump.net>
  * @copyright Joe Stump <joe@joestump.net> 
  * @filesource
  * @link http://www.jerum.com
  * @link http://www.jcssolutions.com
  * @package JAX
  */

  /**
  * JxFieldCreditCard
  *
  * A complex field type for the form class that provides basic credit card
  * verification via the JxCC class. Please note that this field actually
  * includes 5 data fields (type, number, expMonth, expYear and cvv). It 
  * validates all of those fields based on JxCC::isValid() as well as some
  * internal checking for cvv.
  *
  * <code>
  * $field = & new JxFieldCreditCard('cc');
  * $field->label = 'Credit Card'; // used for error reporting
  * $container->addComponent($field);
  * </code>
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  * @see JxField, JxCC
  */
  class JxFieldCreditCard extends JxField
  {
    var $cc;

    var $number;
    var $type;
    var $expMonth;
    var $expYear;
    var $cvv;

    function JxFieldCreditCard($name,$value=null,$cardList=array())
    {    
      global $JX_CARD_ARRAY;

      $this->JxField($name,$value);

      if(!count($cardList))
      {
        $this->cardList = $JX_CARD_ARRAY;
      }

      if($value !== null && is_a($value,'jxcc'))
      {
        $this->cc = $value;
      }
      elseif(count($_POST))
      {

        $this->number   = $_POST['jxcc'][$this->name]['number'];
        $this->type     = $_POST['jxcc'][$this->name]['type'];
        $this->expMonth = $_POST['jxcc'][$this->name]['expMonth'];
        $this->expYear  = $_POST['jxcc'][$this->name]['expYear'];
        $this->cvv      = $_POST['jxcc'][$this->name]['cvv'];

      }
    }

    function getElement()
    {

    }

    function render()
    {
      global $JX_DATE_MONTHS, $JX_DATE_DAYS;

      $ret = '<table border="0" class="jxHtmlForm">
              <tr>
                <td align="right" class="JxLabel">Card Issuer<font color="red">*</font></td>';

      $field = & new JxFieldSelect('jxcc['.$this->name.'][type]',
                                   $this->cardList,$this->type);

      $ret .= '<td>'.$field->getElement().'</td>';
      $ret .= '<td rowspan="4">
                 <!-- <img src="/tpl/images/cvv.gif" border="0"> -->
               </td>'."\n\n";
      $ret .= '</tr>'."\n";
      $ret .= '<tr>
                 <td align="right">Card Number<font color="red">*</font></td>';

      $field = & new JxFieldText('jxcc['.$this->name.'][number]',
                                 $this->number,18,16);
                 
      $ret .= '<td>'.$field->getElement().'</td>';
      $ret .= '</tr><tr>'."\n";
      $ret .= '<td align="right">Expiration<font color="red">*</font></td>';

      $field = & new JxFieldSelect('jxcc['.$this->name.'][expMonth]',
                                   $JX_DATE_MONTHS,$this->expMonth);       

      $ret .= '<td>'.$field->getElement();

      $field = & new JxFieldText('jxcc['.$this->name.'][expYear]',
                                 $this->expYear,5,4);

      $ret .= '&nbsp;'.$field->getElement().' <i>ie. '.(date("Y") + 3).
              '</i></td>';
      $ret .= '</tr>'."\n";
      $ret .= '<tr>
                 <td align="right">Card Verification #<font color="red">*</font></td>'."\n";

      $field = & new JxFieldText('jxcc['.$this->name.'][cvv]',
                                   $this->cvv,5,4);

      $ret .= '<td>'.$field->getElement().'</td>'."\n";
      $ret .= '</tr>'."\n";
      $ret .= '</table>';

      return $ret;
    }

    function isValid()
    {
      if(!strlen($this->numer) ||
         !strlen($this->type) || 
         !strlen($this->expMonth) ||
         !strlen($this->expYear))
      {
        $this->errors[] = 'Your credit card information is invalid';

        return false;
      }
      else
      {
        $this->cc = & new JxCC($this->number,$this->type,$this->expMonth,
                               $this->expYear);
      }

      if(!is_object($this->cc))
      {
        $this->errors[] = 'The credit card information you have entered appears
                           to be incorrect';
      }
      else
      {
        if(!strlen($this->cvv))
        {
          $this->errors[] = 'Invalid card verification number';
          return false;
        }

        if(JxCC::isError($this->cc))
        {
          $this->errors[] = $this->cc->getMessage();
        }
        else
        {
          $result = $this->cc->isValid();
          if(!JxCC::isError($result))
          {
            return true;
          }

          $this->errors[] = $result->getMessage();
        }
      }

      return false;
    }

    function _JxFieldCreditCard()
    {
      $this->_JxField();
    }
  }


?>
