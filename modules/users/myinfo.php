<?php


  class myinfo extends JxAuthUser
  {
    var $form;

    function myinfo()
    {
      $this->JxAuthUser();
      $this->page->title = 'Update Your Information';
      $this->form = array();

      $this->form['password'] = & new JxHtmlForm();
    
      $container = & new JxHtmlFormContainer('password');
      $container->label = 'Change Password';

      $field = & new JxFieldPassword('passA',$_POST['passA'],15,15);
      $field->label = 'New &Password';
      $field->toolTip = 'Passwords can only be 15 characters long';
      $field->required = true;
      $field->saveAs = 'password';
      $container->addComponent($field);

      $field = & new JxFieldPassword('passB',$_POST['passB'],15,15);
      $field->label = '&Verify Password';
      $field->required = true;
      $container->addComponent($field);

      $field = & new JxFieldHidden('action','password');
      $container->addComponent($field);

      $field = & new JxFieldSubmit('button','Change Password');
      $container->addComponent($field);
      $this->form['password']->addComponent($container);

      $this->form['account'] = & new JxHtmlForm();
      $container = & new JxHtmlFormContainer('myinfo');
      $container->label = 'Account Information';

      if(!count($_POST) || $_POST['button'] = 'Change Password')
      {
        $email = $this->user->email;
        $fname = $this->user->fname;
        $lname = $this->user->lname;
      }
      else
      {
        $email = $_POST['email'];
        $lname = $_POST['lname'];
        $fname = $_POST['fname'];
      }
     
      $field = & new JxFieldEmail('email',$email);
      $field->required = true;
      $container->addComponent($field);

      $field = & new JxFieldText('fname',$fname);
      $field->label = '&First Name';
      $field->required = true;
      $container->addComponent($field);

      $field = & new JxFieldHidden('action','account');
      $container->addComponent($field);

      $field = & new JxFieldText('lname',$lname);
      $field->label = '&Last Name';
      $field->required = true;
      $container->addComponent($field);

      $field = & new JxFieldSubmit('button','Update Account');
      $container->addComponent($field);

      $this->form['account']->addComponent($container);

      switch($_POST['action'])
      {
        case 'password':
          if($this->form['password']->isValid())
          {
            if($_POST['passA'] != $_POST['passB'])
            {
              $this->form['password']->throwError('passA',
                                                 'Passwords do not match');
            }
            else
            {
              $sql = "UPDATE users
                      SET password='".$_POST['passA']."'
                      WHERE userID='".$this->user->userID."'";

              $result = $this->db->query($sql);

              $this->templateFile = 'myinfoDone.tpl';
            }

          }

          break;

        case 'account':
          if($this->form['account']->isValid())
          {
            $sql = "UPDATE users
                    SET email='".$_POST['email']."',
                        fname='".$_POST['fname']."',
                        lname='".$_POST['lname']."'
                    WHERE userID='".$this->user->userID."'";

            $this->db->query($sql);
            $this->templateFile = 'myinfoDone.tpl';
          }

          break;
      }

      $form = $this->form['password']->getForm().
              $this->form['account']->getForm();

      $this->setData('infoForm',$form);

    }

    function _myinfo()
    {
      $this->_JxAuthUser();
    }
  }


?>
