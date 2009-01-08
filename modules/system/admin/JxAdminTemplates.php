<?php

  class JxAdminTemplates extends JxObjectDb
  {
      function JxAdminTemplates()
      {
          $this->JxObjectDb();
      }

      function render()
      {
          if (JX_PATH_MODE === JX_PATH_MODE_HOSTED) {
              $path = JX_HOSTED_PATH;
          } else {
              $path = JX_CORE_PATH;
          }

          $template = & new JxTemplate(JX_CORE_PATH.'/modules/system/tpl');
          if (strlen($_GET['dir']) && !strlen($_GET['file'])) {
              $templateFile = 'JxAdminTemplates_templates.tpl';
              $templates = array();

              $dir = dir($path.$_GET['dir']);
              while(false !== ($entry = $dir->read())) {
                  if (eregi('tpl$',$entry)) {
                      $templates[] = $entry;
                  }
              }
              $dir->close();

              $template->assign('name',$_GET['name']);
              $template->assign('path',$path);
              $template->assign('dir',$_GET['dir']);
              $template->assign('templates',$templates);

          } elseif (strlen($_GET['file'])) {
              $templateFile = 'JxAdminTemplates_edit.tpl';

              $error = array();
              $dir = $_GET['dir'];
              if (!is_writable($path.$dir)) {
                  $error[] = PEAR::raiseError('Directory not writable: <code>'.$path.$dir.'</code>');
              }
              
              $file = $path.$dir.'/'.str_replace('..','/',$_GET['file']);

              $contents = '';
              if (file_exists($file)) {
                  if (!is_writable($file)) {
                      $error[] = PEAR::raiseError('File not writable: <code>'.$file.'</code>');
                  }

                  $fp = fopen($file,'r');
                  if ($fp) {
                      $contents = fread($fp,filesize($file));
                      fclose($fp);
                  }
              } else {
                  // new file
              }

              if (!count($error)) {
                  $form = & new JxHtmlForm();

                  $container = & new JxHtmlFormContainer('edit');
                  if ($_GET['file'] == 'new') {
                      $container->label = 'Create Template';

                      $field = & new JxFieldText('name',$_POST['name']);
                      $field->label = 'Name';
                  } else {
                      $container->label = 'Edit Template '.$_GET['file'];
 
                      $field = & new JxFieldStatic('file',$file);
                      $field->label = 'Template';
                      $field->title = '<code style="color: black;">'.$file.'</code>';
                  }

                  $field->required = true;
                  $container->addComponent($field);

                  if (isset($_POST['contents'])) {
                      $contents = $_POST['contents'];
                  }

                  $field = & new JxFieldTextarea('contents',$contents);
                  $field->label = 'Contents';
                  $field->required = true;
                  $container->addComponent($field);

                  $field = & new JxFieldSubmit('button','Save');
                  $container->addComponent($field);

                  $form->addComponent($container);
                  if (!$form->isValid()) {
                      $template->assign('form',$form->getForm());
                  } else {
                      $data = $form->getData();

                      if (isset($data['name'])) {
                          $data['file'] = $path.$_GET['dir'].'/'.$data['name'];
                      }

                      $fp = fopen(stripslashes($data['file']),'w');
                      if ($fp) {
                          $content = stripslashes($_POST['contents']);
                          fwrite($fp,$content,strlen($content));
                          fclose($fp);
                      } else {
                          $error[] = PEAR::raiseError('Could not open '.$data['file']);
                      }
                  }
              }

              $template->assign('error',$error);
              $template->assign('path',$path);
              $template->assign('dir',$dir);
              $template->assign('name',$_GET['name']);
              $template->assign('file',$_GET['file']);

          } else {
              $templateFile = 'JxAdminTemplates_dirs.tpl';
              $siteDirs = $moduleDirs = array();

              $dir = dir($path.'/tpl');
              while (false !== ($entry = $dir->read())) {
                  if (is_dir($path.'/tpl/'.$entry.'/templates')) {
                      $siteDirs[$entry] = '/tpl/'.$entry.'/templates';
                  }
              }
              $dir->close();

              $dir = dir($path.'/modules');
              while (false !== ($entry = $dir->read())) {
                  if (is_dir($path.'/modules/'.$entry.'/tpl/templates')) {
                      $moduleDirs[$entry] = '/modules/'.$entry.'/tpl/templates';
                  } 
              }
              $dir->close();

              $template->assign('siteDirs',$siteDirs);
              $template->assign('moduleDirs',$moduleDirs);
          }

          return $template->fetch($templateFile);
      }

      function _JxAdminTemplates()
      {
          $this->_JxObjectDb();
      }

  }

?>
