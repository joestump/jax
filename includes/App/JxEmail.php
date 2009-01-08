<?php

  /**
  * JxEmail
  *
  * @author Joe Stump <joe@joestump.net>
  * @copyright Joe Stump <joe@joestump.net>
  * @filesource
  * @link http://www.jcssolutions.com
  * @link http://www.jerum.com
  * @package JAX
  */

  require_once('Mail.php');

  /**
  * JxEmail Class
  *
  * The JxEmail class allows you to send out templated emails to users. In your
  * modules template directory you can place template files for your email in
  * text form and then send out customized emails to you users utilizing 
  * Smarty.
  *
  * <code>
  * $email = & new JxEmail($this->path.'/tpl');
  * if(!JxEmail::isError($email))
  * {
  *   $to = $data['email']; // set the to (can be an array as well)
  *   $subject = 'Your Account Information';
  *
  *   // Set the headers array here. Any header you want to change can
  *   // be changed here.
  *   $h = array(); 
  *   $h['From'] = $_SERVER['SERVER_NAME'].' <void@void.com>'; 
  *   $h['Reply-To'] = $h['Return-Path'] = $h['From'];
  *
  *   // Assing data to our email template
  *   $email->template->assign('data',$data);
  *
  *   // Send the email
  *   $result = $email->send($to,$subject,'registerEmail.tpl',$h);
  *   if(JxEmail::isError($result))
  *   {
  *     $this->log->log($result->getMessage());
  *   }
  * }
  * </code>  
  *
  * @author Joe Stump <joe@joestump.net>
  * @package App
  */
  class JxEmail extends JxObject
  {
    // {{{ properties
    /**
    * $mail
    *
    * An instance of PEAR's Mail class.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var mixed $mail
    * @see Mail
    */
    var $mail;

    /**
    * $data
    *
    * The Smarty template data. This variable is assigned to the Smarty template
    * in the send() function.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @var mixed $data
    * @see JxEmail::send(), Smarty
    */
    var $data;

    /**
    * $template
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var mixed $template
    * @see Smarty
    */
    var $template;
    // }}}
    // {{{ JxEmail()
    /**
    * JxEmail
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $tplPath
    * @return void
    */
    function JxEmail($tplPath)
    {
      $this->JxObject();

      $this->data = array();
      $this->template = & new JxTemplate($tplPath);
      if(PEAR::isError($this->template))
      {
        $this = $this->template;
      }
      else
      {
        $this->mail = & Mail::factory('mail');
        if(PEAR::isError($this->mail))
        {
          $this = $this->mail;
        }
      }
    }
    // }}}
    // {{{ send()
    /**
    * send
    *
    * Works much like the current PHP mail() command. It takes a $to, $subject,
    * and $headers for the last argument (an *array* not a string!). The third
    * argument is $msgFile, in other words it's your Smarty template for the
    * given message. Returns true on success and PEAR_Error on false.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $to
    * @param string $subject
    * @param string $msgFile
    * @param mixed $headers
    * @return bool
    * @see Mail
    */
    function send($to,$subject,$msgFile,$headers=array())
    {
      if(file_exists($this->template->template_dir.'/'.$msgFile))
      {
        $this->template->assign('to',$to);  
        $this->template->assign('subject',$subject);  
        $this->template->assign('headers',$headers);  

        $sendTo = array();
        $sendTo[] = $to;

        $sendHeaders = $headers;
        $sendHeaders['Subject'] = $subject;
        // $sendHeaders['To'] = $to;

        $sendMsg = $this->template->fetch($msgFile);

        $result = $this->mail->send($sendTo,$sendHeaders,$sendMsg);
        if(PEAR::isError($result))
        {
          return $result;
        }

        return true;
      }
      else
      {
        return new PEAR_Error('Invalid template file: '.
                              $this->template->template_dir.'/'.$msgFile);
      }  
    }
    // }}}
    // {{{ _JxEmail()
    /**
    * _JxEmail
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return void
    */
    function _JxEmail()
    {
      $this->_JxObject();
    }
    // }}}
  }

?>
