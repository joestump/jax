<?php 

  class JxAdmin_news_categories extends JxAdmin
  {
    function JxAdmin_news_categories()
    {
      $this->JxAdmin();
      $this->table = 'news_categories';
      $this->label = 'news_categories';
      $this->primaryKey = 'contentID';
      $this->titles = array('ContentID',
                            'Name');

      $this->showFields= array('contentID',
                               'name');
    $this->childTable = 'news_categories';

      $this->addField(array('name' => 'contentID',
                            'label' => 'contentID',
                            'type' => 'JxFieldText',
                            'size' => '9',
                            'required' => 'true',
                            'value' => $_POST['contentID']));

      $this->addField(array('name' => 'name',
                            'label' => 'name',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'value' => $_POST['name']));

    }

    function _JxAdmin_news_categories()
    {
      $this->_JxAdmin();
    }
  }

?>