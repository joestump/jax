<?php

  class JxAdminNewsCategories extends JxAdmin
  {
    function JxAdminNewsCategories()
    {
      $this->JxAdmin();
      $this->table      = 'news_categories';
      $this->primaryKey = 'contentID';
      $this->childTable = 'news_categories';
      $this->titles     = array('Category ID','Category Name');
      $this->titleField = 'name';
      $this->showFields = array('contentID','name');
      $this->label      = 'News Categories';

      $this->addField(array('type' => 'JxFieldText',
                            'name' => 'name',
                            'label' => '&Category Name',
                            'size' => 35,
                            'value' => $_POST['name'],
                            'required' => true));

    }

    function _JxAdminNewsCategories()
    {
      $this->_JxAdmin();
    }
  }

?>
