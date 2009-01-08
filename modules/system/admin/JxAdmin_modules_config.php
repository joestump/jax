<?php 

  class JxAdmin_modules_config extends JxAdmin
  {
    function JxAdmin_modules_config()
    {
      $this->JxAdmin();
      $this->table = 'modules_config';
      $this->label = 'modules_config';
      $this->primaryKey = array('module','var');
      $this->titles = array('Module',
                            'Var',
                            'Value');

      $this->showFields= array('module',
                               'var',
                               'value');

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

    function _JxAdmin_modules_config()
    {
      $this->_JxAdmin();
    }
  }

?>