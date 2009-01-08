<?php 

  class JxAdmin_modules_groups extends JxAdmin
  {
    function JxAdmin_modules_groups()
    {
      $this->JxAdmin();
      $this->table = 'modules_groups';
      $this->label = 'modules_groups';
      $this->primaryKey = array('moduleID','groupID');
      $this->titles = array('ModuleID',
                            'GroupID',
                            'Permissions');

      $this->showFields= array('moduleID',
                               'groupID',
                               'permissions');

      $this->addField(array('name' => 'moduleID',
                            'label' => 'moduleID',
                            'type' => 'JxFieldText',
                            'size' => '3',
                            'required' => 'true',
                            'value' => $_POST['moduleID']));

      $this->addField(array('name' => 'groupID',
                            'label' => 'groupID',
                            'type' => 'JxFieldText',
                            'size' => '2',
                            'required' => 'true',
                            'value' => $_POST['groupID']));

      $this->addField(array('name' => 'permissions',
                            'label' => 'permissions',
                            'type' => 'JxFieldText',
                            'size' => '3',
                            'required' => 'true',
                            'value' => $_POST['permissions']));

    }

    function _JxAdmin_modules_groups()
    {
      $this->_JxAdmin();
    }
  }

?>