<?php

  class JxAdminMenuCategories extends JxAdmin
  {
    function JxAdminMenuCategories()
    {
      $this->JxAdmin();
    
      $this->table      = 'menu_categories';
      $this->primaryKey = 'contentID';
      $this->childTable = 'menu_categories';
      $this->titleField = 'name';
      $this->label      = 'Categories';

      $this->titles = array('Name',
                            'Hits');

      $this->showFields = array('name',
                                'hits');

      $this->addField(array('type' => 'JxFieldText',
                            'name' => 'name',
                            'label' => '&Menu Category Name',
                            'value' => $_POST['name'],
                            'required' => true));

      $this->addField(array('type' => 'JxFieldText',
                            'name' => 'url',
                            'label' => 'Link &URL',
                            'size' => 50,
                            'value' => $_POST['url'],
                            'required' => false));
    }

    function _JxAdminMenuCategories()
    {
      $this->_JxAdmin();
    }
  }

?>
