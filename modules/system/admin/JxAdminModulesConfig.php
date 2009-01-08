<?php 

  class JxAdminModulesConfig extends JxAdmin
  {
    function JxAdminModulesConfig()
    {
      $this->JxAdmin();
      $this->table = 'modules_config';
      $this->label = 'Modules Config';
      $this->primaryKey = array('module','var');
      $this->titles = array('Module',
                            'Var',
                            'Value');

      $this->showFields = array('module',
                                'var',
                                'value');

      $modules = & DB_DataObject::factory('modules');
      if($modules->find())
      {
        $arr = array();
        while($modules->fetch())
        {
          $arr[$modules->name] = $modules->title;
        }
      } 

      $this->addField(array('name' => 'module',
                            'label' => 'Module',
                            'type' => 'JxFieldSelect',
                            'list' => $arr,
                            'value' => $_POST['module'],
                            'required' => 'true'));

      $this->addField(array('name' => 'var',
                            'label' => 'Variable',
                            'type' => 'JxFieldText',
                            'value' => $_POST['var'],
                            'size' => '25',
                            'required' => 'true'));

      $this->addField(array('name' => 'value',
                            'label' => 'Value',
                            'type' => 'JxFieldText',
                            'value' => $_POST['value'],
                            'size' => '45',
                            'required' => 'true'));

    }

    function _JxAdminModulesConfig()
    {
      $this->_JxAdmin();
    }
  }

?>
