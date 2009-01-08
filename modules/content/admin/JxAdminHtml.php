<?php

  class JxAdminHtml extends JxAdmin
  {
    function JxAdminHtml()
    {
      $this->JxAdmin();

      $this->table      = 'html';
      $this->primaryKey = 'contentID';
      $this->childTable = 'html';
      $this->titleField = 'title';
      $this->label      = 'HTML Page Editor';

      $this->titles = array('Content ID',
                            'Title',
                            'Name');

      $this->showFields = array('contentID',
                                'title',
                                'name');

      $this->addField(array('type' => 'JxFieldText',
                            'name' => 'title',
                            'label' => 'Page &Title',
                            'size' => 55,
                            'maxLength' => 255,
                            'value' => stripslashes($_POST['title']),
                            'required' => true));

      $this->addField(array('type' => 'JxFieldText',
                            'name' => 'name',
                            'label' => 'Page &Name',
                            'size' => 25,
                            'maxLength' => 64,
                            'value' => $_POST['name'],
                            'required' => true));
      
      $this->addField(array('type' => 'JxFieldEditor',
                            'name' => 'html',
                            'label' => '&Content',
                            'height' => '500',
                            'value' => stripslashes($_POST['html']),
                            'required' => true));

      $this->addField(array('type' => 'JxFieldHidden',
                            'name' => 'lastUpdate',
                            'value' => time(),
                            'required' => true));

      $user = & JxSingleton::factory('user');
      $this->addField(array('type' => 'JxFieldHidden',
                            'name' => 'userID',
                            'value' => $user->userID,
                            'required' => true));
    }

    function _html()
    {
      $this->_JxAdmin();
    }
  }

?>
