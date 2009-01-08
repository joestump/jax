<?php 

  class login extends JxAuthNo
  {
      var $form;

      function login()
      {
          $this->JxAuthNo();
      }

      function __default()
      {
          $this->form = & new JxHtmlForm();
          $this->page->title = 'Login';
    
          $container = & new JxHtmlFormContainer('Login');
          $container->label = 'Login';

          if (isset($_GET['email']) && !isset($_POST['login'])) {
              $_POST['login'] = $_GET['email'];
          }

          if (isset($_GET['password']) && !isset($_POST['password'])) {
              $_POST['password'] = $_GET['password'];
          }

    
          if (JX_LOGIN_TYPE == 'email') {
              $field = & new JxFieldEmail('login',$_POST['login']);
              $field->label = 'Email';
              $field->required = true;
              $container->addComponent($field);
          } elseif (JX_LOGIN_TYPE == 'username') {
              $field = & new JxFieldString('login',$_POST['login']);
              $field->label = 'Username';
              $field->required = true;
              $container->addComponent($field);
          } else {
              return new PEAR_Error('Invalid JX_LOGIN_TYPE: '.JX_LOGIN_TYPE);
          }
    
          $field = & new JxFieldPassword('password',$_POST['password'],15,15);
          $field->label = '&Password';
          $field->required = true;
          $container->addComponent($field);
    
          $field = & new JxFieldSubmit('button','Login!');
          $container->addComponent($field);
    
          $this->form->addComponent($container);
    
          if (is_array($_POST) && count($_POST)) {
              $sql = "SELECT *
                      FROM users
                      WHERE ".JX_LOGIN_TYPE."='".$_POST['login']."'";

              $result = $this->db->getRow($sql);
              if(!JxUser::isError($result)) {
                  if ($result['password'] != $_POST['password']) {
                      $this->form->throwError('password','Invalid password');
                  }
              } else {
                  $this->form->throwError('login','Invalid login');
              }
          }
    
          if (!$this->form->isValid()) { 
              $this->setData('loginForm',$this->form->getForm());
          } else {
              $data = $this->form->getData();
              $session = & new JxSession();
        
              if (!JxSession::isError($session)) {
                  $session->create($data['login']);
                  JxHttp::redirect();
              }
          }
      }

      function _login()
      {
          $this->_JxAuthNo();
      }
  }

?>
