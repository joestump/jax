<?php

  class JxAdminGroups extends JxAdmin
  {
    function JxAdminGroups()
    {
      $this->JxAdmin();

      $this->table      = 'groups';
      $this->primaryKey = 'groupID';

      $this->titles     = array('Group ID',
                                'Name');

      $this->showFields = array('groupID',
                                'name');

      $this->label = 'System Groups';

      $this->addField(array('type' => 'JxFieldHidden',
                            'name' => 'groupID',
                            'value' => JxCreateId('groups','groupID',10,99),
                            'required' => true));

      $this->addField(array('type' => 'JxFieldText',
                            'name' => 'name',
                            'label' => 'Name',
                            'size' => 35,
                            'value' => $_POST['name'],
                            'required' => true));
    }

    function deleteRecord($id)
    {
      $this->addMessage('For technical reasons you cannot delete groups');
    }

    function _JxAdminGroups()
    {
      $this->_JxAdmin();
    }
  }

?>
