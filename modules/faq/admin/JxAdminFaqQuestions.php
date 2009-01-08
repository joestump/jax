<?php


  class JxAdminFaqQuestions extends JxAdmin
  {
    function JxAdminFaqQuestions()
    {
      $this->JxAdmin();
      $this->table      = 'faq';
      $this->primaryKey = 'contentID';
      $this->childTable = 'faq';
      $this->titleField = 'question';
      $this->label      = 'FAQ';

      $this->titles = array('FAQ ID',
                            'Question',
                            'Hits');

      $this->showFields = array('contentID',
                                'question',
                                'hits');

      $sql = "SELECT *
              FROM faq_categories
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
                            'label' => '&FAQ Category',
                            'list' => $cats,
                            'value' => $_POST['categoryID'],
                            'required' => true));

      $this->addField(array('type' => 'JxFieldTextarea',
                            'name' => 'question',
                            'label' => '&Question',
                            'cols' => 35,
                            'rows' => 3,
                            'value' => $_POST['question'],
                            'required' => true));

      $this->addField(array('type' => 'JxFieldEditor',
                            'name' => 'answer',
                            'label' => '&Answer',
                            'value' => $_POST['answer'],
                            'required' => true));
    }
  }

?>
