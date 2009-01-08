<?php 

  class JxAdmin_users extends JxAdmin
  {
    function JxAdmin_users()
    {
      $this->JxAdmin();
      $this->table = 'users';
      $this->label = 'users';
      $this->primaryKey = 'userID';
      $this->titles = array('UserID',
                            'Password',
                            'Email',
                            'Fname',
                            'Lname',
                            'Posted',
                            'Admin',
                            'Available');

      $this->showFields= array('userID',
                               'password',
                               'email',
                               'fname',
                               'lname',
                               'posted',
                               'admin',
                               'available');

      $this->addField(array('name' => 'userID',
                            'label' => 'userID',
                            'type' => 'JxFieldText',
                            'size' => '9',
                            'required' => 'true',
                            'value' => $_POST['userID']));

      $this->addField(array('name' => 'password',
                            'label' => 'password',
                            'type' => 'JxFieldText',
                            'size' => '15',
                            'required' => 'true',
                            'value' => $_POST['password']));

      $this->addField(array('name' => 'email',
                            'label' => 'email',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['email']));

      $this->addField(array('name' => 'fname',
                            'label' => 'fname',
                            'type' => 'JxFieldText',
                            'size' => '35',
                            'required' => 'true',
                            'value' => $_POST['fname']));

      $this->addField(array('name' => 'lname',
                            'label' => 'lname',
                            'type' => 'JxFieldText',
                            'size' => '35',
                            'required' => 'true',
                            'value' => $_POST['lname']));

      $this->addField(array('name' => 'posted',
                            'label' => 'posted',
                            'type' => 'JxFieldText',
                            'size' => '11',
                            'required' => 'true',
                            'value' => $_POST['posted']));

      $this->addField(array('name' => 'admin',
                            'label' => 'admin',
                            'type' => 'JxFieldText',
                            'size' => '1',
                            'required' => 'true',
                            'value' => $_POST['admin']));

      $this->addField(array('name' => 'available',
                            'label' => 'available',
                            'type' => 'JxFieldText',
                            'size' => '1',
                            'required' => 'true',
                            'value' => $_POST['available']));

    }

    function _JxAdmin_users()
    {
      $this->_JxAdmin();
    }
  }

?>