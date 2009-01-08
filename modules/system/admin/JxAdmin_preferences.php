<?php 

  class JxAdmin_preferences extends JxAdmin
  {
    function JxAdmin_preferences()
    {
      $this->JxAdmin();
      $this->table = 'preferences';
      $this->label = 'preferences';
      $this->primaryKey = array('userID','module','var');
      $this->titles = array('UserID',
                            'Module',
                            'Var',
                            'Value');

      $this->showFields= array('userID',
                               'module',
                               'var',
                               'value');

      $this->addField(array('name' => 'userID',
                            'label' => 'userID',
                            'type' => 'JxFieldText',
                            'size' => '9',
                            'required' => 'true',
                            'value' => $_POST['userID']));

      $this->addField(array('name' => 'module',
                            'label' => 'module',
                            'type' => 'JxFieldText',
                            'size' => '15',
                            'required' => 'true',
                            'value' => $_POST['module']));

      $this->addField(array('name' => 'var',
                            'label' => 'var',
                            'type' => 'JxFieldText',
                            'size' => '25',
                            'required' => 'true',
                            'value' => $_POST['var']));

      $this->addField(array('name' => 'value',
                            'label' => 'value',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['value']));

    }

    function _JxAdmin_preferences()
    {
      $this->_JxAdmin();
    }
  }

?>