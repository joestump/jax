<?php 

  class JxAdmin_photos_images extends JxAdmin
  {
    function JxAdmin_photos_images()
    {
      $this->JxAdmin();
      $this->table = 'photos_images';
      $this->label = 'photos_images';
      $this->primaryKey = 'imageID';
      $this->titles = array('ImageID',
                            'UserID',
                            'Caption',
                            'Type',
                            'Posted');

      $this->showFields= array('imageID',
                               'userID',
                               'caption',
                               'type',
                               'posted');

      $this->addField(array('name' => 'imageID',
                            'label' => 'imageID',
                            'type' => 'JxFieldText',
                            'size' => '2',
                            'required' => 'true',
                            'value' => $_POST['imageID']));

      $this->addField(array('name' => 'userID',
                            'label' => 'userID',
                            'type' => 'JxFieldText',
                            'size' => '9',
                            'required' => 'true',
                            'value' => $_POST['userID']));

      $this->addField(array('name' => 'caption',
                            'label' => 'caption',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['caption']));

      $this->addField(array('name' => 'type',
                            'label' => 'type',
                            'type' => 'JxFieldText',
                            'size' => '5',
                            'required' => 'true',
                            'value' => $_POST['type']));

      $this->addField(array('name' => 'posted',
                            'label' => 'posted',
                            'type' => 'JxFieldText',
                            'size' => '11',
                            'required' => 'true',
                            'value' => $_POST['posted']));

    }

    function _JxAdmin_photos_images()
    {
      $this->_JxAdmin();
    }
  }

?>