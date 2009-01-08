<?php 

  class JxAdmin_faq extends JxAdmin
  {
    function JxAdmin_faq()
    {
      $this->JxAdmin();
      $this->table = 'faq';
      $this->label = 'faq';
      $this->primaryKey = 'contentID';
      $this->titles = array('ContentID',
                            'CategoryID',
                            'Question',
                            'Answer',
                            'Hits');

      $this->showFields= array('contentID',
                               'categoryID',
                               'question',
                               'answer',
                               'hits');
    $this->childTable = 'faq';

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

      $this->addField(array('name' => 'question',
                            'label' => 'question',
                            'type' => 'JxFieldText',
                            'size' => '45',
                            'required' => 'true',
                            'value' => $_POST['question']));

      $this->addField(array('name' => 'answer',
                            'label' => 'answer',
                            'type' => 'JxFieldTextarea',
                            'required' => 'true',
                            'value' => $_POST['answer']));

      $this->addField(array('name' => 'hits',
                            'label' => 'hits',
                            'type' => 'JxFieldText',
                            'size' => '11',
                            'required' => 'true',
                            'value' => $_POST['hits']));

    }

    function _JxAdmin_faq()
    {
      $this->_JxAdmin();
    }
  }

?>