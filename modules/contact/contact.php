<?php 

  /**
  * Contact Us
  *
  * @author Joe Stump <joe@joestump.net>
  * @copyright Joe Stump <joe@joestump.net>
  * @package Contact
  * @filesource 
  */

  require_once(JX_BASE_PATH.'/includes/App/JxEmail.php');

  /**
  * contact
  *
  * The default JAX email contact form. Mail is sent to the email address
  * defined in config.php
  * 
  * @author Joe Stump <joe@joestump.net>
  * @package Contact
  */
  class contact extends JxAuthNo
  {
    /**
    * $form
    *
    * The contact form
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @var mixed $form
    */
    var $form;

    /**
    * contact
    *
    * This builds the contact form and processes it when the form is posted.
    * All form handling is done using the JxForm class.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return void
    */
    function contact()
    {
      $this->JxAuthNo();
 
      $this->page->title = 'Contact Us';

      $this->form = & new JxHtmlForm();
      
      $container = & new JxHtmlFormContainer('contact');
      $container->label = 'Contact Us';

      if(!count($_POST))
      {
        $name  = $this->user->fname.' '.$this->user->lname;
        $email = $this->user->email;
      }
      else
      {
        $name  = $_POST['name'];
        $email = $_POST['email'];
      }

      $field = & new JxFieldText('name',$name); 
      $field->label = 'Your Name';      
      $field->required = true;
      $container->addComponent($field);

      $field = & new JxFieldEmail('email',$email);
      $field->label = 'Your Email Address';
      $field->required = true;
      $container->addComponent($field);

      $field = & new JxFieldPhone('phone',$_POST['phone']);
      $field->label = 'Phone Number';
      $field->required = false;
      $container->addComponent($field);

      $field = & new JxFieldText('subject',$_POST['subject']);
      $field->label = 'Subject';
      $field->required = true;
      $container->addComponent($field);

      $field = & new JxFieldTextarea('comments',$_POST['comments']);
      $field->label = 'Comments';
      $field->required = true;
      $container->addComponent($field);

      $field = & new JxFieldSubmit('button','Contact Us');
      $container->addComponent($field);

      $this->form->addComponent($container);

      if(!$this->form->isValid())
      {
        $this->setData('contactForm',$this->form->getForm());
      }
      else
      {
        $data = $this->form->getData();

        $email = & new JxEmail($this->path.'/tpl');
        $to = JxModuleConfig::get('contact','email');
        if(!JxEmail::isError($email) && strlen($to))
        {
          $h = array();
          $h['From'] = stripslashes($data['name'])." <".$data['email'].">";
          $h['Reply-To'] = $data['email'];
          $h['Return-Path'] = $data['email'];

          $subject = '['.$_SERVER['SERVER_NAME'].'] Contact Us';

          
          $email->template->assign('data',$data);
          $result = $email->send($to,$subject,'contactEmail.tpl',$h);
          if(JxEmail::isError($result))
          {
            $this->log->log($result->getMessage());
          }
        }

        $this->setData('data',$data);
        $this->templateFile = 'contactConfirm.tpl';
      }
    }

    function _contact()
    {
      $this->_JxAuthNo();
    }
  }

?>
