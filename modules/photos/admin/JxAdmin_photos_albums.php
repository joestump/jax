<?php 

  class JxAdmin_photos_albums extends JxAdmin
  {
    function JxAdmin_photos_albums()
    {
      $this->JxAdmin();
      $this->table = 'photos_albums';
      $this->label = 'photos_albums';
      $this->primaryKey = 'albumID';
      $this->titles = array('AlbumID',
                            'Title',
                            'Description',
                            'UserID',
                            'Posted');

      $this->showFields= array('albumID',
                               'title',
                               'description',
                               'userID',
                               'posted');

      $this->addField(array('name' => 'albumID',
                            'label' => 'albumID',
                            'type' => 'JxFieldText',
                            'size' => '2',
                            'required' => 'true',
                            'value' => $_POST['albumID']));

      $this->addField(array('name' => 'title',
                            'label' => 'title',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['title']));

      $this->addField(array('name' => 'description',
                            'label' => 'description',
                            'type' => 'JxFieldTextarea',
                            'value' => $_POST['description']));

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

    }

    function _JxAdmin_photos_albums()
    {
      $this->_JxAdmin();
    }
  }

?>