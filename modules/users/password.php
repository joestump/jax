<?php

  require_once(JX_BASE_PATH.'/includes/App/JxEmail.php');

  class password extends JxAuthNo
  {
    var $form;

    function password()
    {
      $this->JxAuthNo();
      $this->page->title = 'Lost Password';
    }

    function lost()
    {
      $this->displayPage = false;
      $this->templateFile = 'lostPassword.tpl';
      $this->form = & new JxHtmlForm();
 
      $container = & new JxHtmlFormContainer('lost');
      $container->label = 'Lost Password';

      $field = & new JxFieldEmail('email',$_POST['email']);
      $field->label = 'Your Email Address';
      $field->required = true;
      $container->addComponent($field); 

      $field = & new JxFieldSubmit('button','Submit');
      $container->addComponent($field); 

      $this->form->addComponent($container);
      if(!$this->form->isValid())
      {
        $this->setData('form',$this->form->getForm());
 
      }
      else
      {
        $data = $this->form->getData();

        $sql = "SELECT *
                FROM users
                WHERE email='".$data['email']."'";

        $result = $this->db->query($sql);
        if(!DB::isError($result) && $result->numRows())
        {
          $this->templateFile = 'lostPasswordDone.tpl';
          $this->setData('count',$result->numRows());
          $this->setData('email',$data['email']);
          while($row = $result->fetchRow())
          {
            $email = & new JxEmail($this->path.'/tpl');
            if(!JxEmail::isError($email))
            {
              $to = $row['email'];
              $subject = 'Your Account Information';

              $h = array();
              $h['From'] = $_SERVER['SERVER_NAME'].' <void@void.com>';
              $h['Reply-To'] = $h['Return-Path'] = $h['From'];

              $email->template->assign('row',$row);
              $send = $email->send($to,$subject,'lostPasswordEmail.tpl',$h);
              if(JxEmail::isError($send))
              {
                $this->log->log($send->getMessage());
              }
            }
          }
        }
        else
        {
          $this->templateFile = 'lostPasswordError.tpl';
        }
      } 
    }

    function _password()
    {
      $this->_JxAuthNo();
    }
  }

?>
