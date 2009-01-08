<?php 

  class JxAdmin_news extends JxAdmin
  {
    function JxAdmin_news()
    {
      $this->JxAdmin();
      $this->table = 'news';
      $this->label = 'news';
      $this->primaryKey = 'contentID';
      $this->titles = array('ContentID',
                            'CategoryID',
                            'Title',
                            'Teaser',
                            'Story');

      $this->showFields= array('contentID',
                               'categoryID',
                               'title',
                               'teaser',
                               'story');
    $this->childTable = 'news';

      $this->addField(array('name' => 'contentID',
                            'label' => 'contentID',
                            'type' => 'JxFieldText',
                            'size' => '9',
                            'required' => 'true',
                            'value' => $_POST['contentID']));

      $this->addField(array('name' => 'categoryID',
                            'label' => 'categoryID',
                            'type' => 'JxFieldText',
                            'size' => '9',
                            'required' => 'true',
                            'value' => $_POST['categoryID']));

      $this->addField(array('name' => 'title',
                            'label' => 'title',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['title']));

      $this->addField(array('name' => 'teaser',
                            'label' => 'teaser',
                            'type' => 'JxFieldTextarea',
                            'required' => 'true',
                            'value' => $_POST['teaser']));

      $this->addField(array('name' => 'story',
                            'label' => 'story',
                            'type' => 'JxFieldTextarea',
                            'required' => 'true',
                            'value' => $_POST['story']));

    }

    function _JxAdmin_news()
    {
      $this->_JxAdmin();
    }
  }

?>