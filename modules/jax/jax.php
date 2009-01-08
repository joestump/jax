<?php 

  require_once(JX_BASE_PATH.'/includes/App/JxAdmin.php');

  class jax extends JxAuthUser
  {
    function jax()
    {
      $this->JxAuthUser();
      $this->page->title = 'JAX Control Panel v. '.JX_API_VERSION;
      $this->displayPage = false;

      $sql = "SELECT M.*,
              SUM((CONV(R.permissions,8,10) & CONV(".JX_USER_R.",8,2))) AS r,
              SUM((CONV(R.permissions,8,10) & CONV(".JX_USER_W.",8,2))) AS w,
              SUM((CONV(R.permissions,8,10) & CONV(".JX_USER_X.",8,2))) AS x
              FROM modules AS M, modules_groups AS R
              WHERE M.moduleID=R.moduleID AND 
                    R.groupID IN (".implode(',',$this->user->groupIds).") AND
                    (CONV(R.permissions,8,10) & CONV(".JX_USER_W.",8,2)) > 0 AND
                    M.available > 0
              GROUP BY M.moduleID
              ORDER BY M.title";

      $result = $this->db->query($sql);
      if(!DB::isError($result) && $result->numRows())
      {
        $modules = array();
        while ($row = $result->fetchRow()) {
            $admin = '/modules/'.$row['name'].'/admin.php';
            if (JX_PATH_MODE === JX_PATH_MODE_DEFAULT) {
                if(file_exists(JX_CORE_PATH.'/'.$admin)) {
                    $modules[] = $row;
                }
            } else {
                if (file_exists(JX_HOSTED_PATH.'/'.$admin)) {
                    $modules[] = $row;
                } elseif (file_exists(JX_CORE_PATH.'/'.$admin)) {
                    $modules[] = $row;
                }
            }
        } 

        $this->setData('modules',$modules);
        $this->setData('module',$_GET['module']);
        $this->setData('form',$_GET['form']);

        if (strlen($_GET['module'])) {
            $file = '/modules/'.$_GET['module'].'/admin.php';
            if (JX_PATH_MODE === JX_PATH_MODE_DEFAULT) {
                $include = JX_CORE_PATH.'/'.$file;
            } else {
                if (file_exists(JX_HOSTED_PATH.'/'.$file)) {
                    $include = JX_HOSTED_PATH.'/'.$file;
                } elseif (file_exists(JX_CORE_PATH.'/'.$file)) {
                    $include = JX_CORE_PATH.'/'.$file;
                }
            }

            if (strlen($_GET['parent'])) {
                $include = JX_MODULE_PATH.'/'.$_GET['parent'].'/admin.php';
            }

            if (@include($include)) {
                $this->setData('forms',$ADMIN); 
            }
        }
      }
      else
      {
        $this->templateFile = 'noperms.tpl';
      }
    }

    function admin()
    {
      $this->templateFile = 'error.tpl';
      if(strlen($_GET['module']) &&
         strlen($_GET['form']))
      {

        $file = '/'.$_GET['module'].'/admin/'.$_GET['form'].'.php';
        if (JX_PATH_MODE == JX_PATH_MODE_DEFAULT) {
            $include = JX_CORE_PATH.'/modules/'.$file;
        } else {
            if (file_exists(JX_HOSTED_PATH.'/modules/'.$file)) {
                $include = JX_HOSTED_PATH.'/modules/'.$file;
            } elseif (file_exists(JX_CORE_PATH.'/modules/'.$file)) {
                $include = JX_CORE_PATH.'/modules/'.$file;
            } else {
                echo 'JX_HOSTED_PATH: '.JX_HOSTED_PATH.' <br />';
                echo 'JX_CORE_PATH: '.JX_CORE_PATH.' <br />';
                echo 'file: '.$file.' <br />';
                echo 'include: '.JX_HOSTED_PATH.'/modules/'.$file. '<br />';
                die("<b>INVALID ADMIN FILE</b>");
            }
        }

//        echo JX_HOSTED_PATH.'<br />';
//        echo $include.'<br />';
//        echo $file.'<br />';

        if(include($include))
        {
          if(class_exists($_GET['form']))
          {
            $class = & new $_GET['form']();

            if(!PEAR::isError($class) && method_exists($class,'render'))
            {

              $this->templateFile = 'admin.tpl';
              if (JX_PATH_MODE == JX_PATH_MODE_DEFAULT) {
                  $tplPath = JX_CORE_PATH.'/modules/jax/tpl';
              } else {
                  $tplPath = JX_HOSTED_PATH.'/modules/jax/tpl';
              }

              $class->template = & new JxTemplate($tplPath);
              $class->templateFile = 'default_admin.tpl';

              $class->template->assign('module',$_GET['module']);
              $class->template->assign('form',$_GET['form']);

              $form = $class->render();

              $this->setData('adminForm',$form);

              $childTable = '';
              if(strlen($class->childTable))
              {
                $childTable = $class->childTable;
              } 

              $this->setData('childTable',$class->childTable);
              $this->setData('user',$this->user);
            }
            else
            {
              $this->setData('errorMsg','Class is invalid!');
            }
          }  
          else
          {
            $this->setData('errorMsg','Class does not exist! '.$include);
          }
        }
        else
        {
          $this->setData('errorMsg','File does not exist!');
        }
      }
      else
      {
        $this->setData('errorMsg','No form or module specified!');
      }
    }

    function module()
    {
      $sql = "SELECT M.*,
              SUM((CONV(R.permissions,8,10) & CONV(".JX_USER_R.",8,2))) AS r,
              SUM((CONV(R.permissions,8,10) & CONV(".JX_USER_W.",8,2))) AS w,
              SUM((CONV(R.permissions,8,10) & CONV(".JX_USER_X.",8,2))) AS x
              FROM modules AS M, modules_groups AS R
              WHERE M.moduleID=R.moduleID AND 
                    R.groupID IN (".implode(',',$this->user->groupIds).") AND
                    (CONV(R.permissions,8,10) & CONV(".JX_USER_W.",8,2)) > 0 AND
                    M.available > 0 AND
                    M.name='".$_GET['module']."'
              GROUP BY M.moduleID
              ORDER BY M.title";

      $result = $this->db->query($sql);
      if(!DB::isError($result) && $result->numRows())
      {
        $this->templateFile = 'module.tpl';
        $this->setData('info',JxModule::getModule($_GET['module']));
      }
      else
      {
        $this->templateFile = 'noperms.tpl';
      }
    }

    function _jax()
    {
      $this->_JxAuthUser();
    }
  }

?>
