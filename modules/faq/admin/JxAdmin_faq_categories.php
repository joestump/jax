<?php 

  class JxAdmin_faq_categories extends JxAdmin
  {
    function JxAdmin_faq_categories()
    {
      $this->JxAdmin();
      $this->table = 'faq_categories';
      $this->label = 'faq_categories';
      $this->primaryKey = 'contentID';
      $this->titles = array('ContentID',
                            'Name');

      $this->showFields= array('contentID',
                               'name');
    $this->childTable = 'faq_categories';

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
                            'required' => 'true',
                            'value' => $_POST['name']));

    }

    function _JxAdmin_faq_categories()
    {
      $this->_JxAdmin();
    }
  }

?>