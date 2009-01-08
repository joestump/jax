<?php

  /**
  * JxCC
  *
  * @author 
  * @filesource
  * @package JAX
  */

  define("JX_CARD_TYPE_MC", 0);
  define("JX_CARD_TYPE_VS", 1);
  define("JX_CARD_TYPE_AX", 2);
  define("JX_CARD_TYPE_DC", 3);
  define("JX_CARD_TYPE_DS", 4);
  define("JX_CARD_TYPE_JC", 5);

  define("JX_CARD_ERROR_TYPE",       -1);
  define("JX_CARD_ERROR_NUMBER",     -2);
  define("JX_CARD_ERROR_EXPIRATION", -3);

  $JX_CARD_ARRAY[JX_CARD_TYPE_AX] = 'American Express';
  $JX_CARD_ARRAY[JX_CARD_TYPE_DS] = 'Discover/Novus';
  $JX_CARD_ARRAY[JX_CARD_TYPE_MC] = 'MasterCard';
  $JX_CARD_ARRAY[JX_CARD_TYPE_VS] = 'Visa';

  /**
  * JxCC
  *
  * Foundation class for the Payment package. Does basic Mod 10 verification
  * as well as simple date checking. Any payment processing factory should have
  * the ability to take this class as an argument. 
  *
  * @author Joe Stump <joe@joestump.net>
  * @package Payment
  */
  class JxCC extends JxObject
  {
    // {{{ properties
    /**
    * $type
    *
    * Should be a integer, but common string values are accepted and 
    * evaluated in the constructor as well. See the JX_CARD_TYPE_* defines
    * at the top of this file for more information.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var mixed $type
    * @see JxCC::JxCC()
    */
    var $type;

    /**
    * $number
    *
    * The credit card number. The constructor removes any non-numerical 
    * characters.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var int $number
    */
    var $number;

    /**
    * $cvv
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var int $cvv
    */
    var $cvv;

    /**
    * $expMonth
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var int $expMonth
    */
    var $expMonth;

    /**
    * $expYear
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var int $expYear
    */
    var $expYear;

    /**
    * $address
    *
    * An associative array containing the following structure:
    *
    * <code>
    * $address = array('address1' => '11901 Pink St.',
    *                  'address2' => 'Apt. #3',
    *                  'city' => 'Brooklyn',
    *                  'state' => 'MI',
    *                  'zip' => '48197',
    *                  'country' => 'US');
    * </code>
    *
    * The address is not used in the basic verification included in JxCC, but
    * should be used when processing payment via Linkpoint and the like. It
    * could be used if we had an up-to-date zips database.
    * 
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var mixed $address
    */
    var $address;
    // }}}
    // {{{ JxCC()
    /**
    * JxCC
    *
    * <code>
    * $cc = & new JxCC('6011005010192907',JX_CARD_TYPE_MC,'04','2004');
    *
    * if(!JxCC::isError($cc))
    * {
    *   $result = $cc->isValid();
    *   if(!JxCC::isError($result))
    *   {
    *     echo $cc->safeValue();
    *   }
    *   else
    *   {
    *     echo $result->getMessage();
    *   }
    * }
    * else
    * {
    *   echo $cc->getMessage();
    * }
    * </code> 
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param int $ccNumber
    * @param mixed $ccType
    * @param int $ccExpMonth
    * @param int $ccExpYear
    * @param int $ccCvv
    * @param mixed $ccAddress
    * @return void
    */
    function JxCC($ccNumber,$ccType,$ccCvv,
                  $ccExpMonth,$ccExpYear,$ccAddress=array())
    {
      $this->JxObject();


      $this->number   = ereg_replace('[^0-9]', '',$ccNumber);
      $this->type     = $ccType;
      $this->expMonth = $ccExpMonth;
      $this->expYear  = $ccExpYear;
      $this->address  = $ccAddress;
      $this->cvv      = $ccCvv;

      if(empty($this->number))
      {
        $this = new PEAR_Error('Invalid credit card number',
                               JX_CARD_ERROR_NUMBER);

        return false;
      }

      // Validate card type
      switch(strtolower($this->type))
      {
        case 'mc':
        case 'mastercard':
        case '0':
          $this->type = JX_CARD_TYPE_MC;
          break;

        case 'vs':
        case 'visa':
        case '1':
          $this->type = JX_CARD_TYPE_VS;
          break;

        case 'amx':
        case '2':
          $this->type = JX_CARD_TYPE_AX;
          break;

        case 'dc':
        case '3':
          $this->type = JX_CARD_TYPE_DC;
          break;

        case 'ds':
        case 'discover':
        case '4':
          $this->type = JX_CARD_TYPE_DS;
          break;

        case 'jc':
        case 'jcb':
        case '5':
          $this->type = JX_CARD_TYPE_JC;
          break;

        default:
          $this = new PEAR_Error($this->type.' is an invalid CC type!',
                                 JX_CARD_ERROR_TYPE);
          return false;
          break;
      }

      // Make sure the number isn't empty after we stripped non numerical
      // characters from it.
      if(empty($this->number))
      {
        $this = new PEAR_Error('Invalid credit card number',
                               JX_CARD_ERROR_NUMBER);

        return false;
      }

      // Validate expiry month/year
      if($this->expMonth < 1 || $this->expMonth > 12)
      {
        $this = new PEAR_Error('Invalid expiration date',
                               JX_CARD_ERROR_EXPIRATION);

        return false;
      }

      if(($this->expMonth < date("m") && $this->expYear == date("Y")) ||
         ($this->expYear < date("Y")))
      {
        $this = new PEAR_Error('Credit card has expired',
                               JX_CARD_ERROR_EXPIRATION);
        return false;
      }
    }
    // }}}
    // {{{ isValid()
    /**
    * isValid
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return bool
    */
    function isValid()
    {
      $valid     = false;
      $passCheck = false;

      switch($this->type)
      {
        case JX_CARD_TYPE_MC:
          $valid = ereg("^5[1-5][0-9]{14}$",$this->number);
          break;
        case JX_CARD_TYPE_VS:
          $valid = ereg("^4[0-9]{12}([0-9]{3})?$",$this->number);
          break;
        case JX_CARD_TYPE_AX:
          $valid = ereg("^3[47][0-9]{13}$",$this->number);
          break;
        case JX_CARD_TYPE_DC:
          $valid = ereg("^3(0[0-5]|[68][0-9])[0-9]{11}$",$this->number);
          break;
        case JX_CARD_TYPE_DS:
          $valid = ereg("^6011[0-9]{12}$", $this->number);
          break;
        case JX_CARD_TYPE_JC:
          $valid = ereg("^(3[0-9]{4}|2131|1800)[0-9]{11}$",$this->number);
          break;
        default:
          $valid = false;
      }

      if(!$valid)
      {
        return new PEAR_Error('Credit card number does not match given type',
                              JX_CARD_ERROR_TYPE);
      }

      // Is the number valid?
      $cardNumber = strrev($this->number);
      $numSum = 0;

      for($i = 0; $i < strlen($cardNumber); $i++)
      {
        $currentNum = substr($cardNumber, $i, 1);

        // Double every second digit
        if($i % 2 == 1)
        {
          $currentNum *= 2;
        }

        // Add digits of 2-digit numbers together
        if($currentNum > 9)
        {
          $firstNum   = $currentNum % 10;
          $secondNum  = ($currentNum - $firstNum) / 10;
          $currentNum = $firstNum + $secondNum;
        }

        $numSum += $currentNum;
      }

      $passCheck = ($numSum % 10 == 0);

      if($passCheck)
      {
        return true;
      }
      else
      {
        return new PEAR_Error('Invalid credit card number',
                               JX_CARD_ERROR_NUMBER);
      }
    }
    // }}} 
    // {{{ safeValue
    /**
    * safeValue
    *
    * Returns a safe-to-view version of the credit card number, such as
    * xxxxxxxxxxxx9054. 
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return string
    */
    function safeValue()
    {
      $safeNumber = substr($this->number,(strlen($this->number) - 4),
                           strlen($this->number));

      for($i = 0 ; $i < (strlen($this->number) - 4) ; ++$i)
      {
        $safeNumber = 'x'.$safeNumber;
      }

      return $safeNumber;
    }
    // }}}
    // {{{ _JxCC()
    /**
    * _JxCC
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return void
    */
    function _JxCC()
    {
      $this->_JxObject();
    }
    // }}}
  }

?>
