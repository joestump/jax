<?php 

  class JxAdmin_content_groups extends JxAdmin
  {
    function JxAdmin_content_groups()
    {
      $this->JxAdmin();
      $this->table = 'content_groups';
      $this->label = 'content_groups';
      $this->primaryKey = array('contentID','groupID');
      $this->titles = array('ContentID',
                            'GroupID',
                            'Permissions');

      $this->showFields= array('contentID',
                               'groupID',
                               'permissions');
    $this->childTable = 'content_groups';

      $this->addField(array('name' => 'contentID',
                            'label' => 'contentID',
                            'type' => 'JxFieldText',
                            'size' => '9',
                            'required' => 'true',
                            'value' => $_POST['contentID']));

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

    function _JxAdmin_content_groups()
    {
      $this->_JxAdmin();
    }
  }

?>