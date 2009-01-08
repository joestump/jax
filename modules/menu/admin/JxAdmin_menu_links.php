<?php 

  class JxAdmin_menu_links extends JxAdmin
  {
    function JxAdmin_menu_links()
    {
      $this->JxAdmin();
      $this->table = 'menu_links';
      $this->label = 'menu_links';
      $this->primaryKey = 'contentID';
      $this->titles = array('ContentID',
                            'CategoryID',
                            'Name',
                            'Url',
                            'Hits',
                            'Sort');

      $this->showFields= array('contentID',
                               'categoryID',
                               'name',
                               'url',
                               'hits',
                               'sort');
    $this->childTable = 'menu_links';

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

      $this->addField(array('name' => 'name',
                            'label' => 'name',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['name']));

      $this->addField(array('name' => 'url',
                            'label' => 'url',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['url']));

      $this->addField(array('name' => 'hits',
                            'label' => 'hits',
                            'type' => 'JxFieldText',
                            'size' => '9',
                            'required' => 'true',
                            'value' => $_POST['hits']));

      $this->addField(array('name' => 'sort',
                            'label' => 'sort',
                            'type' => 'JxFieldText',
                            'size' => '2',
                            'required' => 'true',
                            'value' => $_POST['sort']));

    }

    function _JxAdmin_menu_links()
    {
      $this->_JxAdmin();
    }
  }

?>