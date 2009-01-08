<?php 

  class JxAdminPhotosAlbums extends JxAdmin
  {
      function JxAdminPhotosAlbums()
      {
          $this->JxAdmin();
          $this->table = 'photos_albums';
          $this->label = 'Photo Albums';
          $this->primaryKey = 'albumID';
          $this->titles = array('AlbumID',
                                'Title',
                                'Posted');
    
          $this->showFields= array('albumID',
                                   'title',
                                   'posted');
    
          $this->addField(array('name' => 'albumID',
                                'label' => 'albumID',
                                'type' => 'JxFieldHidden',
                                'required' => 'true',
                                'value' => JxCreateId('photos_albums','albumID')));
    
          $this->addField(array('name' => 'title',
                                'label' => 'Title',
                                'type' => 'JxFieldText',
                                'size' => '45',
                                'required' => 'true',
                                'value' => $_POST['title']));
    
          $this->addField(array('name' => 'description',
                                'label' => 'Description',
                                'type' => 'JxFieldTextarea',
                                'cols' => '40',
                                'rows' => '10',
                                'value' => $_POST['description']));
    
          $this->addField(array('name' => 'userID',
                                'type' => 'JxFieldHidden',
                                'required' => 'true',
                                'value' => $this->user->userID));
    
          $this->addField(array('name' => 'posted',
                                'label' => 'posted',
                                'type' => 'JxFieldHidden',
                                'size' => '11',
                                'required' => 'true',
                                'value' => time()));
    
      }

      function _JxAdminPhotosAlbums()
      {
          $this->_JxAdmin();
      }
  }

?>
