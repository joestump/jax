<?php 

  class JxAdmin_plugins extends JxAdmin
  {
    function JxAdmin_plugins()
    {
      $this->JxAdmin();
      $this->table = 'plugins';
      $this->label = 'plugins';
      $this->primaryKey = 'name';
      $this->titles = array('Name',
                            'Module',
                            'Title',
                            'Available');

      $this->showFields= array('name',
                               'module',
                               'title',
                               'available');

      $this->addField(array('name' => 'name',
                            'label' => 'name',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['name']));

      $this->addField(array('name' => 'module',
                            'label' => 'module',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['module']));

      $this->addField(array('name' => 'title',
                            'label' => 'title',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['title']));

      $this->addField(array('name' => 'available',
                            'label' => 'available',
                            'type' => 'JxFieldText',
                            'size' => '1',
                            'required' => 'true',
                            'value' => $_POST['available']));

    }

    function _JxAdmin_plugins()
    {
      $this->_JxAdmin();
    }
  }

?>