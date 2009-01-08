<?php 

  class JxAdmin_photos_albums_images extends JxAdmin
  {
    function JxAdmin_photos_albums_images()
    {
      $this->JxAdmin();
      $this->table = 'photos_albums_images';
      $this->label = 'photos_albums_images';
      $this->primaryKey = array('imageID','albumID');
      $this->titles = array('ImageID',
                            'AlbumID');

      $this->showFields= array('imageID',
                               'albumID');

      $this->addField(array('name' => 'imageID',
                            'label' => 'imageID',
                            'type' => 'JxFieldText',
                            'size' => '2',
                            'required' => 'true',
                            'value' => $_POST['imageID']));

      $this->addField(array('name' => 'albumID',
                            'label' => 'albumID',
                            'type' => 'JxFieldText',
                            'size' => '2',
                            'required' => 'true',
                            'value' => $_POST['albumID']));

    }

    function _JxAdmin_photos_albums_images()
    {
      $this->_JxAdmin();
    }
  }

?>