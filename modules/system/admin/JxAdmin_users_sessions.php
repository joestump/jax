<?php 

  class JxAdmin_users_sessions extends JxAdmin
  {
    function JxAdmin_users_sessions()
    {
      $this->JxAdmin();
      $this->table = 'users_sessions';
      $this->label = 'users_sessions';
      $this->titles = array('UserID',
                            'SessionID',
                            'Posted',
                            'Track');

      $this->showFields= array('userID',
                               'sessionID',
                               'posted',
                               'track');

      $this->addField(array('name' => 'userID',
                            'label' => 'userID',
                            'type' => 'JxFieldText',
                            'size' => '9',
                            'required' => 'true',
                            'value' => $_POST['userID']));

      $this->addField(array('name' => 'sessionID',
                            'label' => 'sessionID',
                            'type' => 'JxFieldText',
                            'size' => '32',
                            'required' => 'true',
                            'value' => $_POST['sessionID']));

      $this->addField(array('name' => 'posted',
                            'label' => 'posted',
                            'type' => 'JxFieldText',
                            'size' => '11',
                            'required' => 'true',
                            'value' => $_POST['posted']));

      $this->addField(array('name' => 'track',
                            'label' => 'track',
                            'type' => 'JxFieldText',
                            'size' => '1',
                            'required' => 'true',
                            'value' => $_POST['track']));

    }

    function _JxAdmin_users_sessions()
    {
      $this->_JxAdmin();
    }
  }

?>