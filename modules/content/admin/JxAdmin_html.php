<?php 

  class JxAdmin_html extends JxAdmin
  {
    function JxAdmin_html()
    {
      $this->JxAdmin();
      $this->table = 'html';
      $this->label = 'html';
      $this->primaryKey = 'contentID';
      $this->titles = array('ContentID',
                            'UserID',
                            'Title',
                            'Name',
                            'Html',
                            'LastUpdate');

      $this->showFields= array('contentID',
                               'userID',
                               'title',
                               'name',
                               'html',
                               'lastUpdate');
    $this->childTable = 'html';

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

      $this->addField(array('name' => 'title',
                            'label' => 'title',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['title']));

      $this->addField(array('name' => 'name',
                            'label' => 'name',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['name']));

      $this->addField(array('name' => 'html',
                            'label' => 'html',
                            'type' => 'JxFieldTextarea',
                            'required' => 'true',
                            'value' => $_POST['html']));

      $this->addField(array('name' => 'lastUpdate',
                            'label' => 'lastUpdate',
                            'type' => 'JxFieldText',
                            'size' => '11',
                            'required' => 'true',
                            'value' => $_POST['lastUpdate']));

    }

    function _JxAdmin_html()
    {
      $this->_JxAdmin();
    }
  }

?>