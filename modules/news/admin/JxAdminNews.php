<?php

  class JxAdminNews extends JxAdmin
  {
    function JxAdminNews()
    {
      $this->JxAdmin();
      $this->table      = 'news';
      $this->primaryKey = 'contentID';
      $this->childTable = 'news';
      $this->titleField = 'title';
      $this->label      = 'News Entry';
      $this->titles     = array('News ID','Title');
      $this->showFields = array('contentID','title');


      $sql = "SELECT *
              FROM news_categories
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
                            'label' => '&Category',
                            'list' => $cats,
                            'cols' => 35,
                            'rows' => 3,
                            'value' => $_POST['categoryID'],
                            'required' => true));

      $this->addField(array('type' => 'JxFieldText',
                            'name' => 'title',
                            'label' => '&Post Title',
                            'size' => 35,
                            'value' => stripslashes($_POST['title']),
                            'required' => true));

      $this->addField(array('type' => 'JxFieldEditor',
                            'name' => 'teaser',
                            'height' => 250,
                            'label' => '&Teaser',
                            'value' => stripslashes($_POST['teaser']),
                            'required' => true));

      $this->addField(array('type' => 'JxFieldEditor',
                            'name' => 'story',
                            'height' => 400,
                            'label' => '&Extended Entry',
                            'value' => stripslashes($_POST['story']),
                            'required' => false));
    }
  }

?>
