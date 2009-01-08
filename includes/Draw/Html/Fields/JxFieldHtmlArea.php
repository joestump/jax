<?php

  class JxFieldHtmlArea extends JxField 
  {
    var $path;
    var $width;
    var $height;

    function JxFieldHtmlArea($name,$value='',$width=90,$height=25)
    {
      $this->JxField($name,$value);

      $this->width  = $width;
      $this->height = $height;
      $this->path   = JX_URI_PATH.'/includes/HTMLArea';

      $page = & JxSingleton::factory('page');
      $page->addJsFile($this->path.'/htmlarea.js');
      $page->addJsFile($this->path.'/lang/en.js');
      $page->addJsFile($this->path.'/dialog.js');
      $page->addJsFile($this->path.'/popupwin.js');
      $page->addJsFile($this->path.'/plugins/TableOperations/table-operations.js');
      $page->addJsFile($this->path.'/plugins/TableOperations/lang/en.js');
      $page->addCssFile($this->path.'/htmlarea.css');
    }

    function getElement()
    {

      return <<< EOT

<textarea id="ta" name="{$this->name}" rows="{$this->height}" cols="{$this->width}">

  {$this->value}

</textarea>

<script type="text/javascript" language="javascript">

  function initEditor() {

    var editor = new HTMLArea("ta");    
    editor.config.editorURL = '{$this->path}/';
    editor.config.toolbar = [
    [ "fontname", "space", "fontsize", "space", "formatblock", "space",
      "bold", "italic", "underline", "separator", "strikethrough", 
      "subscript", "superscript", "separator", "copy", "cut", "paste", "space",
      "undo", "redo" ],
        
    [ "justifyleft", "justifycenter", "justifyright", "justifyfull", 
      "separator", "insertorderedlist", "insertunorderedlist", "outdent", 
      "indent", "separator", "forecolor", "hilitecolor", "textindicator", 
      "separator", "inserthorizontalrule", "createlink", "insertimage", 
      "inserttable", "htmlmode", "separator", "popupeditor" ]
    ];


    editor.registerPlugin("TableOperations");
    editor.generate();

    return false;
  }

  initEditor();
</script>

EOT;

    }

    function _JxFieldHtmlArea()
    { 
      $this->_JxField();
    }
  }

?>
