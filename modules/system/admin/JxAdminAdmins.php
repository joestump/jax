<?php

  class JxAdminAdmins extends JxAdmin
  {
    function JxAdminAdmins()
    {
      $this->JxAdmin();
    }

    function render()
    {
      $this->form = & new JxHtmlForm();
      $this->form->method = "get";
      $this->form->action = $_SERVER['SCRIPT_NAME'].'/jax/'.
                            'eventHandler=admin/module=system/form=JxAdminAdmins';

      $template = & new JxTemplate(JX_HOSTED_PATH.'/modules/system/tpl');

      if(strlen($_GET['email']))
      {
        $user = & new JxUser($_GET['email']);
        if(!JxUser::isError($user))
        {

          $sql = "UPDATE users
                  SET admin=1
                  WHERE email='".$_GET['email']."'";

          $result = $this->db->query($sql);
          if(!DB::isError($result))
          {
            $sql = "INSERT INTO groups_users
                    SET groupID='".JX_GRP_ADMIN."',
                        userID='".$user->userID."'";

            $result = $this->db->query($sql);
            if(!DB::isError($result))
            {
              $container = & new JxHtmlFormContainer('msg');
              $container->label = 'Messages';

              $field = & new JxFieldHtml('Admin permissions granted to '.
                                         $user->email);
              $container->addComponent($field);
              $this->form->addComponent($container);

              $this->log->log($this->user->email.' granted administrative '.
                              'privileges to '.$user->email);
            }
          }
        }
      }

      if((int)$_GET['delete'] > 0)
      {
        $user = & new JxUser((int)$_GET['delete']);
        if(!JxUser::isError($user))
        {
          $sql = "UPDATE users
                  SET admin=0
                  WHERE userID='".$_GET['delete']."'";

          $result = $this->db->query($sql);
          if(!DB::isError($result))
          {
            $sql = "DELETE
                    FROM groups_users
                    WHERE groupID='".JX_GRP_ADMIN."' AND
                          userID='".$user->userID."'";

            $result = $this->db->query($sql);
            if(!DB::isError($result))
            {

              $container = & new JxHtmlFormContainer('msg');
              $container->label = 'Messages';

              $field = & new JxFieldHtml('Admin permissions for '.
                                         $user->email.' have been revoked ');
              $container->addComponent($field);
              $this->form->addComponent($container);
            }
          }
        }
      }

      $sql = "SELECT *
              FROM users
              WHERE admin=1 AND userID != 1
              ORDER BY email";

      $result = $this->db->query($sql);
      if(!DB::isError($result) && $result->numRows())
      {
        $admins = array();
        while($row = $result->fetchRow())
        {
          $admins[] = $row;
        }

        $template->assign('admins',$admins);
      }

      $container = & new JxHtmlFormContainer('admin');
      $container->label = 'Site Administrators';

      $field = & new JxFieldEmail('email',$_POST['email']);
      $field->label = 'Email Address';
      $field->required = true;
      $container->addComponent($field);

      $field = & new JxFieldSubmit('button','Make an Administrator');
      $container->addComponent($field);

      $this->form->addComponent($container);
      $template->assign('form',$this->form->getForm());

      return $template->fetch('JxAdminAdmins.tpl');
    }

    function _JxAdminAdmins()
    {
      $this->_JxAdmin();
    }
  }

?>
