<?php 

  class JxAdmin_groups extends JxAdmin
  {
    function JxAdmin_groups()
    {
      $this->JxAdmin();
      $this->table = 'groups';
      $this->label = 'groups';
      $this->primaryKey = array('groupID','name');
      $this->titles = array('GroupID',
                            'Name',
                            'Sticky');

      $this->showFields= array('groupID',
                               'name',
                               'sticky');

      $this->addField(array('name' => 'groupID',
                            'label' => 'groupID',
                            'type' => 'JxFieldText',
                            'size' => '2',
                            'required' => 'true',
                            'value' => $_POST['groupID']));

      $this->addField(array('name' => 'name',
                            'label' => 'name',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['name']));

      $this->addField(array('name' => 'sticky',
                            'label' => 'sticky',
                            'type' => 'JxFieldText',
                            'size' => '1',
                            'required' => 'true',
                            'value' => $_POST['sticky']));

    }

    function _JxAdmin_groups()
    {
      $this->_JxAdmin();
    }
  }

?>