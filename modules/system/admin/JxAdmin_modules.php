<?php 

  class JxAdmin_modules extends JxAdmin
  {
    function JxAdmin_modules()
    {
      $this->JxAdmin();
      $this->table = 'modules';
      $this->label = 'modules';
      $this->primaryKey = 'moduleID';
      $this->titles = array('ModuleID',
                            'Name',
                            'Title',
                            'Description',
                            'Image',
                            'Posted',
                            'Available');

      $this->showFields= array('moduleID',
                               'name',
                               'title',
                               'description',
                               'image',
                               'posted',
                               'available');

      $this->addField(array('name' => 'moduleID',
                            'label' => 'moduleID',
                            'type' => 'JxFieldText',
                            'size' => '3',
                            'required' => 'true',
                            'value' => $_POST['moduleID']));

      $this->addField(array('name' => 'name',
                            'label' => 'name',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['name']));

      $this->addField(array('name' => 'title',
                            'label' => 'title',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['title']));

      $this->addField(array('name' => 'description',
                            'label' => 'description',
                            'type' => 'JxFieldTextarea',
                            'required' => 'true',
                            'value' => $_POST['description']));

      $this->addField(array('name' => 'image',
                            'label' => 'image',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['image']));

      $this->addField(array('name' => 'posted',
                            'label' => 'posted',
                            'type' => 'JxFieldText',
                            'size' => '11',
                            'required' => 'true',
                            'value' => $_POST['posted']));

      $this->addField(array('name' => 'available',
                            'label' => 'available',
                            'type' => 'JxFieldText',
                            'size' => '1',
                            'required' => 'true',
                            'value' => $_POST['available']));

    }

    function _JxAdmin_modules()
    {
      $this->_JxAdmin();
    }
  }

?>