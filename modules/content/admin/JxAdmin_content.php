<?php 

  class JxAdmin_content extends JxAdmin
  {
    function JxAdmin_content()
    {
      $this->JxAdmin();
      $this->table = 'content';
      $this->label = 'content';
      $this->primaryKey = 'contentID';
      $this->titles = array('ContentID',
                            'UserID',
                            'Posted',
                            'LastUpdate',
                            'Available',
                            'Mime',
                            'Title',
                            'Search',
                            'Module');

      $this->showFields= array('contentID',
                               'userID',
                               'posted',
                               'lastUpdate',
                               'available',
                               'mime',
                               'title',
                               'search',
                               'module');

      $this->addField(array('name' => 'contentID',
                            'label' => 'contentID',
                            'type' => 'JxFieldText',
                            'size' => '9',
                            'required' => 'true',
                            'value' => $_POST['contentID']));

      $this->addField(array('name' => 'userID',
                            'label' => 'userID',
                            'type' => 'JxFieldText',
                            'size' => '9',
                            'required' => 'true',
                            'value' => $_POST['userID']));

      $this->addField(array('name' => 'posted',
                            'label' => 'posted',
                            'type' => 'JxFieldText',
                            'size' => '11',
                            'required' => 'true',
                            'value' => $_POST['posted']));

      $this->addField(array('name' => 'lastUpdate',
                            'label' => 'lastUpdate',
                            'type' => 'JxFieldText',
                            'size' => '11',
                            'required' => 'true',
                            'value' => $_POST['lastUpdate']));

      $this->addField(array('name' => 'available',
                            'label' => 'available',
                            'type' => 'JxFieldText',
                            'size' => '1',
                            'required' => 'true',
                            'value' => $_POST['available']));

      $this->addField(array('name' => 'mime',
                            'label' => 'mime',
                            'type' => 'JxFieldText',
                            'size' => '25',
                            'required' => 'true',
                            'value' => $_POST['mime']));

      $this->addField(array('name' => 'title',
                            'label' => 'title',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['title']));

      $this->addField(array('name' => 'search',
                            'label' => 'search',
                            'type' => 'JxFieldTextarea',
                            'required' => 'true',
                            'value' => $_POST['search']));

      $this->addField(array('name' => 'module',
                            'label' => 'module',
                            'type' => 'JxFieldText',
                            'size' => '25',
                            'required' => 'true',
                            'value' => $_POST['module']));

    }

    function _JxAdmin_content()
    {
      $this->_JxAdmin();
    }
  }

?>