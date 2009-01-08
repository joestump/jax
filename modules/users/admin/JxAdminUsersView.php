<?php

  class JxAdminUsersView extends JxObjectDb 
  {

    function JxAdminUsersView() 
    {
      $this->JxObjectDb();
    }

    function render() 
    {
      if(strlen($_GET['email']))
      {
        $user = & new JxUser($_GET['email']);
        if(!JxUser::isError($user))
        {
          $groups = JxGroup::getGroups();

          $form = & new JxHtmlForm();
          $hbox = & new JxHbox('users');

          if(is_array($_POST['groups']) && count($_POST['groups']))
          {
            $sql = "DELETE 
                    FROM groups_users
                    WHERE userID='".$user->userID."'";

            $result = $this->db->query($sql);

            for($i = 0 ; $i < count($_POST['groups']) ; ++$i)
            {
              $sql = "INSERT INTO groups_users
                      SET groupID='".$_POST['groups'][$i]."',
                          userID='".$user->userID."'";

              $result = $this->db->query($sql);
            }

            $user = & new JxUser($_GET['email']);
          }

          if(isset($_POST['available']) && 
             in_array($_POST['available'],array(0,1)))
          {
            $sql = "UPDATE users
                    SET available='".$_POST['available']."'
                    WHERE userID='".$user->userID."'";

            $result = $this->db->query($sql);
            $user = & new JxUser($_GET['email']);
          }

          if(strlen($_POST['newpass']))
          {
            $sql = "UPDATE users 
                    SET password='".$_POST['newpass']."'
                    WHERE userID='".$user->userID."'";

            $result = $this->db->query($sql);
            $_POST['newpass'] = '';
          }


          $sql = "SELECT *
                  FROM users_sessions
                  WHERE userID='".$user->userID."'
                  ORDER BY posted DESC
                  LIMIT 10";

          $result = $this->db->query($sql);
          if(!DB::isError($result) && $result->numRows())
          {
            $session = '<table width="100%" cellspacing="0">'."\n";
            $session .= '<tr><td><b>Date</b></td><td><b>Time</b></td></tr>'."\n";
            while($row = $result->fetchRow())
            {
              $bg = (++$i % 2 == 0) ? '#cccccc' : '#ffffff';
              $date = date("D M dS, Y",$row['posted']);     
              $time = date("h:i:s A T",$row['posted']);     
              $session .= '
<tr bgcolor='.$bg.'>
  <td style="font-family: courier">'.$date.'</td>
  <td style="font-family: courier">'.$time.'</td>
</tr>
';     
            }
            $session .= '</table>'."\n";
          }

          $container = & new JxHtmlFormContainer('users');
          $container->label = 'User Information';

          $field = & new JxFieldStatic('email',$_GET['email']);
          $field->label = 'Email Address';
          $field->required = true;
          $field->title = $_GET['email'];
          $container->addComponent($field);

          $field = & new JxFieldCheckbox('groups[]',$groups,$user->getGroups());
          $field->label = 'Groups';
          $field->required = true;
          $container->addComponent($field);

          $arr = array('0' => 'Disabled', '1' => 'Enabled');
          $field = & new JxFieldSelect('available',$arr,$user->available);
          $field->label = 'Status';
          $field->required = false;
          $container->addComponent($field);

          $field = & new JxFieldText('newpass',$_POST['newpass'],15,15);
          $field->label = 'New Password';
          $field->required = false;
          $container->addComponent($field); 

          $field = & new JxFieldSubmit('button','Update Account');
          $container->addComponent($field);

          $hbox->addComponent($container);

          $container = & new JxHtmlFormContainer('sessions');
          $container->label = 'Last 10 Logins';

          $field = & new JxFieldHtml($session);
          $container->addComponent($field);
          $hbox->addComponent($container);

          $form->addComponent($hbox);
            
          $css = <<< EOT
<style type="text/css">
  td.JxHboxuserstd {
    width: 50%;
  }

  table.JxHboxusers {
    width: 100%;
  }
</style>
EOT;

          return $css.$form->getForm();
        }
        else
        {
          return 'Invalid email address!';
        }
      }
      else
      {
        $form = & new JxHtmlForm();

        $container = & new JxHtmlFormContainer('usersearch');
        $container->label = 'Search Users';

        $field = & new JxFieldText('email',$_POST['email']);
        $field->label = 'Email contains';
        $field->required = false;
        $container->addComponent($field);

        $groups = JxGroup::getGroups();
        $field = & new JxFieldCheckbox('groups[]',$groups,$_POST['groups']);
        $field->label = 'Groups';
        $field->required = false;
        $container->addComponent($field);

        $field = & new JxFieldSubmit('button','Search Users');
        $container->addComponent($field);

        $form->addComponent($container);
        if(!$form->isValid())
        {
          return $form->getForm();
        }
        else
        {
          $data = $form->getData();

          $sql = "SELECT U.*,S.posted AS last
                  FROM users AS U, users_sessions AS S, groups_users AS G
                  WHERE U.userID=S.userID AND 
                        U.userID=G.userID AND
                        U.available = 1";
         
          $where = array();
          if(strlen($data['email'])) {
              $where[] = " AND U.email LIKE '%".$data['email']."%'";
          }

          if(isset($_POST['groups']) && count($_POST['groups'])) {
              $where[] = " AND G.groupID IN ('".
                         implode("','",$_POST['groups'])."')";
          }

          $sql .= implode("\n",$where);
          $sql .= "\nGROUP BY U.userID";

          $result = $this->db->query($sql);
          if(!DB::isError($result) && $result->numRows())
          {
            $ret = '<table width="100%" cellspacing="0">'."\n";
            $ret .= '<tr>
                       <td><b>User ID</b></td>
                       <td><b>Last Name</b></td>
                       <td><b>First Name</b></td>
                       <td><b>Email</b></td>
                       <td><b>Created On</b></td>
                       <td><b>Last Login</b></td>
                     </tr>'."\n";
            while($row = $result->fetchRow())
            {
              $ret .= '
                       <tr>
                          <td><a href="'.$_SERVER['REQUEST_URI'].'/email='.$row['email'].'">'.$row['userID'].'</td>
                          <td>'.$row['lname'].'</td>
                          <td>'.$row['fname'].'</td>
                          <td><a href="mailto:'.$row['email'].'">'.$row['email'].'</a></td>
                          <td>'.date("Y-m-d",$row['posted']).'</td>
                          <td>'.date("Y-m-d",$row['last']).'</td>
                       </tr>'."\n";
            }
            $ret .= '</table>';

          }
          else
          {
            $ret = 'No users found matching that criteria';
          }

          return $ret;
        }
      }
    }

    function _JxAdminUsersView() 
    {
      $this->_JxObjectDb();
    }

  }

?>
