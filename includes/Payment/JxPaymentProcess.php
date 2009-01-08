<?php

  class JxPaymentProcess extends JxObjectDb
  {
    var $card = null;
    var $orderID = null;

    function JxPaymentProcess() 
    {
      $this->JxObject();
    }

    function &factory($type,$card,$orderID)
    {
      if(!is_object($card))
      {
        return PEAR::raiseError('Invalid credit card object');
      }

      $file = JX_BASE_PATH.'/includes/Payment/Process/'.$type.'.php';
      if(include_once($file))
      {
        $class = 'JxPaymentProcess_'.$type;
        if(class_exists($class))
        {
          return new $class($card,$orderID);
        }
      }

      return PEAR::raiseError('Invalid process type: '.$type);
    }

    function process()
    {
      return PEAR::raiseError('Abstract function called');
    }

    function isSuccess($object)
    {
      if(is_object($object) && is_a($object,'JxPaymentProcess_result'))
      {
        return true;
      }

      return false;
    }

    function _JxPaymentProcess() 
    {
      $this->_JxObject();
    }
  }

  class JxPaymentProcess_result 
  {
    var $msg = null;
    var $code = null;
    var $transactionID = null;
    var $invoiceID = null;

    function JxPaymentProcess_result($msg,$code=null)
    {
      $this->msg  = $msg;
      $this->code = $code; 
    }
  }

?>
