<?php

  class JxAdminMenuLinks extends JxAdmin
  {
    function JxAdminMenuLinks()
    {
      $this->JxAdmin();

      $this->table      = 'menu_links';
      $this->primaryKey = 'contentID';
      $this->childTable = 'menu_links';
      $this->titleField = 'name';
      $this->label      = 'Links';

      $this->titles = array('Name',
                            'Hits');

      $this->showFields = array('name',
                                'hits');

      $sql = "SELECT *
              FROM menu_categories
              ORDER BY name";

      $result = $this->db->query($sql);
      if(!DB::isError($result) && $result->numRows())
      {
        $cats = array();
        while($row = $result->fetchRow())
        {
          $cats[$row['contentID']] = $row['name'];
        }
      }

      $this->addField(array('type' => 'JxFieldSelect',
                            'name' => 'categoryID',
                            'label' => '&Menu Category',
                            'list' => $cats,
                            'value' => $_POST['categoryID'],
                            'required' => true));

      $this->addField(array('type' => 'JxFieldText',
                            'name' => 'name',
                            'label' => '&Link Name',
                            'value' => $_POST['name'],
                            'required' => true));

      $this->addField(array('type' => 'JxFieldText',
                            'name' => 'url',
                            'label' => 'Link &URL',
                            'size' => 50,
                            'value' => $_POST['url'],
                            'required' => true));

    }

    function _JxAdminMenuLinks()
    {
      $this->_JxAdmin();
    }
  }

?>
