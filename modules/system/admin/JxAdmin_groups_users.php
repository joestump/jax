<?php 

  class JxAdmin_groups_users extends JxAdmin
  {
    function JxAdmin_groups_users()
    {
      $this->JxAdmin();
      $this->table = 'groups_users';
      $this->label = 'groups_users';
      $this->primaryKey = array('groupID','userID');
      $this->titles = array('GroupID',
                            'UserID');

      $this->showFields= array('groupID',
                               'userID');

      $this->addField(array('name' => 'groupID',
                            'label' => 'groupID',
                            'type' => 'JxFieldText',
                            'size' => '2',
                            'required' => 'true',
                            'value' => $_POST['groupID']));

      $this->addField(array('name' => 'userID',
                            'label' => 'userID',
                            'type' => 'JxFieldText',
                            'size' => '9',
                            'required' => 'true',
                            'value' => $_POST['userID']));

    }

    function _JxAdmin_groups_users()
    {
      $this->_JxAdmin();
    }
  }

?>