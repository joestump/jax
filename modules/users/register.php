<?php 

  require_once(JX_BASE_PATH.'/includes/App/JxEmail.php');

  class register extends JxAuthNo
  {
      var $form;
      var $data = array();
  
      function register()
      {
          $this->JxAuthNo();
          $this->page->title = 'Create an Account';
          $this->templateFile = 'register.tpl';
      }
  
      function __default()
      {
          $this->form = & new JxHtmlForm();
    
          $container = & new JxHtmlFormContainer('AccInfo');     
          $container->label = 'Account Information'; 
    
          $field = & new JxFieldString('username',$_POST['username']);
          $field->mustNotMatch = '[^a-z0-9]';
          $field->label = 'Username';
          $field->required = true;
          $container->addComponent($field);
    
          $field = & new JxFieldEmail('email',$_POST['email']);
          $field->required = true;
          $container->addComponent($field);
    
          $field = & new JxFieldPassword('passA',$_POST['passA'],15,15);
          $field->label = '&Password';
          $field->required = true;
          $field->saveAs = 'password';
          $container->addComponent($field); 
    
          $field = & new JxFieldPassword('passB',$_POST['passB'],15,15);
          $field->label = '&Verify Password';
          $field->required = true;
          $container->addComponent($field); 
    
          $this->form->addComponent($container);
    
          $container = & new JxHtmlFormContainer('PersInfo');     
          $container->label = 'Personalize Your Experience'; 
    
          $field = & new JxFieldText('fname',$_POST['fname']);
          $field->label = '&First Name';
          $field->required = true;
          $container->addComponent($field);
    
          $field = & new JxFieldText('lname',$_POST['lname']);
          $field->label = '&Last Name';
          $field->required = true;
          $container->addComponent($field);
    
          $this->form->addComponent($container);
    
          // Allow plugins to add containers to the form
          JxPlugin::doHook('registerForm',&$this);
    
          $field = & new JxFieldSubmit('button','Create Account');
          $this->form->addComponent($field);
    
    
          // validate our form's custom values
          if (is_array($_POST) && count($_POST)) {
              if ($_POST['passA'] != $_POST['passB']) {
                  $this->form->throwError('passA',
                                          'Passwords do not match');
              }
          }
          
          if(!$this->form->isValid()) {
              $this->setData('regForm',$this->form->getForm());
          } else {
              $this->form->exemptData = array('button','passB');
              $this->data = $this->form->getData();
      
              $this->data['posted']    = time();
              $this->data['available'] = 1;
              $this->data['admin']     = 0;
             
              $this->data['userID'] = $this->user->create($this->data);
              if ($this->data['userID']) { 
                  $this->setData('register',$this->data);
                  $this->templateFile = 'registerConfirm.tpl';
      
                  $session = & new JxSession();
                  if (!JxSession::isError($session)) {
                      $session->create($this->data['email']);
                  }
      
                  $email = & new JxEmail($this->path.'/tpl');
                  if (!JxEmail::isError($email)) {
                      $to = $this->data['email'];
                      $subject = 'Your Account Information';
                    
                      $h = array();
                      $h['From'] = $_SERVER['SERVER_NAME'].' <void@void.com>';
                      $h['Reply-To'] = $h['Return-Path'] = $h['From'];
      
                      $email->template->assign('data',$this->data);
                      $result = $email->send($to,$subject,'registerEmail.tpl',$h);
                      if(JxEmail::isError($result))
                      {
                          $this->log->log($result->getMessage());
                      }
                  } else {
                      $this->log->log($email->getMessage());
                  }
      
                  // Process plugins if need be
                  JxPlugin::doHook('registerProcess',&$this);
      
                  // Properly redirect
                  JxHttp::redirect();
              } else {
                $this->templateFile = 'registerError.tpl';
              }
          }
      }
  
      function _register()
      {
          $this->_JxAuthNo();
      }
  }

?>
