<?php

  /**
  * JxFieldEditor
  *
  * WYSIWYG HTML Editor
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  */
  class JxFieldEditor extends JxField
  {
    var $editor;
    var $height;
    var $width;

    function JxFieldEditor($name,$value='',$height=200,$width=570,
                           $toolbarSet='Default')
    {
      $this->JxField($name,$value);

      $this->height = $height;
      $this->width  = $width;

      $this->editor = new FCKeditor;
      $this->editor->ToolbarSet = $toolbarSet;
      $this->editor->CanUpload = false;
      $this->editor->CanBrowse = false;
      $this->editor->Value = $value;
    }

    function getElement()
    {
      return $this->editor->CreateFCKeditor($this->name,
                                            $this->width,
                                            $this->height);
    }

    function resetData()
    {
      $this->value = $this->editor->Value = '';
    }

    function _JxFieldEditor()
    {
      $this->_JxField();
    }
  }

?>
