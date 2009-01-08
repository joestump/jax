<?php

  class JxPaymentProcess_email extends JxPaymentProcess
  {
    var $email;

    function JxPaymentProcess_email($card,$orderID)
    {
      $this->JxPaymentProcess();
      $this->card = $card;
      $this->orderID = $orderID;
      $this->email = JxModuleConfig::get('payment','email');
    }

    function process()
    {
      if(strlen($this->email))
      {
        $email = & new JxEmail(JX_BASE_PATH.'/system/tpl');
        if(!JxEmail::isError($email))
        {
          $to = $this->email;
          $subject = 'Payment Process (OrderID: '.$this->orderID.')';

          $h = array();
          $h['From'] = $_SERVER['SERVER_NAME'].' <void@void.com>';
          $h['Reply-To'] = $h['Return-Path'] = $h['From'];

          $email->template->assign('ccNumber',substr($this->card->number,8));
          $email->template->assign('orderID',$this->orderID);
          $result = $email->send($to,$subject,'JxPaymentProcess_email.tpl',$h);
          if(JxEmail::isError($result))
          {
            $this->log->log($result->getMessage());
            return PEAR::raiseError('Could not send email');
          }
          else
          {
            return new JxPaymentProcess_result('All good');
          }
        }
        else
        {
          return $email;
        }
      }

      return PEAR::raiseError('Invalid email address: '.$this->email);
    }

    function _JxPaymentProcess_email()
    {
      $this->_JxPaymentProcess();
    }
  }

?>
